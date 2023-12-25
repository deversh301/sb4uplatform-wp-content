<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

$fields = array(
    'title' => array(
        'label' => esc_html__( 'Candidate Title or Keywords', 'careerup' ),
        'show_title' => false,
        'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input'),
        'placeholder' => esc_html__( 'Candidate Title or Keywords', 'careerup' ),
        'icon' => 'flaticon-search'
    ),
    'category' => array(
        'label' => esc_html__( 'Category', 'careerup' ),
        'show_title' => false,
        'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_taxonomy_select'),
        'taxonomy' => 'candidate_category',
        'placeholder' => esc_html__( 'All Categories', 'careerup' ),
    ),
    'center-location' => array(
        'label' => esc_html__( 'Location', 'careerup' ),
        'show_title' => false,
        'field_call_back' => array( 'WP_Job_Board_Mixes', 'filter_field_input_location'),
        'placeholder' => esc_html__( 'Location', 'careerup' ),
        'icon' => 'flaticon-location-pin',
        'show_distance' => true,
    )
);
$widget_id = careerup_random_key();

$search_page_url = WP_Job_Board_Mixes::get_candidates_page_url();

careerup_load_select2();

$style = '';
if ( $single_image ) {
    $style = 'style="background:url('.esc_url($single_image).')"';
}
?>
<div class="widget-job-search-form" <?php echo trim($style); ?>>
    <div class="container">
        <?php if ( !empty($title) ) { ?>
            <h1 class="title">
                <?php echo wp_kses_post($title); ?>
            </h1>
        <?php } ?>
        <form action="<?php echo esc_url($search_page_url); ?>" class="form-search layout1" method="GET">
            <div class="flex-middle-sm search-form-inner">
                <?php
                    $instance = array();
                    $args = array( 'widget_id' => $widget_id );
                    if ( $show_keyword_field ) {
                        $key = 'title';
                        $field = $fields['title'];
                        if ( !empty($field['field_call_back']) ) {
                            call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                        }
                    }
                    if ( $show_location_field ) {
                        $key = 'center-location';
                        $field = $fields['center-location'];
                        if ( !empty($field['field_call_back']) ) {
                            call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                        }
                    }
                    if ( $show_category_field ) {
                        $key = 'category';
                        $field = $fields['category'];
                        if ( !empty($field['field_call_back']) ) {
                            call_user_func( $field['field_call_back'], $instance, $args, $key, $field );
                        }
                    }
                ?>
                <div class="form-group form-group-search">
                    <button class="btn-submit btn btn-block btn-theme" type="submit"><?php echo esc_html__('Search','careerup') ?></button>
                </div>
            </div>
            <?php
                $keywords = !empty($keywords) ? array_map('trim', explode(',', $keywords)) : array();
                if ( !empty($keywords) ) {
            ?>
                <div class="content-trending">
                    <ul class="trending-keywords">
                        <li class="title"><?php esc_html_e('Trending Keywords:', 'careerup'); ?></li>
                        <?php foreach ($keywords as $keyword) {
                            $link = add_query_arg( 'filter_title', $keyword, remove_query_arg( 'filter_title', $search_page_url ) );
                        ?>
                            <li class="item"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($keyword); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </form>
    </div>
</div>