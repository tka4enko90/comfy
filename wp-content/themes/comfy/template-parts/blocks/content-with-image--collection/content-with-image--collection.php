<?php
wp_enqueue_style( 'content-with-image' . '-section', get_template_directory_uri() . '/template-parts/blocks/' . 'content-with-image-advanced' . '/' . 'content-with-image-advanced' . '.css', '', '', 'all' );
if ( ! empty( $args['section_name'] ) ) {
	wp_enqueue_style( $args['section_name'] . '-section', get_template_directory_uri() . '/template-parts/blocks/' . $args['section_name'] . '/' . $args['section_name'] . '.css', '', '', 'all' );
}

$section = array(
	'product_cat'     => get_sub_field( 'product_cat' ),
	'custom_image_id' => get_sub_field( 'custom_image_id' ),
	'custom_content'  => get_sub_field( 'custom_content' ),
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

	$image_id       = get_term_meta( $cat->term_id, 'thumbnail_id', true );
	$section_button = array(
		'label' => __( 'shop now', 'comfy' ),
		'url'   => get_category_link( $cat ),
	);

	$section_title       = $cat->name;
	$section_description = category_description( $cat );
}

if ( ! empty( $section['custom_content']['title'] ) ) {
	$section_title = $section['custom_content']['title'];
}

if ( ! empty( $section['custom_content']['description'] ) ) {
	$section_description = $section['custom_content']['description'];
}

if ( ! empty( $section['custom_image_id'] ) ) {
	$image_id = $section['custom_image_id'];
}

if ( ! empty( $section['custom_content']['button']['label'] ) ) {
	$section_button['label'] = $section['custom_content']['button']['label'];
}
if ( ! empty( $section['custom_content']['button']['url'] ) ) {
	$section_button['url'] = $section['custom_content']['button']['url'];
}
?>
<div class="container container-sm">
	<div class="row">
		<div class="col">
			<?php echo ( ! empty( $image_id ) ) ? wp_get_attachment_image( $image_id, 'cmf_collection' ) : ''; ?>
		</div>
		<div class="col">
			<?php
			if ( ! empty( $section_title ) ) {
				?>
				<h2>
					<?php echo $section_title; ?>
				</h2>
				<?php
			}

			echo ( ! empty( $section_description ) ) ? $section_description : '';

			if ( isset( $min_price ) ) {
				?>
				<p>
					<?php echo __( 'From:', 'comfy' ) . ' ' . wc_price( $min_price ); ?>
				</p>
				<?php
			}

			if ( ! empty( $section_button['url'] ) && $section_button['label'] ) {
				?>
				<a href="<?php echo $section_button['url']; ?>" class="button button-secondary">
					<?php echo $section_button['label']; ?>
				</a>
				<?php
			}
			?>
		</div>
	</div>
</div>
