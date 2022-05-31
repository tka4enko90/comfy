<?php
$image_col = get_sub_field( 'image' );
$settings  = array(
	'container'      => 'small',
	'image_position' => get_sub_field( 'image_position' ),
	'content_width'  => '42', // %
	'image_group'    => array(
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_1',
	),
);
$settings[ 'content_padding_' . $settings['image_position'] ] = '20'; // px
get_template_part( 'template-parts/blocks/content-with-image-advanced/content-with-image-advanced', '', $settings );
