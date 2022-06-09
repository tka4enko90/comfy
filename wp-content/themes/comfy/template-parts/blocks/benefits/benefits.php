<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'title'    => get_sub_field( 'title' ),
	'benefits' => get_sub_field( 'benefits' ),
	'image_id' => get_sub_field( 'image_id' ),
	'button'   => get_sub_field( 'button' ),
);
?>
<div class="container">
	<div class="row">
		<div class="col">
			<?php
			if ( ! empty( $section['title'] ) ) {
				?>
				<h2 class="section-title"><?php echo $section['title']; ?></h2>
				<?php
			}

			if ( ! empty( $section['benefits'] ) ) {
				foreach ( $section['benefits'] as $benefit ) {
					?>
					<div class="benefit">
						<?php
						if ( ! empty( $benefit['title'] ) ) {
							?>
							<h5 class="benefit-title"><?php echo $benefit['title']; ?></h5>
							<?php
						}
						if ( ! empty( $benefit['text'] ) ) {
							?>
							<p>
								<?php echo $benefit['text']; ?>
							</p>
							<?php
						}
						?>
					</div>
					<?php
				}
			}

			if ( isset( $section['button'] ) ) {
				if ( ! empty( $section['button']['url'] ) && ! empty( $section['button']['title'] ) ) {
					?>
					<a class="button button-secondary" href="<?php echo $section['button']['url']; ?>" <?php echo ! empty( $section['button']['target'] ) ? 'target="' . $section['button']['target'] . '"' : ''; ?>>
						<?php echo $section['button']['title']; ?>
					</a>
					<?php
				}
			}
			?>
		</div>
		<?php
		if ( ! empty( $section['image_id'] ) ) {
			?>
			<div class="col">
				<?php
				if ( ! empty( $section['title'] ) ) {
					?>
				<h2 class="section-title mobile"><?php echo $section['title']; ?></h2>
					<?php
				}
				echo wp_get_attachment_image( $section['image_id'], 'cmf_benefits_section' );
				?>
			</div>
			<?php
		}
		?>
	</div>
</div>

