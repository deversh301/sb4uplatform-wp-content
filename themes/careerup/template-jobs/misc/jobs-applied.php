<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
careerup_load_select2();
?>
<div class="widget box-employer">
	<h3 class="widget-title"><?php echo esc_html__('Applied Jobs','careerup') ?></h3>

	<div class="search-orderby-wrapper flex-middle-sm">
		<div class="search-jobs-applied-form widget-search">
			<form action="" method="get">
				<div class="input-group">
					<input type="text" placeholder="<?php echo esc_html__( 'Search ...', 'careerup' ); ?>" class="form-control" name="search" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
					<span class="input-group-btn">
						<button class="search-submit btn btn-sm btn-search" name="submit">
							<i class="flaticon-magnifying-glass"></i>
						</button>
					</span>
				</div>
				<input type="hidden" name="paged" value="1" />
			</form>
		</div>
		<div class="sort-jobs-applied-form sortby-form">
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
	<?php if ( !empty($applicants) && !empty($applicants->posts) ) {

		foreach ($applicants->posts as $applicant_id) {
			$job_id = get_post_meta($applicant_id, WP_JOB_BOARD_APPLICANT_PREFIX.'job_id', true);
			$post = get_post($job_id);


			$author_id = $post->post_author;
			$employer_id = WP_Job_Board_User::get_employer_by_user_id($author_id);
			$types = get_the_terms( $post->ID, 'job_listing_type' );
			$address = get_post_meta( $post->ID, WP_JOB_BOARD_JOB_LISTING_PREFIX . 'address', true );
			$salary = WP_Job_Board_Job_Listing::get_salary_html($post->ID);

			?>

			<?php do_action( 'wp_job_board_before_job_content', $post->ID ); ?>

			<article <?php post_class('job-applied-wrapper job-list'); ?>>
				<div class="flex">
					<?php if ( has_post_thumbnail($employer_id) ) { ?>
				        <div class="employer-logo flex-middle">
				            <?php echo get_the_post_thumbnail( $employer_id, 'thumbnail' ); ?>
				        </div>
				    <?php } ?>
				    <div class="job-information flex-middle">
				    	<div class="inner">
				    		<?php if ( $types ) { ?>
					            <?php foreach ($types as $term) { ?>
					                <a class="text-theme" href="<?php echo get_term_link($term); ?>"><?php echo wp_kses_post($term->name); ?></a>
					            <?php } ?>
					        <?php } ?>
					        
					        <div class="job-title-wrapper">
						        <h2 class="job-title">
						        	<a href="<?php echo esc_url(get_permalink($job_id)); ?>" rel="bookmark"><?php echo get_the_title($job_id); ?></a>
						        </h2>
						        <?php
			                        $rejected = WP_Job_Board_Applicant::get_post_meta($applicant_id, 'rejected', true);
			                        $approved = WP_Job_Board_Applicant::get_post_meta($applicant_id, 'approved', true);

			                        if ( $approved ) {
			                            echo '<span class="application-status-label label label-success approved">'.esc_html__('Approved', 'careerup').'</span>';
			                        } elseif ( $rejected ) {
			                            echo '<span class="application-status-label label label-danger rejected">'.esc_html__('Rejected', 'careerup').'</span>';
			                        } else {
			                            echo '<span class="application-status-label label label-default pending">'.esc_html__('Pending', 'careerup').'</span>';
			                        }
			                    ?>
			                </div>

					        <div class="job-date-author">
					            <?php echo sprintf(esc_html__(' posted %s ago', 'careerup'), human_time_diff(get_the_time('U', $job_id), current_time('timestamp')) ); ?> 
					            <?php
					            if ( $employer_id ) {
					                echo sprintf(esc_html__('by %s', 'careerup'), get_the_title($employer_id) );
					            }
					            ?>
					        </div>
					        <div class="job-metas">
					            <?php if ( $address ) { ?>
					                <div class="job-location"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?></div>
					            <?php } ?>
					            <?php if ( $salary ) { ?>
					                <div class="job-salary"><i class="flaticon-price"></i><?php echo wp_kses_post($salary); ?></div>
					            <?php } ?>
					        </div>

				    	</div>
				    	<div class="ali-right">
				    		<a href="javascript:void(0)" class="btn-remove-job-applied btn-action-icon deleted" data-applicant_id="<?php echo esc_attr($applicant_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-applied-nonce' )); ?>"><i class="flaticon-rubbish-bin"></i></a>
				    	</div>
				    	
					</div>
				</div>

			</article><!-- #post-## -->

			<?php do_action( 'wp_job_board_after_job_content', $post->ID );

		}

		WP_Job_Board_Mixes::custom_pagination( array(
			'max_num_pages' => $applicants->max_num_pages,
			'prev_text'     => esc_html__( 'Previous page', 'careerup' ),
			'next_text'     => esc_html__( 'Next page', 'careerup' ),
			'wp_query' => $applicants
		));
	?>

	<?php } else { ?>
		<div class="not-found"><?php esc_html_e('No apply found.', 'careerup'); ?></div>
	<?php } ?>
</div>