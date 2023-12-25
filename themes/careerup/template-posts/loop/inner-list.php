<?php 
global $post;
$thumbsize = !isset($thumbsize) ? careerup_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
$thumb = careerup_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-list-item'); ?>>
    <div class="list-inner <?php echo (!empty($thumb))?'has-thumb':''; ?>">
        <div class="<?php echo (!empty($thumb))?'flex-middle-sm flex':''; ?>">
            <?php
                if ( !empty($thumb) ) {
                    ?>
                    <div class="col-image">
                        <div class="top-image">
                            <?php
                                echo trim($thumb);
                            ?>
                            <?php careerup_post_categories($post); ?>
                         </div>
                    </div>
                    <?php
                }
            ?>
            <div class="<?php echo (!empty($thumb))?'col-content':'col-content-full'; ?>">
                <?php if (get_the_title()) { ?>
                    <h4 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                <?php } ?>
                <div class="top-info">
                    <a href="<?php the_permalink(); ?>"><i class="flaticon-clock"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
                    <span class="comments"><i class="flaticon-chat"></i><?php comments_number( esc_html__('0 Comments', 'careerup'), esc_html__('1 Comment', 'careerup'), esc_html__('% Comments', 'careerup') ); ?></span>
                </div>

                <div class="description hidden-xs hidden-sm"><?php echo careerup_substring( get_the_excerpt(),22, '...' ); ?></div>
                <div class="description visible-sm"><?php echo careerup_substring( get_the_excerpt(),15, '...' ); ?></div>
                
                <a class="btn-readmore text-theme" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'careerup'); ?><i class="flaticon-right-arrow" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</article>