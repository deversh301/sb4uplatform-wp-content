<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$address = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'address', true );
$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);

$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );
?>
<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
<article <?php post_class('job-list-v4 job-card'); ?> data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
    <div class="flex-middle">
        
        <div class="employer-logo">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php if ( has_post_thumbnail($employer_id) ) { ?>
                    <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
                <?php } else { ?>
                    <img src="<?php echo esc_url(careerup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($employer_id)); ?>">
                <?php } ?>
            </a>
        </div>

        <div class="job-information">
            <div class="job-title-wrapper">
                <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                
                <?php careerup_job_display_featured_icon($post); ?>
                
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
    
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>