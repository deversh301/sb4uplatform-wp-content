<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Job_Board_Category_List extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_job_board_category_list';
    }

	public function get_title() {
        return esc_html__( 'Apus Category List', 'careerup' );
    }
    
	public function get_categories() {
        return [ 'careerup-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Category List', 'careerup' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_nb_jobs',
            [
                'label' => esc_html__( 'Show Number Jobs', 'careerup' ),
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
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        $first_terms = get_terms( array(
            'taxonomy' => 'job_listing_category',
            'hide_empty' => false,
            'parent'   => 0
        ) );
        if ( ! empty( $first_terms ) && ! is_wp_error( $first_terms ) ) {
            ?>
            <div class="widget-job-category-list <?php echo esc_attr($el_class); ?>">
                
                <?php
                foreach ($first_terms as $term) {
                    ?>
                    <div class="category-section">
                        <div class="row">
                            <div class="catgory-parent col-md-3 col-xs-12">
                                <a href="<?php echo esc_url(get_term_link( $term, 'job_listing_category' )); ?>">
                                    <h3 class="title-parent"><?php echo esc_html($term->name); ?></h3>
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
                                        <div class="number_total">(<?php echo sprintf(_n('<span>%d</span> Job', '<span>%d</span> Jobs', $count, 'careerup'), $number_jobs); ?>)</div>
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="col-md-9 col-xs-12">
                                <?php
                                    $terms = get_terms( array(
                                        'taxonomy' => 'job_listing_category',
                                        'hide_empty' => false,
                                        'child_of'   => $term->term_id
                                    ) );
                                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                        ?>
                                        <div class="terms-sub">
                                            <ul class="terms-sub-list">
                                                <?php foreach ($terms as $term) { ?>
                                                    <li>
                                                        <a href="<?php echo esc_url(get_term_link( $term, 'job_listing_category' )); ?>">
                                                            <div class="sub-category"><?php echo esc_html($term->name); ?>
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
                                                                <span class="number"> (<?php echo sprintf(_n('<span>%d</span> Job', '<span>%d</span> Jobs', $count, 'careerup'), $number_jobs); ?>)</span>
                                                            <?php } ?>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div> 
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Job_Board_Category_List );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Job_Board_Category_List );
}