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
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

?>
<div class="job-detail-buttons">
	<?php
    if ( !empty($layout_type) && $layout_type == 'layout1' ) {
        ?>
        <?php if ( $show_apply_button || $show_shortlist_button ) { ?>
            <div class="wrapper-apply-shortlist">
                <?php if ( $show_apply_button ) { ?>
                    <div class="job-deadline">
                        <?php careerup_display_apply_job_deadline($post->ID); ?>
                    </div>
                <?php } ?>
                <div class="wrapper-apply-shortlist-inner flex-middle">
                    <?php if ( $show_apply_button ) { ?>
                        <?php careerup_display_apply_job_btn($post->ID); ?>
                    <?php } ?>
                    <?php if ( $show_shortlist_button ) { ?>
                        <div class="wrapper-shortlist">
                            <?php WP_Job_Board_Job_Listing::display_shortlist_btn($post->ID); ?>
                        </div>
                    <?php } ?>
                </div>

                <?php if ( WP_Job_Board_Job_Listing::check_can_apply_social($post->ID) && $show_apply_social ) { ?>
                    <div class="socials-apply clearfix">
                        <div class="inner">
                            <?php do_action('wp_job_board_social_apply_btn', $post); ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
        <?php } ?>
        <?php
    } else {

        if ( $show_apply_button ) {
            WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID);
        }
    ?>

        <?php if ( WP_Job_Board_Job_Listing::check_can_apply_social($post->ID) && $show_apply_social ) { ?>
            <div class="socials-apply clearfix">
                <div class="title"><?php esc_html_e('OR apply with', 'careerup'); ?></div>
                <div class="inner">
                    <?php do_action('wp_job_board_social_apply_btn', $post); ?>
                </div>
            </div>
        <?php } ?>
        
        <?php if ( $show_shortlist_button ) { ?>
            <div class="wrapper-shortlist">
                <?php WP_Job_Board_Job_Listing::display_shortlist_btn($post->ID); ?>
            </div>
        <?php }
    } ?>

</div>