<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post, $job_preview;
$job_preview = $post;
$job_layout = careerup_get_job_layout_type();
$job_layout = !empty($job_layout) ? $job_layout : 'v1';
?>
<div class="job-submission-preview-form-wrapper">
	<?php if ( sizeof($form_obj->errors) ) : ?>
		<ul class="messages">
			<?php foreach ( $form_obj->errors as $message ) { ?>
				<li class="message_line danger">
					<?php echo wp_kses_post( $message ); ?>
				</li>
			<?php
			}
			?>
		</ul>
	<?php endif; ?>
	<form action="<?php echo esc_url($form_obj->get_form_action());?>" class="cmb-form" method="post" enctype="multipart/form-data" encoding="multipart/form-data">
		<input type="hidden" name="<?php echo esc_attr($form_obj->get_form_name()); ?>" value="<?php echo esc_attr($form_obj->get_form_name()); ?>">
		<input type="hidden" name="job_id" value="<?php echo esc_attr($job_id); ?>">
		<input type="hidden" name="submit_step" value="<?php echo esc_attr($step); ?>">
		<input type="hidden" name="object_id" value="<?php echo esc_attr($job_id); ?>">
		<?php wp_nonce_field('wp-job-board-job-submit-preview-nonce', 'security-job-submit-preview'); ?>
		<div class="action-preview">
			<button class="button btn btn-success" name="continue-submit-job"><?php esc_html_e('Submit Job', 'careerup'); ?></button>
			<button class="button btn btn-danger" name="continue-edit-job"><?php esc_html_e('Edit Job', 'careerup'); ?></button>
		</div>
		<?php
		$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
		$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );
		?>
		
	</form>

	<div class="single-listing-wrapper" data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
		<?php
			if ( $job_layout !== 'v1' ) {
				echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-job_listing-'.$job_layout );
			} else {
				echo WP_Job_Board_Template_Loader::get_template_part( 'content-single-job_listing' );
			}
		?>
	</div>
</div>