<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$types = get_the_terms( $post->ID, 'job_listing_type' );

if( has_post_thumbnail() ){
    $img_bg_src = wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), 'full' );
    $style = 'style="background-image:url('.esc_url($img_bg_src).')"';
}else{
    $style = '';
}
?>

<div class="job-detail-header job-detail-header-v7" <?php echo trim($style); ?>>
    <div class="container">
        <div class="row flex-middle-md">
            
            <div class="inncol-xs-12 col-md-8">
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
            <div class="col-xs-12 col-md-4">
                <div class="job-detail-buttons">
                    
                    <div class="wrapper-apply">
                        <?php careerup_display_apply_job_btn($post->ID); ?>
                    </div>
                    
                    <div class="wrapper-shortlist">
                        <?php WP_Job_Board_Job_Listing::display_shortlist_btn($post->ID); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>