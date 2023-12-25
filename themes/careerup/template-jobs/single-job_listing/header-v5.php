<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);

$address = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'address', true );
$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);
$jobs_page = WP_Job_Board_Mixes::get_jobs_page_url();
$filter_url = add_query_arg( 'filter-author', $author_id, $jobs_page );


    if(has_post_thumbnail()){
        $img_bg_src = wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), 'full' );
        $style = 'style="background-image:url('.esc_url($img_bg_src).')"';
    }else{
        $style = '';
    }
?>
<div class="job-detail-header job-detail-header-v5" <?php echo trim($style); ?>>
    <div class="top-header-job-detail">
        <div class="max-750">
            <div class="flex-middle-sm clearfix">
                <div class="left-inner">
                    <div class="job-detail-thumbnail">
                        <a href="<?php echo esc_url(get_permalink($employer_id)); ?>">
                            <?php if ( has_post_thumbnail($employer_id) ) { ?>
                                <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
                            <?php } else { ?>
                                <img src="<?php echo esc_url(careerup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($employer_id)); ?>">
                            <?php } ?>
                        </a>
                    </div>
                </div>
                <div class="inner-info">
                    <div class="job-title-wrapper">
                        <?php the_title( '<h1 class="job-detail-title">', '</h1>' ); ?>
                        <?php careerup_job_display_featured_urgent($post); ?>
                    </div>
                    <div class="job-date-author">
                        <?php echo sprintf(esc_html__('Posted %s ago', 'careerup'), human_time_diff(get_the_time('U'), current_time('timestamp')) ); ?> 
                        <?php
                        if ( $employer_id ) {
                            echo sprintf(wp_kses(__('by <a class="text-theme" href="%s">%s</a>', 'careerup'), array( 'a' => array('class' => array(), 'href' => array()) ) ), get_permalink($employer_id), get_the_title($employer_id));
                        }
                        ?>
                    </div>
                    <div class="job-metas">
                        <?php if ( $address ) { ?>
                            <div class="job-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
                        <?php } ?>
                        <?php if ( $salary ) { ?>
                            <div class="job-salary"><i class="flaticon-price"></i><?php echo wp_kses_post($salary); ?></div>
                        <?php } ?>
                    </div>
                    <div class="clearfix link-more">
                        <a href="<?php echo esc_url($filter_url); ?>" class="btn-link-job"><?php esc_html_e('View all jobs', 'careerup'); ?><span class="next flaticon-right-arrow"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>