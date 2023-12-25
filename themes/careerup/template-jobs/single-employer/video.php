<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$video_url = WP_Job_Board_Employer::get_post_meta($post->ID, 'video_url', true );

if ( !empty($video_url) ) {
?>
    <div id="job-employer-video" class="employer-detail-video widget">
    	<h4 class="widget-title"><?php esc_html_e('Video', 'careerup'); ?></h4>
    	<div class="content-bottom">
	    	<?php
				$video_embed = false;
				$filetype    = wp_check_filetype( $video_url );

				if ( ! empty( $video_url ) ) {
					// FV WordPress Flowplayer Support for advanced video formats.
					if ( shortcode_exists( 'flowplayer' ) ) {
						$video_embed = '[flowplayer src="' . esc_url( $video_url ) . '"]';
					} elseif ( ! empty( $filetype['ext'] ) ) {
						$video_embed = wp_video_shortcode( array( 'src' => $video_url ) );
					} else {
						$video_embed = wp_oembed_get( $video_url );
					}
				}

				if ( $video_embed ) {
					echo trim($video_embed); // WPCS: XSS ok.
				}
	    	?>
        </div>
    </div>
<?php }