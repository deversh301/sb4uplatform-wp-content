<?php
/**
 * Candidate Package
 *
 * @package    wp-job-board-wc-paid-listings
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WP_Job_Board_Wc_Paid_Listings_Candidate_Package {
	public static function init() {
		add_filter( 'wp-job-board-check-candidate-can-apply', array( __CLASS__, 'process_candidate_can_apply' ), 10 );

		add_action( 'wp-job-board-before-after-job-applicant', array( __CLASS__, 'process_added_applicant' ), 10, 4 );
		add_action( 'wp-job-board-after-remove-applied', array( __CLASS__, 'process_removed_applicant' ), 10, 5 );
	}

	public static function process_candidate_can_apply($return) {
		$free_apply = wp_job_board_get_option('candidate_free_job_apply', 'on');
		if ( $free_apply == 'off' ) {
			$return = false;
			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();
				if ( class_exists('WP_Job_Board_User') && WP_Job_Board_User::is_candidate($user_id) ) {
					$packages = WP_Job_Board_Wc_Paid_Listings_Mixes::get_candidate_packages_by_user($user_id);
					if ( !empty($packages) ) {
						$return = true;
					}
				}
			}
		}
		
		return apply_filters( 'wp-job-board-wc-paid-listings-process-candidate-can-apply', $return );
	}

	public static function process_added_applicant($applicant_id, $job_id, $candidate_id, $user_id) {
		$packages = WP_Job_Board_Wc_Paid_Listings_Mixes::get_candidate_packages_by_user($user_id);
		if ( !empty($packages) && !empty($packages[0]) ) {
			$package = $packages[0];
			WP_Job_Board_Wc_Paid_Listings_Mixes::increase_candidate_package_applied_count($applicant_id, $user_id, $package->ID);
			update_post_meta($applicant_id, WP_JOB_BOARD_APPLICANT_PREFIX . 'candidate_package_id', $package->ID);
		}
	}

	public static function process_removed_applicant($applicant_id, $job_id, $candidate_id, $candidate_package_id, $data) {
		$prefix = WP_JOB_BOARD_WC_PAID_LISTINGS_CANDIDATE_PREFIX;
		if ( $candidate_package_id ) {
			$candidate_applied_counts = array();
			$candidate_applied_count = get_post_meta($candidate_package_id, $prefix.'candidate_applied_count', true);
			if ( !empty($candidate_applied_count) ) {
				$candidate_applied_counts = array_map( 'trim', explode(',', $candidate_applied_count) );
				if ( in_array($applicant_id, $candidate_applied_counts) ) {
					$key = array_search($applicant_id, $candidate_applied_counts);
					unset($candidate_applied_counts[$key]);
				}
			}
			$candidate_applied_counts = !empty($candidate_applied_counts) ? implode(',', $candidate_applied_counts) : '';
			update_post_meta( $candidate_package_id, $prefix.'candidate_applied_count', $candidate_applied_counts );
		}
	}

}

WP_Job_Board_Wc_Paid_Listings_Candidate_Package::init();