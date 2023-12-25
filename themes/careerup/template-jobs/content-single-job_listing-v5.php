<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_job_board_before_job_detail', $post->ID ); ?>
<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/header-v5' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('job-single-v5 max-750'); ?>>
	<!-- Main content -->
	<div class="row content-job-detail">
		<div class="col-sm-<?php echo esc_attr( is_active_sidebar( 'job-single-sidebar-v5' ) ? 8 : 12); ?>">

			<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
			
			<div class="job-detail-buttons">
	            <div class="wrapper-apply">
	                <?php WP_Job_Board_Job_Listing::display_apply_job_btn($post->ID); ?>
	            </div>
	            <div class="flex-middle-sm">
		            <?php
		            if ( WP_Job_Board_Candidate::check_added_shortlist($post->ID) ) {
		                $classes = 'btn-added-job-shortlist btn btn-shortlist btn-block';
		                $nonce = wp_create_nonce( 'wp-job-board-remove-job-shortlist-nonce' );
		            } else {
		                $classes = 'btn-add-job-shortlist btn btn-shortlist btn-block';
		                $nonce = wp_create_nonce( 'wp-job-board-add-job-shortlist-nonce' );
		            }
		            ?>
		            <div class="wrapper-shortlist">
		                <a href="javascript:void(0);" class="<?php echo esc_attr($classes); ?>" data-job_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"><i class="pre flaticon-favorites"></i><?php esc_html_e('Shortlist', 'careerup'); ?></a>
		            </div>

		            <!-- share job -->
		            <?php
		            if ( careerup_get_config('show_job_social_share', false) ) { ?>
		                <div class="sharing-popup">
		                    <a href="#" class="share-popup action-button btn btn-block" title="<?php esc_attr_e('Social Share', 'careerup'); ?>">
		                        <i class="flaticon-share"></i> <?php esc_html_e('Share', 'careerup'); ?>
		                    </a>
		                    <div class="share-popup-box">
		                        <?php get_template_part( 'template-parts/sharebox-job' ); ?>
		                    </div>
		                </div>
		            <?php } ?>
		        </div>
	        </div>

			<!-- job description -->
			<div class="job-detail-description">
				<h3 class="title-detail-job"><?php esc_html_e('Job Description', 'careerup'); ?></h3>
				<div class="inner">
					<?php the_content(); ?>
				</div>
			</div>

			<!-- job releated -->
			<?php if ( careerup_get_config('job_releated_show', true) ) { ?>
				<div class="hidden-xs hidden-sm">
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/releated' ); ?>
				</div>
			<?php } ?>
			<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>
		</div>
		
		<?php if ( is_active_sidebar( 'job-single-sidebar-v5' ) ): ?>
			<div class="col-sm-4">
		   		<?php dynamic_sidebar( 'job-single-sidebar-v5' ); ?>
		   	</div>
	   	<?php endif; ?>
	   	<!-- job releated -->
	   	<?php if ( careerup_get_config('job_releated_show', true) ) { ?>
			<div class="hidden-lg hidden-md col-xs-12">
				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/releated' ); ?>
			</div>
	   	<?php } ?>
	</div>

</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_detail', $post->ID ); ?>