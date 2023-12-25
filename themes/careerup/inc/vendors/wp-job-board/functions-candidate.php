<?php

function careerup_get_candidates( $params = array() ) {
	$params = wp_parse_args( $params, array(
		'limit' => -1,
		'post_status' => 'publish',
		'get_candidates_by' => 'recent',
		'orderby' => '',
		'order' => '',
		'post__in' => array(),
		'fields' => null, // ids
		'author' => null,
		'categories' => array(),
		'locations' => array(),
	));
	extract($params);

	$query_args = array(
		'post_type'         => 'candidate',
		'posts_per_page'    => $limit,
		'post_status'       => $post_status,
		'orderby'       => $orderby,
		'order'       => $order,
	);

	$meta_query = array();
	switch ($get_candidates_by) {
		case 'recent':
			$query_args['orderby'] = 'date';
			$query_args['order'] = 'DESC';
			break;
		case 'featured':
			$meta_query[] = array(
				'key' => WP_JOB_BOARD_CANDIDATE_PREFIX.'featured',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
		case 'urgent':
			$meta_query[] = array(
				'key' => WP_JOB_BOARD_CANDIDATE_PREFIX.'urgent',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
		default:
			$query_args['order'] = 'DESC';
			$query_args['orderby'] = array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
				'ID'         => 'DESC',
			);
			break;
	}

	if ( !empty($post__in) ) {
    	$query_args['post__in'] = $post__in;
    }

    if ( !empty($fields) ) {
    	$query_args['fields'] = $fields;
    }

    if ( !empty($author) ) {
    	$query_args['author'] = $author;
    }

    $tax_query = array();
    if ( !empty($categories) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'candidate_category',
            'field'         => 'slug',
            'terms'         => $categories,
            'operator'      => 'IN'
        );
    }
    if ( !empty($locations) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'candidate_location',
            'field'         => 'slug',
            'terms'         => $locations,
            'operator'      => 'IN'
        );
    }

    if ( !empty($tax_query) ) {
    	$query_args['tax_query'] = $tax_query;
    }
    
    $meta_query[] = array(
		'relation' => 'OR',
		array(
			'key'       => WP_JOB_BOARD_CANDIDATE_PREFIX.'show_profile',
			'value'     => 'show',
			'compare'   => '==',
		),
		array(
			'key'       => WP_JOB_BOARD_CANDIDATE_PREFIX.'show_profile',
			'compare' => 'NOT EXISTS',
		),
	);
    if ( !empty($meta_query) ) {
    	$query_args['meta_query'] = $meta_query;
    }

    if ( method_exists('WP_Job_Board_Candidate', 'candidate_restrict_listing_query_args') ) {
	    $query_args = WP_Job_Board_Candidate::candidate_restrict_listing_query_args($query_args, null);
	}

	return new WP_Query( $query_args );
}

if ( !function_exists('careerup_candidate_content_class') ) {
	function careerup_candidate_content_class( $class ) {
		$prefix = 'candidates';
		if ( is_singular( 'candidate' ) ) {
            $prefix = 'candidate';
        }
		if ( careerup_get_config($prefix.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'careerup_candidate_content_class', 'careerup_candidate_content_class', 1 , 1 );

if ( !function_exists('careerup_get_candidates_layout_configs') ) {
	function careerup_get_candidates_layout_configs() {
		$layout_type = careerup_get_config('candidates_archive_layout');
		switch ( $layout_type ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => 'candidates-filter-sidebar', 'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12' );
		 		break;
		 	case 'main-right':
		 	default:
		 		$configs['right'] = array( 'sidebar' => 'candidates-filter-sidebar',  'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['right'] = array( 'sidebar' => 'candidates-filter-sidebar',  'class' => 'offcanvas-filter-sidebar' ); 
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
		}
		return $configs; 
	}
}

function careerup_get_candidates_display_mode() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_candidates_display_mode', true );
	}
	if ( empty($columns) ) {
		$columns = careerup_get_config('candidates_display_mode', 3);
	}
	return apply_filters( 'careerup_get_candidates_columns', $columns );
}

function careerup_get_candidates_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_candidates_columns', true );
	}
	if ( empty($columns) ) {
		$columns = careerup_get_config('candidates_columns', 3);
	}
	return apply_filters( 'careerup_get_candidates_columns', $columns );
}

