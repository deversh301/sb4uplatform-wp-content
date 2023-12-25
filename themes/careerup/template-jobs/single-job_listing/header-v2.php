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

?>
<div class="job-detail-header job-detail-header-v2">
    
    <div class="job-information">
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

    <div class="job-detail-buttons">
        <div class="wrapper-apply">
            <?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
        </div>
        <div class="flex-middle-sm">
            <div class="wrapper-shortlist">
                <?php WP_Job_Board_Job_Listing::display_shortlist_btn($post->ID); ?>
            </div>

            <!-- share job -->
            <?php
            if ( careerup_get_config('show_job_social_share', false) ) { ?>
                <div class="sharing-popup">
                    <a href="#" class="share-popup action-button btn btn-block" title="<?php esc_attr_e('Social Share', 'careerup'); ?>">
                        <i class="flaticon-share"></i> <?php esc_html_e('Share', 'careerup'); ?>
                    </a>
                    <div class="share-popup-box">
                        <?php get_template_part( 'template-parts/sharebox' ); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>