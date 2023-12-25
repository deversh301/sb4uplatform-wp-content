<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$team_members = WP_Job_Board_Employer::get_post_meta($post->ID, 'team_members', true );
if ( !empty($team_members) ) {
?>
    <div id="job-employer-team" class="employer-detail-portfolio widget">
    	<h4 class="widget-title"><?php esc_html_e('Team Member', 'careerup'); ?></h4>
    	<div class="row row-36">
	        <?php foreach ($team_members as $member) { ?>
	        	<div class="col-sm-4 col-xs-6">
		            <div class="member-item">
		            	<div class="profile-image">
			            	<?php if ( !empty($member['profile_image']) ) { ?>
			            		<div class="image">
				                	<img src="<?php echo esc_url($member['profile_image']); ?>" alt="<?php esc_attr_e('Image', 'careerup'); ?>">
				                </div>
				            <?php } ?>

				            <div class="social">
				            	<?php if ( !empty($member['facebook']) ) { ?>
				            		<a href="<?php echo esc_url($member['facebook']); ?>"><i class="fa fa-facebook"></i></a>
					            <?php } ?>
					            <?php if ( !empty($member['twitter']) ) { ?>
				            		<a href="<?php echo esc_url($member['twitter']); ?>"><i class="fa fa-twitter"></i></a>
					            <?php } ?>
					            <?php if ( !empty($member['google_plus']) ) { ?>
				            		<a href="<?php echo esc_url($member['google_plus']); ?>"><i class="fa fa-google-plus"></i></a>
					            <?php } ?>
					            <?php if ( !empty($member['linkedin']) ) { ?>
				            		<a href="<?php echo esc_url($member['linkedin']); ?>"><i class="fa fa-linkedin"></i></a>
					            <?php } ?>
					            <?php if ( !empty($member['dribbble']) ) { ?>
				            		<a href="<?php echo esc_url($member['dribbble']); ?>"><i class="fa fa-dribbble"></i></a>
					            <?php } ?>
				            </div>
				        </div>
				        <div class="content">
				            <?php if ( !empty($member['name']) ) { ?>
			            		<h3 class="title"><?php echo esc_html($member['name']); ?></h3>
				            <?php } ?>
				            <?php if ( !empty($member['designation']) ) { ?>
			            		<div class="designation"><?php echo esc_html($member['designation']); ?></div>
				            <?php } ?>
				            <?php if ( !empty($member['experience']) ) { ?>
			            		<div class="experience text-theme"><?php esc_html_e('Experience: ', 'careerup'); ?><?php echo esc_html($member['experience']); ?></div>
				            <?php } ?>
			            </div>
		            </div>
	            </div>
	        <?php } ?>
	    </div>
    </div>
<?php }