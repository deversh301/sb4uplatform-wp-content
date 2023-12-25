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

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
if ( empty($employer_id) ) {
    return;
}
$socials = WP_Job_Board_Employer::get_post_meta($employer_id, 'socials');
$website = WP_Job_Board_Employer::get_post_meta($employer_id, 'website');

$phone = WP_Job_Board_Employer::get_display_phone( $employer_id );
$email = WP_Job_Board_Employer::get_display_email( $employer_id );

$layout_type = !empty($layout_type) ? $layout_type : '';
?>
<div class="job-detail-employer-info <?php echo esc_attr($layout_type); ?>">
    <?php if ( has_post_thumbnail($employer_id) ) { ?>
        <div class="employer-thumbnail">
            <a href="<?php echo esc_url( get_permalink($employer_id) ); ?>">
                <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
            </a>
        </div>
    <?php } ?>

    <?php if ( $layout_type == 'layout1' ) { ?>
        
        <h4 class="employer-title">
            <a href="<?php echo esc_url( get_permalink($employer_id) ); ?>">
                <?php echo get_the_title( $employer_id ); ?>
            </a>
        </h4>

        <?php if ( $website ) { ?>
            <div class="website-wrapper">
                <a href="<?php echo esc_url($website); ?>"><?php esc_html_e('Visit Website', 'careerup'); ?></a>
            </div>
        <?php } ?>
        
        <?php
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
        if ( $output ) {
            ?>
            <ul class="list social">
                <?php echo wp_kses_post($output); ?>
            </ul>
            <?php
        }
        ?>
    <?php } else { ?>
        
        <div class="employer-links">
            <?php
                $jobs_page = WP_Job_Board_Mixes::get_jobs_page_url();
                $filter_url = add_query_arg( 'filter-author', $author_id, $jobs_page );
            ?>
            <a href="<?php echo esc_url($filter_url); ?>"><?php esc_html_e('View all jobs', 'careerup'); ?> <i class="flaticon-right-arrow"></i></a>
            <a href="<?php echo get_permalink($employer_id); ?>"><?php esc_html_e('Company Profile', 'careerup'); ?> <i class="flaticon-right-arrow"></i></a>
        </div>

        <?php if ( !empty($address) ) { ?>
            <div class="employer-address">
                <?php echo wp_kses_post($address); ?>
            </div>
        <?php } ?>
        <?php if ( !empty($phone) || !empty($email) ) { ?>
            <div class="bottom-inner">
        <?php } ?>
            <?php if ( !empty($phone) ) { ?>
                <div class="employer-phone">
                    <?php careerup_display_phone($phone); ?>
                </div>
            <?php } ?>
            <?php if ( !empty($email) ) { ?>
                <div class="employer-email">
                    <?php echo wp_kses_post($email); ?>
                </div>
            <?php } ?>
        <?php if ( !empty($phone) || !empty($email) ) { ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>