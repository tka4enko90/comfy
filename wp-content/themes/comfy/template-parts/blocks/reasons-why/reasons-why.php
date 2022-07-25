<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'description' => get_sub_field( 'description' ),
	'items'       => get_sub_field( 'reasons' ),
);
?>
<div class="container container-xs">
<?php
if ( ! empty( $section['description'] ) ) {
	?>
	<p class="reasons-why-section-description">
		<?php echo $section['description']; ?>
	</p>
	<?php
}
if ( ! empty( $section['items'] ) ) {
	foreach ( $section['items'] as $item ) {
		?>
		<div class="reasons-why-item">
			<?php
			echo ( ! empty( $item['image_id'] ) ) ? wp_get_attachment_image( $item['image_id'], 'cmf_reasons' ) : '';
			if ( ! empty( $item['content'] ) ) {
				?>
				<div class="reasons-why-item-content">
					<?php
					if ( ! empty( $item['content']['title'] ) ) {
						?>
						<h4 class="reasons-why-item-content-title">
							<?php echo $item['content']['title']; ?>
						</h4>
						<?php
					}
					echo ( ! empty( $item['content']['text'] ) ) ? $item['content']['text'] : '';
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
}
?>
</div>

