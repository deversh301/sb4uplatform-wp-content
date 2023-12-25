<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
if ( empty($post->post_type) || $post->post_type != 'candidate' ) {
    return;
}

if ( method_exists('WP_Job_Board_Candidate', 'get_display_cv_download') ) {
    $cv_attachment = WP_Job_Board_Candidate::get_display_cv_download( $post );
} else {
    $cv_attachment = WP_Job_Board_Candidate::get_post_meta( $post->ID, 'cv_attachment', true );
}
if ( empty($cv_attachment) ) {
    return;
}

extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . $after_title;
}
$admin_url = admin_url( 'admin-ajax.php' );
if ( is_array($cv_attachment) ) { ?>
    <div id="candidate-cv" class="candidate-cv">
    <?php foreach ($cv_attachment as $id => $cv_url) {
        $file_info = pathinfo($cv_url);
        if ( $file_info ) {
            $download_url = add_query_arg(array('action' => 'wp_job_board_ajax_download_cv', 'file_id' => $id), $admin_url);
        ?>
            <a href="<?php echo esc_url($download_url); ?>" class="candidate-detail-cv">
                <span class="icon_type">
                    <?php if ( !empty($file_info['extension']) ) {
                        switch ($file_info['extension']) {
                            case 'doc':
                            case 'docx':
                                ?>
                                <i class="flaticon-doc"></i>
                                <?php
                                break;
                            
                            case 'pdf':
                                ?>
                                <i class="flaticon-pdf"></i>
                                <?php
                                break;
                            default:
                                ?>
                                <i class="flaticon-doc"></i>
                                <?php
                                break;
                        }
                    } ?>
                </span>
                <?php if ( !empty($file_info['filename']) ) { ?>
                    <div class="filename"><?php echo esc_html($file_info['filename']); ?></div>
                <?php } ?>
                <?php if ( !empty($file_info['extension']) ) { ?>
                    <div class="extension"><?php echo esc_html($file_info['extension']); ?></div>
                <?php } ?>
            </a>
        <?php }
    }?>
    </div>
<?php 
}