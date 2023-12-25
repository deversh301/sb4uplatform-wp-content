<?php 
    $thumbsize = !isset($thumbsize) ? careerup_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
    $thumb = careerup_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid-v3'); ?>>
    <?php if($thumb) {?>
        <div class="top-image">
            <div class="date">
                <a href="<?php the_permalink(); ?>">
                    <span class="year"><?php the_time('Y'); ?></span>
                    <?php the_time('F d'); ?></a>
            </div>
            <?php
                echo trim($thumb);
            ?>
         </div>
    <?php } ?>
    <?php careerup_post_categories($post); ?>
    <?php if (get_the_title()) { ?>
        <h4 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>
    <?php } ?>
    <?php if(has_excerpt()){?>
        <div class="description"><?php echo careerup_substring( get_the_excerpt(),15, '' ); ?></div>
    <?php } ?>
</article>