<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( careerup_get_jobs_layout_type() == 'main' ) { 
	add_action( 'wp_job_board_before_job_archive','careerup_add_filter_sidebar' , 26 );
}
?>
<div class="jobs-listing-wrapper main-items-wrapper" data-display_mode="<?php echo esc_attr($jobs_display_mode); ?>">
	<?php
	/**
	 * wp_job_board_before_job_archive
	 */
	do_action( 'wp_job_board_before_job_archive', $jobs );
	?>

	<?php if ( !empty($jobs) && !empty($jobs->posts) ) : ?>
		<?php
		/**
		 * wp_job_board_before_loop_job
		 */
		do_action( 'wp_job_board_before_loop_job', $jobs );
		?>
		
		<div class="jobs-wrapper items-wrapper">
			<?php if ( $jobs_display_mode == 'grid' ) {
				$columns = careerup_get_jobs_columns();
				$bcol = $columns ? 12/$columns : 4;
				$i = 0;
			?>
				<div class="row">
					<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($bcol); ?> col-xs-12 <?php echo esc_attr(($i%$columns == 0)?'md-clearfix':'') ?> <?php echo esc_attr(($i%2 == 0)?'sm-clearfix':'') ?>">
							<?php echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-'.$job_inner_style ); ?>
						</div>
					<?php $i++; endwhile; ?>
				</div>
			<?php } else { ?>
				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-'.$job_inner_style ); ?>
				<?php endwhile; ?>
			<?php } ?>
		</div>

		<?php
		/**
		 * wp_job_board_after_loop_job
		 */
		do_action( 'wp_job_board_after_loop_job', $jobs );
		
		wp_reset_postdata();
		?>

	<?php else : ?>
		<div class="not-found"><?php esc_html_e('No job found.', 'careerup'); ?></div>
	<?php endif; ?>

	<?php
	/**
	 * wp_job_board_after_job_archive
	 */
	do_action( 'wp_job_board_after_job_archive', $jobs );
	?>
</div>