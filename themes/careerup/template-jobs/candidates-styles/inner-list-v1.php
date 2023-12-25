<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$categories = get_the_terms( $post->ID, 'candidate_category' );
$locations = get_the_terms( $post->ID, 'candidate_location' );

$rating_avg = WP_Job_Board_Review::get_ratings_average($post->ID);
$address = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'address', true );
$salary = WP_Job_Board_Candidate::get_salary_html($post->ID);

$featured = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'featured', true );
$urgent = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'urgent', true );

?>

<?php do_action( 'wp_job_board_before_candidate_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('candidate-card'); ?>>
    <div class="candidate-list candidate-list-v1 candidate-archive-layout">
        <div class="flex">
        	
            <div class="candidate-thumbnail">
                <div class="thumbnail-inner">
                    <a href="<?php the_permalink(); ?>" class="justify-content-center flex-middle">
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
                <?php if ( $urgent ) { ?>
                    <span class="urgent"><?php esc_html_e('Urgent', 'careerup'); ?></span>
                <?php } ?>
            </div>
            
            <div class="flex-middle inner-left">
                <div class="candidate-information">
                	
                    <div class="candidate-title-wrapper">
                		<?php the_title( sprintf( '<h2 class="candidate-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                        <?php if ( $featured ) { ?>
                            <span class="featured" data-toggle="tooltip" title="<?php esc_attr_e('featured', 'careerup'); ?>" data-placement="right"><i class="fa fa-star text-theme"></i></span>
                        <?php } ?>
                    </div>

                    <div class="info job-metas clearfix">
                        <?php if ( $categories ) { ?>
                            <div class="candidate-category">
                                <?php $i=1; foreach ($categories as $term) { ?>
                                    <a href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a><?php if( $i < count($categories) ){ echo ','; } ?>
                                <?php $i++;} ?>
                            </div>
                        <?php } ?>

                        <?php if ( $locations ) { ?>
                            <div class="candidate-location">
                                <?php $i=1; foreach ($locations as $term) { ?>
                                    <a href="<?php echo get_term_link($term); ?>"><?php echo esc_html($term->name); ?></a><?php if( $i < count($locations) ){ echo ','; } ?>
                                <?php $i++;} ?>
                            </div>
                        <?php } ?>

                        <?php if ( $salary ) { ?>
                            <div class="candidate-salary">
                                <?php echo wp_kses_post($salary); ?>
                            </div>
                        <?php } ?>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</article><!-- #post# -->
<?php do_action( 'wp_job_board_after_candidate_content', $post->ID ); ?>