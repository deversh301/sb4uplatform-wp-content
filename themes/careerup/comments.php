<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Careerup
 * @since Careerup 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

        <h3 class="comments-title"><?php comments_number( esc_html__('0 Comments', 'careerup'), esc_html__('1 Comment', 'careerup'), esc_html__('% Comments', 'careerup') ); ?></h3>
		<?php careerup_comment_nav(); ?>
		<ol class="comment-list">
			<?php wp_list_comments('callback=careerup_list_comment'); ?>
		</ol><!-- .comment-list -->

		<?php careerup_comment_nav(); ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'careerup' ); ?></p>
	<?php endif; ?>

	<?php
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $comment_args = array(
                        'title_reply'=> '<h4 class="title">'.esc_html__('Leave a Comment','careerup').'</h4><div class="sub">'.esc_html__('Your email address will not be published.','careerup').'</div>',
                        'comment_field' => '<div class="form-group space-comment">
                        						<label>'.esc_html__('Comment', 'careerup').'</label>
                                                <textarea rows="7" id="comment" class="form-control"  name="comment"'.$aria_req.'></textarea>
                                            </div>',
                        'fields' => apply_filters(
                        	'comment_form_default_fields',
	                    		array(
	                                'author' => '<div class="row"><div class="col-sm-12 col-xs-12"><div class="form-group ">
	                                			<label>'.esc_html__('Name', 'careerup').'</label>
	                                            <input type="text" name="author" class="form-control" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
	                                            </div></div>',
	                                'email' => ' <div class="col-sm-12 col-xs-12"><div class="form-group ">
	                                			<label>'.esc_html__('Email', 'careerup').'</label>
	                                            <input id="email"  name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
	                                            </div></div>',
	                                'Website' => ' <div class="col-xs-12 hidden"><div class="form-group ">
	                                            <input id="website" name="website" placeholder="'.esc_attr__('Website', 'careerup').'" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" ' . $aria_req . ' />
	                                            </div></div></div>',
	                            )
							),
	                        'label_submit' => esc_html__('Submit Comment', 'careerup'),
							'comment_notes_before' => '',
							'comment_notes_after' => '',
                        );
    ?>

	<?php careerup_comment_form($comment_args); ?>
</div><!-- .comments-area --> 