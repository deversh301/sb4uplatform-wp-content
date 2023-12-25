<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
careerup_load_select2();
?>
<div class="box-employer widget">
	<h3 class="widget-title"><?php echo esc_html__('Candidate Shortlist','careerup') ?></h3>

	<div class="search-orderby-wrapper flex-middle-sm">
		<div class="search-candidate-shortlist-form widget-search">
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
		<div class="sort-candidate-shortlist-form sortby-form">
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

	<?php if ( !empty($candidate_ids) && is_array($candidate_ids) ) {
		if ( get_query_var( 'paged' ) ) {
		    $paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
		    $paged = get_query_var( 'page' );
		} else {
		    $paged = 1;
		}
		$query_vars = array(
			'post_type'         => 'candidate',
			'posts_per_page'    => get_option('posts_per_page'),
			'paged'    			=> $paged,
			'post_status'       => 'publish',
			'post__in'       	=> $candidate_ids,
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
		$candidates = new WP_Query($query_vars);

		if ( $candidates->have_posts() ) {
			while ( $candidates->have_posts() ) : $candidates->the_post();
				global $post;
				$job_title = get_post_meta( $post->ID, WP_JOB_BOARD_CANDIDATE_PREFIX . 'job_title', true );
				$categories = get_the_terms( $post->ID, 'candidate_category' );
				$address = get_post_meta( $post->ID, WP_JOB_BOARD_CANDIDATE_PREFIX . 'address', true );
				$salary = WP_Job_Board_Candidate::get_salary_html($post->ID);
				$rating_avg = WP_Job_Board_Review::get_ratings_average($post->ID);
				?>

				<?php do_action( 'wp_job_board_before_candidate_content', $post->ID ); ?>

				<article <?php post_class('candidate-shortlist-wrapper candidate-list candidate-archive-layout'); ?>>
					<div class="flex">
						<?php if ( has_post_thumbnail() ) { ?>
					        <div class="candidate-thumbnail">
					        	<div class="thumbnail-inner">
					        		<a href="<?php the_permalink(); ?>">
						            	<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
						            </a>
						            <?php if ( !empty($rating_avg) ) { ?>
			                            <div class="rating-avg"><?php echo round($rating_avg,1,PHP_ROUND_HALF_UP); ?></div>
			                        <?php } ?>		
					            </div>
					        </div>
					    <?php } ?>

					    <div class="flex-middle inner-left">
			                <div class="candidate-information">
			                	
			            		<?php the_title( sprintf( '<h2 class="candidate-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			                    <?php if ( $job_title ) { ?>
			                        <div class="candidate-job-title">
			                            <?php echo wp_kses_post($job_title); ?>
			                        </div>
			                    <?php } ?>

			                    <!-- rating -->
			                    <?php if ( !empty($rating_avg) ) { ?>
			                        <div class="rating-avg-star"><?php echo WP_Job_Board_Review::print_review($rating_avg); ?></div>
			                    <?php } ?>
			                    <div class="info job-metas clearfix">
			                        <?php if ( $address ) { ?>
			                            <div class="candidate-location">
			                                <i class="flaticon-location-pin"></i><?php echo wp_kses_post($address); ?>
			                            </div>
			                        <?php } ?>

			                        <?php if ( $salary ) { ?>
			                            <div class="candidate-salary">
			                                <i class="flaticon-price"></i><?php echo wp_kses_post($salary); ?>
			                            </div>
			                        <?php } ?>
			                    </div>
			            	</div>
			                <div class="ali-right hidden-xs">
			                    <a href="<?php the_permalink(); ?>" class="btn-action-icon view"><i class="flaticon-eye"></i></a>
					    		<a href="javascript:void(0)" class="btn-action-icon deleted btn-remove-candidate-shortlist" data-candidate_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-candidate-shortlist-nonce' )); ?>"><i class="flaticon-rubbish-bin"></i></a>
			                </div>
			            </div>
				    </div>
				    <div class="visible-xs bottom-info">
	                    <a href="<?php the_permalink(); ?>" class="btn-action-icon view"><i class="flaticon-eye"></i></a>
			    		<a href="javascript:void(0)" class="btn-action-icon deleted btn-remove-candidate-shortlist" data-candidate_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-job-board-remove-candidate-shortlist-nonce' )); ?>"><i class="flaticon-rubbish-bin"></i></a>
	                </div>
				</article><!-- #post-## -->

				<?php do_action( 'wp_job_board_after_candidate_content', $post->ID );
			endwhile;

			WP_Job_Board_Mixes::custom_pagination( array(
				'max_num_pages' => $candidates->max_num_pages,
				'prev_text'     => esc_html__( 'Previous page', 'careerup' ),
				'next_text'     => esc_html__( 'Next page', 'careerup' ),
				'wp_query' => $candidates
			));

			wp_reset_postdata();
		}
	?>

	<?php } else { ?>
		<div class="not-found"><?php esc_html_e('Don\'t have any candidates in shortlist', 'careerup'); ?></div>
	<?php } ?>
</div>