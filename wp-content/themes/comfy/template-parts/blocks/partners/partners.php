<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );

}

$section = array(
	'title'    => get_sub_field( 'title' ),
	'partners' => get_sub_field( 'partners' ),
);
?>
<div class="container">

	<?php
	if ( ! empty( $section['title'] ) ) {
		?>
		<h2 class="section-title">
			<?php echo $section['title']; ?>
		</h2>
		<?php
	}
	?>
	<?php
	if ( ! empty( $section['partners'] ) ) {
		?>
		<div class="row">
			<?php
			foreach ( $section['partners'] as $partner ) {
				?>
				<div class="col">
					<?php
					if ( ! empty( $partner['image_id'] ) ) {
						echo wp_get_attachment_image( $partner['image_id'], 'cmf_content_with_image_1' );
					}
					?>
					<?php
					if ( ! empty( $partner['address'] ) ) {
						?>
						<h6 class="partner-address"><?php echo $partner['address']; ?></h6>
						<?php
					}
					if ( ! empty( $partner['title'] ) ) {
						?>
						<h3 class="partner-title"><?php echo $partner['title']; ?></h3>
						<?php
					}
					if ( ! empty( $partner['description'] ) ) {
						?>
						<p class="partner-description"><?php echo $partner['description']; ?></p>
						<?php
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
