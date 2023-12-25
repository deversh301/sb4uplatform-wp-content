<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'job_listing' ) {
    return;
}
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

$job_ids = WP_Job_Board_Job_Listing::customer_also_viewed($post->ID);
if ( empty($job_ids) || sizeof( $job_ids ) == 0 || !is_array($job_ids) ) {
	return;
}

$args = array(
	'post_type'            => 'job_listing',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $limit,
	'post__in'             => $job_ids,
	'orderby' => 'ID(ID, explode('.implode(',', $job_ids).'))'
);

$jobs = new WP_Query( $args );

if ( $jobs->have_posts() ) : ?>

	<div class="job-detail-also-viewed">
		<?php
		if ( $title ) {
		    echo trim($before_title)  . trim( $title ) . $after_title;
		}
		?>
		<div class="content-inner">
			<?php
	            while ( $jobs->have_posts() ) : $jobs->the_post();
	            	global $post;
	            	$author_id = $post->post_author;
					$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
					$address = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'address', true );
	            ?>
	                <div class="item">
					    <div class="job-information">
							<?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							<?php if ( $employer_id ) { ?>
						        <div class="job-date-author">
						            <?php echo sprintf(wp_kses(__('<a class="text-theme" href="%s">%s</a>', 'careerup'), array( 'a' => array('class' => array(), 'href' => array()) ) ), get_permalink($employer_id), get_the_title($employer_id) ); ?>
						        </div>
						    <?php } ?>

				            <?php if ( $address ) { ?>
				                <div class="job-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
				            <?php } ?>
						</div>
					</div><!-- #post-## -->
	                <?php
	            endwhile;
	        ?>
        </div>
	</div>
<?php
	wp_reset_postdata();
endif;
