<?php

class Careerup_Widget_Job_Employer_Info extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_job_employer_info',
            esc_html__('Job Detail:: Employer Information', 'careerup'),
            array( 'description' => esc_html__( 'Show job employer information', 'careerup' ), )
        );
        $this->widgetName = 'job_employer_info';
    }

    public function getTemplate() {
        $this->template = 'job-employer-info.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'layout_type' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('layout_type')); ?>">
                <?php echo esc_html__('Layout Type:', 'careerup' ); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('layout_type')); ?>" name="<?php echo esc_attr($this->get_field_name('layout_type')); ?>">
                <option value="" <?php selected($instance['layout_type'], ''); ?> ><?php echo esc_html__( 'Default', 'careerup' ); ?></option>
                <option value="layout1" <?php selected($instance['layout_type'], 'layout1'); ?> ><?php echo esc_html__( 'Layout 1', 'careerup' ); ?></option>
            </select>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;

    }
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Careerup_Widget_Job_Employer_Info');
}