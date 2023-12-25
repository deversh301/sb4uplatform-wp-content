<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Job_Board_Jobs extends Elementor\Widget_Base {

	public function get_name() {
        return 'careerup_job_board_jobs';
    }

	public function get_title() {
        return esc_html__( 'Apus Jobs', 'careerup' );
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
            'job_item_style',
            [
                'label' => esc_html__( 'Job Item Style', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'list' => esc_html__('List Style (Default)', 'careerup'),
                    'list-v1' => esc_html__('List Style 1', 'careerup'),
                    'list-v2' => esc_html__('List Style 2', 'careerup'),
                    'list-v3' => esc_html__('List Style 3', 'careerup'),
                    'list-v4' => esc_html__('List Style 4', 'careerup'),
                    'list-v5' => esc_html__('List Style 5', 'careerup'),
                    'grid' => esc_html__('Grid Style', 'careerup'),
                    'grid-v1' => esc_html__('Grid 1 Style', 'careerup'),
                    'grid-v2' => esc_html__('Grid 2 Style', 'careerup'),
                ),
                'default' => 'list'
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'careerup' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'careerup'),
                    'carousel' => esc_html__('Carousel', 'careerup'),
                    'list' => esc_html__('List', 'careerup'),
                ),
                'default' => 'list'
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your column number here', 'careerup' ),
                'default' => 4,
                'condition' => [
                    'layout_type' => ['carousel', 'grid'],
                ],
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your rows number here', 'careerup' ),
                'default' => 1,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label'         => esc_html__( 'Show Navigation', 'careerup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'careerup' ),
                'label_off'     => esc_html__( 'Hide', 'careerup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__( 'Show Pagination', 'careerup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'careerup' ),
                'label_off'     => esc_html__( 'Hide', 'careerup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'careerup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'careerup' ),
                'label_off'     => esc_html__( 'No', 'careerup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'careerup' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'careerup' ),
                'label_off'     => esc_html__( 'No', 'careerup' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'view_more_text',
            [
                'label' => esc_html__( 'View More Button Text', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your view more text here', 'careerup' ),
            ]
        );

        $this->add_control(
            'view_more_url',
            [
                'label' => esc_html__( 'View More URL', 'careerup' ),
                'type' => Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your view more url here', 'careerup' ),
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
                'label' => esc_html__( 'Title', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        $category_slugs = !empty($category_slugs) ? array_map('trim', explode(',', $category_slugs)) : array();
        $type_slugs = !empty($type_slugs) ? array_map('trim', explode(',', $type_slugs)) : array();
        $location_slugs = !empty($location_slugs) ? array_map('trim', explode(',', $location_slugs)) : array();

        $args = array(
            'limit' => $limit,
            'get_jobs_by' => $get_jobs_by,
            'orderby' => $orderby,
            'order' => $order,
            'categories' => $category_slugs,
            'types' => $type_slugs,
            'locations' => $location_slugs,
        );
        $loop = careerup_get_jobs($args);
        if ( $loop->have_posts() ) {
            ?>
            <div class="widget-jobs widget <?php echo esc_attr($layout_type.' item-'.$job_item_style); ?> <?php echo esc_attr($el_class); ?>">
                <?php if ( $title || ($view_more_text && $view_more_url) ) { ?>
                    <div class="top-info  
                        <?php echo esc_attr( ( $view_more_text && $view_more_url && $job_item_style != 'list-v2' && $job_item_style != 'list' ) ? 'flex-middle-sm': 'text-center' ); ?>
                        ">
                        <?php if ( $title ) { ?>
                            <h2 class="widget-title"><?php echo wp_kses_post($title); ?></h2>
                        <?php } ?>
                        <?php if ( $view_more_text && $view_more_url && $job_item_style != 'list-v2' && $job_item_style != 'list' ) { ?>
                            <div class="ali-right hidden-xs">
                                <a href="<?php echo esc_url($view_more_url['url']); ?>" class="view-more-btn text-theme" target="<?php echo esc_attr($view_more_url['is_external'] ? '_blank' : '_self'); ?>"><?php echo wp_kses_post($view_more_text); ?> <i class="flaticon-right-arrow"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="widget-content">
                    <?php if ( $layout_type == 'carousel' ): ?>
                        <div class="slick-carousel" data-items="<?php echo esc_attr($columns); ?>" data-smallmedium="2" data-extrasmall="1" data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>">
                            <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style); ?>
                            <?php endwhile; ?>
                        </div>
                    <?php elseif( $layout_type == 'grid' ): ?>
                        <?php
                            $mdcol = 12/$columns;
                            $smcol = $columns >= 2 ? 6 : 12;
                        ?>
                        <div class="row">
                            <?php $count = 1; while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                <div class="col-md-<?php echo esc_attr($mdcol); ?> <?php echo esc_attr( $count%$columns == 1 ? 'md-clearfix':''); ?> <?php echo esc_attr( $count%2 == 1 ? 'sm-clearfix':''); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-12 list-item">
                                    <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style ); ?>
                                </div>
                            <?php $count++; endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                <div class="col-xs-12 list-item">
                                    <?php get_template_part( 'template-jobs/jobs-styles/inner', $job_item_style ); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
                <?php if ( $view_more_text && $view_more_url && $job_item_style != 'list-v2' && $job_item_style != 'list' ) { ?>
                    <div class="more-bottom visible-xs">
                        <a href="<?php echo esc_url($view_more_url['url']); ?>" class="view-more-btn text-theme"><?php echo wp_kses_post($view_more_text); ?> <i class="flaticon-right-arrow"></i></a>
                    </div>
                <?php } ?>
                <?php if( ($job_item_style == 'list-v2' || $job_item_style == 'list') && $view_more_text && $view_more_url ){ ?>
                    <div class="text-center bottom-v2">
                        <a href="<?php echo esc_url($view_more_url['url']); ?>" class="btn btn-primary" target="<?php echo esc_attr($view_more_url['is_external'] ? '_blank' : '_self'); ?>"><?php echo wp_kses_post($view_more_text); ?> <i class="flaticon-right-arrow"></i></a>
                    </div>
                <?php } ?>
            </div>
            <?php
        }
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Job_Board_Jobs );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Job_Board_Jobs );
}