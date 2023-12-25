<?php

function careerup_get_employers( $params = array() ) {
	$params = wp_parse_args( $params, array(
		'limit' => -1,
		'post_status' => 'publish',
		'get_employers_by' => 'recent',
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
		'post_type'         => 'employer',
		'posts_per_page'    => $limit,
		'post_status'       => $post_status,
		'orderby'       => $orderby,
		'order'       => $order,
	);

	$meta_query = array();
	switch ($get_employers_by) {
		case 'recent':
			$query_args['orderby'] = 'date';
			$query_args['order'] = 'DESC';
			break;
		case 'featured':
			$meta_query[] = array(
				'key' => WP_JOB_BOARD_EMPLOYER_PREFIX.'featured',
	           	'value' => 'on',
	           	'compare' => '=',
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
            'taxonomy'      => 'employer_category',
            'field'         => 'slug',
            'terms'         => $categories,
            'operator'      => 'IN'
        );
    }
    if ( !empty($locations) ) {
    	$tax_query[] = array(
            'taxonomy'      => 'employer_location',
            'field'         => 'slug',
            'terms'         => $locations,
            'operator'      => 'IN'
        );
    }

    if ( !empty($tax_query) ) {
    	$query_args['tax_query'] = $tax_query;
    }
    
    if ( !empty($meta_query) ) {
    	$query_args['meta_query'] = $meta_query;
    }

    if ( method_exists('WP_Job_Board_Employer', 'employer_restrict_listing_query_args') ) {
	    $query_args = WP_Job_Board_Employer::employer_restrict_listing_query_args($query_args, null);
	}
	
	return new WP_Query( $query_args );
}

if ( !function_exists('careerup_employer_content_class') ) {
	function careerup_employer_content_class( $class ) {
		$prefix = 'employers';
		if ( is_singular( 'employer' ) ) {
            $prefix = 'employer';
        }
		if ( careerup_get_config($prefix.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'careerup_employer_content_class', 'careerup_employer_content_class', 1 , 1  );

if ( !function_exists('careerup_get_employers_layout_configs') ) {
	function careerup_get_employers_layout_configs() {
		$layout_type = careerup_get_config('employers_archive_layout');
		switch ( $layout_type ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => 'employers-filter-sidebar', 'class' => 'col-md-3 col-sm-12 col-xs-12'  );
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12' );
		 		break;
		 	case 'main-right':
		 	default:
		 		$configs['right'] = array( 'sidebar' => 'employers-filter-sidebar',  'class' => 'col-md-3 col-sm-12 col-xs-12' ); 
		 		$configs['main'] = array( 'class' => 'col-md-9 col-sm-12 col-xs-12' );
		 		break;
	 		case 'main':
	 			$configs['right'] = array( 'sidebar' => 'employers-filter-sidebar',  'class' => 'offcanvas-filter-sidebar' ); 
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12' );
	 			break;
		}
		return $configs; 
	}
}

function careerup_get_employers_display_mode() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_employers_display_mode', true );
	}
	if ( empty($columns) ) {
		$columns = careerup_get_config('employers_display_mode', 3);
	}
	return apply_filters( 'careerup_get_employers_columns', $columns );
}

function careerup_get_employers_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_employers_columns', true );
	}
	if ( empty($columns) ) {
		$columns = careerup_get_config('employers_columns', 3);
	}
	return apply_filters( 'careerup_get_employers_columns', $columns );
}

function careerup_get_employer_layout_type() {
	global $post;
	$layout_type = get_post_meta($post->ID, WP_JOB_BOARD_EMPLOYER_PREFIX.'layout_type', true);
	
	if ( empty($layout_type) ) {
		$layout_type = careerup_get_config('employer_layout_type', 'v1');
	}
	return apply_filters( 'careerup_get_employer_layout_type', $layout_type );
}

function careerup_get_employers_pagination() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$pagination = get_post_meta( $post->ID, 'apus_page_employers_pagination', true );
	}
	if ( empty($pagination) ) {
		$pagination = careerup_get_config('employers_pagination', 'default');
	}
	return apply_filters( 'careerup_get_employers_pagination', $pagination );
}