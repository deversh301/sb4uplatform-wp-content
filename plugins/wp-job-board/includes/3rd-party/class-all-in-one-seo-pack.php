<?php
/**
 * All_In_One_Seo_Pack
 *
 * @package    wp-job-board
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */

if ( ! defined( 'ABSPATH' ) ) {
  	exit;
}

class WP_Job_Board_All_In_One_Seo_Pack {
	
	public static function init() {
		
		add_action( 'aiosp_sitemap_post_filter', array(__CLASS__, 'sitemap_filter_filled_jobs'), 10, 3 );
	}

	public static function sitemap_filter_filled_jobs($posts) {
		foreach ( $posts as $index => $post ) {
			if ( $post instanceof WP_Post && 'job_listing' !== $post->post_type ) {
				continue;
			}
			if ( WP_Job_Board_Job_Listing::is_filled( $post->ID ) ) {
				unset( $posts[ $index ] );
			}
		}
		return $posts;
	}

}

WP_Job_Board_All_In_One_Seo_Pack::init();