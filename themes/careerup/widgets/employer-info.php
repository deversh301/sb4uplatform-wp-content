<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'employer' ) {
    return;
}
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

global $post;
$views = get_post_meta($post->ID, WP_JOB_BOARD_EMPLOYER_PREFIX.'views_count', true );
$user_id = WP_Job_Board_User::get_user_by_employer_id($post->ID);
$jobs = WP_Job_Board_Query::get_posts(array(
    'post_type' => 'job_listing',
    'post_status' => 'publish',
    'author' => $user_id,
    'fields' => 'ids'
));
$count_jobs = $jobs->post_count;

$address = get_post_meta($post->ID, WP_JOB_BOARD_EMPLOYER_PREFIX.'address', true );
$categories = get_the_terms( $post->ID, 'employer_category' );
$founded_date = get_post_meta($post->ID, WP_JOB_BOARD_EMPLOYER_PREFIX.'founded_date', true );

$custom_fields = WP_Job_Board_Post_Type_Job_Custom_Fields::get_custom_fields('employer_cfield');
?>
<div class="employer-detail-detail in-sidebar">
    <ul class="list">
        <?php if ( $custom_fields ) { ?>
            <?php foreach ($custom_fields as $cpost) {
                $value = get_post_meta( $post->ID, WP_JOB_BOARD_EMPLOYER_PREFIX .'custom_'. $cpost->post_name, true );
                $icon_class = get_post_meta( $cpost->ID, WP_JOB_BOARD_EMPLOYER_CUSTOM_FIELD_PREFIX .'icon_class', true );
                
                if ( !empty($value) ) {
                    ?>
                    <li>
                        <div class="icon">
                            <?php if ( !empty($icon_class) ) { ?>
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            <?php } ?>
                        </div>
                        <div class="details">
                            <div class="text"><?php echo wp_kses_post($cpost->post_title); ?></div>
                            <div class="value"><?php echo WP_Job_Board_Post_Type_Job_Custom_Fields::display_field($cpost, $value); ?></div>
                        </div>
                    </li>
                    <?php
                }
            ?>
                
            <?php } ?>
        <?php } ?>

        <?php if ( $views ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-eye"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Views', 'careerup'); ?></div>
                    <div class="value"><?php echo wp_kses_post($views); ?></div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $count_jobs ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-label"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Posted jobs', 'careerup'); ?></div>
                    <div class="value"><?php echo wp_kses_post($count_jobs); ?></div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $address ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-paper-plane"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Location', 'careerup'); ?></div>
                    <div class="value"><?php echo wp_kses_post($address); ?></div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $categories ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-2-squares"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Categories', 'careerup'); ?></div>
                    <div class="value">
                        <?php foreach ($categories as $term) { ?>
                            <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a>
                        <?php } ?>
                    </div>
                </div>
            </li>
        <?php } ?>

        <?php if ( $founded_date ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-timeline"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Since', 'careerup'); ?></div>
                    <div class="value"><?php echo wp_kses_post($founded_date); ?></div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>