<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$display_mode = careerup_get_employers_display_mode();
$columns = careerup_get_employers_columns();
$bcol = $columns ? 12/$columns : 4;


$total = $employers->found_posts;
$per_page = $employers->query_vars['posts_per_page'];
$current = max( 1, $employers->get( 'paged', 1 ) );
$last  = min( $total, $per_page * $current );

$pre_page  = max( 0, ($employers->get( 'paged', 1 ) - 1 ) );
$i =  $per_page * $pre_page;
?>
<div class="results-count">
	<span class="last"><?php echo esc_html($last); ?></span>
</div>

<div class="items-wrapper">
	<?php if ( $display_mode == 'grid' ) { ?>
			<?php while ( $employers->have_posts() ) : $employers->the_post(); ?>
				<div class="col-sm-6 col-md-<?php echo esc_attr($bcol); ?> col-xs-12 <?php echo esc_attr($i%$columns == 0 ? 'md-clearfix':''); ?> <?php echo esc_attr($i%2 == 0 ? 'sm-clearfix':''); ?>">
					<?php echo WP_Job_Board_Template_Loader::get_template_part( 'employers-styles/inner-grid' ); ?>
				</div>
			<?php $i++; endwhile; ?>
	<?php } elseif ( $display_mode == 'list' ) { ?>
		<?php while ( $employers->have_posts() ) : $employers->the_post(); ?>
			<?php echo WP_Job_Board_Template_Loader::get_template_part( 'employers-styles/inner-list' ); ?>
		<?php endwhile; ?>
	<?php } else {

		$companies_by_letter = array();
		while ( $employers->have_posts() ) : $employers->the_post();
			global $post;
			$company = $post->post_title;
			$companies_by_letter[strtoupper($company[0])][] = $post->ID;
		endwhile;
		?>

		
			<?php foreach ( range( 'A', 'Z' ) as $letter ) {
				if ( ! isset( $companies_by_letter[ $letter ] ) ) {
					continue;
				}
				?>
				<div class="company-items col-md-<?php echo esc_attr($bcol); ?>">
					<div id="<?php echo esc_attr($letter); ?>" class="letter-title"><span><?php echo esc_attr($letter); ?></span></div>
					<?php foreach ( $companies_by_letter[$letter] as $employer_id ) { ?>
						<div class="company-item">
							<a href="<?php echo esc_url(get_permalink( $employer_id )); ?>">
								<?php echo get_the_title($employer_id); ?>
							</a>
						</div>

				<?php } ?>
				</div>
			<?php } ?>
	<?php } ?>
</div>

<div class="apus-pagination-next-link"><?php next_posts_link( '&nbsp;', $employers->max_num_pages ); ?></div>