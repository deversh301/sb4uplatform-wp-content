<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$types = get_the_terms( $post->ID, 'job_listing_type' );
$address = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'address', true );
$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);

$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );

?>
<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('job-list'); ?> data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
    <div class="clearfix">
        <div class="job-information flex-middle no-padding width-full">
            <div class="inner">
                <?php if ( $types ) { ?>
                    <?php foreach ($types as $term) { ?>
                        <a class="type-job" href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a>
                    <?php } ?>
                <?php } ?>

                <div class="job-title-wrapper">
                    <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    <?php careerup_job_display_featured_urgent($post); ?>
                </div>
                <div class="job-metas">
                    <?php if ( $address ) { ?>
                        <div class="job-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
                    <?php } ?>
                    <div class="date"><i class="flaticon-event"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></div>
                    <?php if ( $salary ) { ?>
                        <div class="job-salary"><i class="flaticon-price"></i><?php echo wp_kses_post($salary); ?></div>
                    <?php } ?>
                </div>
            </div>
            <div class="ali-right">
                <?php
                if ( WP_Job_Board_Candidate::check_added_shortlist($post->ID) ) {
                    $classes = 'btn-added-job-shortlist';
                    $nonce = wp_create_nonce( 'wp-job-board-remove-job-shortlist-nonce' );
                } else {
                    $classes = 'btn-add-job-shortlist';
                    $nonce = wp_create_nonce( 'wp-job-board-add-job-shortlist-nonce' );
                }
                ?>
                <div class="wrapper-shortlist">
                    <a href="javascript:void(0);" class="<?php echo esc_attr($classes); ?>" data-job_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"><i class="flaticon-favorites"></i></a>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>