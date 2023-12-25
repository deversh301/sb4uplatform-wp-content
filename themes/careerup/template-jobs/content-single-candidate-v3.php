<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_job_board_before_job_detail', get_the_ID() ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('candidate-single-v3'); ?>>
	<div class="<?php echo apply_filters('careerup_candidate_content_class', 'container');?>">
		<!-- heading -->
		<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/header-v3' ); ?>

		<div class="panel-affix-wrapper">
			<div class="header-tabs-wrapper panel-affix">
				<div class="header-tabs-nav">
					<ul class="nav">
						<li><a href="#job-candidate-description"><?php esc_html_e('Description', 'careerup'); ?></a></li>
						<?php
						$video_url = WP_Job_Board_Candidate::get_post_meta($post->ID, 'video_url', true );
						if ( !empty($video_url) ) {
						?>
							<li><a href="#job-candidate-video"><?php esc_html_e('Video', 'careerup'); ?></a></li>
						<?php } ?>

						<li><a href="#job-candidate-education"><?php esc_html_e('Education', 'careerup'); ?></a></li>
						<li><a href="#job-candidate-experience"><?php esc_html_e('Experience', 'careerup'); ?></a></li>
						<li><a href="#job-candidate-portfolio"><?php esc_html_e('Portfolios', 'careerup'); ?></a></li>
						<li><a href="#job-candidate-skill"><?php esc_html_e('Skill', 'careerup'); ?></a></li>
						<li><a href="#job-candidate-award"><?php esc_html_e('Award', 'careerup'); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Main content -->
		<div class="row content-single-candidate ">
			<div class="col-xs-12 list-content-candidate col-md-<?php echo esc_attr( is_active_sidebar( 'candidate-single-sidebar' ) ? 8 : 12); ?>">

				<?php do_action( 'wp_job_board_before_job_content', get_the_ID() ); ?>
				<!-- job description -->
				<div id="job-candidate-description" class="job-detail-description">
					<h3 class="title-candidate-description"><?php esc_html_e('About Me', 'careerup'); ?></h3>
					<div class="inner">
						<?php the_content(); ?>
					</div>
				</div>

				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/video' ); ?>

				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/education' ); ?>

				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/experience' ); ?>

				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/portfolios' ); ?>

				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/skill' ); ?>

				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-candidate/award' ); ?>

				<?php if ( careerup_check_employer_candidate_review($post) ) : ?>
					<!-- Review -->
					<?php comments_template(); ?>
				<?php endif; ?>

				<?php do_action( 'wp_job_board_after_job_content', get_the_ID() ); ?>
			</div>
			<?php if ( is_active_sidebar( 'candidate-single-sidebar' ) ): ?>
				<div class="col-xs-12 col-md-4">
			   		<?php dynamic_sidebar( 'candidate-single-sidebar' ); ?>
			   	</div>
		   	<?php endif; ?>
		</div>
	</div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_detail', get_the_ID() ); ?>