<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
	return;
}
$user_id = WP_Job_Board_User::get_user_by_candidate_id($post->ID);
if ( method_exists('WP_Job_Board_Candidate', 'get_display_email') ) {
    $author_email = WP_Job_Board_Candidate::get_display_email( $post );
} else {
    $author_email = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'email', true );
}
if ( ! empty( $author_email ) ) :
	extract( $args );
	extract( $instance );
	$title = !empty($instance['title']) ? sprintf($instance['title'], $post->post_title) : '';
	$title = apply_filters('widget_title', $title);

	if ( $title ) {
	    echo trim($before_title)  . trim( $title ) . $after_title;
	}

	$email = $phone = '';
	if ( is_user_logged_in() ) {
		if ( method_exists('WP_Job_Board_User', 'get_user_id') ) {
		    $current_user_id = WP_Job_Board_User::get_user_id();
		} else {
		    $current_user_id = get_current_user_id();
		}
		
		if ( WP_Job_Board_User::is_employer() ) {
			$employer_id = WP_Job_Board_User::get_employer_by_user_id($current_user_id);
			$phone = WP_Job_Board_Employer::get_post_meta($employer_id, 'phone', true);
			$email = WP_Job_Board_Employer::get_post_meta($employer_id, 'email', true);
		} elseif ( method_exists('WP_Job_Board_User', 'is_employee') && WP_Job_Board_User::is_employee($current_user_id) ) {
			$current_user_id = WP_Job_Board_User::get_user_id();
			$employer_id = WP_Job_Board_User::get_employer_by_user_id($current_user_id);
			$phone = WP_Job_Board_Employer::get_post_meta($employer_id, 'phone', true);
			$email = WP_Job_Board_Employer::get_post_meta($employer_id, 'email', true);
		} elseif( WP_Job_Board_User::is_candidate() ) {
			$candidate_id = WP_Job_Board_User::get_candidate_by_user_id($current_user_id);
			$phone = WP_Job_Board_Candidate::get_post_meta($candidate_id, 'phone', true );
			$email = WP_Job_Board_Candidate::get_post_meta($candidate_id, 'email', true);
		}

		if ( !empty($email) ) {
			$userdata = get_userdata( $current_user_id );
			$email = $userdata->user_email;
		}
	}
?>

	<div class="contact-form-candidate in-sidebar">
	    <form method="post" action="?" class="contact-form-wrapper">
	    	<div class="row">
		        <div class="col-sm-12">
			        <div class="form-group">
			            <input type="text" class="form-control" name="subject" placeholder="<?php esc_attr_e( 'Subject', 'careerup' ); ?>" required="required">
			        </div><!-- /.form-group -->
			    </div>
			    <div class="col-sm-12">
			        <div class="form-group">
			            <input type="email" class="form-control" name="email" placeholder="<?php esc_attr_e( 'E-mail', 'careerup' ); ?>" required="required" value="<?php echo esc_attr($email); ?>">
			        </div><!-- /.form-group -->
			    </div>
			    <div class="col-sm-12">
			        <div class="form-group">
			            <input type="text" class="form-control style2" name="phone" placeholder="<?php esc_attr_e( 'Phone', 'careerup' ); ?>" required="required" value="<?php echo esc_attr($phone); ?>">
			        </div><!-- /.form-group -->
			    </div>
	        </div>
	        <div class="form-group">
	            <textarea class="form-control" name="message" placeholder="<?php esc_attr_e( 'Message', 'careerup' ); ?>" required="required"></textarea>
	        </div><!-- /.form-group -->

	        <?php if ( WP_Job_Board_Recaptcha::is_recaptcha_enabled() ) { ?>
	            <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_job_board_get_option( 'recaptcha_site_key' )); ?>"></div>
	      	<?php } ?>

	      	<input type="hidden" name="post_id" value="<?php echo esc_attr($post->ID); ?>">
	        <button class="button btn btn-theme btn-block" name="contact-form"><?php echo esc_html__( 'Send Now', 'careerup' ); ?><i class="next flaticon-right-arrow"></i></button>
	    </form>
	    <?php do_action('careerup_after_contact_form', $post, $user_id); ?>
	</div>

<?php endif;

if ( class_exists('WP_Job_Board_Wc_Paid_Listings_Contact_Package') && method_exists('WP_Job_Board_Wc_Paid_Listings_Contact_Package', 'check_user_can_contact_candidate') ) {

	if ( !WP_Job_Board_Wc_Paid_Listings_Contact_Package::check_user_can_contact_candidate($post) ) {
		$contact_package_page_id = wp_job_board_get_option('contact_package_page_id');
		$package_page_url = $contact_package_page_id ? get_permalink($contact_package_page_id) : home_url('/');
		?>
		<div class="alert alert-warning">
			<?php echo sprintf(__('You have no package. To contact "%s" you need <a href="%s" class="text-theme">click here</a> to subscribe a package.', 'careerup'), $post->post_title, $package_page_url); ?>
		</div>
		<?php
	}
	
}