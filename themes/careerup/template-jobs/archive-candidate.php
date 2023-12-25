<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;
if ( isset( $_REQUEST['load_type'] ) && WP_Job_Board_Mixes::is_ajax_request() ) {
	if ( 'items' !== $_REQUEST['load_type'] ) {
        echo WP_Job_Board_Template_Loader::get_template_part('archive-candidate-ajax-full', array('candidates' => $wp_query));
	} else {
		echo WP_Job_Board_Template_Loader::get_template_part('archive-candidate-ajax-candidates', array('candidates' => $wp_query));
	}

} else {
	get_header();
	$sidebar_configs = careerup_get_candidates_layout_configs();
	$filter_top_sidebar = careerup_get_candidates_filter_top_sidebar();
	?>
	<?php if ( $filter_top_sidebar && is_active_sidebar( 'candidates-filter-top-sidebar' ) ) { ?>
		<div class="candidates-filter-top-sidebar-wrapper filter-top-sidebar-wrapper">
	   		<?php dynamic_sidebar( 'candidates-filter-top-sidebar' ); ?>
	   	</div>
	<?php } ?>
	<section id="main-container" class="main-content <?php echo apply_filters('careerup_candidate_content_class', 'container');?> inner">
		<?php careerup_before_content( $sidebar_configs ); ?>
		<div class="row">
			<?php careerup_display_sidebar_left( $sidebar_configs ); ?>

			<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
				<main id="main" class="site-main content" role="main">
					
					<?php
						echo WP_Job_Board_Template_Loader::get_template_part('loop/candidate/archive-inner', array('candidates' => $wp_query));

						echo WP_Job_Board_Template_Loader::get_template_part('loop/candidate/pagination', array('candidates' => $wp_query) );
					?>
				</main><!-- .site-main -->
			</div><!-- .content-area -->
			
			<?php careerup_display_sidebar_right( $sidebar_configs ); ?>
		</div>
	</section><!-- .content-area -->

	<?php get_footer();
}