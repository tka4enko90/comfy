<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'title' => get_sub_field( 'title' ),
	'link'  => get_sub_field( 'link' ),
);
?>
<div class="container container-xs">
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
	if ( ! empty( $section['link'] ) ) {
		if ( ! empty( $section['link']['url'] ) && ! empty( $section['link']['title'] ) ) {
			?>
			<a class="button button-secondary" href="<?php echo $section['link']['url']; ?>" <?php echo ! empty( $section['link']['target'] ) ? 'target="' . $section['link']['target'] . '"' : ''; ?>>
				<?php echo $section['link']['title']; ?>
			</a>
			<?php
		}
	}
	?>

</div>
