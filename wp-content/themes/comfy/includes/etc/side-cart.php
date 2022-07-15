<?php
function cmf_add_variable_product_to_cart() {
	//Bundle

	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity   = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );

	$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : '';
	$variations   = ! empty( $_POST['variation'] ) ? (array) $_POST['variation'] : '';

	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) ) {
		WC_AJAX::get_refreshed_fragments();
	} else {
		// If there was an error adding to the cart, redirect to the product page to show any errors
		$data = array(
			'error'       => true,
			'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
		);
		wp_send_json( $data );
	}
	wp_die();
}
add_action( 'wp_ajax_add_variable_product_to_cart', 'cmf_add_variable_product_to_cart' );
add_action( 'wp_ajax_nopriv_add_variable_product_to_cart', 'cmf_add_variable_product_to_cart' );

add_action(
	'wp_footer',
	function () {
		wp_enqueue_style( 'side-cart', get_template_directory_uri() . '/dist/css/partials/side-cart.css', '', '', 'all' );
		wp_enqueue_script( 'side-cart', get_template_directory_uri() . '/dist/js/partials/side-cart.js', array( 'jquery' ), '', true );
		?>
		<div id="side-cart-wrap" class="side-cart-wrap">
			<div class="side-cart">
				<div class="side-cart-header">
					<h3 class="side-cart-title">
						<?php _e( 'Cart', 'comfy' ); ?>
						<span class="close-cart side-cart-close-icon"></span>
					</h3>
					<p class="close-cart">
						← <?php _e( 'Continue Shopping', 'comfy' ); ?>
					</p>
				</div>
                <div class="side-cart-content">

                </div>
			</div>
		</div>
		<?php
	}
);
