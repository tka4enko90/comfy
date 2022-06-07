<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$contact_col = get_sub_field( 'contact_form' );
$image_col   = get_sub_field( 'image' );
$section     = array(
	'title'          => $contact_col['title'],
	'form_shortcode' => $contact_col['contact_form_shortcode'],
	'image_id'       => $image_col['image_id'],
);
?>
<div class="container">
	<div class="row">
		<div class="section-col">
			<?php
			if ( ! empty( $section['title'] ) ) {
				?>
				<h2 class="section-title"><?php echo $section['title']; ?></h2>
				<?php
			}
			?>
			<?php
			if ( ! empty( $section['form_shortcode'] ) ) {
				echo do_shortcode( $section['form_shortcode'] );
			}
			?>
		</div>
		<div class="section-col">
			<?php
			if ( ! empty( $section['image_id'] ) ) {
				echo wp_get_attachment_image( $section['image_id'], 'cmf_contact_form' );
			}
			?>
		</div>
	</div>
</div>
