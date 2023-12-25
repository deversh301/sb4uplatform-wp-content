<?php

class Careerup_Widget_Job_Simple_Search extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_job_simple_search',
            esc_html__('Job Simple Search', 'careerup'),
            array( 'description' => esc_html__( 'Show job simple search form', 'careerup' ), )
        );
        $this->widgetName = 'job_simple_search';
    }

    public function scripts() {
        wp_enqueue_media();
        wp_enqueue_script( 'careerup-upload-image', get_template_directory_uri().'/js/upload.js', array( 'jquery', 'wp-pointer' ), '1.0', true );
    }

    public function getTemplate() {
        $this->template = 'job-simple-search.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'show_keyword_field' => '',
            'show_location_field' => '',
            'show_type_field' => '',
            'show_category_field' => '',
            'keywords' => '',
            'single_image' => '',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_keyword_field'], 1 ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_keyword_field' )); ?>" name="<?php echo esc_attr($this->get_field_name('show_keyword_field')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_keyword_field' )); ?>">
                <?php esc_html_e('Show keyword field', 'careerup'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_location_field'], 1 ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_location_field' )); ?>" name="<?php echo esc_attr($this->get_field_name('show_location_field')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_location_field' )); ?>">
                <?php esc_html_e('Show location field', 'careerup'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_type_field'], 1 ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_type_field' )); ?>" name="<?php echo esc_attr($this->get_field_name('show_type_field')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_type_field' )); ?>">
                <?php esc_html_e('Show type field', 'careerup'); ?>
            </label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_category_field'], 1 ); ?> id="<?php echo esc_attr($this->get_field_id( 'show_category_field' )); ?>" name="<?php echo esc_attr($this->get_field_name('show_category_field')); ?>" value="1"/>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_category_field' )); ?>">
                <?php esc_html_e('Show category field', 'careerup'); ?>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'keywords' )); ?>">
                <?php esc_html_e('Trending Keywords', 'careerup'); ?>
            </label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id( 'keywords' )); ?>" name="<?php echo esc_attr($this->get_field_name('keywords')); ?>"><?php echo esc_attr( $instance['keywords'] ); ?></textarea>
            
        </p>

        <label for="<?php echo esc_attr($this->get_field_id( 'single_image' )); ?>"><?php esc_html_e( 'Background Image:', 'careerup' ); ?></label>
        <div class="screenshot">
            <?php if ( $instance['single_image'] ) { ?>
                <img src="<?php echo esc_url($instance['single_image']); ?>" alt="<?php esc_attr_e('Image', 'careerup'); ?>"/>
            <?php } ?>
        </div>
        <input class="widefat upload_image" id="<?php echo esc_attr($this->get_field_id( 'single_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'single_image' )); ?>" type="hidden" value="<?php echo esc_attr($instance['single_image']); ?>" />
        <div class="upload_image_action">
            <input type="button" class="button add-image" value="Add">
            <input type="button" class="button remove-image" value="Remove">
        </div>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';
        $instance['show_keyword_field'] = ( ! empty( $new_instance['show_keyword_field'] ) ) ? $new_instance['show_keyword_field'] : '';
        $instance['show_location_field'] = ( ! empty( $new_instance['show_location_field'] ) ) ? $new_instance['show_location_field'] : '';
        $instance['show_type_field'] = ( ! empty( $new_instance['show_type_field'] ) ) ? $new_instance['show_type_field'] : '';
        $instance['show_category_field'] = ( ! empty( $new_instance['show_category_field'] ) ) ? $new_instance['show_category_field'] : '';
        $instance['keywords'] = ( ! empty( $new_instance['keywords'] ) ) ? $new_instance['keywords'] : '';
        $instance['single_image'] = ( ! empty( $new_instance['single_image'] ) ) ? $new_instance['single_image'] : '';

        return $instance;
    }
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Careerup_Widget_Job_Simple_Search');
}