<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_job_board_before_job_detail', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('job-single-v3'); ?>>
	<!-- heading -->
	<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/header-v3' ); ?>

	<!-- Main content -->
	<div class="row content-job-detail">
		<div class="left-content col-xs-12 col-md-<?php echo esc_attr( is_active_sidebar( 'job-single-sidebar-v3' ) ? 8 : 12); ?>">

			<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
			
			<!-- job description -->
			<div class="job-detail-description">
				<h3 class="title-detail-job"><?php esc_html_e('Job Description', 'careerup'); ?></h3>
				<div class="inner">
					<?php the_content(); ?>
				</div>
			</div>
			<!-- Job Map -->
			<div class="widget">
				<h3 class="widget-title"><?php echo esc_html__('Job Location','careerup') ?></h3>
				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/map-location' ); ?>
			</div>
			<div class="job-detail-statistic flex-middle-sm">
				
			    	<div class="statistic-item flex-middle">
			    		<div class="icon text-theme">
			    		<i class="flaticon-24-hours-support"></i></div>
			    		<span class="text"><?php echo sprintf(wp_kses(__('<span class="number">%s</span> ago', 'careerup'), array( 'span' => array('class' => array()) )), human_time_diff(get_the_time('U'), current_time('timestamp')) ); ?></span>
			    	</div>

			    <?php
			    	$views = intval(get_post_meta($post->ID, '_viewed_count', true));
				?>
			    	<div class="statistic-item flex-middle">
			    		<div class="icon text-theme">
			    		<i class="flaticon-zoom-in"></i></div>
			    		<span class="text"><?php echo sprintf(_n('<span class="number">%d</span> View', '<span class="number">%d</span> Views', intval($views), 'careerup'), intval($views)); ?></span>
			    	</div>

			    <?php
			    	$query_args = array(
						'post_type'         => 'job_applicant',
						'posts_per_page'    => 1,
						'post_status'       => 'publish',
						'meta_query'       => array(
							array(
								'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'job_id',
								'value'     => $post->ID,
								'compare'   => '=',
							)
						)
					);
					$loop = new WP_Query($query_args);
					$total = $loop->found_posts;
				?>
			    	<div class="statistic-item flex-middle">
			    		<div class="icon text-theme">
			    		<i class="flaticon-businessman-paper-of-the-application-for-a-job"></i></div>
			    		<span class="text"><?php echo sprintf(_n('<span class="number">%d</span> Applicant', '<span class="number">%d</span> Applicants', intval($total), 'careerup'), intval($total)); ?></span>
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
		
		<?php if ( is_active_sidebar( 'job-single-sidebar-v3' ) ): ?>
			<div class="col-md-4 col-xs-12">
		   		<?php dynamic_sidebar( 'job-single-sidebar-v3' ); ?>
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