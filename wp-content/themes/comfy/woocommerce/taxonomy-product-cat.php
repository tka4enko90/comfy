<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_query;
$cat           = $wp_query->get_queried_object();
$display_type  = get_term_meta( $cat->term_id, 'display_type', true );
$page_sections = array(
	array(
		'section_name' => 'hero',
		'title'        => $cat->name,
		'content'      => category_description( $cat->term_id ),
	),
);
$subcategories = get_terms(
	array(
		'taxonomy' => 'product_cat',
		'parent'   => $cat->term_id,
	)
);

switch ( $display_type ) {
	case 'subcategories':
		foreach ( $subcategories as $subcategory ) {
			$page_sections[] = array(
				'section_name' => 'content-with-image--collection',
				'product_cat'  => $subcategory,
			);
		}
		break;
	default:
		$page_sections[0]['image_id'] = get_term_meta( $cat->term_id, 'thumbnail_id', true );
		$query_args                   = array(
			'post_type'   => 'product',
			'numberposts' => -1,
			'tax_query'   => array(
				array(
					'taxonomy'         => 'product_cat',
					'field'            => 'term_id',
					'terms'            => $cat->term_id,
					'include_children' => true,
				),
			),
		);
		$section_products             = array();
		if ( ! empty( $subcategories ) ) {
			foreach ( $subcategories as $subcategory ) {
				$query_args['tax_query']['terms'] = $subcategory->term_id;
				$products                         = get_posts( $query_args );
				if ( ! empty( $products ) ) {
					foreach ( $products as $_product ) {
						$section_products[]['product'] = $_product;
					}
					$page_sections[] = array(
						'section_name' => 'third-level-collection',
						'title'        => $subcategory->name,
						'subtitle'     => wp_kses( category_description( $subcategory->term_id ), array( 'br' => array() ) ),
						'products'     => $section_products,
					);
				}
			}
		} else {
			$products = get_posts( $query_args );
			foreach ( $products as $_product ) {
				$section_products[]['product'] = $_product;
			}
			if ( ! empty( $products ) ) {
				$page_sections[] = array(
					'section_name' => 'third-level-collection',
					'products'     => $section_products,
				);
			}
		}
}
get_header(); ?>
	<main class="main first-section-margin-<?php echo ( 'subcategories' === $display_type ) ? '64px' : '120px'; ?>">
		<?php
		$section_directory = 'template-parts/blocks/';
		foreach ( $page_sections as $section ) {
			$section_name     = $section['section_name'];
			$section_classes  = '';
			$section_classes .= str_starts_with( $section_name, 'content-with-image-' ) ? 'content-with-image-advanced-section ' . $section_name . '-section' : $section_name . '-section';

			ob_start();
			get_template_part( $section_directory . '/' . $section_name . '/' . $section_name, '', $section );
			$section_layout           = ob_get_clean();
			$filtered_section_classes = apply_filters( $section_name . '_classes', $section_classes );
			?>
			<section class="section <?php echo $filtered_section_classes; ?>">
				<?php echo $section_layout; ?>
			</section>
			<?php
			add_filter(
				$section['section_name'] . '_classes',
				function ( $classes ) use ( $section_classes ) {
					return  $section_classes;
				}
			);
		}
		?>
	</main>
<?php
get_footer();
