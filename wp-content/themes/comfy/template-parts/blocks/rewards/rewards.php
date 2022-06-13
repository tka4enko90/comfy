<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'title' => get_sub_field( 'title' ),
	'items' => get_sub_field( 'items' ),
);
?>
<div class="container">
	<?php
	if ( ! empty( $section['title'] ) ) {
		?>
		<h3 class="section-title">
			<?php echo $section['title']; ?>
		</h3>
		<?php
	}
	if ( ! empty( $section['items'] ) ) {
		?>
		<div class="row">
			<?php
			foreach ( $section['items'] as $item ) {
				?>
				<div class="col">
					<div class="rewards-item">
						<?php
						if ( ! empty( $item['image_id'] ) ) {
							echo wp_get_attachment_image( $item['image_id'], 'cmf_product_preview' );
						}
						if ( ! empty( $item['title'] ) ) {
							?>
							<h6 class="rewards-item-title">
								<?php echo $item['title']; ?>
							</h6>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>
