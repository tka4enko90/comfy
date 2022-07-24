<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );
		$total_discount   = 0;
		$bundles_discount = 0;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product          = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id        = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
			$thumbnail         = wp_get_attachment_image( get_post_thumbnail_id( $product_id ), 'cmf_bundle_breakdown' );
			$product_price     = $_product->is_type( 'bundle' ) ? apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) : $_product->get_price_html();
			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
				if ( apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					// Product sale count
					$sale = floatval( $_product->get_regular_price() ) - floatval( $_product->get_price() );
					if ( 0 < $sale ) {
						$total_discount += $sale * intval( $cart_item['quantity'] );
					}
					?>
					<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<form style="display: none">
							<input type="hidden" name="product_key" value="<?php echo esc_attr( $cart_item_key ); ?>">
							<input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
							<?php if ( $_product->is_type( 'variation' ) ) : ?>
								<input type="hidden" name="variation_id" value="<?php echo esc_attr( $_product->get_variation_id() ); ?>">
							<?php endif; ?>
						</form>
						<?php
						if ( ! empty( $product_permalink ) ) {
							?>
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="woocommerce-mini-cart-item-thumbnail">
							<?php
						}
							echo $thumbnail;
						if ( ! empty( $product_permalink ) ) {
							?>
						</a>
							<?php
						}
						?>
						<div class="woocommerce-mini-cart-item-info">
							<?php
							if ( ! empty( $product_permalink ) ) {
								?>
							<a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php
							}
							?>
								<div class="woocommerce-mini-cart-item-header">
									<h6 class="woocommerce-mini-cart-item-header-title">
										<?php echo wp_kses_post( $product_name ); ?>
									</h6>
									<p class="price">
										<?php echo $product_price; ?>
									</p>
								</div>
								<?php
								if ( $_product->is_type( 'variation' ) || $_product->is_type( 'variable' ) ) :
									$attributes = $_product->get_variation_attributes();
									if ( ! empty( $attributes ) ) :
										foreach ( $attributes as $name => $val ) {
											$attribute_label = wc_attribute_label( str_replace( 'attribute_', '', $name ) );
											?>
											<p class="bundle-item-attribute bundle-item-attribute--<?php echo $name; ?>">
								<span class="bundle-item-attribute-name">
											<?php echo $attribute_label . ':'; ?>
								</span>
												<span class="bundle-item-attribute-value attribute_<?php echo $name; ?>"><?php echo $val; ?></span>
											</p>
											<?php
										}
									endif;
								endif;
								echo wc_get_formatted_cart_item_data( $cart_item );

								if ( ! empty( $product_permalink ) ) {
									?>
							</a>
									<?php
								}
								?>
							<div class="woocommerce-mini-cart-item-actions">
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_3012_1358)"><path d="M3.59766 6H16.3977" stroke="#6C7489" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.39844 9.19922V13.9992" stroke="#6C7489" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.5977 9.19922V13.9992" stroke="#6C7489" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.39844 6L5.19844 15.6C5.19844 16.0243 5.36701 16.4313 5.66707 16.7314C5.96712 17.0314 6.37409 17.2 6.79844 17.2H13.1984C13.6228 17.2 14.0298 17.0314 14.3298 16.7314C14.6299 16.4313 14.7984 16.0243 14.7984 15.6L15.5984 6" stroke="#6C7489" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.59766 5.99687V3.59687C7.59766 3.3847 7.68194 3.18122 7.83197 3.03119C7.982 2.88116 8.18548 2.79688 8.39766 2.79688H11.5977C11.8098 2.79688 12.0133 2.88116 12.1633 3.03119C12.3134 3.18122 12.3977 3.3847 12.3977 3.59687V5.99687" stroke="#6C7489" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_3012_1358"><rect width="19.2" height="19.2" fill="white" transform="translate(0.398438 0.398438)"/></clipPath></defs></svg></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_attr__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $cart_item_key ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
								?>
							</div>
						</div>
					</li>
					<?php
				} else {
					if ( ! empty( $_product->bundled_cart_item->item_data ) ) {
						$bundle_item_discount = $_product->bundled_cart_item->item_data['discount'];
						if ( ! empty( $bundle_item_discount ) && is_numeric( $bundle_item_discount ) ) {
							$item_price            = $_product->get_price();
							$item_full_price       = $item_price / ( 100 - $bundle_item_discount ) * 100;
							$bundled_item_discount = $item_full_price - $item_price;
							$bundles_discount     += $bundled_item_discount * $cart_item['quantity'];
						}
					}
				}
			}
		}
		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

<div class="side-cart-total-wrap">
	<div class="side-cart-total">
		<p class="woocommerce-mini-cart__total total total-el">
			<span><?php _e( 'Subtotal', 'comfy' ); ?></span>
			<span><?php echo cmf_remove_zeros( WC()->cart->get_total() ); ?></span>
		</p>
		<?php
		if ( 0 < $bundles_discount ) {
			?>
			<p class="bundle-discount total-el"><span><?php _e( 'Bundle Discounts', 'comfy' ); ?></span><span><?php echo cmf_remove_zeros( wc_price( $bundles_discount ) ); ?></span></p>
			<?php
		}
		if ( 0 < $total_discount ) {
			?>
			<p class="cart-discount total-el"><span><?php _e( 'Further Discounts', 'comfy' ); ?></span><span><?php echo cmf_remove_zeros( wc_price( $total_discount ) ); ?></span></p>
			<?php
		}


		//Shipping total
		foreach ( WC()->session->get( 'shipping_for_package_0' )['rates'] as $method_id => $rate ) {
			if ( WC()->session->get( 'chosen_shipping_methods' )[0] === $method_id ) {
				echo sprintf(
					'<p class="shipping-total total-el"><span>%s </span><span class="totals">%s</span></p>',
					$rate->label,
					cmf_remove_zeros( WC()->cart->get_cart_shipping_total() )
				);
				break;
			}
		}
		?>
		<p class="cart-total total-el">
			<span>
				<?php _e( 'Total', 'comfy' ); ?>
			</span>
			<span>
				<?php echo cmf_remove_zeros( WC()->cart->get_total() ); ?>
			</span>
		</p>
		<p class="credit-text">
			<?php
			$amount = ( ! WC()->cart->prices_include_tax ) ? $amount = WC()->cart->cart_contents_total : WC()->cart->cart_contents_total + WC()->cart->tax_total;
			cmf_the_credit_text( $amount );
			?>
		</p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	</div>
</div>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
