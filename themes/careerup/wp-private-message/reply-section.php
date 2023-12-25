<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$selected_post = $post;
if ( $selected_post ) {
  if ( method_exists('WP_Private_Message_Mixes', 'get_current_user_id') ) {
      $user_id = WP_Private_Message_Mixes::get_current_user_id();
  } else {
      $user_id = get_current_user_id();
  }
  update_post_meta($selected_post->ID, '_read_'.$user_id, 'yes');
  $post_id = $selected_post->ID;
  $author = $selected_post->post_author;
  $sender = get_post_meta($post_id, '_sender', true);
  $recipient = get_post_meta($post_id, '_recipient', true);

  if ( $user_id == $sender ) {
    $recipient_id = $recipient;
  } else {
    $recipient_id = $sender;
  }
  $paged = isset($paged) ? $paged : 1;
  $args = array(
    'post_per_page' => wp_private_message_get_option('number_replied_per_page', 25),
    'paged' => $paged,
    'parent' => $selected_post->ID,
  );
  $reply_messages = WP_Private_Message_Message::get_list_reply_messages($args);

  $display_name = get_the_author_meta('display_name', $recipient_id);
  if ( class_exists('WP_Job_Board_User') ) {
    if ( WP_Job_Board_User::is_employer($recipient_id) ) {
      $employer_id = WP_Job_Board_User::get_employer_by_user_id($recipient_id);
      $profile_url = get_permalink($employer_id);
      $display_name = get_the_title($employer_id);
    } elseif( WP_Job_Board_User::is_candidate($recipient_id) ) {
      $candidate_id = WP_Job_Board_User::get_candidate_by_user_id($recipient_id);
      $profile_url = get_permalink($candidate_id);
      $display_name = get_the_title($candidate_id);
    }
  }
?>
  <div class="recipient-info clearfix">
    <div class="message-item pull-left">
        <div class="avatar">
          <?php careerup_private_message_user_avarta( $recipient_id ); ?>
        </div>
        <div class="content">
          <h4 class="user-name">
            <?php
            if ( !empty($profile_url) ) {
              echo '<a href="'.$profile_url.'">'.esc_html($display_name).'</a>';
            } else {
              echo esc_html($display_name);
            }
            ?>
          </h4>
          <div class="message-title"><?php echo esc_html($selected_post->post_title); ?></div>
        </div>
    </div>
    <a href="javascript:void(0);" class="delete-message-btn pull-right" data-id="<?php echo esc_attr($selected_post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-private-message-delete-message-nonce' )); ?>"><i class="flaticon-dustbin"></i><?php esc_html_e('Delete Conversation', 'careerup'); ?></a>
  </div>
  <div class="content-box-white">
    <div class="list-replies-inner">
      <?php
      $next_page = $paged + 1;
      if ( $next_page <= $reply_messages->max_num_pages ) { ?>
        <div class="loadmore-action">
          <a href="javascript:void(0);" class="loadmore-replied-btn" data-paged="<?php echo esc_attr($next_page); ?>" data-parent="<?php echo esc_attr($selected_post->ID); ?>"><?php esc_html_e( 'Load more', 'careerup' ); ?></a>
        </div>
      <?php } ?>
      <ul class="list-replies">
        <?php
          if ( $next_page > $reply_messages->max_num_pages ) {
            echo WP_Private_Message_Template_Loader::get_template_part( 'reply-item', array( 'rpost' => $selected_post ) );
          }
        ?>
        
        <?php if ( $reply_messages->have_posts() ) {
          $posts = $reply_messages->posts;
          $posts = array_reverse($posts, true);
        ?>
          <?php foreach ($posts as $rpost) { ?>
            <?php
              echo WP_Private_Message_Template_Loader::get_template_part( 'reply-item', array( 'rpost' => $rpost ) );
            ?>
          <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <?php
      echo WP_Private_Message_Template_Loader::get_template_part( 'reply-message-form', array( 'parent' => $post_id ) );
    } ?>
  </div>