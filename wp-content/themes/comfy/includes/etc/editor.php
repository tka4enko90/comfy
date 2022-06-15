<?php
add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );// Disable Gutenberg editor.

// Disable WordPress editor for default page template
add_action(
	'init',
	function () {
		if ( 'page.php' === basename( get_page_template() ) ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}
);
