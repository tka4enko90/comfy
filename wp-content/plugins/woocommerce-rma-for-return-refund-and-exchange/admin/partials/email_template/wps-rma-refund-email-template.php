<?php
/**
 * Partial Refund Order Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials/email_template
 */

$products              = get_post_meta( $orderid, 'wps_rma_return_product', true );
$payment_method_tittle = get_post_meta( $orderid, '_payment_method_title', true );
if ( isset( $products ) && ! empty( $products ) ) {
	foreach ( $products as $date => $product ) {
		if ( 'complete' === $product['status'] ) {
			$product_datas = $product['products'];
			break;
		}
	}
}
$to = get_post_meta( $orderid, '_billing_email', true );

$subject = esc_html__( 'Your order has been refunded', 'woocommerce-rma-for-return-refund-and-exchange' );


$message = '<div class="header">
<h2>' . esc_html__( 'Refund: Order ', 'woocommerce-rma-for-return-refund-and-exchange' ) . $orderid . '</h2>
</div>
<div class="content">
	<div>' . esc_html__( 'Your order has been refunded. There are more details below for your reference:', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</div>
<div class="Order">
<h4>' . esc_html__( 'Order ', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $orderid . '</h4>
<table width="100%" style="border-collapse: collapse;">
<tbody>
<tr>
<th style="border: 1px solid #C7C7C7;">' . esc_html__( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
<th style="border: 1px solid #C7C7C7;">' . esc_html__( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
<th style="border: 1px solid #C7C7C7;">' . esc_html__( 'Price', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
</tr>';
$order_obj          = wc_get_order( $orderid );
$requested_products = $products[ $date ]['products'];
$get_order_currency = get_woocommerce_currency_symbol( $order_obj->get_currency() );
if ( isset( $requested_products ) && ! empty( $requested_products ) ) {
	$total         = 0;
	$wps_get_refnd = get_post_meta( $orderid, 'wps_wrma_return_product', true );

	if ( ! empty( $wps_get_refnd ) ) {
		foreach ( $wps_get_refnd as $key => $value ) {
			if ( isset( $value['amount'] ) ) {
				$total_price = $value['amount'];
				break;
			}
		}
	}
	$item_ids = array();
	foreach ( $order_obj->get_items() as $item_id => $item ) {
		$product =
		// Woo Order Item Product.
		apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
		foreach ( $requested_products as $requested_product ) {
			if ( $item_id == $requested_product['item_id'] ) {
				$item_ids[] = $item_id;
				if ( isset( $requested_product['variation_id'] ) && $requested_product['variation_id'] > 0 ) {
					$prod = wc_get_product( $requested_product['variation_id'] );

				} else {
					$prod = wc_get_product( $requested_product['product_id'] );
				}

				$prod_price = wc_get_price_excluding_tax( $prod, array( 'qty' => 1 ) );
				$subtotal = $prod_price * $requested_product['qty'];
				$total += $subtotal;
				if ( WC()->version < '3.1.0' ) {
					$item_meta      = new WC_Order_Item_Meta( $item, $_product );
					$item_meta_html = $item_meta->display( true, true );
				} else {
					$item_meta      = new WC_Order_Item_Product( $item, $_product );
					$item_meta_html = wc_display_item_meta( $item_meta, array( 'echo' => false ) );
				}
				$message .= '<tr>
							<td style="border: 1px solid #C7C7C7;">' . $item['name'] . '<br>';
				$message .= '<small>' . $item_meta_html . '</small>
							<td style="border: 1px solid #C7C7C7;">' . $requested_product['qty'] . '</td>
							<td style="border: 1px solid #C7C7C7;">' . wps_wrma_format_price( $requested_product['price'] * $requested_product['qty'], $get_order_currency ) . '</td>
						</tr>';

			}
		}
	}
	$message .= '<tr>
					<th colspan="2" style="border: 1px solid #C7C7C7;">Total:</th>
					<td style="border: 1px solid #C7C7C7;">' . wps_wrma_format_price( $total, $get_order_currency ) . '</td>
				</tr>';

}
if ( WC()->version < '3.0.0' ) {
	$order_id = $order_obj->id;
} else {
	$order_id = $order_obj->get_id();
}

$added_fees = get_option( 'wps_wrma_shipping_global_data', array() );
$wps_fee_cost = get_post_meta( $order_id, 'ship_amount', true );
$wps_fee_name = isset( $added_fees['fee_name'] ) ? $added_fees['fee_name'] : array();
$global_shipping = global_shipping_charges( $orderid, $item_ids );
if ( $global_shipping ) {
	foreach ( $wps_fee_name as $name_key => $name_value ) {
		if ( ! empty( $name_value ) && ! empty( $wps_fee_cost[ $name_key ] ) ) {
			$message .= ' <tr>
			<th colspan="2" style="border: 1px solid #C7C7C7;">' . $name_value . ':</th>
			<td style="border: 1px solid #C7C7C7;">' . wps_wrma_format_price( $wps_fee_cost[ $name_key ], $get_order_currency ) . '</td>
			</tr>';
		}
	}
}
if ( WC()->version < '3.0.0' ) {
	$order_id = $order_obj->id;
} else {
	$order_id = $order_obj->get_id();
}

	$message .= ' <tr>
					<th colspan="2" style="border: 1px solid #C7C7C7;">' . esc_html__( 'Payment Method', 'woocommerce-rma-for-return-refund-and-exchange' ) . ':</th>
						<td style="border: 1px solid #C7C7C7;">' . $payment_method_tittle . '</td>

					</tr>';

	$message .= ' <tr>
					<th colspan="2" style="border: 1px solid #C7C7C7;">' . esc_html__( 'Refund Amount', 'woocommerce-rma-for-return-refund-and-exchange' ) . ':</th>
						<td style="border: 1px solid #C7C7C7;">' . wps_wrma_format_price( $refund_amu, $get_order_currency ) . '</td>
					</tr>';

$message .= '</tbody>
		</table>
	</div>
	<div class="Customer-detail">
		<h4>' . esc_html__( 'Customer details', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
			<ul>
				<li>
					<p class="info">
						<span class="bold">' . esc_html__( 'Email', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </span>' . get_post_meta( $order_id, '_billing_email', true ) . '
					</p>
				</li>
				<li>
					<p class="info">
						<span class="bold">' . esc_html__( 'Tel', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </span>' . get_post_meta( $order_id, '_billing_phone', true ) . '
					</p>
				</li>
			</ul>
		</div>
		<div class="details">
			<div class="Shipping-detail">
				<h4>' . esc_html__( 'Shipping Address', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
				' . $order_obj->get_formatted_shipping_address() . '
				</div>
				<div class="Billing-detail">
					<h4>' . esc_html__( 'Billing Address', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
					' . $order_obj->get_formatted_billing_address() . '
				</div>
				<div class="clear"></div>
			</div>
		</div>';
$attachment     = array();
$customer_email = WC()->mailer()->emails['wps_rma_refund_email'];
$customer_email->trigger( $message, $attachment, $order_obj->get_billing_email(), $order_id, $refund_amu );
