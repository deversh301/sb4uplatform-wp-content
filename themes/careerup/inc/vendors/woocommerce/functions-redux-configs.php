<?php

// Shop Archive settings
function careerup_woo_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-shopping-cart',
        'title' => esc_html__('Shop Settings', 'careerup'),
        'fields' => array(
            array(
                'id' => 'products_breadcrumb_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Breadcrumbs Setting', 'careerup').'</h3>',
            ),
            array(
                'id' => 'show_product_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'careerup'),
                'default' => 1
            ),
            array (
                'title' => esc_html__('Breadcrumbs Background Color', 'careerup'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'careerup').'</em>',
                'id' => 'woo_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'woo_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'careerup'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'careerup'),
            ),
        )
    );
    // Archive settings
    $sections[] = array(
        'title' => esc_html__('Product Archives', 'careerup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'products_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'careerup').'</h3>',
            ),
            array(
                'id' => 'show_shop_cat_title',
                'type' => 'switch',
                'title' => esc_html__('Show Shop/Category Title ?', 'careerup'),
                'default' => 1
            ),
            array(
                'id' => 'product_display_mode',
                'type' => 'select',
                'title' => esc_html__('Products Layout', 'careerup'),
                'subtitle' => esc_html__('Choose a default layout archive product.', 'careerup'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'careerup'),
                    'list' => esc_html__('List', 'careerup'),
                ),
                'default' => 'grid'
            ),
            array(
                'id' => 'product_columns',
                'type' => 'select',
                'title' => esc_html__('Product Columns', 'careerup'),
                'options' => $columns,
                'default' => 3,
                'required' => array('product_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'number_products_per_page',
                'type' => 'text',
                'title' => esc_html__('Number of Products Per Page', 'careerup'),
                'default' => 9,
                'min' => '1',
                'step' => '1',
                'max' => '100',
                'type' => 'slider'
            ),
            array(
                'id' => 'enable_swap_image',
                'type' => 'switch',
                'title' => esc_html__('Enable Swap Image', 'careerup'),
                'default' => 1
            ),

            array(
                'id' => 'products_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'careerup').'</h3>',
            ),
            array(
                'id' => 'product_archive_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'careerup'),
                'default' => false
            ),
            array(
                'id' => 'product_archive_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Archive Product Layout', 'careerup'),
                'subtitle' => esc_html__('Select the layout you want to apply on your archive product page.', 'careerup'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'careerup'),
                        'alt' => esc_html__('Main Content', 'careerup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left Sidebar - Main Content', 'careerup'),
                        'alt' => esc_html__('Left Sidebar - Main Content', 'careerup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main Content - Right Sidebar', 'careerup'),
                        'alt' => esc_html__('Main Content - Right Sidebar', 'careerup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main'
            ),
            array(
                'id' => 'product_archive_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Left Sidebar', 'careerup'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'careerup'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_archive_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Archive Right Sidebar', 'careerup'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'careerup'),
                'options' => $sidebars
            ),
        )
    );
    
    
    // Product Page
    $sections[] = array(
        'title' => esc_html__('Single Product', 'careerup'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'product_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'careerup').'</h3>',
            ),
            array(
                'id' => 'product_thumbs_position',
                'type' => 'select',
                'title' => esc_html__('Thumbnails Position', 'careerup'),
                'options' => array(
                    'thumbnails-left' => esc_html__('Thumbnails Left', 'careerup'),
                    'thumbnails-right' => esc_html__('Thumbnails Right', 'careerup'),
                    'thumbnails-bottom' => esc_html__('Thumbnails Bottom', 'careerup'),
                ),
                'default' => 'thumbnails-left',
            ),
            array(
                'id' => 'number_product_thumbs',
                'title' => esc_html__('Number Thumbnails Per Row', 'careerup'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '8',
                'type' => 'slider',
            ),
            array(
                'id' => 'show_product_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'careerup'),
                'default' => 1
            ),
            array(
                'id' => 'show_product_review_tab',
                'type' => 'switch',
                'title' => esc_html__('Show Product Review Tab', 'careerup'),
                'default' => 1
            ),
            array(
                'id' => 'product_sidebar_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Sidebar Setting', 'careerup').'</h3>',
            ),
            array(
                'id' => 'product_single_layout',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Single Product Sidebar Layout', 'careerup'),
                'subtitle' => esc_html__('Select the layout you want to apply on your Single Product Page.', 'careerup'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Only', 'careerup'),
                        'alt' => esc_html__('Main Only', 'careerup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'careerup'),
                        'alt' => esc_html__('Left - Main Sidebar', 'careerup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'careerup'),
                        'alt' => esc_html__('Main - Right Sidebar', 'careerup'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main'
            ),
            array(
                'id' => 'product_single_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'careerup'),
                'default' => false
            ),
            array(
                'id' => 'product_single_left_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Left Sidebar', 'careerup'),
                'subtitle' => esc_html__('Choose a sidebar for left sidebar.', 'careerup'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_single_right_sidebar',
                'type' => 'select',
                'title' => esc_html__('Single Product Right Sidebar', 'careerup'),
                'subtitle' => esc_html__('Choose a sidebar for right sidebar.', 'careerup'),
                'options' => $sidebars
            ),
            array(
                'id' => 'product_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Product Block Setting', 'careerup').'</h3>',
            ),
            array(
                'id' => 'show_product_releated',
                'type' => 'switch',
                'title' => esc_html__('Show Products Releated', 'careerup'),
                'default' => 1
            ),
            array(
                'id' => 'number_product_releated',
                'title' => esc_html__('Number of related products to show', 'careerup'),
                'default' => 3,
                'min' => '1',
                'step' => '1',
                'max' => '50',
                'type' => 'slider',
                'required' => array('show_product_releated', '=', true)
            ),
            array(
                'id' => 'releated_product_columns',
                'type' => 'select',
                'title' => esc_html__('Releated Products Columns', 'careerup'),
                'options' => $columns,
                'default' => 3,
                'required' => array('show_product_releated', '=', true)
            ),

            array(
                'id' => 'show_product_upsells',
                'type' => 'switch',
                'title' => esc_html__('Show Products upsells', 'careerup'),
                'default' => 1
            ),
            array(
                'id' => 'upsells_product_columns',
                'type' => 'select',
                'title' => esc_html__('Upsells Products Columns', 'careerup'),
                'options' => $columns,
                'default' => 3,
                'required' => array('show_product_upsells', '=', true)
            ),
        )
    );
    
    return $sections;
}
add_filter( 'careerup_redux_framwork_configs', 'careerup_woo_redux_config', 10, 3 );