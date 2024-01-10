<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>

<?php do_action( 'wp_job_board_before_job_detail', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- heading -->
	<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/header' ); ?>

	<!-- Main content -->
	<div class="row content-job-detail">
		<div class="col-xs-12 col-md-<?php echo esc_attr( is_active_sidebar( 'job-single-sidebar' ) ? 8 : 12); ?>">

			<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
			
			<!-- job description -->
			<div class="job-detail-description">
				<!-- <h3 class="title-detail-job"><?php // esc_html_e('Fund Description', 'careerup'); ?></h3> -->
				<div class="inner">
				<?php 
				$custom_fields = WP_Job_Board_Post_Type_Job_Custom_Fields::get_custom_fields('job_cfield');
				if ( $custom_fields ) { ?>
           	   <?php foreach ($custom_fields as $cpost) {
                $meta_key = WP_Job_Board_Post_Type_Job_Custom_Fields::generate_key_id(WP_JOB_BOARD_JOB_LISTING_PREFIX, $cpost->post_name);
                $value = get_post_meta( $post->ID, $meta_key, true );
                $icon_class = get_post_meta( $cpost->ID, WP_JOB_BOARD_JOB_CUSTOM_FIELD_PREFIX .'icon_class', true );
			
				$field_value = get_post_meta($cpost->ID)['_job_cfield_field_type'][0];
			
				
                if ( !empty($value) && get_post_meta($cpost->ID)['_job_cfield_field_type'][0] === 'textarea' ) {
                    ?>
                        <div class="icon">
                            <?php if ( !empty($icon_class) ) { ?>
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            <?php } ?>
                        </div>
                        <div class="details" >
						<h3 class="title-detail-job" style="margin:0 0 15px"><?php echo wp_kses_post($cpost->post_title); ?></h3 >
                            <!-- <div class="text"><?php echo wp_kses_post($cpost->post_title); ?></div> -->
                            <div class="value"  style="margin-bottom: 15px;"><?php echo WP_Job_Board_Post_Type_Job_Custom_Fields::display_field($cpost, $value); ?></div>
                        </div>
                    <?php
                }
            ?>
            <?php } ?>
        <?php } ?>
				</div>
			</div>

			<!-- job social -->
			<?php if ( careerup_get_config('show_job_social_share', false) ) { ?>
				<div class="social-job-detail">
        			<?php get_template_part( 'template-parts/sharebox-job' );  ?>
        		</div>
            <?php } ?>

			<!-- job releated -->
			<?php if ( careerup_get_config('job_releated_show', true) ) { ?>
				<div class="hidden-xs hidden-sm">
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/releated' ); ?>
				</div>
			<?php } ?>
			
			<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>
		</div>
		
		<?php if ( is_active_sidebar( 'job-single-sidebar' ) ): ?>
			<div class="col-xs-12 col-md-4">
		   		<?php dynamic_sidebar( 'job-single-sidebar' ); ?>
		   	</div>
	   	<?php endif; ?>
	   	<!-- job releated -->
	   	<?php if ( careerup_get_config('job_releated_show', true) ) { ?>
			<div class="hidden-lg hidden-md col-xs-12">
				<?php echo WP_Job_Board_Template_Loader::get_template_part( 'single-job_listing/releated' ); ?>
			</div>
		<?php } ?>
	</div>

</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_job_detail', $post->ID ); ?>