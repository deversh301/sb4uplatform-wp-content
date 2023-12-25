<?php

class Careerup_Widget_Job_Also_Viewed extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_job_also_viewed',
            esc_html__('Job Detail:: People also viewed', 'careerup'),
            array( 'description' => esc_html__( 'Show job people also viewed', 'careerup' ), )
        );
        $this->widgetName = 'job_also_viewed';
    }

    public function getTemplate() {
        $this->template = 'job-also-viewed.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'People Also Viewed',
            'limit' => 4,
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'limit' )); ?>"><?php esc_html_e( 'Limit:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'limit' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'limit' )); ?>" type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Careerup_Widget_Job_Also_Viewed');
}