<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
	wp_enqueue_script( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.js', array( 'jquery' ), '', true );
}

$image_col   = get_sub_field( 'image' );
$content_col = get_sub_field( 'content' );
$settings    = array(
	'image_group'  => array(
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_review_slider',
	),
	'section_name' => $args['section_name'],
);
if ( ! empty( $content_col['content'] ) ) {
	ob_start();
	?>
	<?php
	echo ( ! empty( $content_col['content'] ) ) ? $content_col['content'] : '';
	if ( class_exists( 'AW_Referrals_Addon' ) ) {
		echo do_shortcode( '[automatewoo_referrals_page]' );
	}

	$settings['content_group']['content'] = ob_get_clean();
}

get_template_part( 'template-parts/blocks/content-with-image-advanced/content-with-image-advanced', '', $settings );
