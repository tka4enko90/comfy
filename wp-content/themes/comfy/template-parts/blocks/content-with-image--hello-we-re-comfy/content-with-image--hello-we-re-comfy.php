<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}

$image_col = get_sub_field( 'image' );
$settings  = array(
	'container'    => 'sm',
	'image_group'  => array(
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_1',
	),
	'section_name' => $args['section_name'],
);
get_template_part( 'template-parts/blocks/content-with-image-advanced/content-with-image-advanced', '', $settings );
