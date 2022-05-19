<?php
/**
 * @package WordPress
 * @subpackage comfy
 */
get_header();
if ( have_rows( 'flexible_sections' ) ) :
	$section_directory = 'template-parts/blocks/';

	while ( have_rows( 'flexible_sections' ) ) :
		the_row();
		$section_name = str_replace( '_', '-', get_row_layout() );
		get_template_part( $section_directory . '/' . $section_name . '/' . $section_name );
	endwhile;
else :
	the_content();
endif;
get_footer();
