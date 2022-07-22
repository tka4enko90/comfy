<?php
function cmf_add_product_to_cart() {

	$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$quantity   = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );

	$_product = wc_get_product( $product_id );
	if ( $_product->is_type( 'bundle' ) ) {
		if ( ! empty( $_POST['bundle_data'] ) ) {
			$configuration = WC_PB_Cart::instance()->parse_bundle_configuration( $_product, $_POST['bundle_data'] );
			foreach ( $_POST['bundle_data'] as $key => $val ) {
				$key_words       = explode( '_', $key );
				$bundle_item_num = intval( array_pop( $key_words ) );
				array_shift( $key_words );
				$variation_data_key = implode( '_', $key_words );

				if ( 'attribute' === $key_words[0] ) {
					$configuration[ $bundle_item_num ]['attributes'][ $variation_data_key ] = $val;
				} else {
					$configuration[ $bundle_item_num ][ $variation_data_key ] = $val;
				}
			}

			if ( is_wp_error( WC_PB_Cart::instance()->add_bundle_to_cart( $product_id, $quantity, $configuration, $configuration ) ) ) {
				wp_send_json_error( __( 'Error in adding to cart', 'comfy' ), 500 );
				wp_die();
			}
			WC_AJAX::get_refreshed_fragments();
			wp_die();
		}
	}

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
add_action( 'wp_ajax_add_product_to_cart', 'cmf_add_product_to_cart' );
add_action( 'wp_ajax_nopriv_add_product_to_cart', 'cmf_add_product_to_cart' );


/**
 * Function for set quantity via ajax in the aside cart
 */
function set_mini_cart_item_quantity() {
	$response = array();
	if ( isset( $_POST['cart_item_qty'] ) ) {
		$cart_key_sanitized = filter_var( wp_unslash( $_POST['cart_item_key'] ), FILTER_SANITIZE_STRING );
		$cart_qty_sanitized = filter_var( wp_unslash( $_POST['cart_item_qty'] ), FILTER_SANITIZE_NUMBER_INT );
		$product_id         = filter_var( wp_unslash( $_POST['product_id'] ), FILTER_SANITIZE_NUMBER_INT );
		$variation_id       = filter_var( wp_unslash( $_POST['variation_id'] ), FILTER_SANITIZE_NUMBER_INT );

		if ( empty( $variation_id ) ) {
			$variation_id = null;
		}

		if ( '0' === $cart_qty_sanitized ) {

			WC()->cart->remove_cart_item( $cart_key_sanitized );

		} else {

		    if(is_wp_error(WC()->cart->set_quantity( $cart_key_sanitized, $cart_qty_sanitized ))) {
                wp_send_json_error( __( 'Not valid cart item qty', 'comfy' ), 400 );
                wp_die();
            }
			if ( apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $cart_qty_sanitized, $variation_id ) ) {

				//WC()->cart->set_quantity( $cart_key_sanitized, $cart_qty_sanitized );

			} else {
				//wp_send_json_error( __( 'Not valid cart item qty', 'comfy' ), 400 );
			}
		}
	} else {
		wp_send_json_error( __( 'Cart item qty not set', 'comfy' ), 400 );
	}

	WC_AJAX::get_refreshed_fragments();
	wp_die();
}
add_action( 'wp_ajax_set_mini_cart_item_quantity', 'set_mini_cart_item_quantity' );
add_action( 'wp_ajax_nopriv_set_mini_cart_item_quantity', 'set_mini_cart_item_quantity' );

/**
 * Add quantity field to aside cart item
 */
add_filter( 'woocommerce_widget_cart_item_quantity', 'add_minicart_quantity_fields', 10, 3 );
function add_minicart_quantity_fields( $html, $cart_item, $cart_item_key ) {

	$product       = ! empty( $cart_item['variation_id'] ) ? wc_get_product( $cart_item['variation_id'] ) : wc_get_product( $cart_item['product_id'] );
	$price         = ! empty( $cart_item['data'] ) ? WC()->cart->get_product_price( $cart_item['data'] ) : $product->get_price_html();
	$product_price = apply_filters( 'woocommerce_cart_item_price', $price, $cart_item, $cart_item_key );

	$stock_quantity = $product->get_stock_quantity();

	return woocommerce_quantity_input(
		array(
			'input_value' => ! empty( $cart_item['quantity'] ) ? $cart_item['quantity'] : 0,
			'max_value'   => $stock_quantity,
		),
		$cart_item['data'],
		false
	);
}


add_action(
	'wp_footer',
	function () {
		wp_enqueue_style( 'quantity', get_template_directory_uri() . '/dist/css/partials/qty-buttons.css', '', '', 'all' );
		wp_enqueue_style( 'side-cart', get_template_directory_uri() . '/dist/css/partials/side-cart.css', '', '', 'all' );
		wp_enqueue_script( 'side-cart', get_template_directory_uri() . '/dist/js/partials/side-cart.js', array( 'jquery' ), '', true );
		?>
		<div id="side-cart-wrap" class="side-cart-wrap active">
			<div class="side-cart">
				<div class="side-cart-header">
					<h4 class="side-cart-title">
						<?php _e( 'Cart', 'comfy' ); ?>
						<span class="close-cart side-cart-close-icon"></span>
					</h4>
					<p class="close-cart side-cart-close-text">
						← <span><?php _e( 'Continue Shopping', 'comfy' ); ?></span>
					</p>
				</div>
				<div class="side-cart-content">
					<div class="widget_shopping_cart_content">
						<?php woocommerce_mini_cart(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
);

remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
