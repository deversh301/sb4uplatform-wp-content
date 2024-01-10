<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Careerup
 * @since Careerup 1.0
 */
$footer = apply_filters( 'careerup_get_footer_layout', 'default' );

?>
	</div><!-- .site-content -->
	<?php if ( !empty($footer) ): ?>
		<?php careerup_display_footer_builder($footer); ?>
	<?php else: ?>
		<footer id="apus-footer" class="apus-footer " role="contentinfo">
			<div class="footer-default">
				<div class="apus-footer-inner">
					<div class="apus-copyright">
						<div class="container">
							<div class="copyright-content clearfix">
								<div class="text-copyright text-center">
									<?php
										
										$allowed_html_array = array( 'a' => array('href' => array()) );
										echo wp_kses(sprintf(__('&copy; %s - Careerup. All Rights Reserved. <br/> Powered by <a href="//apusthemes.com">ApusThemes</a>', 'careerup'), date("Y")), $allowed_html_array);
									?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer><!-- .site-footer -->
	<?php endif; ?>
	<?php
	if ( careerup_get_config('back_to_top') ) { ?>
		<a href="#" id="back-to-top" class="add-fix-top">
			<i class="flaticon-rocket-launch"></i>
		</a>
	<?php
	}
	?>
</div><!-- .site -->
<?php wp_footer(); ?>
<script>
 		jQuery(document).ready(function() {
			var siteUrl = "<?php echo esc_url(home_url('/')); ?>";
            // Target the anchor tag within the job-detail-thumbnail class
            jQuery(".type-job_listing .left-inner .clearfix a").attr("href", siteUrl + "access-to-finance");
			 jQuery(".type-job_listing .left-inner .clearfix .btn-link-job").html("View all Funds<span class='next flaticon-right-arrow'></span>");
			// $(".btn-link-job").html("New View All Jobs HTML Content");
			
			jQuery(".type-job_listing .job-detail-statistic .statistic-item.flex-middle:eq(2)").css("display", "none");
				var currentText = jQuery(".widget-title span").text().trim();

				// Check if the current text is "Job Information"
				if (currentText === "Job Information") {
					// Replace the text content
					jQuery(".widget-title span").text("Fund Information");
				}

				var otherText = jQuery(".in-sidebar ul li:first-child .details .text").text().trim();
				// Check if the current text is "Job Information"
				if (otherText === "Offered Salary") {
					// Replace the text content
					jQuery(".in-sidebar ul li:first-child .details .text").text("Investment Size");
				}

        });

</script>
</body>
</html>