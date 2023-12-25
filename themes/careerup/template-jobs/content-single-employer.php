<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_job_board_before_job_detail', $post->ID ); ?>

<article id="post-<?php echo esc_attr($post->ID); ?>" <?php post_class('employer-single-v1 container'); ?>>
	<!-- heading -->
	<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-employer/header' ); ?>

	<!-- Main content -->
	<div class="row content-job-detail">
		<div class="col-xs-12 col-md-<?php echo esc_attr( is_active_sidebar( 'employer-single-sidebar' ) ? 8 : 12); ?>">

			<?php do_action( 'wp_job_board_before_employer_content', $post->ID ); ?>

			<!-- employer description -->
			<?php if ( $post->post_content ) { ?>
				<div class="employer-detail-description">
					<h3 class="title-detail-employer"><?php esc_html_e('Employer Description', 'careerup'); ?></h3>
					<div class="inner">
						<?php the_content(); ?>
					</div>
				</div>
			<?php } ?>
			
			<!-- Video -->
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-employer/video' ); ?>

			<!-- Socials -->
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-employer/socials' ); ?>

			<!-- profile photos -->
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-employer/profile-photos' ); ?>

			<!-- team member -->
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-employer/members' ); ?>
			
			<!-- employer releated -->
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-employer/open-jobs' ); ?>

			<?php if ( careerup_check_employer_candidate_review($post) ) : ?>
				<!-- Review -->
				<?php comments_template(); ?>
			<?php endif; ?>

			<?php do_action( 'wp_job_board_after_employer_content', $post->ID ); ?>
		</div>
		<?php if ( is_active_sidebar( 'employer-single-sidebar' ) ): ?>
			<div class="col-md-4 col-xs-12">
		   		<?php dynamic_sidebar( 'employer-single-sidebar' ); ?>
		   	</div>
	   	<?php endif; ?>
	</div>

</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_detail', $post->ID ); ?>