<?php
/**
 * The template for displaying product content in the single-product.php template
 *
*/

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'single-product-bundle', get_template_directory_uri() . '/dist/css/pages/single-product-bundle.css', '', '', 'all' );

wp_enqueue_script( 'single-product-bundle', get_template_directory_uri() . '/dist/js/pages/single-product-bundle.js', array( 'jquery' ), '', true );

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$bundled_items    = $product->get_bundled_items();
$bundle_steps_num = count( $bundled_items ) + 1;
?>
<div class="bundle-steps-wrap" data-steps="<?php echo $bundle_steps_num; ?>">
	<div class="bundle-step bundle-step current-step" data-step="0">
		<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>

			<div class="summary entry-summary">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
				?>
			</div>

			<?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
			?>
		</div>
	</div>
	<?php
	/** WC Core action. */
	do_action( 'woocommerce_before_add_to_cart_form' );
	?>

	<form method="post" enctype="multipart/form-data" class="cart cart_group bundle_form <?php // echo esc_attr( $classes ); ?>">
		<?php

		/**
		 * 'woocommerce_before_bundled_items' action.
		 *
		 * @param WC_Product_Bundle $product
		 */
		do_action( 'woocommerce_before_bundled_items', $product );

		$bundle_step_counter = 1;
		foreach ( $bundled_items as $bundled_item ) {
			/**
			 * 'woocommerce_bundled_item_details' action.
			 *
			 * @hooked wc_pb_template_bundled_item_details_wrapper_open  -   0
			 * @hooked wc_pb_template_bundled_item_thumbnail             -   5
			 * @hooked wc_pb_template_bundled_item_details_open          -  10
			 * @hooked wc_pb_template_bundled_item_title                 -  15
			 * @hooked wc_pb_template_bundled_item_description           -  20
			 * @hooked wc_pb_template_bundled_item_product_details       -  25
			 * @hooked wc_pb_template_bundled_item_details_close         -  30
			 * @hooked wc_pb_template_bundled_item_details_wrapper_close - 100
			 */
			?>
			<div class="bundle-step" data-step="<?php echo $bundle_step_counter++; ?>">
				<?php do_action( 'woocommerce_bundled_item_details', $bundled_item, $product ); ?>
			</div>
			<?php
		}
		?>
		<div class="bundle-step" data-step="<?php echo $bundle_step_counter; ?>">
			<div class="product type-product">
				<?php
				/**
				 * 'woocommerce_after_bundled_items' action.
				 *
				 * @param  WC_Product_Bundle  $product
				 */
				do_action( 'woocommerce_after_bundled_items', $product );


				$product_gallery_ids = array();
				$columns             = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
				$wrapper_classes     = apply_filters(
					'woocommerce_single_product_image_gallery_classes',
					array(
						'woocommerce-product-gallery',
						'woocommerce-product-gallery--' . ( isset( $product_gallery_ids[0] ) ? 'with-images' : 'without-images' ),
						'woocommerce-product-gallery--columns-' . absint( $columns ),
						'images',
					)
				);
				?>
				<div id="bundle-last-step-gallery" class="default-product-gallery active <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
					<?php get_template_part( 'template-parts/product/gallery', '', array( 'image_ids' => $product_gallery_ids ) ); ?>
				</div>
				<?php

				/**
				 * 'woocommerce_bundles_add_to_cart_wrap' action.
				 *
				 * @since  5.5.0
				 *
				 * @param  WC_Product_Bundle  $product
				 */
				do_action( 'woocommerce_bundles_add_to_cart_wrap', $product );
				?>
			</div>
		</div>
	</form>
</div>
<?php
/** WC Core action. */
do_action( 'woocommerce_after_add_to_cart_form' );

do_action( 'woocommerce_after_single_product' );
