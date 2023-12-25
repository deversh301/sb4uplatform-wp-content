<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$display_mode = careerup_get_candidates_display_mode();
?>
<div class="candidates-listing-wrapper main-items-wrapper layout-type-<?php echo esc_attr($display_mode); ?>" data-display_mode="<?php echo esc_attr($display_mode); ?>">
	<?php
	/**
	 * wp_job_board_before_candidate_archive
	 */
	do_action( 'wp_job_board_before_candidate_archive', $candidates );
	?>
	<?php
	if ( !empty($candidates) && !empty($candidates->posts) ) {

		/**
		 * wp_job_board_before_loop_candidate
		 */
		do_action( 'wp_job_board_before_loop_candidate', $candidates );
		?>

		<div class="candidates-wrapper items-wrapper">
			<?php if ( $display_mode == 'grid' ) {
				$columns = careerup_get_candidates_columns();
				$bcol = $columns ? 12/$columns : 4;
				$i = 0;
			?>
				<div class="row">
					<?php while ( $candidates->have_posts() ) : $candidates->the_post(); ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($bcol); ?> col-xs-12 <?php echo esc_attr(($i%$columns == 0)?'md-clearfix':''); ?> <?php echo esc_attr(($i%2 == 0)?'sm-clearfix':''); ?>">
							<?php echo WP_Job_Board_Template_Loader::get_template_part( 'candidates-styles/inner-grid' ); ?>
						</div>
					<?php $i++; endwhile; ?>
				</div>
			<?php } else { ?>
				<?php while ( $candidates->have_posts() ) : $candidates->the_post(); ?>
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'candidates-styles/inner-list' ); ?>
				<?php endwhile; ?>
			<?php } ?>
		</div>

		<?php
		/**
		 * wp_job_board_after_loop_candidate
		 */
		do_action( 'wp_job_board_after_loop_candidate', $candidates );

		wp_reset_postdata();
	?>

	<?php } else { ?>
		<div class="not-found"><?php esc_html_e('No candidate found.', 'careerup'); ?></div>
	<?php } ?>

	<?php
	/**
	 * wp_job_board_after_candidate_archive
	 */
	do_action( 'wp_job_board_after_candidate_archive', $candidates );
	?>
</div>