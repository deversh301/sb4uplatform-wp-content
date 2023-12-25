<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_candidate = careerup_get_config('register_form_enable_candidate', true);
$show_employer = careerup_get_config('register_form_enable_employer', true);
if ( !$show_candidate && !$show_employer ) {
	return;
}
careerup_load_select2();
?>


<div class="box-employer">
	<div class="top-info-user text-center">
		<h3 class="title"><?php echo esc_html__('Create New Account','careerup') ?></h3>
		<div class="des"><?php echo esc_html__('Choose your Account Type','careerup') ?></div>
	</div>
  	<div class="register-form-wrapper">
	  	<div class="container-form">
          	<form id="registerForm-<?php echo esc_attr(rand(000000,999999)); ?>" name="registerForm" method="post" class="register-form">
          		<div class="form-group space-25">
					<ul class="role-tabs <?php echo esc_attr((!$show_candidate || !$show_employer) ? 'hidden' : ''); ?>">
						<?php
						$checked = 'checked="checked"';
						$active_class = 'active';
						if ( $show_candidate ) {
						?>
							<li class="<?php echo esc_attr($active_class); ?>"><input id="cadidate" type="radio" name="role" value="wp_job_board_candidate" <?php echo trim($checked); ?>><label for="cadidate"><?php esc_html_e('Candidate', 'careerup'); ?></label></li>
						<?php
							$checked = '';
							$active_class = '';
						} ?>
						<?php if ( $show_employer ) { ?>
							<li class="<?php echo esc_attr($active_class); ?>"><input type="radio" id="employer" name="role" value="wp_job_board_employer" <?php echo trim($checked); ?>><label for="employer"><?php esc_html_e('Employer', 'careerup'); ?></label></li>
						<?php } ?>
					</ul>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="username" id="register-username" placeholder="<?php esc_attr_e('Username *','careerup'); ?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="email" id="register-email" placeholder="<?php esc_attr_e('Email *','careerup'); ?>">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="<?php esc_attr_e('Password *','careerup'); ?>">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="<?php esc_attr_e('Confirm Password *','careerup'); ?>">
				</div>

				<?php if ( careerup_get_config('register_form_enable_employer_company', true) ) { ?>
					<div class="form-group wp_job_board_employer_show">
						<input type="text" class="form-control" name="company_name" id="register-company-name" placeholder="<?php esc_attr_e('Company Name','careerup'); ?>">
					</div>
				<?php } ?>

				<?php if ( careerup_get_config('register_form_enable_phone', true) ) { ?>
					<div class="form-group">
						<input type="text" class="form-control" name="phone" id="register-phone" placeholder="<?php esc_attr_e('Phone','careerup'); ?>">
					</div>
				<?php } ?>

				<?php
					if ( careerup_get_config('register_form_enable_candidate_category', true) ) {
						$candidate_args = array(
				            'taxonomy' => 'candidate_category',
				            'orderby' => 'name',
				            'order' => 'ASC',
				            'hide_empty' => false,
				            'number' => false,
					    );
					    $terms = get_terms($candidate_args);

					    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					    	?>
					    	<div class="form-group space-25 wp_job_board_candidate_show select2-wrapper">
					    		
									<select id="register-candidate-category" class="register-category" name="candidate_category">
										<option value=""><?php esc_html_e('Select Category', 'careerup'); ?></option>
										<?php foreach ($terms as $term) { ?>
											<option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
										<?php } ?>
									</select>
								
							</div>
					    	<?php
					    }
				    }
				?>
				<?php
					if ( careerup_get_config('register_form_enable_employer_category', true) ) {
						$employer_args = array(
				            'taxonomy' => 'employer_category',
				            'orderby' => 'name',
				            'order' => 'ASC',
				            'hide_empty' => false,
				            'number' => false,
					    );
					    $terms = get_terms($employer_args);

					    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					    	?>
					    	<div class="form-group space-25 wp_job_board_employer_show select2-wrapper">
					    		
									<select id="register-employer-category" class="register-category" name="employer_category">
										<option value=""><?php esc_html_e('Select Category', 'careerup'); ?></option>
										<?php foreach ($terms as $term) { ?>
											<option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
										<?php } ?>
									</select>
							</div>
					    	<?php
					    }
				    }
				?>
				<?php wp_nonce_field('ajax-register-nonce', 'security_register'); ?>

				<?php if ( WP_Job_Board_Recaptcha::is_recaptcha_enabled() ) { ?>
		            <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_job_board_get_option( 'recaptcha_site_key' )); ?>"></div>
		      	<?php } ?>
		      	
		      	<?php
				$page_id = wp_job_board_get_option('terms_conditions_page_id');
				if ( !empty($page_id) ) {
					$page_url = $page_id ? get_permalink($page_id) : home_url('/');
				?>
					<div class="form-group">
						<label for="register-terms-and-conditions">
							<input type="checkbox" name="terms_and_conditions" value="on" id="register-terms-and-conditions" required>
							<?php
								echo sprintf(__('You accept our <a href="%s">Terms and Conditions and Privacy Policy</a>', 'careerup'), esc_url($page_url));
							?>
						</label>
					</div>
				<?php } ?>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block" name="submitRegister">
						<?php echo esc_html__('Register now', 'careerup'); ?>
					</button>
				</div>

				<?php do_action('register_form'); ?>
          	</form>
	    </div>

  	</div>
 </div>
