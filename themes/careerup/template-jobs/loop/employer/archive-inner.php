<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$display_mode = careerup_get_employers_display_mode();
$columns = careerup_get_employers_columns();
$bcol = $columns ? 12/$columns : 4;
?>
<div class="employers-listing-wrapper main-items-wrapper layout-type-<?php echo esc_attr($display_mode); ?>" data-display_mode="<?php echo esc_attr($display_mode); ?>">
	<?php
	/**
	 * wp_job_board_before_employer_archive
	 */
	do_action( 'wp_job_board_before_employer_archive', $employers );
	?>
	<?php
	if ( !empty($employers) && !empty($employers->posts) ) {

		/**
		 * wp_job_board_before_loop_employer
		 */
		do_action( 'wp_job_board_before_loop_employer', $employers );
		?>

		<div class="employers-wrapper items-wrapper">
			<?php 
				if ( $display_mode == 'grid' ) { 
					$i = 0;
			?>
				<div class="row">
					<?php while ( $employers->have_posts() ) : $employers->the_post(); ?>
						<div class="col-sm-6 col-md-<?php echo esc_attr($bcol); ?> col-xs-12 <?php echo esc_attr($i%$columns == 0 ? 'md-clearfix':''); ?> <?php echo esc_attr($i%2 == 0 ? 'sm-clearfix':''); ?>">
							<?php echo WP_Job_Board_Template_Loader::get_template_part( 'employers-styles/inner-grid' ); ?>
						</div>
					<?php $i++; endwhile; ?>
				</div>
			<?php } elseif ( $display_mode == 'list' ) { ?>
				<?php while ( $employers->have_posts() ) : $employers->the_post(); ?>
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'employers-styles/inner-list' ); ?>
				<?php endwhile; ?>
			<?php } else {

				$companies_by_letter = array();
				while ( $employers->have_posts() ) : $employers->the_post();
					global $post;
					$company = $post->post_title;
					if ( !empty($company[0]) ) {
						$companies_by_letter[strtoupper($company[0])][] = $post->ID;
					}
				endwhile;
				?>

				<ul class="list-alphabet">
					<?php foreach ( range( 'A', 'Z' ) as $letter ) { ?>
						<li><a href="#<?php echo esc_attr($letter); ?>"><?php echo esc_attr($letter); ?></a></li>
					<?php } ?>
				</ul>
				
				<div class="row">
					<?php $i = 0; foreach ( range( 'A', 'Z' ) as $letter ) {
						if ( ! isset( $companies_by_letter[ $letter ] ) ) {
							continue;
						}
						?>
						<div class="company-items col-sm-6 col-md-<?php echo esc_attr($bcol); ?> <?php echo esc_attr(($i%$columns)== 0 ?'md-clearfix':''); ?> <?php echo esc_attr(($i%2)== 0 ?'sm-clearfix':''); ?>">
							<div id="<?php echo esc_attr($letter); ?>" class="letter-title"><span><?php echo esc_attr($letter); ?></span></div>
							<?php foreach ( $companies_by_letter[$letter] as $employer_id ) { ?>
								<div class="company-item">
									<a href="<?php echo esc_url(get_permalink( $employer_id )); ?>">
										<?php echo get_the_title($employer_id); ?>
									</a>
								</div>

						<?php } ?>
						</div>
					<?php $i++; } ?>
				</div>
			<?php } ?>
		</div>

		<?php
		/**
		 * wp_job_board_after_loop_employer
		 */
		do_action( 'wp_job_board_after_loop_employer', $employers );

		wp_reset_postdata();
	?>

	<?php } else { ?>
		<div class="not-found"><?php esc_html_e('No employer found.', 'careerup'); ?></div>
	<?php } ?>

	<?php
	/**
	 * wp_job_board_after_employer_archive
	 */
	do_action( 'wp_job_board_after_employer_archive', $employers );
	?>
</div>