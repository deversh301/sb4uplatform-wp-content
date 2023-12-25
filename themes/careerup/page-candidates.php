<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Careerup
 * @since Careerup 1.0
 */
/*
*Template Name: Candidates Template
*/

if ( isset( $_REQUEST['load_type'] ) && WP_Job_Board_Mixes::is_ajax_request() ) {
	if ( get_query_var( 'paged' ) ) {
	    $paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
	    $paged = get_query_var( 'page' );
	} else {
	    $paged = 1;
	}

	$query_args = array(
		'post_type' => 'candidate',
	    'post_status' => 'publish',
	    'post_per_page' => wp_job_board_get_option('number_candidates_per_page', 10),
	    'paged' => $paged,
	);
	$params = true;
	if ( WP_Job_Board_Employer_Filter::has_filter() ) {
		$params = $_GET;
	}
	$candidates = WP_Job_Board_Query::get_posts($query_args, $params);
	
	if ( 'items' !== $_REQUEST['load_type'] ) {
		echo WP_Job_Board_Template_Loader::get_template_part('archive-candidate-ajax-full', array('candidates' => $candidates));
	} else {
		echo WP_Job_Board_Template_Loader::get_template_part('archive-candidate-ajax-candidates', array('candidates' => $candidates));
	}
} else {
	get_header();
	$sidebar_configs = careerup_get_page_layout_configs();
	$filter_top_sidebar = careerup_get_candidates_filter_top_sidebar();
	?>
	<?php if ( $filter_top_sidebar && is_active_sidebar( 'candidates-filter-top-sidebar' ) ) { ?>
		<div class="candidates-filter-top-sidebar-wrapper filter-top-sidebar-wrapper">
	   		<?php dynamic_sidebar( 'candidates-filter-top-sidebar' ); ?>
	   	</div>
	<?php } ?>
	<section id="main-container" class="main-content <?php echo apply_filters('careerup_page_content_class', 'container');?> inner">
		<?php careerup_before_content( $sidebar_configs ); ?>
		<div class="row">
			<?php careerup_display_sidebar_left( $sidebar_configs ); ?>

			<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
				<main id="main" class="site-main" role="main">

					<?php
					// Start the loop.
					while ( have_posts() ) : the_post();
						
						// Include the page content template.
						the_content();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					// End the loop.
					endwhile;
					?>
					
				</main><!-- .site-main -->
			</div><!-- .content-area -->
			
			<?php careerup_display_sidebar_right( $sidebar_configs ); ?>
		</div>
	</section>

	<?php get_footer();
}