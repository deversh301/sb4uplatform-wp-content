<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Job_Board_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'careerup_job_board_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Jobs Search Form', 'careerup' );
    }
    
	public function get_categories() {
        return [ 'careerup-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Search Form', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'careerup' ),
            ]
        );

        $this->add_control(
            'show_keyword_field',
            [
                'label' => esc_html__( 'Show keyword field', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
            ]
        );

        $this->add_control(
            'enable_autocompleate_search',
            [
                'label' => esc_html__( 'Enable autocompleate search', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Disbale', 'careerup' ),
                'label_off' => esc_html__( 'Enable', 'careerup' ),
                'condition' => [
                    'show_keyword_field' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_location_field',
            [
                'label' => esc_html__( 'Show location field', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
            ]
        );

        $this->add_control(
            'show_location_list_field',
            [
                'label' => esc_html__( 'Show location list field', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
            ]
        );

        $this->add_control(
            'show_type_field',
            [
                'label' => esc_html__( 'Show type field', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
            ]
        );

        $this->add_control(
            'show_category_field',
            [
                'label' => esc_html__( 'Show category field', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
            ]
        );

        $this->add_control(
            'keywords',
            [
                'label' => esc_html__( 'Trending Keywords', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'careerup' ),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'layout1' => esc_html__('Layout 1', 'careerup'),
                    'layout2' => esc_html__('Layout 2', 'careerup'),
                    'layout3' => esc_html__('Layout 3', 'careerup'),
                    'layout4' => esc_html__('Layout 4', 'careerup'),
                ),
                'default' => 'layout1'
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'careerup' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'careerup' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Title', 'careerup' ),
                'tab' =>Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .search-form-inner ' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_button_color',
            [
                'label' => esc_html__( 'Background Button Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_button_hv_color',
            [
                'label' => esc_html__( 'Background Button Hover Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-submit:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .btn-submit:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_keywords',
            [
                'label' => esc_html__( 'Keywords', 'careerup' ),
                'tab' =>Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_key',
            [
                'label' => esc_html__( 'Title Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .trending-keywords .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'key_color',
            [
                'label' => esc_html__( 'Key Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .trending-keywords a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-search .trending-keywords' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'key_hover_color',
            [
                'label' => esc_html__( 'Key Hover Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-search .trending-keywords a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-search .trending-keywords a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $fields = array(
            'title' => array(
                'label' => esc_html__( 'Search Keywords', 'careerup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input'),
                'placeholder' => esc_html__( 'Job Title or Keywords', 'careerup' ),
                'icon' => 'flaticon-search'
            ),
            'category' => array(
                'label' => esc_html__( 'Category', 'careerup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_hierarchical_select'),
                'taxonomy' => 'job_listing_category',
                'placeholder' => esc_html__( 'All Categories', 'careerup' ),
            ),
            'center-location' => array(
                'label' => esc_html__( 'Location', 'careerup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input_location'),
                'placeholder' => esc_html__( 'Location', 'careerup' ),
                'show_distance' => true,
                'icon' => 'flaticon-location-pin'
            ),
            'location' => array(
                'label' => esc_html__( 'Location list', 'careerup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_hierarchical_select'),
                'taxonomy' => 'job_listing_location',
                'placeholder' => esc_html__( 'All Locations', 'careerup' ),
                'toggle' => true,
                'for_post_type' => 'job_listing',
            ),
            'type' => array(
                'label' => esc_html__( 'Type', 'careerup' ),
                'show_title' => false,
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_hierarchical_select'),
                'taxonomy' => 'job_listing_type',
                'placeholder' => esc_html__( 'All Types', 'careerup' ),
            )
        );
        $widget_id = careerup_random_key();

        $search_page_url = WP_Job_Board_Mixes::get_jobs_page_url();

        careerup_load_select2();
        ?>
        <div class="widget-job-search-form <?php echo esc_attr($el_class); ?>">
            <?php if ( !empty($title) ) { ?>
                <h1 class="title">
                    <?php echo wp_kses_post($title); ?>
                </h1>
            <?php } ?>
            <form action="<?php echo esc_url($search_page_url); ?>" class="form-search <?php echo esc_attr($layout_type); ?>" method="GET">
                <div class="flex-middle-sm search-form-inner">
                    <?php
                        $instance = array();
                        $args = array( 'widget_id' => $widget_id );
                        if ( !empty($show_keyword_field) && $show_keyword_field ) {
                            $key = 'title';
                            $field = $fields['title'];
                            if ( $enable_autocompleate_search ) {
                                wp_enqueue_script( 'handlebars', get_template_directory_uri() . '/js/handlebars.min.js', array(), null, true);
                                wp_enqueue_script( 'typeahead-jquery', get_template_directory_uri() . '/js/typeahead.bundle.min.js', array('jquery', 'handlebars'), null, true);
                                $field['add_class'] = 'apus-autocompleate-input';
                            }
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                        if ( !empty($show_location_field) && $show_location_field ) {
                            $key = 'center-location';
                            $field = $fields['center-location'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                        if ( !empty($show_location_list_field) && $show_location_list_field ) {
                            $key = 'location';
                            $field = $fields['location'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                        if ( !empty($show_type_field) && $show_type_field ) {
                            $key = 'type';
                            $field = $fields['type'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                        if ( !empty($show_category_field) && $show_category_field ) {
                            $key = 'category';
                            $field = $fields['category'];
                            if ( !empty($field['field_call_back']) ) {
                                call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                            }
                        }
                    ?>
                    <div class="form-group form-group-search">
                        <button class="btn-submit btn btn-block btn-theme" type="submit"><?php echo esc_html__('Search','careerup') ?></button>
                    </div>
                </div>
                <?php
                    $keywords = !empty($keywords) ? array_map('trim', explode(',', $keywords)) : array();
                    if ( !empty($keywords) ) {
                ?>
                    <div class="content-trending">
                        <ul class="trending-keywords">
                            <li class="title"><?php esc_html_e('Trending Keywords:', 'careerup'); ?></li>
                            <?php foreach ($keywords as $keyword) {
                                $link = add_query_arg( 'filter-title', $keyword, remove_query_arg( 'filter-title', $search_page_url ) );
                            ?>
                                <li class="item"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($keyword); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </form>
        </div>
        <?php
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Job_Board_Search_Form );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Job_Board_Search_Form );
}