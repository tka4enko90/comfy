<?php
wp_enqueue_style( 'products' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'products' . '/' . 'products' . '.css', '', '', 'all' );
$section = array(
	'title'                => get_sub_field( 'title' ),
	'products_by'          => get_sub_field( 'products_by' ),
	'term_id'              => get_sub_field( 'category' ),
	'show_only_chosen_cat' => get_sub_field( 'show_only_chosen_cat' ),
	'products_num'         => get_sub_field( 'products_num' ),
	'products'             => get_sub_field( 'products' ),
	'show_categories'      => get_sub_field( 'show_categories' ),
);

if ( isset( $section['products_by'] ) ) {
	switch ( $section['products_by'] ) {
		case 'cats':
			$section['show_categories'] = true;
			$products                   = get_posts(
				array(
					'post_type'   => 'product',
					'numberposts' => $section['products_num'],
					'tax_query'   => array(
						array(
							'taxonomy'         => 'product_cat',
							'field'            => 'term_id',
							'terms'            => $section['term_id'], /// Where term_id of Term 1 is "1".
							'include_children' => false,
						),
					),
				)
			);
			break;
		case 'products':
			if ( ! empty( $section['products'] ) ) {
				$products = array();
				foreach ( $section['products'] as $product ) {
					$products[] = $product['product'];
				}
			}
			break;
	}
}

?>
	<div class="container">
		<div class="row justify-content-between">
			<?php
			if ( ! empty( $section['title'] ) ) {
				?>
				<div class="col-100">
					<h3 class="section-title"><?php echo $section['title']; ?></h3>
				</div>
				<?php
				if ( isset( $products ) ) {
					foreach ( $products as $product ) {
						$args = array(
							'product'              => $product, // Important
							'thumb'                => 'cmf_product_preview', // optional
							'show_cats'            => $section['show_categories'],
							'show_only_chosen_cat' => $section['show_only_chosen_cat'],
							'term_id'              => $section['term_id'], // if 'show_only_chosen_cat'
							'show_stars'           => true,
							'show_reviews_num'     => true,
						);
						?>
						<div class="col">
							<?php get_template_part( 'template-parts/product-preview', '', $args ); ?>
						</div>
						<?php
					}
				}
			}
			?>
		</div>
	</div>
<?php


