<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/public/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! is_user_logged_in() ) {
	$guest_user = true;
} else {
	$guest_user = false;
}
if ( isset( $_GET['wps_rma_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['wps_rma_nonce'] ) ), 'wps_rma_nonce' ) && isset( $_GET['order_id'] ) && ( $guest_user || current_user_can( 'wps-rma-cancel-request' ) ) ) {
	$order_id = sanitize_text_field( wp_unslash( $_GET['order_id'] ) );
} else {
	$order_id = '';
}
if ( ! empty( $order_id ) ) {
	$order_obj = wc_get_order( $order_id );
	if ( ! empty( $order_obj ) ) {
		$condition = wps_rma_show_buttons( 'cancel', $order_obj );
	} else {
		$condition = esc_html__( 'Please give the correct order id', 'woocommerce-rma-for-return-refund-and-exchange' );
	}
}
if ( isset( $condition ) && 'yes' === $condition && isset( $order_id ) && ! empty( $order_id ) && ! empty( $order_obj ) ) {
	$order_customer_id = get_post_meta( $order_id, '_customer_user', true );
	if ( get_current_user_id() > 0 ) {
		if ( get_current_user_id() != $order_customer_id ) {
			$myaccount_page     = get_option( 'woocommerce_myaccount_page_id' );
			$myaccount_page_url = get_permalink( $myaccount_page );
			$condition          = esc_html( "This order #$order_id is not associated to your account. <a href='$myaccount_page_url'>Click Here</a>" );
		}
	}
}

get_header( 'shop' );

if ( 'on' === get_option( 'wps_rma_show_sidebar', 'no' ) ) {
	// Main Content.
	do_action( 'woocommerce_before_main_content' );
}

if ( isset( $condition ) && 'yes' === $condition ) {
	$show_customer_details  = is_user_logged_in() && $order_obj->get_user_id() === get_current_user_id();
	$wps_main_wrapper_class = get_option( 'wps_wrma_cancel_form_wrapper_class' );
	$wps_cancel_css         = get_option( 'wps_rma_cancel_form_css' );
	?>
	<style>	<?php echo wp_kses_post( $wps_cancel_css ); ?>	</style>
	<div class="wps-rma-form__wrapper <?php echo esc_html( $wps_main_wrapper_class ); ?>" id="wps_wrma_return_request_form_wrapper">
		<div id="wps_wrma_return_request_container" class="wps-rma-form__header">
			<h1 class="wps-rma-form__heading">
				<?php
				$return_product_form = esc_html__( 'Order\'s Product Cancel Request Form', 'woocommerce-rma-for-return-refund-and-exchange' );
				// Order cancel form heading.
				echo esc_html( apply_filters( 'wps_wrma_cancel_product_form', $return_product_form ) );
				?>
			</h1>
		</div>
		<ul id="wps-return-alert">
		</ul>
		<p class="">
			<?php
			// Before order item table on cancel form.
			do_action( 'wps_wrma_cancel_before_order_item_table' );
			?>
		</p>
		<div class="wps_rma_product_table_wrapper wps-rma-product__table-wrapper">
			<table class="shop_table order_details wps_wrma_product_table wps-rma-product__table">
				<thead>
					<tr>
						<th class="product-check"><input type="checkbox" name="wps_rma_cancel_product_all" class="wps_wrma_cancel_product_all" value="<?php echo esc_html( $order_id ); ?>"><?php esc_html_e( 'Check All', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th class="product-qty"><?php esc_html_e( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>

					</tr>
				</thead>
				<tbody>
					<?php
					$wps_rma_check_tax  = get_option( $order_id . 'check_tax', false );
					$get_order_currency = get_woocommerce_currency_symbol( $order_obj->get_currency() );
					foreach ( $order_obj->get_items() as $item_id => $item ) {
						$item_quantity = $item->get_quantity();
						$refund_qty    = $order_obj->get_qty_refunded_for_item( $item_id );
						$item_qty      = $item->get_quantity() + $refund_qty;
						if ( $item_qty > 0 ) {
							if ( isset( $item['variation_id'] ) && $item['variation_id'] > 0 ) {
								$variation_id = $item['variation_id'];
								$product_id   = $item['product_id'];
							} else {
								$product_id = $item['product_id'];
							}
							$product =
							// Woo Order Item Product.
							apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
							$thumbnail = wp_get_attachment_image( $product->get_image_id(), 'thumbnail' );
							?>
							<tr class="wps_wrma_cancel_column" data-productid="<?php echo esc_html( $product_id ); ?>" data-variationid="<?php echo esc_html( $item['variation_id'] ); ?>" data-itemid="<?php echo esc_html( $item_id ); ?>">
								<td class="product-select">
									<?php
									$exclude_prod = wps_rma_exclude_product( $product_id, 'cancel' );
									if ( ! $exclude_prod ) {

										echo '<img src="' . esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . '/public/images/return-disable.png">';
									} else {
										echo '<input type="checkbox" class="wps_wrma_cancel_product" value="' . esc_html( $item_id ) . '">';
									}
									?>
								</td>
								<td class="product-name">
									<div class="wps-rma-product__wrap">
										<?php
										$is_visible        = $product && $product->is_visible();
										$product_permalink =
										// Woo Order item Permalink.
										apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order_obj );

										if ( isset( $thumbnail ) && ! empty( $thumbnail ) ) {
											echo wp_kses_post( $thumbnail );
										} else {
											?>
											<img alt="Placeholder" width="150" height="150" class="attachment-thumbnail size-thumbnail wp-post-image" src="<?php echo esc_html( plugins_url() ); ?>/woocommerce/assets/images/placeholder.png">
											<?php
										}
										?>
										<div class="wps_wrma_product_title wps-rma__product-title">
											<?php
											// Order Item Name.
											echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item['name'] ) : $item['name'], $item, $is_visible ) );
											// Order Item Quanity.
											echo wp_kses_post( apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item['qty'] ) . '</strong>', $item ) );
											// Order Item meta start.
											do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order_obj );
											if ( WC()->version < '3.0.0' ) {
												$order_obj->display_item_meta( $item );
												$order_obj->display_item_downloads( $item );
											} else {
												wc_display_item_meta( $item );
												wc_display_item_downloads( $item );
											}
											// Order Item meta end.
											do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order_obj );
											?>
											<p>
												<b><?php esc_html_e( 'Total Price', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> :</b>
												<?php
												if ( $item->get_subtotal_tax() ) {
													$t = $item->get_subtotal() + $item->get_subtotal_tax();
												} else {
													$t = $item->get_subtotal();
												}
												echo wp_kses_post( wps_wrma_format_price( $t, $get_order_currency ) );
												?>
											</p>
										</div>
									</div>
								</td>
								<td class="product-quantity">
									<?php echo sprintf( '<input type="number" max="%s" min="1" value="%s" class="wps_wrma_cancel_product_qty form-control" name="wps_wrma_cancel_product_qty">', esc_html( $item_qty ), 1 ); ?>
								</td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
			<p class="form-row form-row-wide">
			<?php
			// After note note do something.
			do_action( 'wps_wrma_cancel_after_note' );
			?>
			</p>
			<?php
				$cancel_button_text = esc_html__( 'Cancel Product(s)', 'woocommerce-rma-for-return-refund-and-exchange' );
				$cancel_button_text =
				// cancel button text.
				apply_filters( 'wps_rma_cancel_button_text', $cancel_button_text );
			?>
		</div>
		<p class="form-row form-row-wide wps_rma_product_from_submit">
			<input type="submit" name="wps_rma_cancel_product_submit" value="<?php echo esc_html( $cancel_button_text ); ?>" class="button btn wps_rma_cancel_product_submit">
			<div class="wps_rma_return_notification"><img src="<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ); ?>/public/images/loading.gif" width="40px"></div>
		</p>
		<p class="form-row form-row-wide">
			<?php
			// Do something after submit button.
			do_action( 'wps_rma_cancel_after_submit' );
			?>
		</p>
		<div class="wps_rma_note_tag_wrapper">
			<div class="wps_rma_customer_detail">
				<?php
				wc_get_template( 'order/order-details-customer.php', array( 'order' => $order_obj ) );
				?>
			</div>				
		</div>
	</div>
		<?php
} else {
	if ( isset( $condition ) ) {
		echo wp_kses_post( $condition );
	} else {
		echo esc_html__( 'Cancel Request Can\'t make on this order', 'woocommerce-rma-for-return-refund-and-exchange' );
	}
}

/**
 * Woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
if ( 'on' === get_option( 'wps_rma_show_sidebar', 'no' ) ) {
	// Main Content.
	do_action( 'woocommerce_after_main_content' );
}

get_footer( 'shop' );
