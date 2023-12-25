<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$categories = get_the_terms( $post->ID, 'employer_category' );
$website = WP_Job_Board_Employer::get_post_meta( $post->ID, 'website', true );

if ( method_exists('WP_Job_Board_Employer', 'get_display_phone') ) {
    $phone = WP_Job_Board_Employer::get_display_phone( $post );
} else {
    $phone = WP_Job_Board_Employer::get_post_meta( $post->ID, 'phone', true );
}

if ( method_exists('WP_Job_Board_Employer', 'get_display_email') ) {
    $email = WP_Job_Board_Employer::get_display_email( $post );
} else {
    $email = WP_Job_Board_Employer::get_post_meta( $post->ID, 'email', true );
}

$featured = WP_Job_Board_Employer::get_post_meta( $post->ID, 'featured', true );

?>
<div class="candidate-detail-header">
    <div class="flex-middle-sm row">
        <div class="col-xs-12 col-sm-9">  
            <div class="flex-middle">

                <div class="employer-thumbnail flex-middle">
                    <div class="inner-image">
                        <?php if ( has_post_thumbnail() ) { ?>
                            <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
                        <?php } else { ?>
                            <img src="<?php echo esc_url(careerup_placeholder_img_src('full')); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                        <?php } ?>
                    </div>
                </div>

                <div class="candidate-information">
                    <div class="title-wrapper">
                        <?php the_title( '<h1 class="candidate-title">', '</h1>' ); ?>
                        <?php if ( $featured ) { ?>
                            <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'careerup'); ?>"><i class="fa fa-star text-theme"></i></span>
                        <?php } ?>
                    </div>
                    <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ){ ?>
                        <?php foreach ($categories as $term) { ?>
                            <a class="text-theme" href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a>
                        <?php } ?>
                    <?php } ?>
                    <div class="job-metas-cadidate">
                        <?php if ( $website ) { ?>
                            <div class="employer-website"><i class="flaticon-link text-theme"></i><a href="<?php echo esc_url($website); ?>"><?php echo esc_html($website); ?></a></div>
                        <?php } ?>
                        <?php if ( $phone ) { ?>
                            <div class="employer-phone">
                                <?php careerup_display_phone($phone, 'flaticon-phone-call text-theme'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ( $email ) { ?>
                        <div class="job-metas-cadidate">
                            <div class="employer-email"><i class="flaticon-mail text-theme"></i><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">  
            <div class="candidate-detail-buttons">
                <?php WP_Job_Board_Employer::display_follow_btn($post->ID); ?>
                <?php if ( careerup_check_employer_candidate_review($post) ) { ?>
                    <a href="#review_form_wrapper" class="btn button btn-block btn-shortlist btn-icon add-a-review"><i class="flaticon-consulting-message pre"></i><?php esc_html_e('Add a review', 'careerup'); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>