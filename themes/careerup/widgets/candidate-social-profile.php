<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
    return;
}
$socials = WP_Job_Board_Candidate::get_post_meta($post->ID, 'socials');
$output = '';
if ( $socials ) {
    ob_start();
    foreach ($socials as $social) { ?>
        <?php if ( !empty($social['url']) && !empty($social['network']) ) { ?>
            <a href="<?php echo esc_html($social['url']); ?>"><i class="fa fa-<?php echo esc_attr($social['network']); ?>"></i></a>
        <?php } ?>
    <?php }
    $output = ob_get_clean();
}
if ( empty($output) ) {
    return;
}


extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

?>
<div class="widget-job-detail-social st_dark">
    <span class="title"><?php echo esc_html__('Social Profiles:','careerup'); ?> </span>
    <div class="apus-social-share">
        <?php echo wp_kses_post($output); ?>
    </div>
</div>