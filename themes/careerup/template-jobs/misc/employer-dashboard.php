<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$jobs = WP_Job_Board_Query::get_posts(array(
    'post_type' => 'job_listing',
    'post_status' => 'publish',
    'author' => $user_id,
    'fields' => 'ids'
));
$count_jobs = $jobs->post_count;
$shortlist = get_post_meta($employer_id, WP_JOB_BOARD_EMPLOYER_PREFIX.'shortlist', true);
$shortlist = is_array($shortlist) ? count($shortlist) : 0;
$total_reviews = WP_Job_Board_Review::get_total_reviews($employer_id);
$views = get_post_meta($employer_id, WP_JOB_BOARD_EMPLOYER_PREFIX.'views_count', true);
?>

<div class="employer-dashboard-wrapper">
	<div class="inner-list">
		<h3 class="title"><?php esc_html_e('Applications statistics', 'careerup'); ?></h3>
		<div class="statistics row">
			<div class="col-xs-6 col-sm-3">
				<div class="posted-jobs list-item">
					<div class="icon">
						<i class="flaticon-paper-plane"></i>
					</div>
					<div class="inner">
						<div class="jobs-count"><?php echo esc_html( $count_jobs ? WP_Job_Board_Mixes::format_number($count_jobs) : 0); ?></div>
						<h4><?php esc_html_e('Posted Jobs', 'careerup'); ?></h4>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="shortlist list-item">
					<div class="icon">
						<i class="flaticon-favorites"></i>
					</div>
					<div class="inner">
						<div class="jobs-count"><?php echo esc_html($shortlist ? WP_Job_Board_Mixes::format_number($shortlist) : 0); ?></div>
						<h4><?php esc_html_e('Shortlisted', 'careerup'); ?></h4>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="review-count-wrapper list-item">
					<div class="icon">
						<i class="flaticon-alarm"></i>
					</div>
					<div class="inner">
						<div class="review-count"><?php echo esc_html( $total_reviews ? WP_Job_Board_Mixes::format_number($total_reviews) : 0 ); ?></div>
						<h4><?php esc_html_e('Review', 'careerup'); ?></h4>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="views-count-wrapper list-item">
					<div class="icon">
						<i class="flaticon-tag"></i>
					</div>
					<div class="inner">
						<div class="views-count"><?php echo esc_html( $views ? WP_Job_Board_Mixes::format_number($views) : 0 ); ?></div>
						<h4><?php esc_html_e('Views', 'careerup'); ?></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="inner-list">
		<h3 class="title"><?php esc_html_e('Recent Applicants', 'careerup'); ?></h3>
		<div class="applicants">
			<?php
				$jobs_loop = WP_Job_Board_Query::get_posts(array(
					'post_type' => 'job_listing',
					'fields' => 'ids',
					'author' => $user_id,
				));
				$job_ids = array();
				if ( !empty($jobs_loop) && !empty($jobs_loop->posts) ) {
					$job_ids = $jobs_loop->posts;
				}

				if ( !empty($job_ids) ) {
					$jids = array();
					if ( class_exists('WP_Job_Board_WPML') ) {
						foreach ($job_ids as $id) {
							$jids = array_merge($jids, WP_Job_Board_WPML::get_all_translations_object_id($id));
						}
					} else {
						$jids = $job_ids;
					}
					$query_args = array(
						'post_type'         => 'job_applicant',
						'posts_per_page'    => 5,
						'post_status'       => 'publish',
						'meta_query'       => array(
							array(
								'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'job_id',
								'value'     => $jids,
								'compare'   => 'IN',
							)
						)
					);

					$applicants = new WP_Query($query_args);
					if ( $applicants->have_posts() ) {
						while ( $applicants->have_posts() ) : $applicants->the_post();
							global $post;
							$rejected = WP_Job_Board_Applicant::get_post_meta($post->ID, 'rejected', true);
		                    $approved = WP_Job_Board_Applicant::get_post_meta($post->ID, 'approved', true);
		                    if ( $rejected ) {
								echo WP_Job_Board_Template_Loader::get_template_part( 'content-rejected-applicant' );
							} elseif ( $approved ) {
								echo WP_Job_Board_Template_Loader::get_template_part( 'content-approved-applicant' );
							} else {
								echo WP_Job_Board_Template_Loader::get_template_part( 'content-applicant' );
							}
						endwhile;
						wp_reset_postdata();
					} else {
						?>
						<div class="no-found"><?php esc_html_e('No applicants found.', 'careerup'); ?></div>
						<?php
					}
				} else {
					?>
					<div class="no-found"><?php esc_html_e('No applicants found.', 'careerup'); ?></div>
					<?php
				}
			?>
		</div>
	</div>
</div>