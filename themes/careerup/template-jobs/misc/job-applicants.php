<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
careerup_load_select2();
?>
<div class="box-employer widget">
	<h3 class="widget-title"><?php echo esc_html__('Applicant','careerup') ?></h3>

	<div class="search-orderby-wrapper flex-middle-md">
		<div class="search-applicants-form widget-search">
			<form action="" method="get" class="my-jobs-ordering">
				<div class="input-group">
					<input type="text" placeholder="<?php echo esc_html__( 'Search ...', 'careerup' ); ?>" class="form-control" name="search" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
					<span class="input-group-btn">
						<select name="job_id" class="job_id">
							<option value=""><?php esc_html_e('Filter by job', 'careerup'); ?></option>
							<?php if ( !empty($job_ids) ) {
								$selected = !empty($_GET['job_id']) ? $_GET['job_id'] : '';
							?>
								<?php foreach ($job_ids as $job_id) { ?>
									<option value="<?php echo esc_attr($job_id); ?>" <?php selected($selected, $job_id); ?>><?php echo get_the_title($job_id); ?></option>
								<?php } ?>
							<?php } ?>
						</select>
						<button class="search-submit btn btn-sm btn-search" name="submit">
							<i class="flaticon-magnifying-glass"></i>
						</button>
					</span>
				</div>
				<input type="hidden" name="paged" value="1" />
			</form>
		</div>
		<div class="sort-applicants-form sortby-form">
			<?php
				$orderby_options = apply_filters( 'wp_job_board_my_jobs_orderby', array(
					'menu_order'	=> esc_html__( 'Default', 'careerup' ),
					'newest' 		=> esc_html__( 'Newest', 'careerup' ),
					'oldest'     	=> esc_html__( 'Oldest', 'careerup' ),
				) );

				$orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : 'newest'; 
			?>

			<div class="orderby-wrapper flex-middle">
				<span class="text-sort">
					<?php echo esc_html__('Sort by: ','careerup'); ?>
				</span>
				<form class="my-jobs-ordering" method="get">
					<select name="orderby" class="orderby">
						<?php foreach ( $orderby_options as $id => $name ) : ?>
							<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
						<?php endforeach; ?>
					</select>
					<input type="hidden" name="paged" value="1" />
					<?php WP_Job_Board_Mixes::query_string_form_fields( null, array( 'orderby', 'submit', 'paged' ) ); ?>
				</form>
			</div>
		</div>
	</div>

	<?php
	if ( !empty($job_ids) && is_array($job_ids) ) {
		
		if ( !empty($_GET['job_id']) ) {
			$job_ids = array($_GET['job_id']);
		}

		foreach ($job_ids as $job_id) {
			$jids = array();
			if ( class_exists('WP_Job_Board_WPML') ) {
				$jids = array_merge($jids, WP_Job_Board_WPML::get_all_translations_object_id($job_id));
			} else {
				$jids = array($job_id);
			}
			$current_page = 1;
			$query_vars = array(
				'post_type'         => 'job_applicant',
				'posts_per_page'    => get_option('posts_per_page'),
				'paged'    			=> $current_page,
				'post_status'       => 'publish',
				'meta_query'       => array(
					array(
						'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'job_id',
						'value'     => $jids,
						'compare'   => 'IN',
					)
				)
			);

			if ( isset($_GET['search']) ) {
				$query_vars['s'] = $_GET['search'];
			}
			if ( isset($_GET['orderby']) ) {
				switch ($_GET['orderby']) {
					case 'menu_order':
						$query_vars['orderby'] = array(
							'menu_order' => 'ASC',
							'date'       => 'DESC',
							'ID'         => 'DESC',
						);
						break;
					case 'newest':
						$query_vars['orderby'] = 'date';
						$query_vars['order'] = 'DESC';
						break;
					case 'oldest':
						$query_vars['orderby'] = 'date';
						$query_vars['order'] = 'ASC';
						break;
				}
			}

			$applicants = new WP_Query($query_vars);
			
			
			$query_vars = array(
				'post_type'         => 'job_applicant',
				'posts_per_page'    => 1,
				'paged'    			=> 1,
				'post_status'       => 'publish',
				'meta_query'       => array(
					array(
						'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'job_id',
						'value'     => $jids,
						'compare'   => 'IN',
					),
					array(
						'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'rejected',
						'value'     => '1',
						'compare'   => '=',
					)
				)
			);
			$rejected = WP_Job_Board_Query::get_posts($query_vars);

			$query_vars = array(
				'post_type'         => 'job_applicant',
				'posts_per_page'    => 1,
				'paged'    			=> 1,
				'post_status'       => 'publish',
				'meta_query'       => array(
					array(
						'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'job_id',
						'value'     => $jids,
						'compare'   => 'IN',
					),
					array(
						'key' => WP_JOB_BOARD_APPLICANT_PREFIX.'approved',
						'value'     => '1',
						'compare'   => '=',
					)
				)
			);
			$approved = WP_Job_Board_Query::get_posts($query_vars);
			?>
			<div class="job-applicants">
				<div class="heading row flex-middle-sm">
					<div class="col-sm-6 col-xs-12">
						<h3 class="job-title"><?php echo get_the_title($job_id); ?></h3>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="inner-result flex-middle justify-content-end">
							<div class="total-applicants show-total-applicants active" data-job_id="<?php echo esc_attr($job_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-show-applicants-nonce' )); ?>">
								<?php echo sprintf(__('Total: %s', 'careerup'), '<span class="number">'.$applicants->found_posts.'</span>'); ?>
							</div>
							<div class="approved-applicants show-approved-applicants" data-job_id="<?php echo esc_attr($job_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-show-approved-applicants-nonce' )); ?>">
								<?php echo sprintf(__('Approved: %s', 'careerup'), '<span class="number">'.$approved->found_posts.'</span>'); ?>
							</div>
							<div class="rejected-applicants show-rejected-applicants" data-job_id="<?php echo esc_attr($job_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-show-rejected-applicants-nonce' )); ?>">
								<?php echo sprintf(__('Rejected: %s', 'careerup'), '<span class="number">'.$rejected->found_posts.'</span>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="applicants-wrapper">
					<?php if ( $applicants->have_posts() ) {
							?>
							<div class="applicants-inner">
								<?php
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
								?>
							</div>
							<?php if ( $applicants->max_num_pages > $current_page ) { ?>
								<form class="applicants-pagination-form">
									<button class="apus-loadmore-btn"><?php esc_html_e( 'Load more', 'careerup' ); ?></button>
									<input type="hidden" name="paged" value="<?php echo esc_attr($current_page + 1); ?>">
									<input type="hidden" name="job_id" value="<?php echo esc_attr($job_id); ?>">
									<?php WP_Job_Board_Mixes::query_string_form_fields( null, array( 'job_id', 'submit', 'paged' ) ); ?>
								</form>
							<?php } ?>
							
							<?php wp_reset_postdata();
						} else {
							?>
							<div class="no-found"><?php esc_html_e('No applicants found.', 'careerup'); ?></div>
							<?php
						}
					?>

				</div>
			</div>
			<?php
		}
		
	} else { ?>
		<div class="no-found"><?php esc_html_e('No applicants found.', 'careerup'); ?></div>
	<?php } ?>
</div>