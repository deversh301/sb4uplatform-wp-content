<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$job_title = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'job_title', true );
$address = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'address', true );
$salary = WP_Job_Board_Candidate::get_salary_html($post->ID);

?>

<?php do_action( 'wp_job_board_before_candidate_content', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="candidate-list candidate-list-small candidate-archive-layout">
        <div class="flex">

            <div class="candidate-thumbnail">
                <div class="thumbnail-inner">
                    <a href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) { ?>
                            <?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
                        <?php } else { ?>
                            <img src="<?php echo esc_url(careerup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                        <?php } ?>
                    </a>
                </div>
            </div>
            
            <div class="flex-middle inner-left">
                <div class="candidate-information">
                	
                    <div class="candidate-title-wrapper">
                		<?php the_title( sprintf( '<h2 class="candidate-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    </div>

                    <?php if ( $job_title ) { ?>
                        <div class="candidate-job-title">
                            <?php echo wp_kses_post($job_title); ?>
                        </div>
                    <?php } ?>

                    <div class="info job-metas clearfix">
                        <?php if ( $address ) { ?>
                            <div class="candidate-location">
                                <i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?>
                            </div>
                        <?php } ?>

                        <?php if ( $salary ) { ?>
                            <div class="candidate-salary">
                                <i class="flaticon-price"></i><?php echo wp_kses_post($salary); ?>
                            </div>
                        <?php } ?>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</article><!-- #post# -->
<?php do_action( 'wp_job_board_after_candidate_content', $post->ID ); ?>