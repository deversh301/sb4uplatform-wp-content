<?php
/**
 * Submit Form
 *
 * @package    wp-job-board-wc-paid-listings
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WP_Job_Board_Wc_Paid_Listings_Submit_Form {
	
	public static $job_package;
	public static $listing_user_package;

	public static function init() {
		add_filter( 'wp_job_board_submit_job_steps',  array( __CLASS__, 'submit_job_steps' ), 5, 1 );

		// get listing package
		if ( ! empty( $_POST['wjbwpl_job_package'] ) ) {
			if ( is_numeric( $_POST['wjbwpl_job_package'] ) ) {
				self::$job_package = absint( $_POST['wjbwpl_job_package'] );
			}
		} elseif ( ! empty( $_POST['wjbwpl_listing_user_package'] ) ) {
			if ( is_numeric( $_POST['wjbwpl_listing_user_package'] ) ) {
				self::$listing_user_package = absint( $_POST['wjbwpl_listing_user_package'] );
			}
		} elseif ( ! empty( $_COOKIE['chosen_job_package'] ) ) {
			self::$job_package  = absint( $_COOKIE['chosen_job_package'] );
		} elseif ( ! empty( $_COOKIE['chosen_listing_user_package'] ) ) {
			self::$listing_user_package = absint( $_COOKIE['chosen_listing_user_package'] );
			if ( ! empty( $_COOKIE['chosen_job_package'] ) ) {
				unset($_COOKIE['chosen_job_package']);
				setcookie('chosen_job_package', null, -1, '/');
			}
		}
	}

	public static function get_products() {
		$query_args = array(
		   	'post_type' => 'product',
		   	'post_status' => 'publish',
			'posts_per_page'   => -1,
			'order'            => 'asc',
			'orderby'          => 'menu_order',
		   	'tax_query' => array(
		        array(
		            'taxonomy' => 'product_type',
		            'field'    => 'slug',
		            'terms'    => array('job_package', 'job_package_subscription'),
		        ),
		    ),
		);
		$posts = get_posts( $query_args );

		return $posts;
	}

	public static function submit_job_steps($steps) {
		
		$packages = self::get_products();

		if ( !empty($packages) ) {
			$steps['wjb-choose-packages'] = array(
				'view'     => array( __CLASS__, 'choose_package' ),
				'handler'  => array( __CLASS__, 'choose_package_handler' ),
				'priority' => 1
			);

			$steps['wjb-process-packages'] = array(
				'name'     => '',
				'view'     => false,
				'handler'  => array( __CLASS__, 'process_package_handler' ),
				'priority' => 25
			);

			add_filter( 'wp_job_board_submit_job_post_status', array( __CLASS__, 'submit_job_post_status' ), 10, 2 );
		}

		return $steps;
	}

	public static function submit_job_post_status( $status, $job ) {
		if ( $job->post_status === 'preview' ) {
			return 'pending_payment';
		}
		return $status;
	}

	public static function choose_package($atts = array()) {
		echo WP_Job_Board_Wc_Paid_Listings_Template_Loader::get_template_part('choose-package-form', array('atts' => $atts) );
	}

	public static function choose_package_handler() {

		if ( !isset( $_POST['security-job-submit-package'] ) || ! wp_verify_nonce( $_POST['security-job-submit-package'], 'wp-job-board-job-submit-package-nonce' )  ) {
			$this->errors[] = esc_html__('Sorry, your nonce did not verify.', 'wp-job-board-wc-paid-listings');
			return;
		}

		$form = WP_Job_Board_Submit_Form::get_instance();

		$validation = self::validate_package();

		if ( is_wp_error( $validation ) ) {
			$form->add_error( $validation->get_error_message() );
			$form->set_step( array_search( 'wjb-choose-packages', array_keys( $form->get_steps() ) ) );
			return false;
		}
		if ( self::$listing_user_package ) {
			wc_setcookie( 'chosen_listing_user_package', self::$listing_user_package );
		} elseif ( self::$job_package ) {
			wc_setcookie( 'chosen_job_package', self::$job_package );
		}
		

		$form->next_step();
	}

	private static function validate_package() {
		if ( empty( self::$listing_user_package ) && empty( self::$job_package )  ) {
			return new WP_Error( 'error', esc_html__( 'Invalid Package', 'wp-job-board-wc-paid-listings' ) );
		} elseif ( self::$listing_user_package ) {
			if ( ! WP_Job_Board_Wc_Paid_Listings_Mixes::package_is_valid( get_current_user_id(), self::$listing_user_package ) ) {
				return new WP_Error( 'error', __( 'Invalid Package', 'wp-job-board-wc-paid-listings' ) );
			}
		} elseif ( self::$job_package ) {
			$package = wc_get_product( self::$job_package );
			if ( empty($package) || ($package->get_type() != 'job_package' && ! $package->is_type( 'job_package_subscription' )) ) {
				return new WP_Error( 'error', esc_html__( 'Invalid Package', 'wp-job-board-wc-paid-listings' ) );
			}

			// Don't let them buy the same subscription twice if the subscription is for the package
			if ( class_exists( 'WC_Subscriptions' ) && is_user_logged_in() && $package->is_type( 'job_package_subscription' ) && 'package' === WP_Job_Board_Wc_Paid_Listings_Job_Package_Subscription::get_package_subscription_type(self::$job_package) ) {
				if ( wcs_user_has_subscription( get_current_user_id(), self::$job_package, 'active' ) ) {
					return new WP_Error( 'error', __( 'You already have this subscription.', 'wp-job-board-wc-paid-listings' ) );
				}
			}
		}

		return true;
	}

	public static function process_package_handler() {
		$form = WP_Job_Board_Submit_Form::get_instance();
		$job_id = $form->get_job_id();
		$post_status = get_post_status( $job_id );
		if ( $post_status == 'preview' ) {
			$update_job = array(
				'ID' => $job_id,
				'post_status' => 'pending_payment',
				'post_date' => current_time( 'mysql' ),
				'post_date_gmt' => current_time( 'mysql', 1 ),
				'post_author' => get_current_user_id(),
			);

			wp_update_post( $update_job );
		}

		if ( self::$listing_user_package ) {
			$product_id = get_post_meta(self::$listing_user_package, WP_JOB_BOARD_WC_PAID_LISTINGS_PREFIX.'product_id', true);
			// Urgent
			$urgent_jobs = get_post_meta(self::$listing_user_package, WP_JOB_BOARD_WC_PAID_LISTINGS_PREFIX.'urgent_jobs', true );
			$urgent = '';
			if ( !empty($urgent_jobs) && $urgent_jobs == 'on') {
				$urgent = 'on';
			}
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX. 'urgent', $urgent );
			// Featured
			$feature_jobs = get_post_meta(self::$listing_user_package, WP_JOB_BOARD_WC_PAID_LISTINGS_PREFIX.'feature_jobs', true );
			$featured = '';
			if ( !empty($feature_jobs) && $feature_jobs == 'on' ) {
				$featured = 'on';
			}
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX. 'featured', $featured );
			//
			$job_duration = get_post_meta(self::$listing_user_package, WP_JOB_BOARD_WC_PAID_LISTINGS_PREFIX.'job_duration', true );
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'duration', $job_duration );
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'package_duration', $job_duration );
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'package_id', $product_id );
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'user_package_id', self::$listing_user_package );

			$subscription_type = get_post_meta(self::$listing_user_package, WP_JOB_BOARD_WC_PAID_LISTINGS_PREFIX.'subscription_type', true );
			if ( 'listing' === $subscription_type ) {
				update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'expiry_date', '' ); // Never expire automatically
			}

			// Approve the job
			if ( in_array( get_post_status( $job_id ), array( 'pending_payment', 'expired' ) ) ) {
				WP_Job_Board_Wc_Paid_Listings_Mixes::approve_job_with_package( $job_id, get_current_user_id(), self::$listing_user_package );
			}

			// remove cookie
			wc_setcookie( 'chosen_listing_user_package', '', time() - HOUR_IN_SECONDS );

			do_action( 'wjbwpl_process_user_package_handler',self::$listing_user_package, $job_id );

			$form->next_step();
		} elseif ( self::$job_package ) {
			// Urgent
			$urgent_jobs = get_post_meta(self::$job_package, '_urgent_jobs', true );
			$urgent = '';
			if ( !empty($urgent_jobs) && $urgent_jobs == 'yes' ) {
				$urgent = 'on';
			}
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'urgent', $urgent );

			// Featured
			$feature_jobs = get_post_meta(self::$job_package, '_feature_jobs', true );
			$featured = '';
			if ( !empty($feature_jobs) && $feature_jobs == 'yes' ) {
				$featured = 'on';
			}
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'featured', $featured );
			//
			$job_duration = get_post_meta(self::$job_package, '_jobs_duration', true );
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'duration', $job_duration );
			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'package_duration', $job_duration );

			update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'package_id', self::$job_package );
			
			$subscription_type = get_post_meta(self::$job_package, '_job_package_subscription_type', true );
			if ( 'listing' === $subscription_type ) {
				update_post_meta( $job_id, WP_JOB_BOARD_JOB_LISTING_PREFIX.'expiry_date', '' ); // Never expire automatically
			}

			WC()->cart->add_to_cart( self::$job_package, 1, '', '', array(
				'job_id' => $job_id
			) );

			wc_add_to_cart_message( self::$job_package );

			// remove cookie
			wc_setcookie( 'chosen_job_package', '', time() - HOUR_IN_SECONDS );

			do_action( 'wjbwpl_process_package_handler', self::$job_package, $job_id );

			wp_redirect( get_permalink( wc_get_page_id( 'checkout' ) ) );
			exit;
		}
	}

}

WP_Job_Board_Wc_Paid_Listings_Submit_Form::init();