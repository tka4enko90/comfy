<?php
wp_enqueue_style( 'content-with-image' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'content-with-image-advanced' . '/' . 'content-with-image-advanced' . '.css', '', '', 'all' );
$section = array(
	'image_group'           => isset( $args['image_group'] ) ? $args['image_group'] : get_sub_field( 'image' ),
	'content_group'         => isset( $args['content_group'] ) ? $args['content_group'] : get_sub_field( 'content' ),

	'container'             => isset( $args['container'] ) ? $args['container'] : get_sub_field( 'container' ),
	'image_position'        => isset( $args['image_position'] ) ? $args['image_position'] : get_sub_field( 'image_position' ),
	'content_width'         => isset( $args['content_width'] ) ? $args['content_width'] : get_sub_field( 'content_width' ),
	'content_padding_left'  => isset( $args['content_padding_left'] ) ? $args['content_padding_left'] : get_sub_field( 'desktop_content_padding_left' ),
	'content_padding_right' => isset( $args['content_padding_right'] ) ? $args['content_padding_right'] : get_sub_field( 'desktop_content_padding_right' ),
);
// Image size
if ( 'custom' === $section['image_group']['size'] ) {
	if ( ! empty( $section['image_group']['width'] ) && ! empty( $section['image_group']['height'] ) ) {
		$section['image_group']['size'] = array( $section['image_group']['width'], $section['image_group']['height'] );
	} else {
		$section['image_group']['size'] = 'full';
	}
}

$container_class = ( ! empty( $section['container'] ) && 'md' !== $section['container'] ) ? ' container-' . $section['container'] : '';
if ( ! empty( $args['section_name'] ) && ! empty( $section['image_position'] ) && 'right' === $section['image_position'] ) {
	add_filter(
		$args['section_name'] . '_classes',
		function ( $classes ) {
			return  $classes . ' ' . 'image-position-right';
		}
	);
}
?>
<div class="container<?php echo $container_class; ?>">
	<div class="row">
		<div class="col">
			<?php
			if ( ! empty( $section['image_group']['title'] ) ) {
				add_filter(
					$args['section_name'] . '_classes',
					function ( $classes ) {
						return  $classes . ' ' . 'image-title-exist';
					}
				);
				?>
				<h3 class="section-title">
					<?php echo $section['image_group']['title']; ?>
				</h3>
				<?php
			}
			echo ( ! empty( $section['image_group']['image_id'] ) ) ? wp_get_attachment_image( $section['image_group']['image_id'], $section['image_group']['size'] ) : ''
			?>
		</div>
		<?php
		if ( ! empty( $section['content_group']['content'] ) || ! empty( $section['content_group']['link'] ) ) {
			?>
			<div class="col">
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
			<?php
		}
		?>
	</div>
</div>
