<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Careerup_Elementor_Job_Board_City_Banner extends Elementor\Widget_Base {

	public function get_name() {
        return 'careerup_job_board_city_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus City Banner', 'careerup' );
    }
    
	public function get_categories() {
        return [ 'careerup-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'City Banner', 'careerup' ),
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
                'label' => esc_html__( 'City Slug', 'careerup' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your City Slug here', 'careerup' ),
            ]
        );

        $this->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'City Image', 'careerup' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'careerup' ),
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

        if ( empty($slug) ) {
            return;
        }
        ?>
        <div class="widget-job-location-banner <?php echo esc_attr($el_class); ?>">
            
            <?php
            $term = get_term_by( 'slug', $slug, 'job_listing_location' );
            if ($term) {
            ?>
                <a href="<?php echo esc_url(get_term_link( $term, 'job_listing_location' )); ?>">
                    <div class="location-banner-inner">
                        <?php
                        if ( !empty($img_src['id']) ) {
                        ?>
                            <div class="location-image">
                                <?php echo careerup_get_attachment_thumbnail($img_src['id'], 'full'); ?>
                            </div>
                        <?php } ?>
                        <div class="content-inner">
                            <?php if ( !empty($title) ) { ?>
                                <h4 class="title">
                                    <?php echo trim($title); ?>
                                </h4>
                            <?php } ?>

                            <?php if ( $show_nb_jobs ) {
                                    $args = array(
                                        'fields' => 'ids',
                                        'locations' => array($term->slug),
                                        'limit' => 1
                                    );
                                    $query = careerup_get_jobs($args);
                                    $count = $number_jobs = $query->found_posts;
                                    $number_jobs = $number_jobs ? WP_Job_Board_Mixes::format_number($number_jobs) : 0;
                            ?>
                                <div class="number"><?php echo sprintf(_n('<strong>%d</strong> Open Position', '<strong>%d</strong> Open Positions', $count, 'careerup'), $number_jobs); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
        <?php

    }

}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Careerup_Elementor_Job_Board_City_Banner );
} else {
    Elementor\Plugin::instance()->widgets_manager->register( new Careerup_Elementor_Job_Board_City_Banner );
}