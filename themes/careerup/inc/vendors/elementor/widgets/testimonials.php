<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Testimonials extends Widget_Base {

    public function get_name() {
        return 'careerup_testimonials';
    }

    public function get_title() {
        return esc_html__( 'Apus Testimonials', 'careerup' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return [ 'careerup-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'careerup' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'content', [
                'label' => esc_html__( 'Content', 'careerup' ),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Choose Image', 'careerup' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Brand Image', 'careerup' ),
            ]
        );
        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'careerup' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'John Doe',
            ]
        );

        $repeater->add_control(
            'job',
            [
                'label' => esc_html__( 'Job', 'careerup' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Designer',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link To', 'careerup' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your social link here', 'careerup' ),
                'placeholder' => esc_html__( 'https://your-link.com', 'careerup' ),
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials', 'careerup' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'careerup' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Style 1', 'careerup'),
                    'style2' => esc_html__('Style 2', 'careerup'),
                    'style3' => esc_html__('Style 3', 'careerup'),
                    'style4' => esc_html__('Style 4', 'careerup'),
                    'style5' => esc_html__('Style 5', 'careerup'),
                ),
                'default' => ''
            ]
        );
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'careerup' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => '1'
            ]
        );
        $this->add_control(
            'show_nav',
            [
                'label' => esc_html__( 'Show Nav', 'careerup' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Show Pagination', 'careerup' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'careerup' ),
                'label_off' => esc_html__( 'Show', 'careerup' ),
            ]
        );
        $this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'careerup' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'careerup' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Style', 'careerup' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'careerup' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'careerup' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->add_control(
            'test_title_color',
            [
                'label' => esc_html__( 'Testimonial Title Color', 'careerup' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .name-client a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Testimonial Title Typography', 'careerup' ),
                'name' => 'test_title_typography',
                'selector' => '{{WRAPPER}} .name-client a',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'careerup' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Content Typography', 'careerup' ),
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_control(
            'job_color',
            [
                'label' => esc_html__( 'Job Color', 'careerup' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .job' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'careerup' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .testimonials-item::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => esc_html__( 'Dots Color', 'careerup' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .slick-dots li' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Job Typography', 'careerup' ),
                'name' => 'job_typography',
                'selector' => '{{WRAPPER}} .job',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border', 'careerup' ),
                'selector' => '{{WRAPPER}} .testimonials-item',
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box_style',
            [
                'label' => esc_html__( 'Hover Box', 'careerup' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_hv',
                'label' => esc_html__( 'Border', 'careerup' ),
                'selector' => '{{WRAPPER}} .testimonials-item:hover',
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_control(
            'shadow_hv_color',
            [
                'label' => esc_html__( 'Box Shadow Hover', 'careerup' ),
                'type' => Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .testimonials-item:hover' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} {{box_shadow_position.VALUE}};',
                ],
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($testimonials) ) {
            ?>
            <div class="widget widget-testimonials <?php echo esc_attr($el_class.' '.$style); ?>">
                <?php if($style == 'style5') {?>
                    <div class="wrapper-testimonial-thumbnail">
                        <div class="slick-carousel center testimonial-thumbnail" data-centerMode="true" data-items="5" data-smallmedium="3" data-extrasmall="3" data-pagination="false" data-nav="false" data-asnavfor=".testimonial-main" data-slidestoscroll="1" data-focusonselect="true" data-infinite="true">
                            <?php foreach ($testimonials as $item) { ?>
                                <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                                <?php if ( $img_src ) { ?>
                                    <div class="wrapper-avarta">
                                        <div class="avarta flex-middle justify-content-center">
                                            <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="slick-carousel testimonial-main" data-items="1" data-smallmedium="1" data-extrasmall="1" data-pagination="true" data-nav="false" data-asnavfor=".testimonial-thumbnail" data-slickparent="true">
                        <?php foreach ($testimonials as $item) { ?>
                            <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                            <div class="item">
                                <div class="testimonials-item">
                                    <div class="info-testimonials">
                                        <?php
                                        $img_rating_src = ( isset( $item['img_rating_src']['id'] ) && $item['img_rating_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_rating_src']['id'] ) : '';
                                        ?>
                                         <?php if ( !empty($item['name']) ) {

                                            $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                            if ( ! empty( $item['link']['url'] ) ) {
                                                $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                            }
                                            echo wp_kses_post($title);
                                        ?>
                                        <?php } ?>

                                        <?php if ( !empty($item['job']) ) { ?>
                                            <span class="job text-theme"><?php echo wp_kses_post($item['job']); ?></span>
                                        <?php } ?>
                                        <?php if ( !empty($item['content']) ) { ?>
                                            <div class="description"><?php echo wp_kses_post($item['content']); ?></div>
                                        <?php } ?>
                                        <?php if ( $img_rating_src ) {
                                        ?>
                                            <div class="rating">
                                                <img src="<?php echo esc_url($img_rating_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php }else{ ?>
                    <div class="slick-carousel testimonial-main" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="1" data-extrasmall="1" data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>">
                        <?php foreach ($testimonials as $item) { ?>
                        <?php $img_src = ( isset( $item['img_src']['id'] ) && $item['img_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_src']['id'] ) : ''; ?>
                        <div class="item">
                            <?php if($style == 'style3') {?>
                                <div class="testimonials-item">

                                    <div class="info-testimonials">

                                        <div class="flex-middle top-testimonials">
                                            <?php if ( $img_src ) { ?>
                                                <div class="avarta">
                                                    <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                                </div>
                                            <?php } ?>
                                            <div class="top-testimonials-right">
                                                <?php if ( !empty($item['name']) ) {

                                                    $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                                    if ( ! empty( $item['link']['url'] ) ) {
                                                        $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                                    }
                                                    echo wp_kses_post($title);
                                                ?>
                                                <?php } ?>

                                                <?php if ( !empty($item['job']) ) { ?>
                                                    <span class="job text-theme"><?php echo wp_kses_post($item['job']); ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <?php
                                        $img_rating_src = ( isset( $item['img_rating_src']['id'] ) && $item['img_rating_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_rating_src']['id'] ) : '';
                                        ?>

                                        <?php if ( !empty($item['content']) ) { ?>
                                            <div class="description"><?php echo wp_kses_post($item['content']); ?></div>
                                        <?php } ?>
                                        <?php if ( $img_rating_src ) {
                                        ?>
                                            <div class="rating">
                                                <img src="<?php echo esc_url($img_rating_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php }else{ ?>
                                <div class="testimonials-item">
                                    <?php if ( $img_src ) { ?>
                                        <div class="avarta">
                                            <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                        </div>
                                    <?php } ?>
                                    <div class="info-testimonials">
                                        <?php
                                        $img_rating_src = ( isset( $item['img_rating_src']['id'] ) && $item['img_rating_src']['id'] != 0 ) ? wp_get_attachment_url( $item['img_rating_src']['id'] ) : '';
                                        ?>
                                         <?php if ( !empty($item['name']) ) {

                                            $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                            if ( ! empty( $item['link']['url'] ) ) {
                                                $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                            }
                                            echo wp_kses_post($title);
                                        ?>
                                        <?php } ?>

                                        <?php if ( !empty($item['job']) ) { ?>
                                            <span class="job text-theme"><?php echo wp_kses_post($item['job']); ?></span>
                                        <?php } ?>
                                        <?php if ( !empty($item['content']) ) { ?>
                                            <div class="description"><?php echo wp_kses_post($item['content']); ?></div>
                                        <?php } ?>
                                        <?php if ( $img_rating_src ) {
                                        ?>
                                            <div class="rating">
                                                <img src="<?php echo esc_url($img_rating_src); ?>" alt="<?php echo esc_attr(!empty($item['name']) ? $item['name'] : ''); ?>">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Testimonials );
} else {
    Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Testimonials );
}