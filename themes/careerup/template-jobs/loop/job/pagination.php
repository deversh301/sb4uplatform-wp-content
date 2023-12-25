<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="jobs-pagination-wrapper main-pagination-wrapper">
	<?php
		$pagination_type = careerup_get_jobs_pagination();
		if ( $pagination_type == 'loadmore' || $pagination_type == 'infinite' ) {
			$next_link = get_next_posts_link( '&nbsp;', $jobs->max_num_pages );
			if ( $next_link ) {
		?>
				<div class="ajax-pagination <?php echo trim($pagination_type == 'loadmore' ? 'loadmore-action' : 'infinite-action'); ?>">
					<div class="apus-pagination-next-link hidden"><?php echo wp_kses_post($next_link); ?></div>
					<a href="#" class="apus-loadmore-btn"><?php esc_html_e( 'Load more', 'careerup' ); ?></a>
					<span href="#" class="apus-allproducts"><?php esc_html_e( 'All jobs loaded.', 'careerup' ); ?></span>
				</div>
		<?php
			}
		} else {
			WP_Job_Board_Mixes::custom_pagination( array(
				'max_num_pages' => $jobs->max_num_pages,
				'prev_text'     => '<i class="flaticon-left-arrow"></i>'.esc_html__( 'Previous', 'careerup' ),
				'next_text'     => esc_html__( 'Next ', 'careerup' ).'<i class="flaticon-right-arrow"></i>',
				'wp_query' => $jobs
			));
		}
	?>
</div>
