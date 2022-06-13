<?php
/**
 * Exchange Request Accept Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials/email_template
 */

$exchange_details = get_post_meta( $orderid, 'wps_wrma_exchange_product', true );
$updated_amo      = get_post_meta( $orderid, 'ex_left_amount', true );
$total            = 0;
if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
	foreach ( $exchange_details as $date => $exchange_detail ) {
		$do_nothing = '';
	}
}
$html_content =
'<div class="header">
	<h2>' . esc_html__( 'Your Exchange Request is Accepted.', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h2>
</div>
			
<div class="content">
	<div class="Order">
		<h4>' . esc_html__( 'Order ', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $orderid . '</h4>
		<h4>' . esc_html__( 'Exchanged From', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
				<table style="width: 100%; border-collapse: collapse;">
				<tbody>
					<tr>
						<th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
						<th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
						<th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Price', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
					</tr>';
	$order_obj              = wc_get_order( $orderid );
	$get_order_currency = get_woocommerce_currency_symbol( $order_obj->get_currency() );
	$requested_products = $exchange_details[ $date ]['from'];

if ( isset( $requested_products ) && ! empty( $requested_products ) ) {
	foreach ( $order_obj->get_items() as $item_id => $item ) {
		$product =
		// Woo Order Item Product.
		apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
		foreach ( $requested_products as $requested_product ) {
			if ( $item_id == $requested_product['item_id'] ) {
				if ( isset( $requested_product['variation_id'] ) && $requested_product['variation_id'] > 0 ) {
					$requested_product_obj = wc_get_product( $requested_product['variation_id'] );
				} else {
					$requested_product_obj = wc_get_product( $requested_product['product_id'] );
				}
				$subtotal = $requested_product['price'] * $requested_product['qty'];
				$total   += $subtotal;
				if ( WC()->version < '3.1.0' ) {
					$item_meta      = new WC_Order_Item_Meta( $item, $product );
					$item_meta_html = $item_meta->display( true, true );
				} else {
					$item_meta      = new WC_Order_Item_Product( $item, $product );
					$item_meta_html = wc_display_item_meta( $item_meta, array( 'echo' => false ) );
				}
				$html_content .= '<tr><td style="border: 1px solid #c7c7c7;">' . $item['name'] . '<br>';
				$html_content .= '<small>' . $item_meta_html . '</small><td style="border: 1px solid #c7c7c7;">' . $requested_product['qty'] . '</td><td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $requested_product['price'] * $requested_product['qty'], $get_order_currency ) . '</td></tr>';
			}
		}
	}
}
	$html_content .= '
				<tr>
					<th colspan="2" style="border: 1px solid #c7c7c7;">' . esc_html__( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ) . ':</th>
					<td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $total, $get_order_currency ) . '</td>
				</tr>
			</tbody>
		</table>
		<h4>' . esc_html__( 'Exchanged To', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
		<table style="width: 100%; border-collapse: collapse;">
			<tbody>
				<tr>
					<th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
					<th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
					<th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Price', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
				</tr>';

			$exchanged_to_products = $exchange_details[ $date ]['to'];

			$total_price = 0;
if ( isset( $exchanged_to_products ) && ! empty( $exchanged_to_products ) ) {
	foreach ( $exchanged_to_products as $key => $exchanged_product ) {
		$variation_attributes = array();
		if ( isset( $exchanged_product['variation_id'] ) ) {
			if ( $exchanged_product['variation_id'] ) {
				$variation_product    = new WC_Product_Variation( $exchanged_product['variation_id'] );
				$variation_attributes = $variation_product->get_variation_attributes();
				$variation_labels     = array();
				foreach ( $variation_attributes as $label => $value ) {
					if ( is_null( $value ) || '' === $value ) {
						$variation_labels[] = $label;
					}
				}

				if ( isset( $exchanged_product['variations'] ) && ! empty( $exchanged_product['variations'] ) ) {
					$variation_attributes = $exchanged_product['variations'];
				}
			}
		}

		if ( isset( $exchanged_product['p_id'] ) ) {
			if ( $exchanged_product['p_id'] ) {
				$grouped_product       = new WC_Product_Grouped( $exchanged_product['p_id'] );
				$grouped_product_title = $grouped_product->get_title();
			}
		}

		if ( isset( $exchanged_product['variation_id'] ) ) {

			$product = wc_get_product( $exchanged_product['variation_id'] );
		} else {
			$product = wc_get_product( $exchanged_product['id'] );
		}
		$pro_price    = $exchanged_product['qty'] * $exchanged_product['price'];
		$total_price += $pro_price;
		$title1       = '';
		if ( isset( $exchanged_product['p_id'] ) ) {
			$title1 .= $grouped_product_title . ' -> ';
		}
		$title1 .= $product->get_title();

		if ( isset( $variation_attributes ) && ! empty( $variation_attributes ) ) {
			$title1 .= wc_get_formatted_variation( $variation_attributes );
		}

		$html_content .= '<tr>
							<td style="border: 1px solid #c7c7c7;">' . $title1 . '</td>
							<td style="border: 1px solid #c7c7c7;">' . $exchanged_product['qty'] . '</td>
							<td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $pro_price, $get_order_currency ) . '</td>
						</tr>';

	}
}

	$html_content .= '<tr>
					<th colspan="2" style="border: 1px solid #c7c7c7;">' . esc_html__( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ) . ':</th>
					<td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $total_price, $get_order_currency ) . '</td>
					</tr>';

