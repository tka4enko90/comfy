<?php
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'main', get_template_directory_uri() . '/dist/css/main.css', array(), 1.0, 'all' );
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/dist/js/main.js', array( 'jquery' ), 1.0, true );
	}
);
