<?php
/**
 * Bundled Product Image template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/bundled-item-image.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 5.7.3
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! isset( $product_id ) ) {
	exit;
}

$product             = wc_get_product( $product_id );
$product_gallery_ids = $product->get_gallery_image_ids();
if ( empty( $product_gallery_ids ) ) {
	$product_gallery_ids[] = get_post_thumbnail_id( $product->get_id() );
}
$columns         = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$wrapper_classes = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( isset( $product_gallery_ids[0] ) ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
	<div class="variation-gallery-wrap">
		<div class="default-product-gallery active <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
			<?php get_template_part( 'template-parts/product/gallery', '', array( 'image_ids' => $product_gallery_ids ) ); ?>
		</div>
	</div>
<?php

