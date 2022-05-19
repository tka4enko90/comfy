<?php
add_action(
	'widgets_init',
	function() {
		register_sidebar(
			array(
				'name'         => 'Footer area',
				'id'           => 'footer_area',
				'description'  => 'Footer navigation area',
				'before_title' => '<h6 class="widget-title">',
				'after_title'  => '</h6>',
			)
		);
	}
);
