<?php
/**
 * Yoast
 *
 * @package    wp-job-board
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
  	exit;
}

class WP_Job_Board_Yoast {
	
	public static function init() {
		add_action( 'wpseo_sitemap_entry', array(__CLASS__, 'skip_filled_job_listings'), 10, 3 );
	}

	public static function skip_filled_job_listings($url, $type, $post) {
		if ( 'job_listing' !== $post->post_type ) {
			return $url;
		}

		if ( WP_Job_Board_Job_Listing::is_filled( $post->ID ) ) {
			return false;
		}

		return $url;
	}

}

WP_Job_Board_Yoast::init();