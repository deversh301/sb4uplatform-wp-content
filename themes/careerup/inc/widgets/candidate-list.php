<?php

class Careerup_Widget_Candidate_List extends Apus_Widget {
    public function __construct() {
        parent::__construct(
            'apus_widget_candidate_list',
            esc_html__('Apus Simple Candidates List', 'careerup'),
            array( 'description' => esc_html__( 'Show list of candidate', 'careerup' ), )
        );
        $this->widgetName = 'candidate_list';
    }

    public function getTemplate() {
        $this->template = 'candidate-list.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Latest Candidate',
            'number_post' => '4',
            'orderby' => '',
            'order' => '',
            'get_candidates_by' => 'recent',
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        $orderbys = array(
            '' => esc_html__('Default', 'careerup'),
            'date' => esc_html__('Date', 'careerup'),
            'ID' => esc_html__('ID', 'careerup'),
            'author' => esc_html__('Author', 'careerup'),
            'title' => esc_html__('Title', 'careerup'),
            'modified' => esc_html__('Modified', 'careerup'),
            'rand' => esc_html__('Random', 'careerup'),
            'comment_count' => esc_html__('Comment count', 'careerup'),
            'menu_order' => esc_html__('Menu order', 'careerup'),
        );
        $orders = array(
            '' => esc_html__('Default', 'careerup'),
            'ASC' => esc_html__('Ascending', 'careerup'),
            'DESC' => esc_html__('Descending', 'careerup'),
        );
        $get_candidates_bys = array(
            'featured' => esc_html__('Featured Candidates', 'careerup'),
            'urgent' => esc_html__('Urgent Candidates', 'careerup'),
            'recent' => esc_html__('Recent Candidates', 'careerup'),
        );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('orderby')); ?>">
                <?php echo esc_html__('Order By:', 'careerup' ); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('orderby')); ?>" name="<?php echo esc_attr($this->get_field_name('orderby')); ?>">
                <?php foreach ($orderbys as $key => $title) { ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected($instance['orderby'], $key); ?> ><?php echo esc_html( $title ); ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('order')); ?>">
                <?php echo esc_html__('Order:', 'careerup' ); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('order')); ?>" name="<?php echo esc_attr($this->get_field_name('order')); ?>">
                <?php foreach ($orders as $key => $title) { ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected($instance['order'], $key); ?> ><?php echo esc_html( $title ); ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('get_candidates_by')); ?>">
                <?php echo esc_html__('Get candidates by:', 'careerup' ); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('get_candidates_by')); ?>" name="<?php echo esc_attr($this->get_field_name('get_candidates_by')); ?>">
                <?php foreach ($get_candidates_bys as $key => $title) { ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected($instance['get_candidates_by'], $key); ?> ><?php echo esc_html( $title ); ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number_post' )); ?>"><?php esc_html_e( 'Num Posts:', 'careerup' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number_post' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number_post' )); ?>" type="text" value="<?php echo esc_attr($instance['number_post']); ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_post'] = ( ! empty( $new_instance['number_post'] ) ) ? strip_tags( $new_instance['number_post'] ) : '';
        $instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
        $instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
        $instance['get_candidates_by'] = ( ! empty( $new_instance['get_candidates_by'] ) ) ? strip_tags( $new_instance['get_candidates_by'] ) : '';
        return $instance;

    }
}
if ( function_exists('apus_framework_reg_widget') ) {
    apus_framework_reg_widget('Careerup_Widget_Candidate_List');
}