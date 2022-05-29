<?php
$image_col = get_sub_field( 'image' );
$settings  = array(
	// 'container'      => 'small',
	//'image_position' => get_sub_field( 'image_position' ),
	'content_width'  => '43', // %
	'image_group'    => array(
		'title'    => $image_col['title'],
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_3',
		//'width'    => '', // if 'size' === custom
		//'height'   => '', // if 'size' === custom
	),
	/*
	'content_group'  => array(
		'content' => '', //html string
		'link'    => array(
			'title'  => '',
			'url'    => '',
			'target' => '',
		),
	),*/
);
//$settings[ 'content_padding_' . $settings['image_position'] ] = '15'; // px
get_template_part( 'template-parts/blocks/content-with-image/content-with-image', '', $settings );
