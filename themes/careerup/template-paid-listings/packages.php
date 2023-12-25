<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( $packages ) : ?>
	<div class="widget widget-packages widget-subwoo">
		<h2 class="widget-title"><?php esc_html_e( 'Packages', 'careerup' ); ?></h2>
		<div class="row list-packge">
			<?php $i = 1; foreach ( $packages as $key => $package ) :
				$product = wc_get_product( $package );
				if ( ! $product->is_type( array( 'job_package', 'job_package_subscription' ) ) || ! $product->is_purchasable() ) {
					continue;
				}
				?>
				<div class="col-sm-4 col-xs-12 <?php echo esc_attr(($i%3 == 1)?'md-clearfix sm-clearfix':''); ?>">
					<div class="subwoo-inner <?php echo esc_attr($product->is_featured()?'highlight':''); ?>">
						<div class="item">
							<div class="header-sub">
								<div class="inner-sub">
									<h3 class="title"><?php echo trim($product->get_title()); ?></h3>
									<div class="price">
										<?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free', 'careerup'); ?>
									</div>
								</div>
							</div>
							<div class="bottom-sub">
								<div class="short-des"><?php echo apply_filters( 'the_excerpt', get_post_field('post_excerpt', $product->get_id()) ) ?></div>
								<div class="button-action">
									<div class="add-cart">
										<button class="button btn-block" type="submit" name="wjbwpl_job_package" value="<?php echo esc_attr($product->get_id()); ?>" id="package-<?php echo esc_attr($product->get_id()); ?>">
											<?php esc_html_e('Get Started', 'careerup') ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php $i++; endforeach; ?>
		</div>
	</div>
<?php endif; ?>