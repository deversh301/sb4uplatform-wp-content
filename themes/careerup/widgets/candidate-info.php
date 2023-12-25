<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
    return;
}
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$views = get_post_meta(get_the_ID(), WP_JOB_BOARD_CANDIDATE_PREFIX.'views_count', true );

$address = get_post_meta(get_the_ID(), WP_JOB_BOARD_CANDIDATE_PREFIX.'address', true );
$categories = get_the_terms( get_the_ID(), 'candidate_category' );

$salary = WP_Job_Board_Candidate::get_salary_html($post->ID);
$custom_fields = WP_Job_Board_Post_Type_Job_Custom_Fields::get_custom_fields('candidate_cfield');
?>
<div class="job-detail-detail in-sidebar">
    <ul class="list">
        <?php if ( $salary ) { ?>
            <li>
                <div class="icon">
                    <i class="flaticon-money"></i>
                </div>
                <div class="details">
                    <div class="text"><?php esc_html_e('Offered Salary', 'careerup'); ?></div>
                    <div class="value"><?php echo wp_kses_post($salary); ?></div>
                </div>
            </li>
        <?php } ?>
        <?php if ( $custom_fields ) { ?>
            <?php foreach ($custom_fields as $cpost) {
                $value = get_post_meta( $post->ID, WP_JOB_BOARD_CANDIDATE_PREFIX .'custom_'. $cpost->post_name, true );
                $icon_class = get_post_meta( $cpost->ID, WP_JOB_BOARD_CANDIDATE_CUSTOM_FIELD_PREFIX .'icon_class', true );
                
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
    </ul>
</div>