<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Job_Board_Candidate_Category_Banner extends Elementor\Widget_Base {

	public function get_name() {
        return 'careerup_job_board_candidate_category_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Candidate Category Banner', 'careerup' );
    }
    
	public function get_categories() {
        return [ 'careerup-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Category Banner', 'careerup' ),
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
            'slug',
            [
                'label' => esc_html__( 'Category Slug', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Category Slug here', 'careerup' ),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Category Icon', 'careerup' ),
                'type' => Elementor\Controls_Manager::ICON,
            ]
        );

        $this->add_control(
            'show_nb_jobs',
            [
                'label' => esc_html__( 'Show Number Candidates', 'careerup' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
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
            'section_title_style',
            [
                'label' => esc_html__( 'Style', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

            $this->start_controls_tab(
                'tab_normal',
                [
                    'label' => esc_html__( 'Normal', 'careerup' ),
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'border',
                    'label' => esc_html__( 'Border', 'careerup' ),
                    'selector' => '{{WRAPPER}} .candidate-banner-inner',
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'careerup' ),
                    'selector' => '{{WRAPPER}} .candidate-banner-inner',
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'tab_hover',
                [
                    'label' => esc_html__( 'Hover', 'careerup' ),
                ]
            );

            $this->add_control(
                'hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'condition' => [
                        'border_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .candidate-banner-inner:hover' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .candidate-banner-inner:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'box_hv_shadow',
                    'label' => esc_html__( 'Box Shadow', 'careerup' ),
                    'selector' => '{{WRAPPER}} .candidate-banner-inner:hover',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->end_controls_section();

        // icon style
        $this->start_controls_section(
            'section_title_icon',
            [
                'label' => esc_html__( 'Icon', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_icon_style' );

            $this->start_controls_tab(
                'tab_icon_normal',
                [
                    'label' => esc_html__( 'Normal', 'careerup' ),
                ]
            );

            $this->add_control(
                'icon_color',
                [
                    'label' => esc_html__( 'Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .candidate-banner-inner .category-icon' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'tab_icon_hover',
                [
                    'label' => esc_html__( 'Hover', 'careerup' ),
                ]
            );

            $this->add_control(
                'icon_hv_color',
                [
                    'label' => esc_html__( 'Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .candidate-banner-inner:hover .category-icon' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_text_style',
            [
                'label' => esc_html__( 'Title and Text', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color Title', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__( 'Color Number', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( empty($slug) ) {
            return;
        }
        ?>
        <div class="widget-candidate-category-banner <?php echo esc_attr($el_class); ?>">
            
            <?php
            $term = get_term_by( 'slug', $slug, 'candidate_category' );
            if ($term) {
            ?>
                <a href="<?php echo esc_url(get_term_link( $term, 'candidate_category' )); ?>">
                    <div class="candidate-banner-inner">
                        <div class="content-inner flex-middle">
                            <?php if ( !empty($icon) ) { ?>
                                <div class="category-icon"><i class="<?php echo esc_attr($icon); ?>"></i></div>
                            <?php } ?>
                            <div class="inner">
                                <?php if ( !empty($title) ) { ?>
                                    <h4 class="title">
                                        <?php echo trim($title); ?>
                                    </h4>
                                <?php } ?>

                                <?php if ( $show_nb_jobs ) {
                                        $args = array(
                                            'fields' => 'ids',
                                            'categories' => array($term->slug),
                                            'limit' => 1
                                        );
                                        $query = careerup_get_jobs($args);
                                        $number_jobs = $count = $query->found_posts;
                                        $number_jobs = $number_jobs ? WP_Job_Board_Mixes::format_number($number_jobs) : 0;
                                ?>
                                    <div class="number"><?php echo sprintf(_n('<strong>%d</strong> Open Position', '<strong>%d</strong> Open Positions', $count, 'careerup'), $number_jobs); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
        <?php
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Job_Board_Candidate_Category_Banner );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Job_Board_Candidate_Category_Banner );
}