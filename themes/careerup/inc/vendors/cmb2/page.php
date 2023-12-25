<?php

if ( !function_exists( 'careerup_page_metaboxes' ) ) {
	function careerup_page_metaboxes(array $metaboxes) {
		global $wp_registered_sidebars;
        $sidebars = array();

        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'careerup' )), careerup_get_header_layouts() );
        $footers = array_merge( array('global' => esc_html__( 'Global Setting', 'careerup' )), careerup_get_footer_layouts() );

		$prefix = 'apus_page_';

        $columns = array(
            '' => esc_html__( 'Global Setting', 'careerup' ),
            '1' => esc_html__('1 Column', 'careerup'),
            '2' => esc_html__('2 Columns', 'careerup'),
            '3' => esc_html__('3 Columns', 'careerup'),
            '4' => esc_html__('4 Columns', 'careerup'),
            '6' => esc_html__('6 Columns', 'careerup')
        );
        // Jobs Page
        $fields = array(
            array(
                'name' => esc_html__( 'Jobs Layout', 'careerup' ),
                'id'   => $prefix.'layout_type',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'main' => esc_html__('Main Content', 'careerup'),
                    'left-main' => esc_html__('Left Sidebar - Main Content', 'careerup'),
                    'main-right' => esc_html__('Main Content - Right Sidebar', 'careerup'),
                    'half-map' => esc_html__('Half Map', 'careerup'),
                )
            ),
            array(
                'id' => $prefix.'jobs_show_filter_top_sidebar',
                'type' => 'select',
                'name' => esc_html__('Show filter top sidebar?', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'no' => esc_html__('No', 'careerup'),
                    'yes' => esc_html__('Yes', 'careerup')
                )
            ),
            array(
                'id' => $prefix.'display_mode',
                'type' => 'select',
                'name' => esc_html__('Default Display Mode', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'grid' => esc_html__('Grid', 'careerup'),
                    'list' => esc_html__('List', 'careerup'),
                )
            ),
            array(
                'id' => $prefix.'inner_style',
                'type' => 'select',
                'name' => esc_html__('Jobs list item style', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'list' => esc_html__('List Default', 'careerup'),
                    'list-v1' => esc_html__('List V1', 'careerup'),
                    'list-v2' => esc_html__('List V2', 'careerup'),
                    'list-v3' => esc_html__('List V3', 'careerup'),
                    'list-v4' => esc_html__('List V4', 'careerup'),
                    'list-v5' => esc_html__('List V5', 'careerup'),
                ),
            ),
            array(
                'id' => $prefix.'inner_grid_style',
                'type' => 'select',
                'name' => esc_html__('Jobs grid item style', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'grid' => esc_html__('Grid Default', 'careerup'),
                    'grid-v1' => esc_html__('Grid V1', 'careerup'),
                ),
            ),
            array(
                'id' => $prefix.'jobs_columns',
                'type' => 'select',
                'name' => esc_html__('Grid Listing Columns', 'careerup'),
                'options' => $columns,
            ),
            array(
                'id' => $prefix.'jobs_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'default' => esc_html__('Default', 'careerup'),
                    'loadmore' => esc_html__('Load More Button', 'careerup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'careerup'),
                ),
            ),
        );
        
        $metaboxes[$prefix . 'jobs_setting'] = array(
            'id'                        => $prefix . 'jobs_setting',
            'title'                     => esc_html__( 'Jobs Settings', 'careerup' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );


        // Employers Page
        $fields = array(
            array(
                'id' => $prefix.'employers_display_mode',
                'type' => 'select',
                'name' => esc_html__('Employers display mode', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'grid' => esc_html__('Grid', 'careerup'),
                    'list' => esc_html__('List', 'careerup'),
                    'simple' => esc_html__('Simple', 'careerup'),
                )
            ),
            array(
                'id' => $prefix.'employers_columns',
                'type' => 'select',
                'name' => esc_html__('Employer Columns', 'careerup'),
                'options' => $columns,
                'description' => esc_html__('Apply for display mode is grid and simple.', 'careerup'),
            ),
            array(
                'id' => $prefix.'employers_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'default' => esc_html__('Default', 'careerup'),
                    'loadmore' => esc_html__('Load More Button', 'careerup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'careerup'),
                ),
            ),
        );
        $metaboxes[$prefix . 'employers_setting'] = array(
            'id'                        => $prefix . 'employers_setting',
            'title'                     => esc_html__( 'Employers Settings', 'careerup' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        // Candidates Page
        $fields = array(
            array(
                'id' => $prefix.'candidates_show_filter_top_sidebar',
                'type' => 'select',
                'name' => esc_html__('Show filter top sidebar?', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'no' => esc_html__('No', 'careerup'),
                    'yes' => esc_html__('Yes', 'careerup')
                )
            ),
            array(
                'id' => $prefix.'candidates_display_mode',
                'type' => 'select',
                'name' => esc_html__('Candidates display mode', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'grid' => esc_html__('Grid', 'careerup'),
                    'list' => esc_html__('List', 'careerup'),
                )
            ),
            array(
                'id' => $prefix.'candidates_columns',
                'type' => 'select',
                'name' => esc_html__('Candidate Columns', 'careerup'),
                'options' => $columns,
                'description' => esc_html__('Apply for display mode is grid.', 'careerup'),
            ),
            array(
                'id' => $prefix.'candidates_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'careerup'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'careerup' ),
                    'default' => esc_html__('Default', 'careerup'),
                    'loadmore' => esc_html__('Load More Button', 'careerup'),
                    'infinite' => esc_html__('Infinite Scrolling', 'careerup'),
                ),
            ),
        );
        $metaboxes[$prefix . 'candidates_setting'] = array(
            'id'                        => $prefix . 'candidates_setting',
            'title'                     => esc_html__( 'Candidates Settings', 'careerup' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        // General
	    $fields = array(
			array(
				'name' => esc_html__( 'Select Layout', 'careerup' ),
				'id'   => $prefix.'layout',
				'type' => 'select',
				'options' => array(
					'main' => esc_html__('Main Content Only', 'careerup'),
					'left-main' => esc_html__('Left Sidebar - Main Content', 'careerup'),
					'main-right' => esc_html__('Main Content - Right Sidebar', 'careerup')
				)
			),
			array(
                'id' => $prefix.'fullwidth',
                'type' => 'select',
                'name' => esc_html__('Is Full Width?', 'careerup'),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__('No', 'careerup'),
                    'yes' => esc_html__('Yes', 'careerup')
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'careerup'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'careerup'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'careerup'),
                'options' => array(
                    'no' => esc_html__('No', 'careerup'),
                    'yes' => esc_html__('Yes', 'careerup')
                ),
                'default' => 'yes',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'careerup')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'careerup')
            ),
            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'careerup'),
                'description' => esc_html__('Choose a header for your website.', 'careerup'),
                'options' => $headers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_transparent',
                'type' => 'select',
                'name' => esc_html__('Header Transparent', 'careerup'),
                'description' => esc_html__('Choose a header for your website.', 'careerup'),
                'options' => array(
                    'no' => esc_html__('No', 'careerup'),
                    'yes' => esc_html__('Yes', 'careerup')
                ),
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'careerup'),
                'description' => esc_html__('Choose a footer for your website.', 'careerup'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'careerup'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'careerup')
            )
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'careerup' ),
			'object_types'              => array( 'page' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'careerup_page_metaboxes' );

if ( !function_exists( 'careerup_cmb2_style' ) ) {
	function careerup_cmb2_style() {
        wp_enqueue_style( 'careerup-cmb2-style', get_template_directory_uri() . '/inc/vendors/cmb2/assets/style.css', array(), '1.0' );
		wp_enqueue_script( 'careerup-admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '20150330', true );
	}
}
add_action( 'admin_enqueue_scripts', 'careerup_cmb2_style' );


