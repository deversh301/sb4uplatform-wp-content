<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

$job_title = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'job_title', true );
$categories = get_the_terms( $post->ID, 'candidate_category' );
$address = get_the_terms( $post->ID, 'candidate_location' );
$rating_avg = WP_Job_Board_Review::get_ratings_average($post->ID);

$featured = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'featured', true );
$urgent = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'urgent', true );
?>

<?php do_action( 'wp_job_board_before_candidate_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('candidate-card'); ?>>
    <div class="candidate-grid-v1 candidate-archive-layout">
        <div class="top-inner">

            <div class="candidate-thumbnail">
                <div class="thumbnail-inner">
                    <a href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) { ?>
                            <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                        <?php } else { ?>
                            <img src="<?php echo esc_url(careerup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                        <?php } ?>
                    </a>
                    <?php if ( careerup_candidate_check_hidden_review() && !empty($rating_avg) ) { ?>
                        <div class="rating-avg"><?php echo round($rating_avg,1,PHP_ROUND_HALF_UP); ?></div>
                    <?php } ?>
                </div>
            </div>
            
            <?php the_title( sprintf( '<h2 class="candidate-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

            <?php if ( $job_title ) { ?>
                <div class="candidate-job">
                    <?php echo wp_kses_post($job_title); ?>
                </div>
            <?php } ?>
        </div>

        <?php if ( $address ) {
            $terms = array();
            careerup_locations_walk($address, 0, $terms);
        ?>
            <div class="candidate-location">
                <?php $i=1; foreach ($terms as $term) { ?>
                    <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($terms) ? ', ' : '' ); ?>
                <?php $i++; } ?>
            </div>
        <?php } ?>
            
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_candidate_content', $post->ID ); ?>