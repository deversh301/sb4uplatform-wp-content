<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$featured = WP_Job_Board_Employer::get_post_meta( $post->ID, 'featured', true );
$categories = get_the_terms( $post->ID, 'employer_category' );
$locations = get_the_terms( $post->ID, 'employer_location' );

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

<article id="post-<?php the_ID(); ?>" <?php post_class('employer-card'); ?>>
    <div class="employer-grid">
        <?php if ( $featured ) { ?>
            <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'careerup'); ?>"><i class="fa fa-star text-theme"></i></span>
        <?php } ?>
        <div class="open-job">
            <?php echo sprintf(_n('<span class="text-theme">%d</span> Open Job', '<span class="text-theme">%d</span> Open Jobs', intval($count_jobs), 'careerup'), intval($count_jobs)); ?>
        </div>
        <div class="employer-thumbnail">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php if ( has_post_thumbnail() ) { ?>
                    <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
                <?php } else { ?>
                    <img src="<?php echo esc_url(careerup_placeholder_img_src('full')); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                <?php } ?>
            </a>
        </div>
        <div class="employer-information">
    		<div class="employer-title-wrapper">
                <?php the_title( sprintf( '<h2 class="employer-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                
            </div>
            <?php if ( $categories ) { ?>
                <?php foreach ($categories as $term) { ?>
                    <a href="<?php echo get_term_link($term); ?>" class="text-theme"><?php echo wp_kses_post($term->name); ?></a>
                <?php } ?>
            <?php } ?>

            <?php if ( $locations ) {
                $terms = array();
                careerup_locations_walk($locations, 0, $terms);
            ?>
                <div class="employer-location">
                    <i class="flaticon-location-pin"></i>
                    <?php $i=1; foreach ($terms as $term) { ?>
                        <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($terms) ? ', ' : '' ); ?>
                    <?php $i++; } ?>
                </div>
            <?php } ?>
    	</div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_employer_content', $post->ID ); ?>