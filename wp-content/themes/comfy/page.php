<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
get_header();
if ( have_rows( 'flexible_sections' ) ) :
	$section_directory = 'template-parts/blocks/';

	add_filter(
		'acf-flexible-content-preview.images_path',
		function ( $path ) {
			return 'template-parts/blocks';
		}
	);

	while ( have_rows( 'flexible_sections' ) ) :
		the_row();
		$section_name = str_replace( '_', '-', get_row_layout() );
		wp_enqueue_style( $section_name . '-section', get_template_directory_uri() . '/' . $section_directory . $section_name . '/' . $section_name . '.css', '', '', 'all' );
		?>
		<section class="section <?php echo $section_name . '-section'; ?>">
			<?php get_template_part( $section_directory . '/' . $section_name . '/' . $section_name ); ?>
		</section>
		<?php
	endwhile;
else :
	the_content();
endif;
get_footer();
