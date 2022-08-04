<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );

}

$image_col   = get_sub_field( 'image' );
$content_col = get_sub_field( 'content' );
$settings    = array(
	'image_group'  => array(
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_2',
	),
	'section_name' => $args['section_name'],
);

ob_start();

if ( ! empty( $content_col['icon_id'] ) ) {
	?>
	<div class="content-icon">
		<?php echo wp_get_attachment_image( $content_col['icon_id'], 'cmf_content_with_image_2_icon' ); ?>
	</div>
	<?php
}
echo ( ! empty( $content_col['content'] ) ) ? $content_col['content'] : '';

$settings['content_group']['content'] = ob_get_clean();
$settings['content_group']['link']    = $content_col['link'];

get_template_part( 'template-parts/blocks/content-with-image-advanced/content-with-image-advanced', '', $settings );
