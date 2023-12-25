<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Job_Board_Candidate_Search_Form extends Elementor\Widget_Base {

    public function get_name() {
        return 'careerup_job_board_candidate_search_form';
    }

    public function get_title() {
        return esc_html__( 'Apus Candidates Search Form', 'careerup' );
    }
    
    public function get_categories() {
        return [ 'careerup-elements' ];
    }

    public function get_form_fields() {
        
        return array(
            'title' => array(
                'label' => esc_html__( 'Search Keywords', 'careerup' ),
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input'),
                'placeholder' => esc_html__( 'e.g. web design', 'careerup' ),
                'toggle' => true,
                'for_post_type' => 'candidate',
            ),
            'category' => array(
                'label' => esc_html__( 'Candidate Category', 'careerup' ),
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_hierarchical_select'),
                'taxonomy' => 'candidate_category',
                'placeholder' => esc_html__( 'All Categories', 'careerup' ),
                'toggle' => true,
                'for_post_type' => 'candidate',
            ),
            'center-location' => array(
                'label' => esc_html__( 'Location', 'careerup' ),
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input_location'),
                'placeholder' => esc_html__( 'All Location', 'careerup' ),
                'show_distance' => true,
                'toggle' => true,
                'for_post_type' => 'candidate',
            ),
            'location' => array(
                'label' => esc_html__( 'Location List', 'careerup' ),
                'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_hierarchical_select'),
                'taxonomy' => 'candidate_location',
                'placeholder' => esc_html__( 'All Locations', 'careerup' ),
                'toggle' => true,
                'for_post_type' => 'candidate',
            ),
        );

    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Search Form', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $fields = $this->get_form_fields();
        $search_fields = array( '' => esc_html__('Choose a field', 'careerup') );
        foreach ($fields as $key => $field) {
            $search_fields[$key] = $field['label'];
        }

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'filter_field',
            [
                'label' => esc_html__( 'Filter field', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $search_fields
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'careerup' ),
            ]
        );

        $repeater->add_control(
            'desc',
            [
                'label' => esc_html__( 'Description', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
            ]
        );

        $repeater->add_control(
            'placeholder',
            [
                'label' => esc_html__( 'Placeholder', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
            ]
        );

        $repeater->add_control(
            'enable_autocompleate_search',
            [
                'label' => esc_html__( 'Enable autocompleate search', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Disbale', 'careerup' ),
                'label_off' => esc_html__( 'Enable', 'careerup' ),
                'condition' => [
                    'filter_field' => 'title',
                ],
            ]
        );

        $columns = array();
        for ($i=1; $i <= 12 ; $i++) { 
            $columns[$i] = sprintf(esc_html__('%d Columns', 'careerup'), $i);
        }
        $repeater->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'default' => 1
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
            'main_search_fields',
            [
                'label' => esc_html__( 'Main Search Fields', 'careerup' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'filter_btn_text',
            [
                'label' => esc_html__( 'Button Text', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Find Candidates',
            ]
        );

        $this->add_control(
            'btn_columns',
            [
                'label' => esc_html__( 'Button Columns', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'default' => 1
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
            'style',
            [
                'label' => esc_html__( 'Style', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'careerup'),
                ),
                'default' => ''
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
                'label' => esc_html__( 'Style', 'careerup' ),
                'tab' =>Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__( 'Color Input', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .select2-selection--single' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label' => esc_html__( 'Background Color Input', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-control' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .widget-candidate-search-form .select2-selection--single' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_br_color',
            [
                'label' => esc_html__( 'Border Color Input', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-control' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .widget-candidate-search-form .select2-selection--single' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_br_focus_color',
            [
                'label' => esc_html__( 'Border Color Input Focus', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .form-control:focus' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .widget-candidate-search-form .select2-container--open .select2-selection--single' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_button',
            [
                'label' => esc_html__( 'Button', 'careerup' ),
                'tab' =>Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs( 'tabs_button_style' );

                $this->start_controls_tab(
                    'tab_button_normal',
                    [
                        'label' => esc_html__( 'Normal', 'careerup' ),
                    ]
                );

                $this->add_control(
                    'button_text_color',
                    [
                        'label' => esc_html__( 'Text Color', 'careerup' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .btn-submit' => 'fill: {{VALUE}}; color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'background_color',
                    [
                        'label' => esc_html__( 'Background Color', 'careerup' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .btn-submit' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );


                $this->end_controls_tab();

                $this->start_controls_tab(
                    'tab_button_hover',
                    [
                        'label' => esc_html__( 'Hover', 'careerup' ),
                    ]
                );

                $this->add_control(
                    'hover_button_text_color',
                    [
                        'label' => esc_html__( 'Text Color', 'careerup' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'default' => '',
                        'selectors' => [
                            '{{WRAPPER}} .btn-submit:hover,{{WRAPPER}} .btn-submit:focus' => 'fill: {{VALUE}}; color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'hover_background_color',
                    [
                        'label' => esc_html__( 'Background Color', 'careerup' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'button_hover_border_color',
                    [
                        'label' => esc_html__( 'Border Color', 'careerup' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'condition' => [
                            'border_border!' => '',
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'border-color: {{VALUE}};',
                        ],
                    ]
                );

                $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->add_group_control(
                Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'border',
                    'selector' => '{{WRAPPER}} .btn-submit',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'careerup' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        $this->end_controls_section();


        $this->start_controls_section(
            'section_trending',
            [
                'label' => esc_html__( 'Trending Keywords', 'careerup' ),
                'tab' =>Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_keywords_color',
            [
                'label' => esc_html__( 'Title Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .trending-keywords .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'keywords_color',
            [
                'label' => esc_html__( 'Keywords Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .trending-keywords a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'keywords_hv_color',
            [
                'label' => esc_html__( 'Keywords Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .trending-keywords a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .trending-keywords a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'keywords_align',
            [
                'label' => esc_html__( 'Alignment', 'careerup' ),
                'type' => Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'careerup' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'careerup' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'careerup' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'careerup' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .content-trending' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $filter_fields = $this->get_form_fields();
        $widget_id = careerup_random_key();
        $instance = array();
        $args = array( 'widget_id' => $widget_id );
        $search_page_url = WP_Job_Board_Mixes::get_candidates_page_url();

        careerup_load_select2();
        ?>
        <div class="widget-candidate-search-form <?php echo esc_attr($el_class); ?>">
            <?php if ( !empty($title) ) { ?>
                <h1 class="title">
                    <?php echo esc_html($title); ?>
                </h1>
            <?php } ?>
            <form action="<?php echo esc_url($search_page_url); ?>" class="form-search" method="GET">
                <div class="search-form-inner search-form-inner-v2 <?php echo esc_attr($style); ?>">
                    <div class="row flex-end-md">
                        <?php
                        if ( !empty($main_search_fields) ) {
                            foreach ($main_search_fields as $item) {
                                if ( empty($filter_fields[$item['filter_field']]['field_call_back']) ) {
                                    continue;
                                }
                                $filter_field = $filter_fields[$item['filter_field']];

                                if ( $item['filter_field'] == 'title' ) {
                                    if ($item['enable_autocompleate_search']) {
                                        wp_enqueue_script( 'handlebars', get_template_directory_uri() . '/js/handlebars.min.js', array(), null, true);
                                        wp_enqueue_script( 'typeahead-jquery', get_template_directory_uri() . '/js/typeahead.bundle.min.js', array('jquery', 'handlebars'), null, true);
                                        $filter_field['add_class'] = 'apus-autocompleate-candidate-input';
                                    }
                                }

                                if ( isset($item['placeholder']) ) {
                                    $filter_field['placeholder'] = $item['placeholder'];
                                }
                                $filter_field['show_title'] = false;
                                $columns = !empty($item['columns']) ? $item['columns'] : '1';
                                ?>
                                <div class="col-xs-12 col-md-<?php echo esc_attr($columns); ?>">
                                    <div class="filter-item-wrapper">
                                        <?php if ( !empty($item['title']) ) { ?>
                                            <h6 class="title"><?php echo trim($item['title']); ?></h6>
                                        <?php } ?>
                                        <?php if ( !empty($item['desc']) ) { ?>
                                            <div class="desc"><?php echo trim($item['desc']); ?></div>
                                        <?php } ?>
                                        <?php call_user_func( $filter_field['field_call_back'], $instance, $args, $item['filter_field'], $filter_field ); ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="col-xs-12 col-md-<?php echo esc_attr($btn_columns); ?> form-group-btn-search">
                            <button class="btn-submit btn btn-block btn-theme" type="submit">
                                <?php echo trim($filter_btn_text); ?>
                            </button>
                        </div>
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
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Job_Board_Candidate_Search_Form );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Job_Board_Candidate_Search_Form );
}