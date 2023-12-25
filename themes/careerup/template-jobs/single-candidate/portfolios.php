<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$portfolio_photos = WP_Job_Board_Candidate::get_post_meta($post->ID, 'portfolio_photos', true );

if ( !empty($portfolio_photos) ) {
?>
    <div id="job-candidate-portfolio" class="candidate-detail-portfolio widget">
    	<h4 class="widget-title"><?php esc_html_e('Portfolio', 'careerup'); ?></h4>
    	<div class="content-bottom">
	    	<div class="row">
		        <?php $i = 0; foreach ($portfolio_photos as $attach_id => $img_url) { ?>
		            <div class="col-xs-4 <?php echo esc_attr($i%3 == 0 ? 'sm-clearfix md-clearfix' : ''); ?>">
		            	<div class="education-item">
		            		<a class="item p-popup-image" href="<?php echo esc_url($img_url); ?>">
		                		<?php echo wp_get_attachment_image( $attach_id, 'medium' );  ?>
		                	</a>
		                </div>
		            </div>
		        <?php $i++; } ?>
	        </div>
        </div>
    </div>
<?php }