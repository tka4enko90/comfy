<?php
add_action(
	'wp_enqueue_scripts',
	function () {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
        //wp_dequeue_style( 'wc-block-style' ); // WooCommerce

		wp_enqueue_style( 'main', get_template_directory_uri() . '/dist/css/main.css', array(), 1.0, 'all' );
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/dist/js/main.js', array( 'jquery' ), 1.0, true );
		wp_enqueue_style( 'product-preview', get_template_directory_uri() . '/dist/css/partials/product-preview.css', '', '', 'all' );
	}
);


remove_action('wp_head', 'print_emoji_detection_script', 7);// REMOVE EMOJI ICONS Script
remove_action('wp_print_styles', 'print_emoji_styles');     // REMOVE EMOJI ICONS Style
add_filter('use_block_editor_for_post_type', '__return_false', 10);// Disable Gutenberg editor.
