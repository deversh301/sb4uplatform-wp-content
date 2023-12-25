<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_User_Info extends Elementor\Widget_Base {

	public function get_name() {
        return 'careerup_user_info';
    }

	public function get_title() {
        return esc_html__( 'Apus Header User Info', 'careerup' );
    }
    
	public function get_categories() {
        return [ 'careerup-header-elements' ];
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
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'careerup' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'careerup' ),
            ]
        );

        $this->add_responsive_control(
            'align',
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
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Icon', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color Icon', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .drop-dow' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography_menu',
                'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .btn',
            ]
        );
        
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding Button', 'careerup' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'careerup' ),
                'type' =>Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Color Button', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-login' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__( 'Background Color Button', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-login' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_color',
            [
                'label' => esc_html__( 'Border Color Button', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-login' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => esc_html__( 'Hover Color Button', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-login:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-login:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => esc_html__( 'Hover Background Color Button', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-login:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .btn-login:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__( 'Hover Border Color Button', 'careerup' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .btn-login:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .btn-login:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $userdata = get_userdata($user_id);
            $user_name = $userdata->display_name;
            if ( WP_Job_Board_User::is_employer($user_id) || WP_Job_Board_User::is_candidate($user_id) || ( method_exists('WP_Job_Board_User', 'is_employee') && WP_Job_Board_User::is_employee($user_id) ) ) {
                if ( WP_Job_Board_User::is_employer($user_id) ) {
                    $menu_nav = 'employer-menu';
                    $employer_id = WP_Job_Board_User::get_employer_by_user_id($user_id);
                    $user_name = get_post_field('post_title', $employer_id);
                    $avatar = get_the_post_thumbnail( $employer_id, 'thumbnail' );
                } elseif ( method_exists('WP_Job_Board_User', 'is_employee') && WP_Job_Board_User::is_employee($user_id) ) {
                    $user_id = WP_Job_Board_User::get_user_id();
                    
                    $menu_nav = 'employee-menu';
                    $employer_id = WP_Job_Board_User::get_employer_by_user_id($user_id);
                    $user_name = get_post_field('post_title', $employer_id);
                    $avatar = get_the_post_thumbnail( $employer_id, 'thumbnail' );
                } else {
                    $menu_nav = 'candidate-menu';
                    $candidate_id = WP_Job_Board_User::get_candidate_by_user_id($user_id);
                    $user_name = get_post_field('post_title', $candidate_id);
                    $avatar = get_the_post_thumbnail( $candidate_id, 'thumbnail' );
                }
            }
            ?>
            <div class="top-wrapper-menu <?php echo esc_attr($el_class); ?> pull-right">
                <a class="drop-dow" href="javascript:void(0);">
                    <div class="infor-account flex-middle">
                        <div class="avatar">
                            <?php if ( !empty($avatar)) {
                                echo trim($avatar);
                            } else {
                                echo get_avatar($user_id, 54);
                            } ?>
                        </div>
                        <div class="name-acount"><?php echo esc_html($user_name); ?> 
                            <?php if ( !empty($menu_nav) && has_nav_menu( $menu_nav ) ) { ?>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            <?php } ?>
                        </div>
                    </div>
                </a>
                <?php
                    if ( !empty($menu_nav) && has_nav_menu( $menu_nav ) ) {
                        $args = array(
                            'theme_location' => $menu_nav,
                            'container_class' => 'inner-top-menu',
                            'menu_class' => 'nav navbar-nav topmenu-menu',
                            'fallback_cb' => '',
                            'menu_id' => '',
                            'walker' => new Careerup_Nav_Menu()
                        );
                        wp_nav_menu($args);
                    }
                ?>
            </div>
        <?php } else {
            $login_register_page_id = wp_job_board_get_option('login_register_page_id');
            $page_id = WP_Job_Board_WPML::get_icl_object_id($login_register_page_id, 'page');
        ?>
            <div class="top-wrapper-menu <?php echo esc_attr($el_class); ?> pull-right">
                <a class="btn btn-theme btn-login login" href="<?php echo esc_url( get_permalink( $page_id ) ); ?>" title="<?php esc_html_e('Sign in','careerup'); ?>"><?php esc_html_e('Login/Register', 'careerup'); ?>
                </a>
            </div>
        <?php }
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_User_Info );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_User_Info );
}