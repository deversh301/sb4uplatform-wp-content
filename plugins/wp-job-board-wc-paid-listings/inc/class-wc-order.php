<?php
/**
 * Order
 *
 * @package    wp-job-board-wc-paid-listings
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WP_Job_Board_Wc_Paid_Listings_Order {

	
	public static function init() {
		add_action( 'woocommerce_thankyou', array( __CLASS__, 'woocommerce_thankyou' ), 5 );

		// Change Order Statuses
		add_action( 'woocommerce_order_status_processing', array( __CLASS__, 'order_paid' ) );
		add_action( 'woocommerce_order_status_completed', array( __CLASS__, 'order_paid' ) );

		// Delete User
		add_action( 'delete_user', array( __CLASS__, 'delete_user_packages' ) );
	}

	
	public static function woocommerce_thankyou( $order_id ) {
		global $wp_post_types;

		$order = wc_get_order( $order_id );

		foreach ( $order->get_items() as $item ) {
			if ( isset( $item['job_id'] ) && 'publish' === get_post_status( $item['job_id'] ) ) {
				switch ( get_post_status( $item['job_id'] ) ) {
					case 'pending' :
						echo wpautop( sprintf( __( '%s has been submitted successfully and will be visible once approved.', 'wp-job-board-wc-paid-listings' ), get_the_title( $item['job_id'] ) ) );
					break;
					case 'pending_payment' :
					case 'expired' :
						echo wpautop( sprintf( __( '%s has been submitted successfully and will be visible once payment has been confirmed.', 'wp-job-board-wc-paid-listings' ), get_the_title( $item['job_id'] ) ) );
					break;
					default :
						echo wpautop( sprintf( __( '%s has been submitted successfully.', 'wp-job-board-wc-paid-listings' ), get_the_title( $item['job_id'] ) ) );
					break;
				}

				echo '<p class="job-submit-done-paid-listing-actions">';

				if ( 'publish' === get_post_status( $item['job_id'] ) ) {
					echo '<a class="button" href="' . get_permalink( $item['job_id'] ) . '">' . __( 'View Job', 'wp-job-board-wc-paid-listings' ) . '</a> ';
				} elseif ( wp_job_board_get_option( 'my_jobs_page_id' ) ) {
					echo '<a class="button" href="' . get_permalink( wp_job_board_get_option( 'my_jobs_page_id' ) ) . '">' . __( 'View Dashboard', 'wp-job-board-wc-paid-listings' ) . '</a> ';
				}

				echo '</p>';

			}
		}
	}

	
	public static function order_paid( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( get_post_meta( $order_id, 'wp_job_board_wc_paid_listings_packages_processed', true ) ) {
			return;
		}
		foreach ( $order->get_items() as $item ) {
			$product = wc_get_product( $item['product_id'] );

			if ( $product->is_type( array( 'job_package' ) ) && $order->get_customer_id() ) {

				// create packages for user
				for ( $i = 0; $i < $item['qty']; $i ++ ) {
					$user_package_id = WP_Job_Board_Wc_Paid_Listings_Mixes::create_user_package( $order->get_customer_id(), $product->get_id(), $order_id );
				}

				// Approve listing with new package
				if ( isset( $item['job_id'] ) ) {
					$listing = get_post( $item['job_id'] );

					if ( in_array( $listing->post_status, array( 'pending_payment', 'expired' ) ) ) {
						WP_Job_Board_Wc_Paid_Listings_Mixes::approve_job_with_package( $listing->ID, $order->get_customer_id(), $user_package_id );
					}
				}
			}

			if ( $product->is_type( array( 'cv_package' ) ) && $order->get_customer_id() ) {
				// create cv packages for user
				for ( $i = 0; $i < $item['qty']; $i ++ ) {
					$user_package_id = WP_Job_Board_Wc_Paid_Listings_Mixes::create_user_cv_package( $order->get_customer_id(), $product->get_id(), $order_id );
				}
			}

			if ( $product->is_type( array( 'contact_package' ) ) && $order->get_customer_id() ) {
				// create cv packages for user
				for ( $i = 0; $i < $item['qty']; $i ++ ) {
					$user_package_id = WP_Job_Board_Wc_Paid_Listings_Mixes::create_user_contact_package( $order->get_customer_id(), $product->get_id(), $order_id );
				}
			}

			if ( $product->is_type( array( 'candidate_package' ) ) && $order->get_customer_id() ) {
				// create cv packages for user
				for ( $i = 0; $i < $item['qty']; $i ++ ) {
					$user_package_id = WP_Job_Board_Wc_Paid_Listings_Mixes::create_user_candidate_package( $order->get_customer_id(), $product->get_id(), $order_id );
				}
			}

			if ( $product->is_type( array( 'resume_package' ) ) && $order->get_customer_id() ) {
				// create cv packages for user
				for ( $i = 0; $i < $item['qty']; $i ++ ) {
					$user_package_id = WP_Job_Board_Wc_Paid_Listings_Mixes::create_user_resume_package( $order->get_customer_id(), $product->get_id(), $order_id );
				}
				
				// increase expiry candidate with new package
				WP_Job_Board_Wc_Paid_Listings_Mixes::increase_expiry_with_package( $order->get_customer_id(), $user_package_id );
				$candidate_id = WP_Job_Board_User::get_candidate_by_user_id($order->get_customer_id());
				if ( $candidate_id ) {
					update_post_meta( $candidate_id, WP_JOB_BOARD_CANDIDATE_PREFIX.'package_id', $product->get_id() );
					update_post_meta( $candidate_id, WP_JOB_BOARD_CANDIDATE_PREFIX.'user_package_id', $user_package_id );
				}
			}
		}
		
		update_post_meta( $order_id, 'wp_job_board_wc_paid_listings_packages_processed', true );
	}

	
	public static function delete_user_packages( $user_id ) {
		if ( $user_id ) {
			$packages = get_posts(array(
				'post_type' => array('job_package'),
				'meta_query' => array(
					array(
						'key'     => '_user_id',
						'value'   => $user_id,
						'compare' => '='
					)
				)
			));
			if ( !empty($packages) ) {
				foreach ($packages as $package) {
					wp_delete_post($package->ID, true);
				}
			}
		}

	}
}
WP_Job_Board_Wc_Paid_Listings_Order::init();
