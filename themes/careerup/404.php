<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Careerup
 * @since Careerup 1.0
 */
/*
*Template Name: 404 Page
*/
get_header();
$icon = careerup_get_config('icon-img');
?>
<section class="page-404">
	<div id="main-container" class="inner">
		<div id="main-content" class="main-page">
			<section class="error-404 not-found clearfix">
				<div class="container">
					<div class="clearfix text-center">
						<div class="top-image">
							<?php if( !empty($icon) && !empty($icon['url'])) { ?>
								<img src="<?php echo esc_url( $icon['url']); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<?php }else{ ?>
								<img src="<?php echo esc_url_raw( get_template_directory_uri().'/images/error.jpg'); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<?php } ?>
						</div>
						<div class="slogan">
							<?php if(!empty(careerup_get_config('404_title', '404')) ) { ?>
								<h4 class="title-big"><?php echo careerup_get_config('404_title', 'We Are Sorry, Page Not Found'); ?></h4>
							<?php } ?>
						</div>
						<div class="page-content">
							<div class="description">
								<?php echo careerup_get_config('404_description', 'Unfortunately the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exist. Check the Url you entered for any mistakes and try again. '); ?>
							</div>
							<?php get_search_form(); ?>
							<div class="return">
								<a class="btn-readmore text-theme" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__('Back to Homepage','careerup') ?><i class="flaticon-right-arrow"></i> </a>
							</div>
						</div><!-- .page-content -->
					</div>
				</div>
			</section><!-- .error-404 -->
		</div><!-- .content-area -->
	</div>
</section>
<?php get_footer(); ?>