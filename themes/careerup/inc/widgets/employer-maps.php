<?php

class Careerup_Widget_Employer_Maps extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_employer_maps',
            esc_html__('Employer Detail:: Maps', 'careerup'),
            array( 'description' => esc_html__( 'Show employer maps', 'careerup' ), )
        );
        $this->widgetName = 'employer_maps';
    }

    public function getTemplate() {
        $this->template = 'employer-maps.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Employer Location',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;

    }
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Careerup_Widget_Employer_Maps');
}