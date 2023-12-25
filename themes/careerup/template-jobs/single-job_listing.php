<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$job_layout = careerup_get_job_layout_type();
$job_layout = !empty($job_layout) ? $job_layout : 'v1';
?>
<section class="detail-version-<?php echo esc_attr($job_layout); ?>">
	<?php if ( $job_layout == 'v7' ) { ?>
		<!-- heading -->
		<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/header-v7' ); ?>
	<?php } ?>
	<section id="primary" class="content-area <?php echo apply_filters('careerup_job_content_class', 'container');?> inner">
		<main id="main" class="site-main content" role="main">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post();
					global $post;

					if ( method_exists('WP_Job_Board_Job_Listing', 'check_view_job_detail') && !WP_Job_Board_Job_Listing::check_view_job_detail() ) {
					?>
						<div class="restrict-wrapper">
							<?php
								$restrict_detail = wp_job_board_get_option('job_restrict_detail', 'all');
								switch ($restrict_detail) {
									case 'register_user':
										?>
										<h2 class="restrict-title"><?php esc_html_e( 'The page is restricted only for register user.', 'careerup' ); ?></h2>
										<div class="restrict-content"><?php esc_html_e( 'You need login to view this page', 'careerup' ); ?></div>
										<?php
										break;
									case 'only_applicants':
										?>
										<h2 class="restrict-title"><?php esc_html_e( 'The page is restricted only for candidates view his applicants.', 'careerup' ); ?></h2>
										<?php
										break;
									case 'register_candidate':
										?>
										<h2 class="restrict-title"><?php esc_html_e( 'The page is restricted only for candidates.', 'careerup' ); ?></h2>
										<?php
										break;
									default:
										$content = apply_filters('wp-job-board-restrict-job-detail-information', '', $post);
										echo trim($content);
										break;
								}
							?>
						</div><!-- /.alert -->

						<?php
					} else {

						$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
						$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );
				?>
						<div class="single-listing-wrapper" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
							<?php
								if ( $job_layout !== 'v1' ) {
									echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-job_listing-'.$job_layout );
								} else {
									echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-job_listing' );
								}
							?>
						</div>
				<?php
					}

				endwhile; ?>

				<?php the_posts_pagination( array(
					'prev_text'          => esc_html__( 'Previous page', 'careerup' ),
					'next_text'          => esc_html__( 'Next page', 'careerup' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'careerup' ) . ' </span>',
				) ); ?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</main><!-- .site-main -->
	</section><!-- .content-area -->
</section>
<?php get_footer(); ?>
