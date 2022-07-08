<?php
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' ); // WordPress core

		wp_enqueue_style( 'main', get_template_directory_uri() . '/dist/css/main.css', array(), 1.0, 'all' );
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/dist/js/main.js', array( 'jquery' ), 1.0, true );
		wp_enqueue_style( 'product-preview', get_template_directory_uri() . '/dist/css/partials/product-preview.css', '', '', 'all' );

		if ( is_checkout() ) {
			wp_enqueue_style( 'cmf-checkout', get_template_directory_uri() . '/dist/css/pages/checkout.css', '', '', 'all' );
		}
	}
);
add_action( 'cfw_wp_head', function() {
    wp_enqueue_style( 'cmf-checkout', get_template_directory_uri() . '/dist/css/pages/checkout.css', '', '', 'all' );

} );


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );// REMOVE EMOJI ICONS Script
remove_action( 'wp_print_styles', 'print_emoji_styles' );     // REMOVE EMOJI ICONS Style
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
