<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$types = get_the_terms( $post->ID, 'job_listing_type' );
$address = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'address', true );
$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);
$jobs_page = WP_Job_Board_Mixes::get_jobs_page_url();
$filter_url = add_query_arg( 'filter-author', $author_id, $jobs_page );
?>
<div class="job-detail-header job-detail-header-v3">
    <div class="row flex-middle-sm">
        <div class="col-sm-8 col-xs-12">
            <div class="flex-middle">
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

                    <div class="clearfix link-more text-center">
                        <a href="<?php echo esc_url($filter_url); ?>" class="btn-link-job"><?php esc_html_e('View all jobs', 'careerup'); ?><span class="next flaticon-right-arrow"></span></a>
                    </div>
                </div>
                <div class="inner-info">
                        <?php if ( $types ) { ?>
                            <?php foreach ($types as $term) { ?>
                                <a class="text-theme type-job" href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a>
                            <?php } ?>
                        <?php } ?>
                        
                        <div class="job-title-wrapper">
                            <?php the_title( '<h1 class="job-detail-title">', '</h1>' ); ?>
                            <?php careerup_job_display_featured_urgent($post); ?>
                        </div>
                        
                        <div class="job-date-author">
                            <?php echo sprintf(esc_html__('Posted %s ago', 'careerup'), human_time_diff(get_the_time('U'), current_time('timestamp')) ); ?> 
                            <?php
                            if ( $employer_id ) {
                                echo sprintf(wp_kses(__('by <a class="text-theme" href="%s">%s</a>', 'careerup'), array( 'a' => array('class' => array(), 'href' => array()) ) ), get_permalink($employer_id), get_the_title($employer_id) );
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
                </div>
            </div>
        </div> 
        <div class="col-sm-4 col-xs-12">
            <div class="job-detail-buttons">
                <div class="wrapper-shortlist">
                    <?php WP_Job_Board_Job_Listing::display_shortlist_btn($post->ID); ?>
                </div>
                <div class="wrapper-apply flex-middle">
                    <?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
                </div>
            </div>
        </div>
    </div>
</div>