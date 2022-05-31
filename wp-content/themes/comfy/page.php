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

		add_filter(
			'acf-flexible-content-preview.images_path',
			function ( $path ) {
				return 'template-parts/blocks';
			}
		);

		while ( have_rows( 'flexible_sections' ) ) :
			the_row();
			$section_name  = str_replace( '_', '-', get_row_layout() );
			$section_class = str_starts_with( $section_name, 'content-with-image-' ) ? 'content-with-image-advanced-section ' . $section_name : $section_name;
			?>
			<section class="section <?php echo $section_class . '-section'; ?>">
				<?php get_template_part( $section_directory . '/' . $section_name . '/' . $section_name ); ?>
			</section>
			<?php
		endwhile;
	else :
		the_content();
	endif;
	?>
</main>
<?php
get_footer();
