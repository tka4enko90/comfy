<?php
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );// Disable Gutenberg editor.


add_action(
	'init',
	function () {
		if ( 'page.php' === basename( get_page_template() ) ) {
			// Disable WordPress editor for default page template
			remove_post_type_support( 'page', 'editor' );

			// tiny_mce custom formats
			add_filter(
				'mce_buttons_2',
				function ( $buttons ) {
					array_unshift( $buttons, 'styleselect' );
					return $buttons;
				}
			);

			/*
			* Callback function to filter the MCE settings
			*/
			add_filter(
				'tiny_mce_before_init',
				function ( $init_array ) {

					// Define the style_formats array
					$style_formats = array(
						array(
							'title'   => 'Row of images (only for content section)',
							'block'   => 'div',
							'classes' => 'images-row',
							'wrapper' => true,
						),
					);
					// Insert the array, JSON ENCODED, into 'style_formats'
					$init_array['style_formats'] = json_encode( $style_formats );

					return $init_array;

				}
			);
		}
	}
);

