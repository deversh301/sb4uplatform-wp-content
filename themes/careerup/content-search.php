<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Careerup
 * @since Careerup 1.0
 */
?>
<article <?php post_class('post post-layout post-list-item'); ?>>
    <div class="list-inner">
        <div class="col-content-full">
            <?php if (get_the_title()) { ?>
                <h4 class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
            <?php } ?>
            <div class="top-info">
                <a href="<?php the_permalink(); ?>"><i class="flaticon-clock"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
                <span class="comments"><i class="flaticon-chat"></i><?php comments_number( esc_html__('0 Comments', 'careerup'), esc_html__('1 Comment', 'careerup'), esc_html__('% Comments', 'careerup') ); ?></span>
            </div>
            <div class="description"><?php echo careerup_substring( get_the_excerpt(),22, '...' ); ?></div>
            <a class="btn-readmore text-theme" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'careerup'); ?><i class="flaticon-right-arrow" aria-hidden="true"></i></a>
        </div>
    </div>
</article>