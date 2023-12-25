<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}

$args = array(
    'limit' => $number_post,
    'get_candidates_by' => $get_candidates_by,
    'orderby' => $orderby,
    'order' => $order,
);

$loop = careerup_get_candidates($args);
if ( $loop->have_posts() ):
?>
<div class="candidates-widget">
	<?php
		while ( $loop->have_posts() ): $loop->the_post();
			get_template_part( 'template-jobs/candidates-styles/inner', 'list-small');
	    endwhile;
    	wp_reset_postdata();
    ?>
</div>
<?php endif; ?>