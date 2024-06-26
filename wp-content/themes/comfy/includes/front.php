<?php
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' ); // WordPress core

		wp_enqueue_style( 'main', get_template_directory_uri() . '/dist/css/main.css', array(), 1.0, 'all' );
		wp_enqueue_style( 'product-preview', get_template_directory_uri() . '/dist/css/partials/product-preview.css', '', '', 'all' );

		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/dist/js/main.js', array( 'jquery' ), 1.0, true );
		wp_enqueue_script( 'qty-buttons', get_template_directory_uri() . '/dist/js/partials/qty-buttons.js', array( 'jquery' ), '', true );

		if ( is_cart() ) {
			wp_enqueue_style( 'cmf-cart', get_template_directory_uri() . '/dist/css/pages/cart.css', '', '', 'all' );
		}

		if ( is_account_page() ) {
			wp_enqueue_style( 'cmf-account', get_template_directory_uri() . '/dist/css/pages/my-account.css', '', '', 'all' );
		}
		if ( is_checkout() ) {
			wp_enqueue_style( 'cmf-checkout', get_template_directory_uri() . '/dist/css/pages/checkout.css', '', '', 'all' );
		}
	},
	1
);

add_action(
	'wp_enqueue_scripts',
	function () {
		if ( is_archive() ) {
			wp_dequeue_style( 'woocommerce-general' );
		}

		if ( ! is_account_page() && ! is_cart() && is_page() ) {
			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'wc-gc-css' );
			wp_dequeue_style( 'wc-pb-checkout-blocks' );
			wp_dequeue_style( 'metorik-css' );
			wp_dequeue_style( 'wc-bundle-style' );

			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'woo-variation-swatches' );
			wp_dequeue_script( 'wc_additional_variation_images_script' );
		}
	},
	101
);

//disable_woocommerce_block_editor_styles
add_action(
	'enqueue_block_assets',
	function () {
		wp_deregister_style( 'wc-blocks-vendors-style' );
		wp_deregister_style( 'wc-block-style' );
	},
	1,
	1
);

add_action(
	'cfw_wp_head',
	function() {
		wp_enqueue_style( 'cmf-checkout', get_template_directory_uri() . '/dist/css/pages/checkout.css', '', '', 'all' );

	}
);

add_action(
	'get_header',
	function ( $name ) {
		if ( 'shop' === $name ) {
			global $wp;
			if ( 'refund-request-form' === $wp->request ) {
				wp_enqueue_style( 'cmf-refund', get_template_directory_uri() . '/dist/css/pages/refund.css', '', '', 'all' );
			}
		}
	},
	2,
	1
);

add_action(
	'wp_head',
	function () {

		if ( is_front_page() ) {
			$custom_frontpage_header_scripts = get_field( 'front_page_custom_header_scripts', 'options' );
			echo ( ! empty( $custom_frontpage_header_scripts ) ) ? $custom_frontpage_header_scripts : '';
		}

		$custom_header_scripts = get_field( 'custom_header_scripts', 'options' );
		echo ( ! empty( $custom_header_scripts ) ) ? $custom_header_scripts : '';

	},
	0
);

add_action(
	'cfw_wp_head',
	function() {
		wp_enqueue_style( 'cmf-checkout', get_template_directory_uri() . '/dist/css/pages/checkout.css', '', '', 'all' );
	}
);


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );// REMOVE EMOJI ICONS Script
remove_action( 'wp_print_styles', 'print_emoji_styles' );     // REMOVE EMOJI ICONS Style
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
