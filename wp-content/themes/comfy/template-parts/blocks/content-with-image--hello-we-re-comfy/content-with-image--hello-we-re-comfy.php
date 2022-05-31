<?php
$image_col = get_sub_field( 'image' );
$settings  = array(
	'container'   => 'sm',
	'image_group' => array(
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_1',
	),
);
get_template_part( 'template-parts/blocks/content-with-image-advanced/content-with-image-advanced', '', $settings );
