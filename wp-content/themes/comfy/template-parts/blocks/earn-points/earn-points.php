<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'title' => get_sub_field( 'title' ),
	'ways'  => get_sub_field( 'ways' ),
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
	if ( ! empty( $section['ways'] ) ) {
		?>
		<div class="ways">
			<?php
			foreach ( $section['ways'] as $way ) {
				?>
				<div class="way">
					<?php
					if ( ! empty( $way['title'] ) ) {
						?>
						<h5 class="way-title">
							<?php echo $way['title']; ?>
						</h5>
						<?php
					}
					if ( ! empty( $way['desc'] ) ) {
						?>
						<p>
							<?php echo $way['desc']; ?>
						</p>
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
