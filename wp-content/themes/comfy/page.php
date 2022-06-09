<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
$page = array(
	'first_sections_space' => get_field( 'space_between_first_two_sections' ),
);
get_header(); ?>
<main class="main <?php echo ( ! empty( $page['first_sections_space'] ) ) ? 'first-section-margin-' . $page['first_sections_space'] : 'first-section-margin-120px'; ?>">
	<?php
	if ( have_rows( 'flexible_sections' ) ) :
		$section_directory = 'template-parts/blocks/';

		while ( have_rows( 'flexible_sections' ) ) :
			the_row();
			$section_classes  = '';
			$section_name     = str_replace( '_', '-', get_row_layout() );
			$section_classes .= str_starts_with( $section_name, 'content-with-image-' ) ? 'content-with-image-advanced-section ' . $section_name . '-section' : $section_name . '-section';
			$args             = array(
				'section_name' => $section_name,
			);
			ob_start();
			get_template_part( $section_directory . '/' . $section_name . '/' . $section_name, '', $args );
			$section_layout  = ob_get_clean();
			$section_classes = apply_filters( $section_name . '_classes', $section_classes );
			?>
			<section class="section <?php echo $section_classes; ?>">
				<?php echo $section_layout; ?>
			</section>
			<?php


			if ( ! empty( $classes ) ) {
				wp_die( $classes );
			}
		endwhile;
	else :
		the_content();
	endif;
	?>
</main>
<?php
get_footer();
