<?php
wp_enqueue_style( 'content-with-image' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'content-with-image' . '/' . 'content-with-image' . '.css', '', '', 'all' );
$section = array(
	'image_group'    => get_sub_field( 'image' ),
	'content_group'  => get_sub_field( 'content' ),

	'container'      => get_sub_field( 'container' ),
	'image_position' => get_sub_field( 'image_position' ),
	'content_width'  => get_sub_field( 'content_width' ),
);
if ( 'custom' === $section['image_group']['size'] ) {
	if ( ! empty( $section['image_group']['width'] ) && ! empty( $section['image_group']['height'] ) ) {
		$section['image_group']['size'] = array( $section['image_group']['width'], $section['image_group']['height'] );
	} else {
		$section['image_group']['size'] = 'full';
	}
}
$container_class    = ( ! empty( $section['container'] ) && 'large' !== $section['container'] ) ? 'container-' . $section['container'] : '';
$row_class          = ( ! empty( $section['image_position'] ) ) ? 'image-position-' . $section['image_position'] : '';
$content_col_class  = ( ! empty( $section['content_width'] ) ) ? 'col-md-' . $section['content_width'] : '';
$content_col_class .= ( ! empty( $section['image_group']['title'] ) ) ? ' image-title-exist' : '';
?>
<div class="container <?php echo $container_class; ?>">
	<div class="row justify-content-between <?php echo $row_class; ?>">
		<div class="col image-col">
			<?php
			if ( ! empty( $section['image_group']['title'] ) ) {
				?>
				<h3 class="section-title">
					<?php echo $section['image_group']['title']; ?>
				</h3>
				<?php
			}
			echo ( ! empty( $section['image_group']['image_id'] ) ) ? wp_get_attachment_image( $section['image_group']['image_id'], $section['image_group']['size'] ) : ''
			?>
		</div>
		<div class="col content-col <?php echo $content_col_class; ?>">
				<?php
				echo ( ! empty( $section['content_group']['content'] ) ) ? $section['content_group']['content'] : '';
				if ( isset( $section['content_group']['link'] ) ) {
					if ( ! empty( $section['content_group']['link']['url'] ) && ! empty( $section['content_group']['link']['title'] ) ) {
						?>
						<a class="button button-secondary" href="<?php echo $section['content_group']['link']['url']; ?>" <?php echo ! empty( $section['content_group']['link']['target'] ) ? 'target="' . $section['content_group']['link']['target'] . '"' : ''; ?>>
							<?php echo $section['content_group']['link']['title']; ?>
						</a>
						<?php
					}
				}
				?>
		</div>
	</div>
</div>
