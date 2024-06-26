<?php
$section = array(
	'title'     => ( ! empty( $args['title'] ) ) ? $args['title'] : get_sub_field( 'title' ),
	'content'   => ( ! empty( $args['content'] ) ) ? $args['content'] : get_sub_field( 'content' ),
	'link'      => ( ! empty( $args['link'] ) ) ? $args['link'] : get_sub_field( 'link' ),
	'image_id'  => ( ! empty( $args['image_id'] ) ) ? $args['image_id'] : get_sub_field( 'image_id' ),
	'container' => ( ! empty( $args['container'] ) ) ? $args['container'] : get_sub_field( 'container' ),
	'layout'    => ( ! empty( $args['layout'] ) ) ? $args['layout'] : get_sub_field( 'layout' ),
);

if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );

	if ( ! empty( $section['layout'] ) && 'full-width' === $section['layout'] ) {
		add_filter(
			$args['section_name'] . '_classes',
			function ( $classes ) {
				return  $classes . ' ' . 'full-width-content';
			}
		);
	}
}
?>
<div class="container container-<?php echo ! empty( $section['container'] ) ? $section['container'] : 'sm'; ?>">
	<div class="row justify-content-between">
		<div class="col">
			<?php
			if ( ! empty( $section['title'] ) ) {
				?>
				<h1 class="section-title">
					<?php echo $section['title']; ?>
				</h1>
				<?php
			}
			?>
		</div>
		<?php
		if ( ! empty( $section['content'] ) || ! empty( $section['link']['url'] ) ) {
			?>
			<div class="col">
				<div class="section-content">
					<?php
					echo ( ! empty( $section['content'] ) ) ? $section['content'] : '';
					if ( isset( $section['link'] ) ) {
						if ( isset( $section['link']['url'] ) && isset( $section['link']['title'] ) ) {
							?>
							<a class="button button-secondary" href="<?php echo $section['link']['url']; ?>" <?php echo ! empty( $section['link']['target'] ) ? 'target="' . $section['link']['target'] . '"' : ''; ?>>
								<?php echo $section['link']['title']; ?>
							</a>
							<?php
						}
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
<?php
if ( ! empty( $section['image_id'] ) ) {
	?>
	<div class="container container-lg">
		<div class="row">
			<?php echo wp_get_attachment_image( $section['image_id'], 'cmf_fullwidth', false, array( 'loading' => 'eager' ) ); ?>
		</div>
	</div>
	<?php
}
?>
