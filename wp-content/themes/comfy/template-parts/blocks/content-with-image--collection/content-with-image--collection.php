<?php
wp_enqueue_style( 'content-with-image' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'content-with-image-advanced' . '/' . 'content-with-image-advanced' . '.css', '', '', 'all' );
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}

$section = array(
	'product_cat'     => get_sub_field( 'product_cat' ),
	'custom_image_id' => get_sub_field( 'custom_image_id' ),
	'custom_content'  => get_sub_field( 'custom_content' ),
	'button_label'    => __( 'shop now', 'comfy' ),
);

if ( $section['product_cat'] instanceof WP_Term ) {
	$cat      = $section['product_cat'];
	$products = wc_get_products(
		array(
			'category' => array( $cat->slug ),
		)
	);

	$all_prices = array();
	foreach ( $products as $product ) {
		$all_prices[] = $product->is_type( 'bundle' ) ? $product->get_min_raw_price() : $product->get_price();
	}
	$min_price = min( $all_prices );

	$section['title']       = $cat->name;
	$section['description'] = category_description( $cat );
	$section['image_id']    = get_term_meta( $cat->term_id, 'thumbnail_id', true );
	$section['button_url']  = get_category_link( $cat );
}

$custom_content = array(
	'title'        => $section['custom_content']['title'],
	'description'  => $section['custom_content']['description'],
	'image_id'     => $section['custom_image_id'],
	'button_label' => $section['custom_content']['button']['label'],
	'button_url'   => $section['custom_content']['button']['url'],
);

foreach ( $custom_content as $key => $value ) {
	if ( ! empty( $value ) ) {
		$section[ $key ] = $value;
	}
}
?>
<div class="container container-sm">
	<div class="row">
		<div class="col">
			<?php echo ( ! empty( $section['image_id'] ) ) ? wp_get_attachment_image( $section['image_id'], 'cmf_collection' ) : ''; ?>
		</div>
		<div class="col">
			<?php
			if ( ! empty( $section['title'] ) ) {
				?>
				<h2>
					<?php echo $section['title']; ?>
				</h2>
				<?php
			}

			echo ( ! empty( $section['description'] ) ) ? $section['description'] : '';

			if ( isset( $min_price ) ) {
				?>
				<p>
					<?php echo __( 'From:', 'comfy' ) . ' ' . wc_price( $min_price ); ?>
				</p>
				<?php
			}

			if ( ! empty( $section['button_url'] ) && $section['button_label'] ) {
				?>
				<a href="<?php echo $section['button_url']; ?>" class="button button-secondary">
					<?php echo $section['button_label']; ?>
				</a>
				<?php
			}
			?>
		</div>
	</div>
</div>
