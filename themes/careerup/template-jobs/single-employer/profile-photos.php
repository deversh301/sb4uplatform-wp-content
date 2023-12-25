<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$profile_photos = WP_Job_Board_Employer::get_post_meta($post->ID, 'profile_photos', true );

if ( !empty($profile_photos) ) {
?>
    <div id="job-employer-portfolio" class="employer-detail-portfolio candidate-detail-portfolio widget">
    	<h4 class="widget-title"><?php esc_html_e('Office Photos', 'careerup'); ?></h4>
        <div class="content-bottom">
            <div class="row">
                <?php $i = 0; foreach ($profile_photos as $attach_id => $img_url) { ?>
                    <div class="col-xs-4 <?php echo esc_attr($i%3 == 0 ? 'sm-clearfix md-clearfix' : ''); ?>">
                        <div class="photo-item education-item">
                        	<a href="<?php echo esc_url($img_url); ?>" class="item p-popup-image">
                            	<?php echo wp_get_attachment_image( $attach_id, 'medium' );  ?>
                            </a>
                        </div>
                    </div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
<?php }