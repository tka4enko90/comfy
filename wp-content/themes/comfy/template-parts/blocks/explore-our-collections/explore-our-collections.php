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
	?>
	<?php
	if ( ! empty( $section['items'] ) ) {
		?>
		<div class="row">
			<?php
			foreach ( $section['items'] as $item ) {
				?>
				<div class="col">
					<?php
					if ( ! empty( $item['image_id'] ) ) {
						echo wp_get_attachment_image( $item['image_id'], 'cmf_content_with_image_1' );
					}
					?>
					<?php
					if ( ! empty( $item['address'] ) ) {
						?>
						<h6 class="item-address"><?php echo $item['address']; ?></h6>
						<?php
					}
					if ( ! empty( $item['title'] ) ) {
						?>
						<h5 class="item-title"><?php echo $item['title']; ?></h5>
						<?php
					}
					if ( ! empty( $item['description'] ) ) {
						?>
						<p class="item-description"><?php echo $item['description']; ?></p>
						<?php
					}
					if ( isset( $item['link'] ) ) {
						if ( ! empty( $item['link']['url'] ) && ! empty( $item['link']['title'] ) ) {
							$href   = $item['link']['url'];
							$title  = $item['link']['title'];
							$target = ! empty( $item['link']['target'] ) ? 'target="' . $item['link']['target'] . '"' : '';
							?>
							<a class="button button-secondary" href="<?php echo $href; ?>" <?php echo $target; ?>>
								<?php echo $title; ?>
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
		<?php
	}
	?>
</div>
