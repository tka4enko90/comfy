<?php
// add post thumbnails support
add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'post-thumbnails' );
	}
);

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'cmf_fullwidth', 1360, 640, true );
	add_image_size( 'cmf_post_single', 1360, 598, true );
	add_image_size( 'cmf_post_big', 1186, 480, true );
	add_image_size( 'cmf_header_nav_image', 403, 256, true );
	add_image_size( 'cmf_post_preview', 403, 403, true );
	add_image_size( 'cmf_product_preview', 352, 352, true );
	add_image_size( 'cmf_reasons', 316, 316, true );
	add_image_size( 'cmf_product_preview_small', 142, 142, true );
	add_image_size( 'cmf_product_single', 609 );
	add_image_size( 'cmf_product_single_zoomed', 1318 );

	add_image_size( 'cmf_bundle_breakdown', 96, 96, true );
	add_image_size( 'cmf_search_result', 54, 54 );
	add_image_size( 'cmf_content_with_image_2_icon', 64, 64 );
	add_image_size( 'cmf_logo', 91, 32 );
	add_image_size( 'cmf_footer_partner', 33, 20 );
	add_image_size( 'cmf_social_icon', 16, 16 );
	add_image_size( 'cmf_sign', 226, 83 );

	add_image_size( 'cmf_collection', 490, 482, true );
	add_image_size( 'cmf_content_with_image_3', 490, 640, true );
	add_image_size( 'cmf_content_with_image_1', 490, 577, true );
	add_image_size( 'cmf_content_with_image_2', 664, 577, true );
	add_image_size( 'cmf_coming_soon', 664, 820, true );
	add_image_size( 'cmf_review_slider', 577, 577, true );

	add_image_size( 'cmf_benefits_section', 402, 525, true );
	add_image_size( 'cmf_contact_form', 577, 840, true );

}
