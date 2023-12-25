<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$types = get_the_terms( $post->ID, 'job_listing_type' );


?>

<div class="job-detail-header job-detail-header-v6">
    <div class="top-header-job-detail">
        
        <div class="inner-info">
            <?php if ( $types ) { ?>
                <div class="job-type-wrapper">
                    <?php foreach ($types as $term) { ?>
                        <a class="type-job" href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a>
                    <?php } ?>
                </div>
            <?php } ?>

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

        </div>

    </div>
</div>