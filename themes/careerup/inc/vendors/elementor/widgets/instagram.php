<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Instagram extends Widget_Base {

	public function get_name() {
        return 'careerup_instagram';
    }

	public function get_title() {
        return esc_html__( 'Apus Instagram', 'careerup' );
    }
    
    public function get_icon() {
        return 'fa fa-instagram';
    }

	public function get_categories() {
        return [ 'careerup-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Instagram', 'careerup' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'careerup' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'careerup' ),
            ]
        );
        $this->add_control(
            'username',
            [
                'label' => esc_html__( 'Instagram Username', 'careerup' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'number',
            [
                'label' => esc_html__( 'Number', 'careerup' ),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__( 'Number images to display', 'careerup' ),
                'default' => 4
            ]
        );
        
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'careerup' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 4
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'careerup' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'careerup'),
                    'carousel' => esc_html__('Carousel', 'careerup'),
                ),
                'default' => 'grid'
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__( 'Photo size', 'careerup' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'thumbnail' => esc_html__('Thumbnail', 'careerup'),
                    'small' => esc_html__('Small', 'careerup'),
                    'large' => esc_html__('Large', 'careerup'),
                    'original' => esc_html__('Original', 'careerup'),
                ),
                'default' => 'thumbnail'
            ]
        );

        $this->add_control(
            'target',
            [
                'label' => esc_html__( 'Open links in', 'careerup' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '_self' => esc_html__('Current window (_self)', 'careerup'),
                    '_blank' => esc_html__('New window (_blank)', 'careerup'),
                ),
                'default' => 'grid'
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
                ),
                'default' => 'grid'
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

        $this->end_controls_section();
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-instagram text-center <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php if ( !empty($title) ) { ?>
                <h2 class="widget-title" >
                   <?php echo trim( $title ); ?>
                </h2>
            <?php } ?>
            <?php if ( !empty($username) ) { ?>
                <div class="space-45">
                    <a class="userinstagram" target="bank" href="<?php echo '//instagram.com/'.trim( $username ); ?>"><?php echo trim( '@'.$username ); ?></a>
                </div>
            <?php } ?>
            <div class="widget-content">
                <?php
                    $bcol = 12/(int)$columns;
                    if ($columns == 5) {
                        $bcol = 'cus-5';
                    }

                    if ( $username != '' ) {
                        $media_array = apus_framework_scrape_instagram( $username );
                        if ( is_wp_error( $media_array ) ) {
                            echo wp_kses_post( $media_array->get_error_message() );
                        } else {
                            // filter for images only?
                            if ( $images_only = apply_filters( 'careerup_instagram_element_images_only', false ) ) {
                                $media_array = array_filter( $media_array, 'apus_framework_images_only' );
                            }

                            // slice list down to required number
                            $media_array = array_slice( $media_array, 0, $number );
                            if ( $layout_type == 'grid' ) {
                                ?>
                                <div class="row instagram-pics">
                                    <?php
                                    foreach ( $media_array as $item ) {
                                        echo '<div class="col-xs-4 col-sm-'.esc_attr($bcol).'">';
                                        echo '<div class="item-instagram">';
                                        echo '<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"><img src="'. esc_url( $item[$size] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/>';

                                            echo '<div class="like-comments">';
                                                echo '<span class="likes"><i class="icon_heart"></i> '.$item['likes'].'</span>';
                                                echo '<span class="comments"><i class="icon_chat"></i> '.$item['comments'].'</span>';
                                            echo '</div>';
                                        echo '</a>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="slick-carousel" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="4" data-extrasmall="3" data-pagination="false" data-nav="true">
                                    <?php
                                    foreach ( $media_array as $item ) {
                                        echo '<div class="item">';
                                        echo '<div class="item-instagram">';
                                        echo '<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"><img src="'. esc_url( $item[$size] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/></a>';
                                        echo '<div class="like-comments">';
                                                echo '<span class="likes"><i class="icon_heart"></i> '.$item['likes'].'</span>';
                                                echo '<span class="comments"><i class="icon_chat"></i> '.$item['comments'].'</span>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                    }
                ?>
            </div>

        </div>
        <?php

    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Instagram );
} else {
    Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Instagram );
}