<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

ob_start();
if ( !empty($options) ) {
    $i = 1;
    foreach ($options as $option) {
        ?>
        <li class="list-item <?php echo esc_attr($i > 6 ? 'more-fields' : ''); ?>"><input id="<?php echo esc_attr($name.'-'.sanitize_title($option['text'])); ?>" type="radio" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($option['value']); ?>"  <?php checked($selected, $option['value']); ?>><label for="<?php echo esc_attr($name.'-'.sanitize_title($option['text'])); ?>"><?php echo wp_kses_post($option['text']); ?></label>

            <?php if ( isset($option['count']) ) { ?>
                <span class="count"><?php echo sprintf(__('(%d)', 'wp-job-board'), $option['count']); ?></span>
            <?php } ?>
        </li>
        <?php
        $i++;
    }
}
$output = ob_get_clean();

if ( !empty($output) ) {
?>
    <div class="form-group form-group-<?php echo esc_attr($key); ?> <?php echo esc_attr(!empty($field['toggle']) ? 'toggle-field' : ''); ?> <?php echo esc_attr(!empty($field['hide_field_content']) ? 'hide-content' : ''); ?>">
        <?php if ( !isset($field['show_title']) || $field['show_title'] ) { ?>
            <label for="<?php echo esc_attr( $args['widget_id'] ); ?>_<?php echo esc_attr($key); ?>" class="heading-label">
                <?php echo wp_kses_post($field['label']); ?>
                <?php if ( !empty($field['toggle']) ) { ?>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                <?php } ?>
            </label>

        <?php } ?>
        <div class="form-group-inner">
            <ul class="terms-list circle-check">
                <?php echo $output; ?>
            </ul>
            <?php if ( $i > 7 ) { ?>
                <a class="toggle-filter-list" href="javascript:void(0);"><span class="text"><?php esc_html_e('Show More +', 'wp-job-board'); ?></span></a>
            <?php } ?>
        </div>
    </div><!-- /.form-group -->
<?php }