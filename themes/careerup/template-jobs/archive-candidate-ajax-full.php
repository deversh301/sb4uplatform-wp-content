<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
	'candidates' => $candidates,
);
?>

<?php
	echo WP_Job_Board_Template_Loader::get_template_part('loop/candidate/archive-inner', $args);
?>

<?php echo WP_Job_Board_Template_Loader::get_template_part('loop/candidate/pagination', array('candidates' => $candidates) ); ?>


<?php

$sidebar_configs = careerup_get_candidates_layout_configs();
careerup_display_sidebar_left( $sidebar_configs );
careerup_display_sidebar_right( $sidebar_configs );

?>