<?php
wp_enqueue_style( 'content-with-image--not-sure-where-to-start' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'content-with-image--not-sure-where-to-start' . '/' . 'content-with-image--not-sure-where-to-start' . '.css', '', '', 'all' );

$image_col   = get_sub_field( 'image' );
$content_col = get_sub_field( 'content' );
$settings    = array(
	'content_width' => '35', // %
	'image_group'   => array(
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_2',
	),
);
if ( ! empty( $content_col['icon_id'] ) && ! empty( $content_col['content'] ) ) {
	ob_start();
	?>
	<div class="content-icon">
		<?php echo wp_get_attachment_image( $content_col['icon_id'], 'cmf_content_with_image_2_icon' ); ?>
	</div>
	<?php
	echo $content_col['content'];
	$settings['content_group']['content'] = ob_get_clean();
}
$settings['content_group']['link'] = $content_col['link'];

get_template_part( 'template-parts/blocks/content-with-image-advanced/content-with-image-advanced', '', $settings );
