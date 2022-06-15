<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$content = get_sub_field( 'content' );
$content = apply_filters( 'the_content', $content );
$content = str_replace( ']]>', ']]&gt;', $content );
if ( ! empty( $content ) ) {
	?>
	<div class="container">
		<?php echo $content; ?>
	</div>
	<?php
}
