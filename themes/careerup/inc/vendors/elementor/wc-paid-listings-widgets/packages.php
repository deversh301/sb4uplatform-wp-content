<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Jobs_Packages extends Elementor\Widget_Base {

	public function get_name() {
        return 'careerup_jobs_packages';
    }

	public function get_title() {
        return esc_html__( 'Apus Packages', 'careerup' );
    }
    
	public function get_categories() {
        return [ 'careerup-elements' ];
    }

	protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'package_type',
            [
                'label' => esc_html__( 'Packages Type', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'job_package' => esc_html__('Job Package', 'careerup'),
                    'cv_package' => esc_html__('CV Package', 'careerup'),
                    'contact_package' => esc_html__('Contact Package', 'careerup'),
                    'candidate_package' => esc_html__('Candidate Package', 'careerup'),
                    'resume_package' => esc_html__('Resume Package', 'careerup'),
                ),
                'default' => 'job_package'
            ]
        );

        $this->add_control(
            'order_by',
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
            'number',
            [
                'label' => esc_html__( 'Number Product Packages', 'careerup' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Number Product to display', 'careerup' ),
                'default' => 3
            ]
        );
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => 3,
            ]
        );
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'careerup'),
                    'style2' => esc_html__('Style 2', 'careerup'),
                    'style3' => esc_html__('Style 3', 'careerup'),
                    'style4' => esc_html__('Style 4', 'careerup'),
                ),
                'default' => 'style1'
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
            'section_normal_style',
            [
                'label' => esc_html__( 'Normal', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bg_normal_price_color',
            [
                'label' => esc_html__( 'Price Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner:not(.highlight) .price' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'bg_normal_color',
            [
                'label' => esc_html__( 'Price Background Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner:not(.highlight) .price' => 'background-color: {{VALUE}};',
                ],
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
                'normal_button_color',
                [
                    'label' => esc_html__( 'Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .subwoo-inner .add-cart .button' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'normal_button_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .subwoo-inner .add-cart .button' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'normal_button_br_color',
                [
                    'label' => esc_html__( 'Border Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .subwoo-inner .add-cart .button' => 'border-color: {{VALUE}};',
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
                'hover_button_color',
                [
                    'label' => esc_html__( 'Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart:hover,{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart:focus' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .subwoo-inner .add-cart .button:hover,{{WRAPPER}} .subwoo-inner .add-cart .button:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'hover_button_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart:hover, {{WRAPPER}} .subwoo-inner .add-cart .added_to_cart:focus' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .subwoo-inner .add-cart .button:hover, {{WRAPPER}} .subwoo-inner .add-cart .button:focus' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'hover_button_br_color',
                [
                    'label' => esc_html__( 'Border Color', 'careerup' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart:hover, {{WRAPPER}} .subwoo-inner .add-cart .added_to_cart:focus' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .subwoo-inner .add-cart .button:hover, {{WRAPPER}} .subwoo-inner .add-cart .button:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();



        $this->add_group_control(
            Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border', 'careerup' ),
                'selector' => '{{WRAPPER}} .subwoo-inner',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Highlight', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_price_color',
            [
                'label' => esc_html__( 'Background Price for Highlight', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.highlight .price' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hightlight_color',
            [
                'label' => esc_html__( 'Highlight Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.highlight' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background for Highlight', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.highlight' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.highlight .add-cart .added_to_cart' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .subwoo-inner.highlight .add-cart .button' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__( 'Button Background Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.highlight .add-cart .added_to_cart' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .subwoo-inner.highlight .add-cart .button' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'button_br_color',
            [
                'label' => esc_html__( 'Button Border Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .subwoo-inner.highlight .add-cart .added_to_cart' => 'border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .subwoo-inner.highlight .add-cart .button' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'hightlight_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .subwoo-inner.highlight' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        $loop = careerup_get_products( array(
            'product_type' => $package_type,
            'post_per_page' => $number,
            'orderby' => $order_by,
            'order' => $order,
        ));
        ?>
        <div class="widget woocommerce widget-subwoo <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php if ($loop->have_posts()): ?>
                <div class="row">
                    <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                        <div class="col-xs-12 col-sm-<?php echo esc_attr(12/$columns); ?>">
                            <div class="subwoo-inner <?php echo esc_attr($style.( $product->is_featured() ? ' highlight' : '') ); ?>">
                                <div class="item">
                                    <div class="header-sub">
                                        <h3 class="title"><?php the_title(); ?></h3>
                                        <div class="price"><?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free','careerup'); ?></div>
                                    </div>
                                    <div class="bottom-sub">
                                        <?php if ( has_excerpt() ) { ?>
                                            <div class="short-des"><?php the_excerpt(); ?></div>
                                        <?php } ?>
                                        <div class="button-action"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Jobs_Packages );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Jobs_Packages );
}