<?php

class Careerup_Widget_Job_Statistics extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_job_statistics',
            esc_html__('Job Detail:: Statistics', 'careerup'),
            array( 'description' => esc_html__( 'Show job statistics', 'careerup' ), )
        );
        $this->widgetName = 'job_statistics';
    }

    public function getTemplate() {
        $this->template = 'job-statistics.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'show_post_date' => 1,
            'show_views' => 1,
            'show_applicants' => 1,
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_post_date'], 1 ); ?> id="<?php echo esc_attr( 'show_post_date' ); ?>" name="<?php echo esc_attr($this->get_field_name('show_post_date')); ?>" value="1" />
            <label for="<?php echo esc_attr($this->get_field_name('show_post_date') ); ?>">
                <?php esc_html_e('Show post date', 'careerup'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_views'], 1 ); ?> id="<?php echo esc_attr( 'show_views' ); ?>" name="<?php echo esc_attr($this->get_field_name('show_views')); ?>" value="1" />
            <label for="<?php echo esc_attr($this->get_field_name('show_views') ); ?>">
                <?php esc_html_e('Show Views', 'careerup'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_applicants'], 1 ); ?> id="<?php echo esc_attr( 'show_applicants' ); ?>" name="<?php echo esc_attr($this->get_field_name('show_applicants')); ?>" value="1" />
            <label for="<?php echo esc_attr($this->get_field_name('show_applicants') ); ?>">
                <?php esc_html_e('Show Applicants', 'careerup'); ?>
            </label>
        </p>

<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';
        $instance['show_post_date'] = ( ! empty( $new_instance['show_post_date'] ) ) ? $new_instance['show_post_date'] : '';
        $instance['show_views'] = ( ! empty( $new_instance['show_views'] ) ) ? $new_instance['show_views'] : '';
        $instance['show_applicants'] = ( ! empty( $new_instance['show_applicants'] ) ) ? $new_instance['show_applicants'] : '';

        return $instance;
    }
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Careerup_Widget_Job_Statistics');
}