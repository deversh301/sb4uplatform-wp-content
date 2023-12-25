<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

$author_id = $post->post_author;
$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
$types = get_the_terms( $post->ID, 'job_listing_type' );
$address = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'address', true );

$latitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_latitude', true );
$longitude = WP_Job_Board_Job_Listing::get_post_meta( $post->ID, 'map_location_longitude', true );

?>
<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('job-list-v5 job-card'); ?> data-latitude="<?php echo esc_attr($latitude); ?>" data-longitude="<?php echo esc_attr($longitude); ?>">
    <div class="flex-middle">
        
        <div class="employer-logo flex-middle">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php if ( has_post_thumbnail($employer_id) ) { ?>
                    <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
                <?php } else { ?>
                    <img src="<?php echo esc_url(careerup_placeholder_img_src()); ?>" alt="<?php echo esc_attr(get_the_title($employer_id)); ?>">
                <?php } ?>
            </a>
        </div>

        <div class="job-information flex-middle">
            <div class="inner">
                <div class="job-title-wrapper">
                    <?php the_title( sprintf( '<h2 class="job-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    <?php careerup_job_display_featured_icon($post); ?>
                </div>
                <div class="job-date-author">
                    <?php
                    if ( $employer_id ) {
                        echo sprintf('<a href="%s" class="employer">%s</a>', get_permalink($employer_id), get_the_title($employer_id) );
                    }
                    ?>
                </div>
            </div>
            <div class="ali-right hidden-xs">
                <div class="flex-middle">
                    <div class="job-metas">
                        <?php if ( $address ) { ?>
                            <div class="job-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
                        <?php } ?>
                    </div>
                    <?php if ( $types ) { ?>
                        <?php foreach ($types as $term) {
                            $color = get_term_meta( $term->term_id, '_color', true );
                            $style = '';
                            if ( $color ) {
                                $style = 'background-color: '.$color;
                            }
                        ?>
                            <a class="type-job <?php echo (!empty($style))?'has-bg':''; ?>" href="<?php echo get_term_link($term); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="visible-xs bottom-mobile">
        <div class="flex-middle">
            <div class="job-metas">
                <?php if ( $address ) { ?>
                    <div class="job-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
                <?php } ?>
            </div>
            <?php if ( $types ) { ?>
                <?php foreach ($types as $term) {
                    $color = get_term_meta( $term->term_id, '_color', true );
                    $style = '';
                    if ( $color ) {
                        $style = 'background-color: '.$color;
                    }
                ?>
                    <a class="type-job <?php echo (!empty($style))?'has-bg':''; ?>" href="<?php echo get_term_link($term); ?>" style="<?php echo esc_attr($style); ?>"><?php echo esc_html($term->name); ?></a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_job_board_after_job_content', $post->ID ); ?>