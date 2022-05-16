<?php
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'main', get_template_directory_uri() . '/static/css/main.min.css', array(), 1.0, 'all' );
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/static/js/main.min.js', array( 'jquery' ), 1.0, true );
	}
);
