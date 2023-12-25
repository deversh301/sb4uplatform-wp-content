<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;


$categories = get_the_terms( $post->ID, 'candidate_category' );
$address = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'address', true );

if ( method_exists('WP_Job_Board_Candidate', 'get_display_phone') ) {
    $phone = WP_Job_Board_Candidate::get_display_phone( $post );
} else {
    $phone = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'phone', true );
}

if ( method_exists('WP_Job_Board_Candidate', 'get_display_email') ) {
    $email = WP_Job_Board_Candidate::get_display_email( $post );
} else {
    $email = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'email', true );
}

$featured = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'featured', true );
$urgent = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'urgent', true );

$rating_avg = WP_Job_Board_Review::get_ratings_average($post->ID);
?>
<div class="candidate-detail-header">
    <div class="flex-middle-sm row">
        <div class="col-md-8 col-sm-8 col-xs-12"> 
            <div class="flex">
                
                <div class="candidate-thumbnail flex-middle justify-content-center">
                    <div class="inner-image">
                        <?php if ( has_post_thumbnail() ) { ?>
                            <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
                        <?php } else { ?>
                            <img src="<?php echo esc_url(careerup_placeholder_img_src('full')); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                        <?php } ?>
                    </div>
                    <?php if ( careerup_candidate_check_hidden_review() && !empty($rating_avg) ) { ?>
                        <div class="rating-avg"><?php echo round($rating_avg,1,PHP_ROUND_HALF_UP); ?></div>
                    <?php } ?>
                </div>

                <div class="candidate-information">
                    <div class="title-wrapper">
                        <?php the_title( '<h1 class="candidate-title">', '</h1>' ); ?>
                        <?php if ( $featured ) { ?>
                            <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'careerup'); ?>"><i class="fa fa-star text-theme"></i></span>
                        <?php } ?>
                        <?php if ( $urgent ) { ?>
                            <span class="urgent"><?php esc_html_e('Urgent', 'careerup'); ?></span>
                        <?php } ?>
                    </div>
                    <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) { ?>
                        <?php foreach ($categories as $term) { ?>
                            <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a>
                        <?php } ?>
                    <?php } ?>

                    <div class="job-metas-cadidate">
                        <?php if ( $phone ) { ?>
                            <div class="candidate-phone">
                                <?php careerup_display_phone($phone, 'flaticon-phone-call text-theme'); ?>
                            </div>
                        <?php } ?>
                        <?php if ( $email ) { ?>
                            <div class="candidate-email"><i class="flaticon-mail text-theme"></i><?php echo wp_kses_post($email); ?></div>
                        <?php } ?>
                    </div>
                    
                    <?php if ( careerup_candidate_check_hidden_review() && !empty($rating_avg) ) { ?>
                        <div class="rating-avg-star"><?php echo WP_Job_Board_Review::print_review($rating_avg); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>  
        <div class="col-xs-12 col-sm-4 col-md-4">
            <div class="candidate-detail-buttons flex-middle">
                <div class="wrapper-shortlist">
                    <?php WP_Job_Board_Candidate::display_shortlist_btn($post->ID); ?>
                </div>
                <?php
                    
                    WP_Job_Board_Candidate::display_download_cv_btn($post->ID);
                    
                ?>
            </div>
        </div>
    </div>
</div>