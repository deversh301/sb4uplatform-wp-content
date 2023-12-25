<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_query;
if ( isset( $_REQUEST['load_type'] ) && WP_Job_Board_Mixes::is_ajax_request() ) {
	if ( 'items' !== $_REQUEST['load_type'] ) {
        echo WP_Job_Board_Template_Loader::get_template_part('archive-job_listing-ajax-full', array('jobs' => $wp_query));
	} else {
		echo WP_Job_Board_Template_Loader::get_template_part('archive-job_listing-ajax-jobs', array('jobs' => $wp_query));
	}

} else {
	get_header();

	$layout_type = careerup_get_jobs_layout_type();
	$jobs_display_mode = careerup_get_jobs_display_mode();
	$job_inner_style = careerup_get_jobs_inner_style();

	$args = array(
		'jobs' => $wp_query,
		'job_inner_style' => $job_inner_style,
		'jobs_display_mode' => $jobs_display_mode,
	);

	if ( $layout_type == 'half-map' ) {
	?>
		<section id="main-container" class="inner">
			<div class="row no-margin layout-type-<?php echo esc_attr($layout_type); ?>">
				<div id="main-content" class="col-xs-12 col-md-7 no-padding">
					<div class="inner-left">
						<?php if ( is_active_sidebar( 'jobs-filter-sidebar' ) ): ?>
							<div class="filter-sidebar">
								<div class="mobile-groups-button hidden-lg hidden-md clearfix text-center">
									<button class=" btn btn-sm btn-theme btn-view-map" type="button"><i class="fa fa-map-o" aria-hidden="true"></i> <?php esc_html_e( 'Map View', 'careerup' ); ?></button>
									<button class=" btn btn-sm btn-theme  btn-view-listing hidden-sm hidden-xs" type="button"><i class="fa fa-list" aria-hidden="true"></i> <?php esc_html_e( 'Listing View', 'careerup' ); ?></button>
								</div>
								<span class="filter-in-sidebar visible-xs visible-sm"><i class="fa fa-sliders"></i></span>
								<div class="filter-scroll">
						   			<?php dynamic_sidebar( 'jobs-filter-sidebar' ); ?>
						   		</div>
					   		</div>
					   	<?php endif; ?>
					   	<div class="content-listing">
					   		
							<?php
								echo WP_Job_Board_Template_Loader::get_template_part('loop/job/archive-inner', $args);

								echo WP_Job_Board_Template_Loader::get_template_part('loop/job/pagination', array('jobs' => $wp_query));
							?>
						</div>
					</div>
				</div><!-- .content-area -->
				<div class="col-md-5 col-xs-12 no-padding">
					<div id="jobs-google-maps" class="fix-map hidden-sm hidden-xs"></div>
				</div>
			</div>
		</section>
	<?php
	} else {
		$sidebar_configs = careerup_get_jobs_layout_configs();
		$filter_top_sidebar = careerup_get_jobs_filter_top_sidebar();
	?>
		<?php if ( $filter_top_sidebar && is_active_sidebar( 'jobs-filter-top-sidebar' ) ) { ?>
			<div class="jobs-filter-top-sidebar-wrapper filter-top-sidebar-wrapper">
		   		<?php dynamic_sidebar( 'jobs-filter-top-sidebar' ); ?>
		   	</div>
		<?php } ?>
		<section id="main-container" class="main-content <?php echo apply_filters('careerup_job_content_class', 'container');?> inner">
			<?php if(careerup_get_jobs_layout_type() !== 'main') { ?>
				<?php careerup_before_content( $sidebar_configs ); ?>
			<?php } ?>
			<div class="row">
				<?php careerup_display_sidebar_left( $sidebar_configs ); ?>

				<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
					<main id="main" class="site-main layout-type-<?php echo esc_attr($layout_type); ?>" role="main">

						<?php
							echo WP_Job_Board_Template_Loader::get_template_part('loop/job/archive-inner', $args);

							echo WP_Job_Board_Template_Loader::get_template_part('loop/job/pagination', array('jobs' => $wp_query));
						?>


					</main><!-- .site-main -->
				</div><!-- .content-area -->
				
				<?php careerup_display_sidebar_right( $sidebar_configs ); ?>
				<?php if(careerup_get_jobs_layout_type() == 'main') { ?>
					<div class="over-dark"></div>	
				<?php } ?>
			</div>
		</section>
	<?php
	}

	get_footer();
}