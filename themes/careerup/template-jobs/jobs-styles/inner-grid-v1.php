<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$types = get_the_terms( $post->ID, 'job_listing_type' );
$address = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'address', true );

$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );

?>

<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('job-grid style2 text-center job-card'); ?> data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
	<?php if ( has_post_thumbnail($employer_id) ) { ?>
        <div class="employer-logo text-center">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
            </a>
            <?php careerup_job_display_featured_urgent($post); ?>
        </div>
    <?php } else { ?>
        <div class="employer-logo text-center">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <img src="<?php echo esc_url(careerup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($employer_id)); ?>">
            </a>
            <?php careerup_job_display_featured_urgent($post); ?>
        </div>
    <?php } ?>

    <div class="job-information">
    	<?php if ( $types ) { ?>
            <?php foreach ($types as $term) {
                $color = get_term_meta( $term->term_id, '_color', true );
                $style = '';
                if ( $color ) {
                    $style = 'color: '.$color;
                }
            ?>
                <a class="type-job" href="<?php echo get_term_link($term); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
            <?php } ?>
        <?php } ?>

		<div class="job-title-wrapper">
            <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            
        </div>

        <?php if ( $address ) { ?>
            <div class="job-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
        <?php } ?>

        <div class="bottom-metas">
            <a class="btn btn-grid1" href="<?php echo esc_url( get_permalink() ) ?>"><?php echo esc_html__('Browse Job','careerup') ?></a>
        </div>
	</div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>