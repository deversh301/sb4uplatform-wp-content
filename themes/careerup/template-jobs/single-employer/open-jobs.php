<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$limit = apply_filters('wp_job_board_employer_limit_open_jobs', 3);

$user_id = WP_Job_Board_User::get_user_by_employer_id($post->ID);
$args = array(
    'post_type' => 'job_listing',
    'posts_per_page' => $limit,
    'author' => $user_id
);
$jobs = new WP_Query( $args );
if( $jobs->have_posts() ):
    $jobs_url = WP_Job_Board_Mixes::get_jobs_page_url();
    $jobs_url = add_query_arg( 'filter-author', $user_id, remove_query_arg( 'filter-author', $jobs_url ) );
?>
    <div class="widget">
        <h4 class="widget-title">
            <span><?php esc_html_e( 'Open Position', 'careerup' ); ?></span>
            <div class="pull-right">
                <a href="<?php echo esc_url($jobs_url); ?>" class="text-theme view_all">
                    <?php esc_html_e('Browse Full List', 'careerup'); ?><i class="ti-arrow-right"></i>
                </a>
            </div>
        </h4>
        <div class="widget-content">
            <?php
                while ( $jobs->have_posts() ) : $jobs->the_post();
                    echo WP_Job_Board_Template_Loader::get_template_part( 'jobs-styles/inner-list-noimage' );
                endwhile;
            ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>