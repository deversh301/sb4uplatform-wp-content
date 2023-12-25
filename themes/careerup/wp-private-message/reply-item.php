<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( method_exists('WP_Private_Message_Mixes', 'get_current_user_id') ) {
    $user_id = WP_Private_Message_Mixes::get_current_user_id();
} else {
    $user_id = get_current_user_id();
}
?>
<li class="<?php echo esc_attr($rpost->post_author == $user_id ? 'yourself-reply' : 'user-reply'); ?> author-id-<?php echo esc_attr($rpost->post_author); ?>">
  <?php if ( $rpost->post_author != $user_id ) { ?>
    <div class="avatar">
      <?php careerup_private_message_user_avarta( $rpost->post_author ); ?>
    </div>
  <?php } ?>
  <div class="reply-content">
    <!-- date -->
    <?php
      
      $current = strtotime(date("Y-m-d"));
      $date    = strtotime( get_the_time('Y-m-d', $rpost) );

      $datediff = $date - $current;
      $difference = floor($datediff/(60*60*24));
      if ( $difference == 0 ) {
        $date = esc_html__('Today', 'careerup');
      } elseif ( $difference == -1 ) {
        $date = esc_html__('Yesterday', 'careerup');
      } else {
        $date = get_the_time( get_option('date_format'), $rpost );
      }
    ?>
    <div class="post-date"><?php echo trim($date); ?>, <?php echo get_the_time( get_option('time_format'), $rpost ); ?></div>
    <div class="post-content"><?php echo esc_html($rpost->post_content); ?></div>
  </div>
  
</li>