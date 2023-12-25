<?php
    $post_format = get_post_format();
    $thumbsize = !isset($thumbsize) ? careerup_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
    $thumb = careerup_display_post_thumb($thumbsize);
    $categories = get_the_category();
?>
<article <?php post_class('post post-layout post-grid-v5'); ?>>
    <div class="top-image <?php echo (!empty($thumb) && $post_format != 'audio' && $post_format != 'video' ) ? 'has-thumb' : 'no-thumb'; ?>">
        <?php
            echo trim($thumb);
        ?>
    </div>
    <div class="entry-content <?php echo !empty($thumb) ? 'has-thumb' : 'no-thumb'; ?>">
        <?php if ( ! empty( $categories ) ) { ?>
            <div class="categories">
                <?php careerup_post_categories_first($post); ?>
            </div>
        <?php } ?>
        <?php if (get_the_title()) { ?>
            <h3 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        <?php } ?>
    </div>
</article>