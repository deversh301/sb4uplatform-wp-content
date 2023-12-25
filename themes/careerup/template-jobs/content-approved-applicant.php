<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;

$job_id = get_post_meta($post->ID, WP_JOB_BOARD_APPLICANT_PREFIX.'job_id', true);

$candidate_id = get_post_meta( $post->ID, WP_JOB_BOARD_APPLICANT_PREFIX.'candidate_id', true );
$candidate = get_post($candidate_id);

$candidate_url = get_permalink($candidate_id);
$candidate_url = add_query_arg( 'applicant_id', $post->ID, $candidate_url );
$candidate_url = add_query_arg( 'candidate_id', $candidate_id, $candidate_url );
$candidate_url = add_query_arg( 'action', 'view-profile', $candidate_url );

$admin_url = admin_url( 'admin-ajax.php' );
$download_url = add_query_arg(array('action' => 'wp_job_board_ajax_download_resume_cv', 'post_id' => $candidate_id), $admin_url);

$rating_avg = WP_Job_Board_Review::get_ratings_average($candidate_id);

$viewed = get_post_meta( $post->ID, WP_JOB_BOARD_APPLICANT_PREFIX.'viewed', true );
$classes = $viewed ? 'viewed' : '';

$categories = get_the_terms( $candidate_id, 'candidate_category' );
$locations = get_the_terms( $candidate_id, 'candidate_location' );

?>

<?php do_action( 'wp_job_board_before_applicant_content', $post->ID ); ?>

<article <?php post_class('applicants-job job-applicant-wrapper clearfix '.$classes); ?>>

    <?php if ( has_post_thumbnail($candidate_id) ) { ?>
        <div class="applicant-thumbnail">
            <div class="inner">
                <a href="<?php echo esc_url( $candidate_url ); ?>" rel="bookmark">
                    <?php echo get_the_post_thumbnail( $candidate_id, 'thumbnail' ); ?>
                </a>
            </div>
            <?php if ( !empty($rating_avg) ) { ?>
                <div class="rating-avg"><?php echo round($rating_avg,1,PHP_ROUND_HALF_UP); ?></div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="applicant-information">
        <div class="flex-middle-sm">
            <div class="left-info">
                <div class="flex-bottom-sm">
                    <h2 class="applicant-title">
                        <a href="<?php echo esc_url( $candidate_url ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h2>

                    <?php
                        $rejected = WP_Job_Board_Applicant::get_post_meta($post->ID, 'rejected', true);
                        $approved = WP_Job_Board_Applicant::get_post_meta($post->ID, 'approved', true);

                        if ( $approved ) {
                            echo '<span class="application-status-label label label-success approved">'.esc_html__('Approved', 'careerup').'</span>';
                        } elseif ( $rejected ) {
                            echo '<span class="application-status-label label label-danger rejected">'.esc_html__('Rejected', 'careerup').'</span>';
                        } else {
                            echo '<span class="application-status-label label label-default pending">'.esc_html__('Pending', 'careerup').'</span>';
                        }
                    ?>
                </div>
                <h4 class="job-title">
                    <a href="<?php echo get_permalink($job_id); ?>" class="text-theme"><?php echo get_the_title($job_id); ?></a>
                </h4>
                <div class="flex-bottom-sm">
                    <?php if ( !empty($rating_avg) ) { ?>
                        <div class="rating-avg-star"><?php echo WP_Job_Board_Review::print_review($rating_avg); ?></div>
                    <?php } ?>
                    <div class="applicant-date text-theme">
                        <span class="space hidden-xs"> - </span>
                        <?php the_time( get_option('date_format', 'd M, Y') ); ?>
                    </div>
                </div>
                
                <div class="metas flex-middle hidden-xs">
                    <?php if ( $categories ) { ?>
                        <div class="candidate-categories">
                            <i class="ti-folder"></i>
                            <?php $i=1; foreach ($categories as $term) { ?>
                                <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($categories) ? ', ' : '' ); ?>
                            <?php $i++; } ?>
                            
                        </div>
                    <?php } ?>
                    <?php if ( $locations ) {
                        $terms = array();
                        careerup_locations_walk($locations, 0, $terms);
                    ?>
                        <div class="job-location">
                            <i class="flaticon-location-pin"></i>
                            <?php $i=1; foreach ($terms as $term) { ?>
                                <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($terms) ? ', ' : '' ); ?>
                            <?php $i++; } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="right-info ali-right hidden-xs">
                <div class="flex-middle">
                    <div class="applicant-action-button">
                            
                        <a href="javascript:void(0);" class="btn-undo-approve-job-applied btn-action-icon btn-action-sm approve" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-undo-approve-applied-nonce' )); ?>" title="<?php esc_html_e('Undo Approved', 'careerup'); ?>"><i class="fa fa-undo"></i></a>

                        <?php careerup_display_shortlist_link($candidate_id); ?>

                        <?php
                        if ( $download_url ) {
                        ?>
                            <a class="btn-action-icon download btn-action-sm" href="<?php echo esc_url($download_url); ?>" title="<?php esc_html_e('Download CV', 'careerup'); ?>"><i class="flaticon-download"></i></a>
                        <?php } ?>

                        <a href="javascript:void(0);" class="btn-remove-job-applied btn-action-icon deleted btn-action-sm" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-applied-nonce' )); ?>" title="<?php esc_html_e('Remove', 'careerup'); ?>"><i class="flaticon-rubbish-bin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right-info bottom-info visible-xs">
        <div class="metas">
            <?php if ( $categories ) { ?>
                <div class="candidate-categories">
                    <i class="ti-folder"></i>
                    <?php $i=1; foreach ($categories as $term) { ?>
                        <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($categories) ? ', ' : '' ); ?>
                    <?php $i++; } ?>
                    
                </div>
            <?php } ?>
            <?php if ( $locations ) { ?>
                <div class="job-location">
                    <i class="flaticon-location-pin"></i>
                    <?php $i=1; foreach ($locations as $term) { ?>
                        <a href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a><?php echo esc_html( $i < count($locations) ? ', ' : '' ); ?>
                    <?php $i++; } ?>
                </div>
            <?php } ?>
        </div>
        <div class="flex-middle">
            <div class="applicant-action-button">
                
                <a href="javascript:void(0);" class="btn-undo-approve-job-applied btn-action-icon btn-action-sm approve" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-undo-approve-applied-nonce' )); ?>" title="<?php esc_html_e('Undo Approved', 'careerup'); ?>"><i class="fa fa-undo"></i></a>

                <?php careerup_display_shortlist_link($candidate_id); ?>

                <?php
                if ( $download_url ) {
                ?>
                    <a class="btn-action-icon download btn-action-sm" href="<?php echo esc_url($download_url); ?>" title="<?php esc_html_e('Download CV', 'careerup'); ?>"><i class="flaticon-download"></i></a>
                <?php } ?>
                
                <a href="javascript:void(0);" class="btn-remove-job-applied btn-action-icon deleted btn-action-sm" data-applicant_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-applied-nonce' )); ?>" title="<?php esc_html_e('Remove', 'careerup'); ?>"><i class="flaticon-rubbish-bin"></i></a>
            </div>
        </div>
    </div>
</article><!-- #post-## -->

<?php do_action( 'wp_job_board_after_applicant_content', $post->ID );