$wps_shipping_fee = get_post_meta( $orderid, 'ex_ship_amount', true );
$total1           = 0;
if ( ! empty( $wps_shipping_fee ) ) {
	foreach ( $wps_shipping_fee as $name_key => $name_value ) {
		$total1       += $name_value;
		$html_content .= ' <tr>
							<th colspan="2" style="border: 1px solid #c7c7c7;;">' . $name_key . ':</th>
							<td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $name_value, $get_order_currency ) . '</td>
							</tr>';
	}
}
$html_content .= '</tbody></table></div>';
$orders        = wc_get_order( $order_id );
$extra_amount  = $total_price - $total;
$wps_dis_tot   = 0;
if ( $extra_amount >= 0 ) {
	if ( $total1 > 0 ) {
		$html_content .= '<h2 style="margin-top: 20px;">' . esc_html__( 'Extra Amount Need to Pay:', 'woocommerce-rma-for-return-refund-and-exchange' ) . wps_wrma_format_price( $extra_amount + $total1, $get_order_currency ) . '</h2>
							<a href=' . $orders->get_checkout_payment_url() . '>' . esc_html__( 'Click here to Pay', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</a>';
	} else {
		$html_content .= '<h2>' . esc_html__( 'Extra Amount Need to Pay:', 'woocommerce-rma-for-return-refund-and-exchange' ) . wps_wrma_format_price( $extra_amount, $get_order_currency ) . '</h2>
					<a href=' . $orders->get_checkout_payment_url() . '>' . esc_html__( 'Click here to Pay', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</a>';
	}
} else {

	if ( $total1 > 0 ) {
		$html_content .= '<h2><i>' . esc_html__( 'Left Amount After Exchange:', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</i> ' . wps_wrma_format_price( $updated_amo, $get_order_currency ) . '</h2>';
		$left_amount   = $updated_amo;
		update_post_meta( $orderid, 'wps_wrma_left_amount', $left_amount );

	} else {
		if ( $wps_dis_tot > $total_price ) {
			$total_price = 0;
		} else {
			$total_price = $total_price - $wps_dis_tot;
		}
		$left_amount = $total - $total_price;
		update_post_meta( $orderid, 'wps_wrma_left_amount', $left_amount );

		$html_content .= '<h2><i>' . esc_html__( 'Left Amount After Exchange:', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</i> ' . wps_wrma_format_price( $left_amount, $get_order_currency ) . '</h2>';
	}
}

			$new_url = $orders->get_checkout_order_received_url();


			$html_content .= '<div><b>' . esc_html__( 'Your new order id is: #', 'woocommerce-rma-for-return-refund-and-exchange' ) . $order_id . '</b></div>';
			$html_content .= '<a href=' . $new_url . '>' . esc_html__( 'Click here to View Order Received', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</a>';

			$html_content .= ' <div class="Customer-detail">
							<h4>' . esc_html__( 'Customer details', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
							<ul>
								<li><p class="info">
										<span class="bold">' . esc_html__( 'Email', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </span>' . get_post_meta( $orderid, '_billing_email', true ) . '
									</p></li>
								<li><p class="info">
										<span class="bold">' . esc_html__( 'Tel', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </span>' . get_post_meta( $orderid, '_billing_phone', true ) . '
									</p></li>
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
$customer_email = WC()->mailer()->emails['wps_rma_exchange_request_accept_email'];
$restrict_mail  = apply_filters( 'wps_rma_restrict_exchange_request_accept_mail', false );
if ( ! $restrict_mail ) {
	$customer_email->trigger( $html_content, $attachment, $order_obj->get_billing_email(), $order_id, $orderid );
}
