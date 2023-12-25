<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="box-employer">
	<div class="login-form-wrapper">
		<div id="login-form-wrapper" class="form-container">
			<div class="top-info-user text-center">
				<h3 class="title"><?php echo esc_html__('Quick Login', 'careerup'); ?></h3>
				<div class="des"><?php echo esc_html__('Login Your Account','careerup') ?></div>
			</div>
			
			<?php if ( defined('CAREERUP_DEMO_MODE') && CAREERUP_DEMO_MODE ) { ?>
				<div class="sign-in-demo-notice">
					Username: <strong>candidate</strong> or <strong>employer</strong><br>
					Password: <strong>demo</strong>
				</div>
			<?php } ?>
			
			<form class="login-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
				<?php if ( isset($_SESSION['register_msg']) ) { ?>
					<div class="alert <?php echo esc_attr($_SESSION['register_msg']['error'] ? 'alert-warning' : 'alert-info'); ?>">
						<?php echo wp_kses_post($_SESSION['register_msg']['msg']); ?>
					</div>
				<?php
					unset($_SESSION['register_msg']);
				}
				?>
				<div class="form-group">
					<input autocomplete="off" type="text" name="username" class="form-control" id="username_or_email" placeholder="<?php esc_attr_e('Username or email','careerup'); ?>">
				</div>
				<div class="form-group">
					<input name="password" type="password" class="password required form-control" id="login_password" placeholder="<?php esc_attr_e('Password','careerup'); ?>">
				</div>
				<div class="row form-group info">
					<div class="col-sm-6 col-xs-6">
						<label for="user-remember-field" class="remember">
							<input type="checkbox" name="remember" id="user-remember-field" value="true"> <?php echo esc_html__('Keep me signed in','careerup'); ?>
						</label>
					</div>
					<div class="col-sm-6 col-xs-6 text-right">
						<a class="text-theme back-link" href="#forgot-password-form-wrapper" title="<?php esc_attr_e('Forgot Password','careerup'); ?>"><?php echo esc_html__("Lost Your Password?",'careerup'); ?></a>
					</div>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-theme btn-block" name="submit" value="<?php esc_attr_e('Login','careerup'); ?>"/>
				</div>
				<?php
					do_action('login_form');
					wp_nonce_field('ajax-login-nonce', 'security_login');
				?>
			</form>
		</div>
		<!-- reset form -->
		<div id="forgot-password-form-wrapper" class="form-container">
			<div class="top-info-user text-center">
				<h3 class="title"><?php echo esc_html__('Reset Password', 'careerup'); ?></h3>
				<div class="des"><?php echo esc_html__('Please Enter Username or Email','careerup') ?></div>
			</div>
			<form name="forgotpasswordform" class="forgotpassword-form" action="<?php echo esc_url( site_url('wp-login.php?action=lostpassword', 'login_post') ); ?>" method="post">
				<div class="lostpassword-fields">
					<div class="form-group">
						<input type="text" name="user_login" class="user_login form-control" id="lostpassword_username" placeholder="<?php esc_attr_e('Username or E-mail','careerup'); ?>">
					</div>
					<?php
						do_action('lostpassword_form');
						wp_nonce_field('ajax-lostpassword-nonce', 'security_lostpassword');
					?>
					
					<?php if ( version_compare(WP_JOB_BOARD_PLUGIN_VERSION, '2.1.0', '>=') && WP_Job_Board_Recaptcha::is_recaptcha_enabled() ) { ?>
			            <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(wp_job_board_get_option( 'recaptcha_site_key' )); ?>"></div>
			      	<?php } ?>

					<div class="form-group">
						<div class="row">
							<div class="col-xs-6"><input type="submit" class="btn btn-theme btn-sm btn-block" name="wp-submit" value="<?php esc_attr_e('Get New Password', 'careerup'); ?>" tabindex="100" /></div>
							<div class="col-xs-6"><input type="button" class="btn btn-danger btn-sm btn-block btn-cancel" value="<?php esc_attr_e('Cancel', 'careerup'); ?>" tabindex="101" /></div>
						</div>
					</div>
				</div>
				<div class="lostpassword-link"><a href="#login-form-wrapper" class="back-link text-theme"><?php echo esc_html__('Back To Login', 'careerup'); ?></a></div>
			</form>
		</div>
	</div>
</div>
