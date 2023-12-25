<?php

function careerup_child_enqueue_styles() {
	wp_enqueue_style( 'careerup-child-style', get_stylesheet_uri() );
}

add_action( 'wp_enqueue_scripts', 'careerup_child_enqueue_styles', 100 );