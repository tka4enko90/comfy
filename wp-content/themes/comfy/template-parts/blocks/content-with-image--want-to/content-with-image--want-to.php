<?php
$section = array(
	'image_position' => get_sub_field( 'image_position' ),
	'image_id'       => get_sub_field( 'image_id' ),
	'content'        => get_sub_field( 'content' ),
);

wp_enqueue_style( 'content-with-image' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'content-with-image-advanced' . '/' . 'content-with-image-advanced' . '.css', '', '', 'all' );
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
	if ( ! empty( $section['image_position'] ) && 'right' === $section['image_position'] ) {
		add_filter(
			$args['section_name'] . '_classes',
			function ( $classes ) {
				return  $classes . ' ' . 'image-position-right';
			}
		);
	}
}
?>
	<div class="container">
		<div class="row">
			<div class="col">
				<?php
				if ( ! empty( $section['content']['title'] ) ) {
					?>
					<h2 class="mobile-title">
						<?php echo $section['content']['title']; ?>
					</h2>
					<?php
				}
				echo ( ! empty( $section['image_id'] ) ) ? wp_get_attachment_image( $section['image_id'], 'cmf_content_with_image_2' ) : '';
				?>
			</div>
			<div class="col">
				<?php
				if ( ! empty( $section['content']['title'] ) ) {
					?>
					<h2 class="title">
						<?php echo $section['content']['title']; ?>
					</h2>
					<?php
				}

				echo ( ! empty( $section['content']['text'] ) ) ? $section['content']['text'] : '';

				if ( isset( $section['content']['link'] ) ) {
					if ( ! empty( $section['content']['link']['url'] ) && ! empty( $section['content']['link']['title'] ) ) {
						$href   = $section['content']['link']['url'];
						$label  = $section['content']['link']['title'];
						$target = ! empty( $section['content']['link']['target'] ) ? 'target="' . $section['content']['link']['target'] . '"' : '';
						?>
						<a class="button button-secondary" href="<?php echo $href; ?>" <?php echo $target; ?>>
							<?php echo $label; ?>
						</a>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>
<?php
