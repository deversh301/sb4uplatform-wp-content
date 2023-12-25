<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="box-employer widget">
	<h3 class="widget-title"><?php echo esc_html__('Change Password','careerup') ?></h3>
	<form method="post" action="" class="change-password-form">
		<div class="form-group">
			<label for="change-password-form-old-password"><?php echo esc_html__( 'Old password', 'careerup' ); ?></label>
			<input id="change-password-form-old-password" class="form-control" type="password" name="old_password" required="required">
		</div><!-- /.form-control -->

		<div class="form-group">
			<label for="change-password-form-new-password"><?php echo esc_html__( 'New password', 'careerup' ); ?></label>
			<input id="change-password-form-new-password" class="form-control" type="password" name="new_password" required="required" minlength="8">
		</div><!-- /.form-control -->

		<div class="form-group space-30">
			<label for="change-password-form-retype-password"><?php echo esc_html__( 'Retype password', 'careerup' ); ?></label>
			<input id="change-password-form-retype-password" class="form-control" type="password" name="retype_password" required="required" minlength="8">
		</div><!-- /.form-control -->

		<button type="submit" name="change_password_form" class="button btn btn-theme"><?php echo esc_html__( 'Change Password', 'careerup' ); ?></button>
	</form>
</div>