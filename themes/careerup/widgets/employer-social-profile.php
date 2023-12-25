<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'employer' ) {
    return;
}
$socials = WP_Job_Board_Employer::get_post_meta($post->ID, 'socials');
$output = '';
if ( $socials ) {
    ob_start();
    foreach ($socials as $social) { ?>
        <?php if ( !empty($social['url']) && !empty($social['network']) ) { ?>
            <li><a href="<?php echo esc_html($social['url']); ?>"><i class="fa fa-<?php echo esc_attr($social['network']); ?>"></i></a></li>
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
<div class="employer-detail-social">
    <div class="label">
        <?php esc_html_e('Social Profiles:', 'careerup'); ?>
    </div>
    <ul class="list">
        <?php echo wp_kses_post($output); ?>
    </ul>
</div>