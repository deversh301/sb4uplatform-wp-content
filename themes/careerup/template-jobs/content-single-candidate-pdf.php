<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php do_action( 'wp_job_board_before_job_detail', get_the_ID() ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('candidate-single-v1'); ?>>
	<!-- heading -->
	<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/header-pdf' ); ?>

	<!-- Main content -->
	<div class="row">
		<div class="col-sm-12">

			<?php do_action( 'wp_job_board_before_job_content', get_the_ID() ); ?>
			
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/detail' ); ?>

			<!-- job description -->
			<h2><?php esc_html_e('About Me', 'careerup'); ?></h2>
			<div class="job-detail-description">
				<div class="inner">
					<?php the_content(); ?>
				</div>
			</div>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/education' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/experience' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/portfolios' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/skill' ); ?>

			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/award' ); ?>
			
			<?php do_action( 'wp_job_board_after_job_content', get_the_ID() ); ?>
		</div>
	</div>

</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_detail', get_the_ID() ); ?>