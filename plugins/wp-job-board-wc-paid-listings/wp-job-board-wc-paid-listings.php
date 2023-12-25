<?php
/**
 * Plugin Name: WP Job Board - WooCommerce Paid Listings
 * Plugin URI: http://apusthemes.com/wp-job-board-wc-paid-listings/
 * Description: Add paid listing functionality via WooCommerce
 * Version: 3.2.2
 * Author: Habq
 * Author URI: http://apusthemes.com
 * Requires at least: 3.8
 * Tested up to: 5.2
 *
 * Text Domain: wp-job-board-wc-paid-listings
 * Domain Path: /languages/
 *
 * @package wp-job-board-wc-paid-listings
 * @category Plugins
 * @author Habq
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists("WP_Job_Board_Wc_Paid_Listings") ) {
	
	final class WP_Job_Board_Wc_Paid_Listings {

		private static $instance;

		public static function getInstance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Job_Board_Wc_Paid_Listings ) ) {
				self::$instance = new WP_Job_Board_Wc_Paid_Listings;
				self::$instance->setup_constants();
				self::$instance->load_textdomain();
				self::$instance->plugin_update();

				add_action( 'tgmpa_register', array( self::$instance, 'register_plugins' ) );

				self::$instance->libraries();
				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 *
		 */
		public function setup_constants() {
			
			define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_VERSION', '3.2.2' );

			// Plugin Folder Path
			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_URL' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_FILE' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_FILE', __FILE__ );
			}

			// Prefix
			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PREFIX' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_PREFIX', '_job_package_' );
			}

			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_CV_PREFIX' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_CV_PREFIX', '_cv_package_' );
			}

			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_CONTACT_PREFIX' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_CONTACT_PREFIX', '_contact_package_' );
			}

			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_CANDIDATE_PREFIX' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_CANDIDATE_PREFIX', '_candidate_package_' );
			}

			if ( ! defined( 'WP_JOB_BOARD_WC_PAID_LISTINGS_RESUME_PREFIX' ) ) {
				define( 'WP_JOB_BOARD_WC_PAID_LISTINGS_RESUME_PREFIX', '_resume_package_' );
			}
		}

		public function includes() {
			// post type
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/post-types/class-post-type-job_package.php';
			
			// class
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-mixes.php';
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-submit-form.php';
			if ( class_exists('WC_Product_Simple') ) {
				require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-product-type-package.php';
				
				require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-wc-cart.php';
				require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-wc-order.php';
			}
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-job-package.php';
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-resume-package.php';
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-cv-package.php';
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-contact-package.php';
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-candidate-package.php';
			
			if ( class_exists( 'WC_Subscriptions' ) ) {
				require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-job-package-subscription.php';
			}
			
			// template loader
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'inc/class-template-loader.php';

			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'style' ) );
		}

		public function plugin_update() {
	        require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'libraries/plugin-update-checker/plugin-update-checker.php';
	        Puc_v4_Factory::buildUpdateChecker(
	            'https://www.apusthemes.com/themeplugins/wp-job-board-wc-paid-listings.json',
	            __FILE__,
	            'wp-job-board-wc-paid-listings'
	        );
	    }

		public static function style() {
			wp_enqueue_style('wp-job-board-wc-paid-listings-style', WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_URL . 'assets/style.css');
			wp_enqueue_script('wp-job-board-wc-paid-listings-script', WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_URL . 'assets/admin-main.js', array( 'jquery' ), '5', true);
		}

		/**
		 * Loads third party libraries
		 *
		 * @access public
		 * @return void
		 */
		public static function libraries() {
			require_once WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_DIR . 'libraries/class-tgm-plugin-activation.php';
		}

		/**
		 * Install plugins
		 *
		 * @access public
		 * @return void
		 */
		public static function register_plugins() {
			$plugins = array(
	            array(
		            'name'      => 'CMB2',
		            'slug'      => 'cmb2',
		            'required'  => true,
	            ),
	            array(
		            'name'      => 'WP Job Board',
		            'slug'      => 'wp-job-board',
		            'required'  => true,
	            )
			);

			tgmpa( $plugins );
		}
		/**
		 *
		 */
		public function load_textdomain() {
			// Set filter for WP_Job_Board_Wc_Paid_Listings's languages directory
			$lang_dir = dirname( plugin_basename( WP_JOB_BOARD_WC_PAID_LISTINGS_PLUGIN_FILE ) ) . '/languages/';
			$lang_dir = apply_filters( 'wp_job_board_wc_paid_listings_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'wp-job-board-wc-paid-listings' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'wp-job-board-wc-paid-listings', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/wp-job-board-wc-paid-listings/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/wp-job-board-wc-paid-listings folder
				load_textdomain( 'wp-job-board-wc-paid-listings', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/wp-job-board-wc-paid-listings/languages/ folder
				load_textdomain( 'wp-job-board-wc-paid-listings', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'wp-job-board-wc-paid-listings', false, $lang_dir );
			}
		}
	}
}

function WP_Job_Board_Wc_Paid_Listings() {
	return WP_Job_Board_Wc_Paid_Listings::getInstance();
}

add_action( 'plugins_loaded', 'WP_Job_Board_Wc_Paid_Listings' );