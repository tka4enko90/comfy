<?php
$image_col = get_sub_field( 'image' );
$settings  = array(
	'image_group' => array(
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_3',
	),
);
get_template_part( 'template-parts/blocks/content-with-image-advanced/content-with-image-advanced', '', $settings );
