<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$employer_layout = careerup_get_employer_layout_type();
$employer_layout = !empty($employer_layout) ? $employer_layout : 'v1';
?>

<section id="primary" class="content-area inner">
	<main id="main" class="site-main content" role="main">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post();
				global $post;
				if ( method_exists('WP_Job_Board_Employer', 'check_view_employer_detail') && !WP_Job_Board_Employer::check_view_employer_detail() ) {
					?>
					<div class="restrict-wrapper container">
						<?php
							$restrict_detail = wp_job_board_get_option('employer_restrict_detail', 'all');
							switch ($restrict_detail) {
								case 'register_user':
									?>
									<h2 class="restrict-title"><?php echo esc_html__( 'The page is restricted only for register user.', 'careerup' ); ?></h2>
									<div class="restrict-content"><?php echo esc_html__( 'You need login to view this page', 'careerup' ); ?></div>
									<?php
									break;
								case 'only_applicants':
									?>
									<h2 class="restrict-title"><?php echo esc_html__( 'The page is restricted only for candidates view his applicants.', 'careerup' ); ?></h2>
									<?php
									break;
								case 'register_candidate':
									?>
									<h2 class="restrict-title"><?php echo esc_html__( 'The page is restricted only for candidates.', 'careerup' ); ?></h2>
									<?php
									break;
								default:
									$content = apply_filters('wp-job-board-restrict-employer-detail-information', '', $post);
									echo trim($content);
									break;
							}
						?>
					</div><!-- /.alert -->

					<?php
				} else {
					$latitude = WP_Job_Board_Employer::get_post_meta( $post->ID, 'map_location_latitude', true );
					$longitude = WP_Job_Board_Employer::get_post_meta( $post->ID, 'map_location_longitude', true );
				?>
					<div class="single-listing-wrapper" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
						<?php
							if ( $employer_layout !== 'v1' ) {
								echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-employer-'.$employer_layout );
							} else {
								echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-employer' );
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

<?php get_footer();
