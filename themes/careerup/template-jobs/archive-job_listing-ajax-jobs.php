<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jobs_display_mode = careerup_get_jobs_display_mode();
$job_inner_style = careerup_get_jobs_inner_style();


$total = $jobs->found_posts;
$per_page = $jobs->query_vars['posts_per_page'];
$current = max( 1, $jobs->get( 'paged', 1 ) );
$last  = min( $total, $per_page * $current );

$pre_page  = max( 0, ($jobs->get( 'paged', 1 ) - 1 ) );
$i =  $per_page * $pre_page;
?>
<div class="results-count">
	<span class="last"><?php echo esc_html($last); ?></span>
</div>

<div class="items-wrapper">
	<?php if ( $jobs_display_mode == 'grid' ) {
		$columns = careerup_get_jobs_columns();
		$bcol = $columns ? 12/$columns : 4;
	?>
			<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
				<div class="col-sm-6 col-md-<?php echo esc_attr($bcol); ?> col-xs-12 <?php echo esc_attr(($i%$columns == 0)?'md-clearfix':'') ?> <?php echo esc_attr(($i%2 == 0)?'sm-clearfix':'') ?>">
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-'.$job_inner_style ); ?>
				</div>
			<?php $i++; endwhile; ?>
	<?php } else { ?>
		<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-'.$job_inner_style ); ?>
		<?php endwhile; ?>
	<?php } ?>
</div>

<div class="apus-pagination-next-link"><?php next_posts_link( '&nbsp;', $jobs->max_num_pages ); ?></div>