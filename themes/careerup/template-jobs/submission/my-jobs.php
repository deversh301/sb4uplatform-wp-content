<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
careerup_load_select2();

$my_jobs_page_id = wp_job_board_get_option('my_jobs_page_id');
$my_jobs_url = get_permalink( $my_jobs_page_id );

?>

<div class="box-employer widget my-job-employer">
<h3 class="widget-title"><?php echo esc_html__('Manage Jobs','careerup') ?></h3>

	<div class="search-orderby-wrapper flex-middle-sm">
		<div class="search-my-jobs-form widget-search">
			<form action="" method="get">
				<div class="input-group">
					<input type="text" placeholder="<?php esc_attr_e( 'Search Job', 'careerup' ); ?>" class="form-control" name="search" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
					<span class="input-group-btn">
						<button class="search-submit btn btn-sm btn-search" name="submit">
							<i class="flaticon-magnifying-glass"></i>
						</button>
					</span>
				</div>
			</form>
		</div>
		<div class="sort-my-jobs-form">
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
		if ( method_exists('WP_Job_Board_User', 'get_user_id') ) {
			$user_id = WP_Job_Board_User::get_user_id();
		} else {
			$user_id = get_current_user_id();
		}
		$paged = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
		$query_vars = array(
			'post_type'     => 'job_listing',
			'post_status'   => apply_filters('wp-job-board-my-jobs-post-statuses', array( 'publish', 'expired', 'pending', 'pending_approve', 'pending_payment', 'draft', 'preview' )),
			'paged'         => $paged,
			'author'        => $user_id,
			'orderby'		=> 'date',
			'order'			=> 'DESC',
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
		$jobs = new WP_Query($query_vars);
	?>
	<?php if ( $jobs->have_posts() ) : ?>
		<div class="table-responsive">
			<table class="job-table">
				<thead>
					<tr>
						<th class="job-title"><?php esc_html_e('Job Title', 'careerup'); ?></th>
						<th class="job-applicants"><?php esc_html_e('Applicants', 'careerup'); ?></th>
						<th class="job-status"><?php esc_html_e('Status', 'careerup'); ?></th>
						<th class="job-actions"><?php esc_html_e('Actions', 'careerup'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); global $post;
					$filled = WP_Job_Board_Job_Listing::get_post_meta($post->ID, 'filled');
				?>
					<tr>
						<td class="job-table-info">
							
							<div class="job-table-info-content">
								<div class="job-table-info-content-title">
									<div class="job-title-wrapper">
										<h3 class="job-title">
											<?php if ( $post->post_status == 'publish' ) { ?>
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											<?php } else { ?>
												<?php the_title(); ?>
											<?php } ?>
										</h3>
										<?php if ( $filled ) { ?>
											<span class="application-status-label label label-success"><?php esc_html_e('Filled', 'careerup'); ?></span>
										<?php } ?>
									</div>

									<?php $is_urgent = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'urgent', true ); ?>
									<?php if ( $is_urgent ) : ?>
										<span class="urgent"><?php esc_html_e( 'Urgent', 'careerup' ); ?></span>
									<?php endif; ?>

									<?php $is_featured = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'featured', true ); ?>
									<?php if ( $is_featured ) : ?>
										<span class="featured"><i class="fa fa-star text-theme"></i></span>
									<?php endif; ?>

								</div>

								<?php $location = WP_Job_Board_Query::get_job_location_name(); ?>
								<?php if ( ! empty( $location ) ) : ?>
									<div class="job-table-info-content-location">
										<i class="flaticon-location-pin"></i><?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
									</div>
								<?php endif; ?>
								
								<div class="job-table-info-content-date-expiry">
									<div class="job-table-info-content-date">
										<span class="sub-date"><i class="flaticon-event"></i><?php esc_html_e('Created: ', 'careerup'); ?></span>
										<?php the_time( get_option('date_format') ); ?>
									</div>
									<div class="job-table-info-content-expiry">
										<span class="sub-date"><i class="flaticon-event"></i><?php esc_html_e('Expiry: ', 'careerup'); ?></span>
										<?php
											$expires = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX.'expiry_date', true);
											if ( $expires ) {
												echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $expires ) ) );
											} else {
												echo '--';
											}
										?>
									</div>
								</div>
							</div>
						</td>

						<td class="job-table-applicants min-width nowrap">
							<div class="job-table-applicants-inner">
								<?php
									$count_applicants = WP_Job_Board_Job_Listing::count_applicants($post->ID);
									echo sprintf(wp_kses(__('<span class="number">%d</span> Applicant(s)', 'careerup'), array( 'span' => array('class' => array()) ) ), $count_applicants);
								?>
							</div>
						</td>

						<td class="job-table-status min-width nowrap">
							<div class="job-table-actions-inner <?php echo esc_attr($post->post_status); ?>">
								<?php
									$post_status = get_post_status_object( $post->post_status );
									if ( !empty($post_status->label) ) {
										echo esc_html($post_status->label);
									} else {
										echo esc_html($post->post_status);
									}
								?>
							</div>
						</td>

						<td class="job-table-actions min-width nowrap td-action">
							
							<?php
							$my_jobs_url = add_query_arg( 'job_id', $post->ID, remove_query_arg( 'job_id', $my_jobs_url ) );
							switch ( $post->post_status ) {
								case 'publish' :
									$edit_url = add_query_arg( 'action', 'edit', remove_query_arg( 'action', $my_jobs_url ) );
									?>
									
									<?php
									
									if ( $filled ) {
										$classes = 'mark_not_filled';
										$title = esc_html__('Mark not filled', 'careerup');
										$nonce = wp_create_nonce( 'wp-job-board-mark-not-filled-nonce' );
										$icon_class = 'fa fa-lock';
									} else {
										$classes = 'mark_filled';
										$title = esc_html__('Mark filled', 'careerup');
										$nonce = wp_create_nonce( 'wp-job-board-mark-filled-nonce' );
										$icon_class = 'fa fa-unlock';
									}
									?>
									<a class="fill-btn btn-action-icon btn-action-sm <?php echo esc_attr($classes); ?>" href="javascript:void(0);" title="<?php echo esc_attr($title); ?>" data-job_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"><i class="<?php echo esc_attr($icon_class); ?>"></i></a>

									<?php
									$edit_able = wp_job_board_get_option('user_edit_published_submission');
									if ( $edit_able !== 'no' ) {
									?>
										<a href="<?php echo esc_url($edit_url); ?>" class="edit-btn btn-action-icon edit btn-action-sm job-table-action" title="<?php esc_attr_e('Edit', 'careerup'); ?>">
											<i class="flaticon-edit"></i>
										</a>
									<?php } ?>
									<?php
									break;
								case 'expired' :
									$relist_url = add_query_arg( 'action', 'relist', remove_query_arg( 'action', $my_jobs_url ) );
									?>
									<a href="<?php echo esc_url($relist_url); ?>" class="btn-action-icon view btn-action-sm job-table-action" title="<?php esc_attr_e('Relist', 'careerup'); ?>">
										<i class="fa fa-registered"></i>
									</a>
									<?php
									break;
								case 'pending_payment':
								case 'pending_approve':
								case 'pending' :
									$edit_able = wp_job_board_get_option('user_edit_published_submission');
									if ( $edit_able !== 'no' ) {
										$edit_url = add_query_arg( 'action', 'edit', remove_query_arg( 'action', $my_jobs_url ) );
										?>
										<a href="<?php echo esc_url($edit_url); ?>" class="edit-btn btn-action-icon edit btn-action-sm job-table-action" title="<?php esc_attr_e('Edit', 'careerup'); ?>">
											<i class="flaticon-edit"></i>
										</a>
										<?php
									}
								break;
								case 'draft' :
								case 'preview' :
									$continue_url = add_query_arg( 'action', 'continue', remove_query_arg( 'action', $my_jobs_url ) );
									?>
									<a href="<?php echo esc_url($continue_url); ?>" class="edit-btn btn-action-icon edit btn-action-sm job-table-action" title="<?php esc_attr_e('Continue', 'careerup'); ?>">
										<i class="flaticon-right-arrow"></i>
									</a>
									<?php
									break;
							}
							?>
							
							<a href="javascript:void(0)" class="remove-btn btn-action-icon deleted btn-action-sm job-table-action job-button-delete" data-job_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-delete-job-nonce' )); ?>" title="<?php esc_attr_e('Remove', 'careerup'); ?>">
								<i class="flaticon-rubbish-bin"></i>
							</a>

						</td>
					</tr>
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<?php
		WP_Job_Board_Mixes::custom_pagination( array(
			'max_num_pages' => $jobs->max_num_pages,
			'prev_text'     => esc_html__( 'Previous page', 'careerup' ),
			'next_text'     => esc_html__( 'Next page', 'careerup' ),
			'wp_query' => $jobs
		));
		wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="alert alert-warning">
			<p><?php esc_html_e( 'You don\'t have any jobs, yet. Start by creating new one.', 'careerup' ); ?></p>
		</div>
	<?php endif; ?>
</div>