function careerup_get_candidates_filter_top_sidebar() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$show = get_post_meta( $post->ID, 'apus_page_candidates_show_filter_top_sidebar', true );
	}
	if ( empty($show) ) {
		$show = careerup_get_config('candidates_show_filter_top_sidebar', false);
	} else {
		if ( $show == 'yes' ) {
			$show = true;
		} else {
			$show = false;
		}
	}
	return apply_filters( 'careerup_get_candidates_filter_top_sidebar', $show );
}

function careerup_get_candidate_layout_type() {
	global $post;
	$layout_type = get_post_meta($post->ID, WP_JOB_BOARD_CANDIDATE_PREFIX.'layout_type', true);
	
	if ( empty($layout_type) ) {
		$layout_type = careerup_get_config('candidate_layout_type', 'v1');
	}
	return apply_filters( 'careerup_get_candidate_layout_type', $layout_type );
}

function careerup_get_candidates_pagination() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$pagination = get_post_meta( $post->ID, 'apus_page_candidates_pagination', true );
	}
	if ( empty($pagination) ) {
		$pagination = careerup_get_config('candidates_pagination', 'default');
	}
	return apply_filters( 'careerup_get_candidates_pagination', $pagination );
}

function careerup_display_shortlist_link( $post_id = null ) {
	if ( null == $post_id ) {
		$post_id = get_the_ID();
	}

	if ( WP_Job_Board_Employer::check_added_shortlist($post_id) ) {
		$classes = 'btn-added-candidate-shortlist btn-action-icon btn-action-sm';
		$nonce = wp_create_nonce( 'wp-job-board-remove-candidate-shortlist-nonce' );
		$text = esc_html__('Shortlisted', 'careerup');
	} else {
		$classes = 'btn-add-candidate-shortlist btn-action-icon btn-action-sm';
		$nonce = wp_create_nonce( 'wp-job-board-add-candidate-shortlist-nonce' );
		$text = esc_html__('Shortlist', 'careerup');
	}
	?>
	<a href="javascript:void(0);" class="<?php echo esc_attr($classes); ?>" title="<?php echo esc_html($text); ?>" data-candidate_id="<?php echo esc_attr($post_id); ?>" data-nonce="<?php echo esc_attr($nonce); ?>"><i class="flaticon-favorites"></i></a>
	<?php
}

function careerup_candidate_check_hidden_review() {
	$view = wp_job_board_get_option('candidates_restrict_review', 'all');
	if ( $view == 'always_hidden' ) {
		return false;
	}
	return true;
}


add_filter( 'cmb2_meta_boxes', 'careerup_candidate_fields' );
function careerup_candidate_fields( array $metaboxes) {
	$prefix = WP_JOB_BOARD_CANDIDATE_PREFIX;
	if ( !empty($metaboxes[ $prefix . 'general' ]['fields']) ) {
		$fields = $metaboxes[ $prefix . 'general' ]['fields'];
		$fields[] = array(
			'name'              => esc_html__( 'Cover Photo', 'careerup' ),
			'id'                => $prefix . 'cover_photo',
			'type'              => 'file',
			'query_args' => array( 'type' => 'image' ),
		);

		$metaboxes[ $prefix . 'general' ]['fields'] = $fields;
	}
	

	return $metaboxes;
}

add_filter( 'wp-job-board-candidate-fields-front', 'careerup_candidate_fields_front', 10);
function careerup_candidate_fields_front( $fields) {
	$prefix = WP_JOB_BOARD_CANDIDATE_PREFIX;
	$fields[] = array(
		'name'              => esc_html__( 'Cover Photo', 'careerup' ),
		'id'                => $prefix . 'cover_photo',
		'type'              => 'wp_job_board_file',
		'file_multiple'		=> false,
		'ajax'				=> true,
		'mime_types' 		=> array( 'gif', 'jpeg', 'jpg', 'png' ),
		'priority'          => 1.5,
	);
	return $fields;
}