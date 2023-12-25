<?php

global $post;
$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$img = '';
if ( has_post_thumbnail($employer_id) ) {
	$img = 'data-media="'.get_the_post_thumbnail_url($employer_id, 'full').'"';
}

wp_enqueue_script('addthis');
?>
<div class="apus-social-share">
		<div class="bo-social-icons bo-sicolor social-radius-rounded">
		<span class="title"><?php echo esc_html__('Share Link:','careerup'); ?> </span>
		

		<?php if ( careerup_get_config('facebook_share', 1) ): ?>
 			<a href="javascript:void(0);" data-original-title="facebook" class="bo-social-facebook addthis_button_facebook" <?php echo trim($img); ?> data-url="<?php echo esc_url(get_permalink($post)); ?>" data-title="<?php echo esc_attr(get_the_title($post)); ?>"><i class="fa fa-facebook"></i></a>
		<?php endif; ?>
		<?php if ( careerup_get_config('twitter_share', 1) ): ?>
 			<a href="javascript:void(0);" data-original-title="twitter" class="bo-social-twitter addthis_button_twitter" <?php echo trim($img); ?>><i class="fa fa-twitter"></i></a>
		<?php endif; ?>
		<?php if ( careerup_get_config('linkedin_share', 1) ): ?>
 			<a href="javascript:void(0);" data-original-title="linkedin" class="bo-social-linkedin addthis_button_linkedin" <?php echo trim($img); ?>><i class="fa fa-linkedin"></i></a>
		<?php endif; ?>
		
		<?php if ( careerup_get_config('pinterest_share', 1) ): ?>
 			<a href="javascript:void(0);" data-original-title="pinterest" class="bo-social-pinterest addthis_button_pinterest" <?php echo trim($img); ?>><i class="fa fa-pinterest"></i></a>
		<?php endif; ?>

		<?php if ( careerup_get_config('more_share', 1) ): ?>
			<a href="javascript:void(0);" data-original-title="share_more" class="bo-social-pinterest addthis_button_compact" <?php echo trim($img); ?>><i class="fa fa-plus"></i></a>
		<?php endif; ?>
	</div>
</div>	