<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <div class="post-layout detail-top">
        <?php if( $post_format == 'link' ) {
            $format = careerup_post_format_link_helper( get_the_content(), get_the_title() );
            $title = $format['title'];
            $link = careerup_get_link_attributes( $title );
            $thumb = careerup_post_thumbnail('', $link);
            echo trim($thumb);
        } elseif( has_post_thumbnail() ) { ?>
            <div class="top-image">
                <div class="entry-thumb <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
                    <?php
                        $thumb = careerup_post_thumbnail();
                        echo trim($thumb);
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php careerup_post_categories($post); ?>
        <?php if (get_the_title()) { ?>
            <h1 class="entry-title">
                <?php the_title(); ?>
            </h1>
        <?php } ?>
        <div class="top-info">
            <a href="<?php the_permalink(); ?>"><i class="flaticon-clock"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
            <span class="comments"><i class="flaticon-chat"></i><?php comments_number( esc_html__('0 Comments', 'careerup'), esc_html__('1 Comment', 'careerup'), esc_html__('% Comments', 'careerup') ); ?></span>
        </div>
    </div>

	<div class="entry-content-detail">
    	<div class="single-info info-bottom">
            <div class="entry-description">
                <?php
                    
                        the_content();
                ?>
            </div><!-- /entry-content -->
    		<?php
    		wp_link_pages( array(
    			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'careerup' ) . '</span>',
    			'after'       => '</div>',
    			'link_before' => '<span>',
    			'link_after'  => '</span>',
    			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'careerup' ) . ' </span>%',
    			'separator'   => '',
    		) );
    		?>
            <?php  
                $posttags = get_the_tags();
            ?>
            <?php if( !empty($posttags) || careerup_get_config('show_blog_social_share', false) ){ ?>
        		<div class="tag-social clearfix">
                    <?php careerup_post_tags(); ?>
        			<?php if( careerup_get_config('show_blog_social_share', false) ) {
        				get_template_part( 'template-parts/sharebox' );
        			} ?>
        		</div>
            <?php } ?>
            <?php
                //Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true"><i class="flaticon-right-arrow"></i></span> ' .
                        '<span class="inner"><span class="navi">' . esc_html__( 'Next', 'careerup' ) . '</span> ' .
                        '<span class="title-direct">%title</span></span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true"><i class="flaticon-left-arrow"></i></span> ' .
                        '<span class="inner "><span class="navi"> ' . esc_html__( 'Prev', 'careerup' ) . '</span> ' .
                        '<span class="title-direct">%title</span></span>',
                ) );
            ?>
    	</div>
    </div>
</article>