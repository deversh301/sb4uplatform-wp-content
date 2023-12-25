<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
    return;
}

$tags = get_the_terms( $post->ID, 'candidate_tag' );

if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
    extract( $args );
    extract( $instance );
    $title = apply_filters('widget_title', $instance['title']);

    if ( $title ) {
        echo trim($before_title)  . trim( $title ) . $after_title;
    }


    ?>
    <div class="tagcloud in-sidebar">
        <?php foreach ($tags as $tag) { ?>
            <a href="<?php echo esc_url(get_term_link($tag)); ?>"><?php echo esc_attr($tag->name); ?></a>
        <?php } ?>
    </div>
<?php }