<?php
wp_enqueue_style( 'content-with-image-2' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'content-with-image-2' . '/' . 'content-with-image-2' . '.css', '', '', 'all' );

$image_col   = get_sub_field( 'image' );
$content_col = get_sub_field( 'content' );
$settings    = array(
	//'container'      => 'small',
	'image_position' => get_sub_field( 'image_position' ),
	'content_width'  => '35', // %
	'image_group'    => array(
		//'title'    => '', // Title above image
		'image_id' => $image_col['image_id'],
		'size'     => 'cmf_content_with_image_2',
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
$settings[ 'content_padding_' . $settings['image_position'] ] = '15'; // px
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

get_template_part( 'template-parts/blocks/content-with-image/content-with-image', '', $settings );
