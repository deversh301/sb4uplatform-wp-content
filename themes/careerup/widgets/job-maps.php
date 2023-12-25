<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'job_listing' ) {
    return;
}
extract( $args );
extract( $instance );
if ( !empty($instance['title']) ) {
	$title = apply_filters('widget_title', $instance['title']);

	if ( !empty($title) ) {
	    echo trim($before_title)  . trim( $title ) . $after_title;
	}
}

?>
<div class="job-detail-map-location job_maps_sidebar">
    <div id="jobs-google-maps" class="single-job-map"></div>
</div>