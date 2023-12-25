<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Job_Board_Jobs_Maps extends Elementor\Widget_Base {

	public function get_name() {
        return 'careerup_job_board_jobs_maps';
    }

	public function get_title() {
        return esc_html__( 'Apus Jobs Maps', 'careerup' );
    }
    
	public function get_categories() {
        return [ 'careerup-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Jobs', 'careerup' ),
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
            'category_slugs',
            [
                'label' => esc_html__( 'Categories Slug', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'careerup' ),
            ]
        );

        $this->add_control(
            'type_slugs',
            [
                'label' => esc_html__( 'Types Slug', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'careerup' ),
            ]
        );

        $this->add_control(
            'location_slugs',
            [
                'label' => esc_html__( 'Location Slug', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter id spearate by comma(,)', 'careerup' ),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'careerup' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Limit jobs to display', 'careerup' ),
                'default' => 4
            ]
        );
        
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order by', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'careerup'),
                    'date' => esc_html__('Date', 'careerup'),
                    'ID' => esc_html__('ID', 'careerup'),
                    'author' => esc_html__('Author', 'careerup'),
                    'title' => esc_html__('Title', 'careerup'),
                    'modified' => esc_html__('Modified', 'careerup'),
                    'rand' => esc_html__('Random', 'careerup'),
                    'comment_count' => esc_html__('Comment count', 'careerup'),
                    'menu_order' => esc_html__('Menu order', 'careerup'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'careerup'),
                    'ASC' => esc_html__('Ascending', 'careerup'),
                    'DESC' => esc_html__('Descending', 'careerup'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'get_jobs_by',
            [
                'label' => esc_html__( 'Get Jobs By', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'careerup'),
                    'featured' => esc_html__('Featured Jobs', 'careerup'),
                    'urgent' => esc_html__('Urgent Jobs', 'careerup'),
                    'recent' => esc_html__('Recent Jobs', 'careerup'),
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
            'section_title_style',
            [
                'label' => esc_html__( 'Tyles', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'careerup' ),
                'type' => Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #jobs-google-maps' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-jobs-maps <?php echo esc_attr($el_class); ?>">
            <?php if ( $title ) { ?>
                <h2 class="widget-title text-center"><?php echo esc_html($title); ?></h2>
            <?php } ?>
            <div class="widget-content">
                <div id="jobs-google-maps" class="jobs-google-maps" data-settings="<?php echo esc_attr(json_encode( $settings )); ?>"></div>
                <div class="hidden main-items-wrapper jobs-listing-wrapper"></div>
            </div>
        </div>
        <?php
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Job_Board_Jobs_Maps );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Job_Board_Jobs_Maps );
}