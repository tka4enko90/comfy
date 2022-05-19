<?php

add_filter(
	'acf-flexible-content-preview.images_path',
	function ( $path ) {
		return 'acf-previews/sections';
	}
);


// Add fancybox to admin for ACF priviews pop-up
add_action(
	'admin_enqueue_scripts',
	function () {
		wp_enqueue_style( 'ia/fancybox.css', get_template_directory_uri() . '/additional-assets/jquery.fancybox.min.css', false, null );
		wp_enqueue_style( 'ia/acf-styles.css', get_template_directory_uri() . '/additional-assets/acf-styles.css', false, null );
		wp_enqueue_script( 'ia/fancybox.js', get_template_directory_uri() . '/additional-assets/jquery.fancybox.min.js', array( 'jquery' ), null, true );
	},
	100
);



//ACF flexible content KEY -> folder
$acf_keys = array(
	'field_62861917588bf' => 'sections/',
);

/**
 * This functions show section thumbnail for flexible-content on admin.
 */

function acf_flexible_content_layout_title( $title, $field, $layout, $i ) {

	global $acf_keys;

	$key         = $field['key'];
	$title_text  = $title;
	$layout_name = $layout['name'];

	if ( array_key_exists( $key, $acf_keys ) ) {
		$folder = $acf_keys[ $key ];
	} else {
		$folder = '';
	}

	//URL for images
	$preview_url_small = get_template_directory_uri() . '/acf-previews/' . $folder . $layout_name . '-small.png';
	$preview_url_large = get_template_directory_uri() . '/acf-previews/' . $folder . $layout_name . '-large.png';

	$title = '<div class="acf-fl-thumb"><a href="' . $preview_url_large . '" data-fancybox><img src="' . $preview_url_small . '" alt=""></a></div> <div class="acf-fl-title">' . $title_text . '</div>';

	return $title;

}

foreach ( $acf_keys as $key => $value ) {
	add_filter( 'acf/fields/flexible_content/layout_title/key=' . $key . '', 'acf_flexible_content_layout_title', 10, 4 );
}
