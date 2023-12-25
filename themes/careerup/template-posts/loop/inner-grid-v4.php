<?php 
    $thumbsize = !isset($thumbsize) ? careerup_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
    $thumb = careerup_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid-v4'); ?>>
    <?php if($thumb) {?>
        <div class="top-image">
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
    <div class="top-info">
        <a href="<?php the_permalink(); ?>"><i class="flaticon-clock"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
        <span class="comments"><i class="flaticon-chat"></i><?php comments_number( esc_html__('0 Comments', 'careerup'), esc_html__('1 Comment', 'careerup'), esc_html__('% Comments', 'careerup') ); ?></span>
    </div>
    <a class="btn-readmore text-theme" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'careerup'); ?><i class="flaticon-right-arrow" aria-hidden="true"></i></a>
</article>