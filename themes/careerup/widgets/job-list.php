<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$args = array(
    'limit' => $number_post,
    'get_jobs_by' => $get_jobs_by,
    'orderby' => $orderby,
    'order' => $order,
);

$loop = careerup_get_jobs($args);
if ( $loop->have_posts() ):
?>
<div class="jobs-widget">
	<?php
		while ( $loop->have_posts() ): $loop->the_post();
			get_template_part( 'template-jobs/jobs-styles/inner', 'list-small');
	    endwhile;
    	wp_reset_postdata();
    ?>
</div>
<?php endif; ?>