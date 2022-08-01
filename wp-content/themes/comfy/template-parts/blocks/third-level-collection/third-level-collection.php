<?php
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}
$section = array(
	'title'    => ( ! empty( $args['title'] ) ) ? $args['title'] : get_sub_field( 'title' ),
	'subtitle' => ( ! empty( $args['subtitle'] ) ) ? $args['subtitle'] : get_sub_field( 'subtitle' ),
	'category' => ( ! empty( $args['category'] ) ) ? $args['category'] : get_sub_field( 'category' ),
);
if ( ! empty( $section['category'] ) && $section['category'] instanceof WP_Term ) {
	$query_args = array(
		'post_type'   => 'product',
		'numberposts' => -1,
		'tax_query'   => array(
			array(
				'taxonomy'         => 'product_cat',
				'field'            => 'term_id',
				'terms'            => $section['category']->term_id,
				'include_children' => true,
			),
		),
	);
	$products   = get_posts( $query_args );
	if ( ! empty( $products ) ) {
		?>
		<div class="container container-sm">
			<?php
			if ( ! empty( $section['title'] ) ) {
				?>
				<h2 class="section-title">
					<?php echo $section['title']; ?>
				</h2>
				<?php
			}
			if ( ! empty( $section['subtitle'] ) ) {
				?>
				<p class="section-subtitle">
					<?php echo $section['subtitle']; ?>
				</p>
				<?php
			}
			if ( ! empty( $products ) ) {
				?>
				<div class="row">
					<?php
					$product_args = array(
						'thumb'            => 'cmf_post_preview', // optional
						'show_stars'       => true,
						'show_reviews_num' => true,
					);
					foreach ( $products as $item ) {
						$product_args['product'] = $item;
						if ( ! empty( $product_args['product'] ) ) {
							?>
							<div class="col">
								<?php get_template_part( 'template-parts/product-preview', '', $product_args ); ?>
							</div>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
}
