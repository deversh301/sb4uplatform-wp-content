<?php

class Careerup_Widget_Candidate_Social_Profile extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_candidate_social_profile',
            esc_html__('Candidate Detail:: Social Profile', 'careerup'),
            array( 'description' => esc_html__( 'Show candidate social profile', 'careerup' ), )
        );
        $this->widgetName = 'candidate_social_profile';
    }

    public function getTemplate() {
        $this->template = 'candidate-social-profile.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
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
    apus_framework_reg_widget('Careerup_Widget_Candidate_Social_Profile');
}