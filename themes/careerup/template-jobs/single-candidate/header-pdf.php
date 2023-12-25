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

$urgent = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'urgent', true );
?>
<div class="candidate-detail-header">
    <div class="flex-sm row">
        <div class="col-xs-12"> 
            <div class="flex">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="candidate-thumbnail flex-middle">
                        <div class="inner-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
                <div class="candidate-information">
                    <div class="title-wrapper">
                        <h1 class="candidate-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
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
                            <div class="candidate-phone"><i class="flaticon-telephone text-theme"></i><?php echo wp_kses_post($phone); ?></div>
                        <?php } ?>
                        <?php if ( $email ) { ?>
                            <div class="candidate-email"><i class="flaticon-mail text-theme"></i><?php echo wp_kses_post($email); ?></div>
                        <?php } ?>
                    </div>
                    <div class="job-metas-cadidate">
                        <?php if ( $address ) { ?>
                            <div class="candidate-address"><i class="flaticon-location-pin text-theme"></i><?php echo wp_kses_post($address); ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>  
        
    </div>
</div>