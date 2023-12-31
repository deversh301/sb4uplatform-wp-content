<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$display_mode = careerup_get_candidates_display_mode();

$total = $candidates->found_posts;
$per_page = $candidates->query_vars['posts_per_page'];
$current = max( 1, $candidates->get( 'paged', 1 ) );
$last  = min( $total, $per_page * $current );

$pre_page  = max( 0, ($candidates->get( 'paged', 1 ) - 1 ) );
$i =  $per_page * $pre_page;
?>
<div class="results-count">
	<span class="last"><?php echo esc_html($last); ?></span>
</div>

<div class="items-wrapper">
	<?php if ( $display_mode == 'grid' ) {
		$columns = careerup_get_candidates_columns();
		$bcol = $columns ? 12/$columns : 4;
	?>
			<?php while ( $candidates->have_posts() ) : $candidates->the_post(); ?>
				<div class="col-sm-6 col-md-<?php echo esc_attr($bcol); ?> col-xs-12 <?php echo esc_attr(($i%$columns == 0)?'md-clearfix':''); ?> <?php echo esc_attr(($i%2 == 0)?'sm-clearfix':''); ?>">
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'candidates-styles/inner-grid' ); ?>
				</div>
			<?php $i++; endwhile; ?>
	<?php } else { ?>
		<?php while ( $candidates->have_posts() ) : $candidates->the_post(); ?>
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'candidates-styles/inner-list' ); ?>
		<?php endwhile; ?>
	<?php } ?>
</div>

<div class="apus-pagination-next-link"><?php next_posts_link( '&nbsp;', $candidates->max_num_pages ); ?></div>