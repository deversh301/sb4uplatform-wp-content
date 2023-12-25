<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$args = array(
    'limit' => $number_post,
    'get_employers_by' => $get_employers_by,
    'orderby' => $orderby,
    'order' => $order,
);

$loop = careerup_get_employers($args);
if ( $loop->have_posts() ):
?>
<div class="employers-widget">
	<?php
		while ( $loop->have_posts() ): $loop->the_post();
			get_template_part( 'template-jobs/employers-styles/inner', 'list-small');
	    endwhile;
    	wp_reset_postdata();
    ?>
</div>
<?php endif; ?>