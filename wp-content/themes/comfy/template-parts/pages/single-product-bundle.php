<?php
/**
 * The template for displaying product content in the single-product.php template
 *
*/

defined( 'ABSPATH' ) || exit;

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
?>
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
    /** WC Core action. */
    do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <form method="post" enctype="multipart/form-data" class="cart cart_group bundle_form <?php echo esc_attr( $classes ); ?>"><?php

        /**
         * 'woocommerce_before_bundled_items' action.
         *
         * @param WC_Product_Bundle $product
         */
        do_action( 'woocommerce_before_bundled_items', $product );

        $bundled_items = $product->get_bundled_items();
        foreach ( $bundled_items as $bundled_item ) {

            /**
             * 'woocommerce_bundled_item_details' action.
             *
             * @hooked wc_pb_template_bundled_item_details_wrapper_open  -   0
             * @hooked wc_pb_template_bundled_item_thumbnail             -   5 *
             * @hooked wc_pb_template_bundled_item_details_open          -  10
             * @hooked wc_pb_template_bundled_item_title                 -  15
             * @hooked wc_pb_template_bundled_item_description           -  20
             * @hooked wc_pb_template_bundled_item_product_details       -  25
             * @hooked wc_pb_template_bundled_item_details_close         -  30 *
             * @hooked wc_pb_template_bundled_item_details_wrapper_close - 100
             */
            do_action( 'woocommerce_bundled_item_details', $bundled_item, $product );
        }

        /**
         * 'woocommerce_after_bundled_items' action.
         *
         * @param  WC_Product_Bundle  $product
         */
        do_action( 'woocommerce_after_bundled_items', $product );

        /**
         * 'woocommerce_bundles_add_to_cart_wrap' action.
         *
         * @since  5.5.0
         *
         * @param  WC_Product_Bundle  $product
         */
        do_action( 'woocommerce_bundles_add_to_cart_wrap', $product );

        ?></form><?php
    /** WC Core action. */
    do_action( 'woocommerce_after_add_to_cart_form' );
    ?>

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

<?php do_action( 'woocommerce_after_single_product' ); ?>
