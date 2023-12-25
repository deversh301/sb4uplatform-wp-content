<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
$categories = get_the_terms( $post->ID, 'employer_category' );
$address = WP_Job_Board_Employer::get_post_meta( $post->ID, 'address', true );
$featured = WP_Job_Board_Employer::get_post_meta( $post->ID, 'featured', true );
$user_id = WP_Job_Board_User::get_user_by_employer_id($post->ID);
$args = array(
        'post_type' => 'job_listing',
        'post_per_page' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
        'author' => $user_id
    );
$jobs = WP_Job_Board_Query::get_posts($args);
$count_jobs = $jobs->found_posts;
?>

<?php do_action( 'wp_job_board_before_employer_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="employer-list employer-list-small">
        <div class="flex">
            <div class="employer-thumbnail flex-middle">
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                    <?php if ( has_post_thumbnail() ) { ?>
                        <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                    <?php } else { ?>
                        <img src="<?php echo esc_url(careerup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                    <?php } ?>
                </a>
            </div>
            <div class="flex-middle right-content">
                <div class="employer-information">
                    <div class="employer-title-wrapper">
                        <?php the_title( sprintf( '<h2 class="employer-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                        <?php if ( $featured ) { ?>
                            <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'careerup'); ?>"><i class="fa fa-star text-theme"></i></span>
                        <?php } ?>
                    </div>

                    <?php if ( $categories ) { ?>
                        <?php foreach ($categories as $term) { ?>
                            <a href="<?php echo get_term_link($term); ?>" class="text-theme"><?php echo wp_kses_post($term->name); ?></a>
                        <?php } ?>
                    <?php } ?>

                    <?php if ( $address ) { ?>
                        <div class="employer-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
                    <?php } ?>
                    <div class="open-job-small">
                        <?php echo sprintf(_n('<span class="text-theme">%d</span> Open Job', '<span class="text-theme">%d</span> Open Jobs', intval($count_jobs), 'careerup'), intval($count_jobs)); ?>
                    </div>
                </div>
                
            </div>
        </div>
        
	</div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_employer_content', $post->ID ); ?>