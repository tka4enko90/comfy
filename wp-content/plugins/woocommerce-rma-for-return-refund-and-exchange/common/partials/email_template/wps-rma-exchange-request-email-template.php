<?php
/**
 * Partial Refund Order Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/common/partials/email_template
 */

$products = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
$subject  = '';
$reason   = '';
// $date     = date( 'd-m-Y' );
foreach ( $products as $date => $value ) {
	if ( isset( $value['subject'] ) ) {
		$subject = $value['subject'];
		$reason  = $value['reason'];
	}
}
$message            = '';
$message            = '<div class="header">
<h2>' . $subject . '</h2>
</div>
<div class="content">
<div class="reason">
    <h4>' . esc_html__( 'Reason of Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
    <p>' . $reason . '</p>
</div>
<div class="Order">
    <h4>Order #' . $order_id . '</h4>
    <h4>' . esc_html__( 'Exchanged From', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
                <th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
                <th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Price', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
            </tr>';
$order_obj          = wc_get_order( $order_id );
$get_order_currency = get_woocommerce_currency_symbol( $order_obj->get_currency() );
$requested_products = $products[ $date ]['from'];
$wps_vendor_emails = array();

if ( isset( $requested_products ) && ! empty( $requested_products ) ) {
	$total = 0;
	foreach ( $order_obj->get_items() as $item_id => $item ) {
		$product =
		// Woo Order Item Product.
		apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
		foreach ( $requested_products as $requested_product ) {
			if ( isset( $requested_product['item_id'] ) ) {
				if ( $item_id == $requested_product['item_id'] ) {
					if ( isset( $requested_product['variation_id'] ) && $requested_product['variation_id'] > 0 ) {
						$prod = wc_get_product( $requested_product['variation_id'] );

					} else {
						$prod = wc_get_product( $requested_product['product_id'] );
					}

					$subtotal = $requested_product['price'] * $requested_product['qty'];
					$total   += $subtotal;
					if ( WC()->version < '3.1.0' ) {
						$item_meta      = new WC_Order_Item_Meta( $item, $prod );
						$item_meta_html = $item_meta->display( true, true );
					} else {
						$item_meta      = new WC_Order_Item_Product( $item, $prod );
						$item_meta_html = wc_display_item_meta( $item_meta, array( 'echo' => false ) );
					}

					$message .= '<tr>
                                <td style="border: 1px solid #c7c7c7;">' . $item['name'] . '<br>';
					$message .= '<small>' . $item_meta_html . '</small>
                                <td style="border: 1px solid #c7c7c7;">' . $requested_product['qty'] . '</td>
                                <td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $requested_product['price'] * $requested_product['qty'], $get_order_currency ) . '</td>
                            </tr>';

				}
			}
		}
	}
}
$message              .= '
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
$exchanged_to_products = $products[ $date ]['to'];
$total_price           = 0;
if ( isset( $exchanged_to_products ) && ! empty( $exchanged_to_products ) ) {
	foreach ( $exchanged_to_products as $key => $exchanged_product ) {
		$variation_attributes = array();
		if ( isset( $exchanged_product['variation_id'] ) ) {
			if ( $exchanged_product['variation_id'] ) {
				$variation_product    = new WC_Product_Variation( $exchanged_product['variation_id'] );
				$variation_attributes = $variation_product->get_variation_attributes();
				$variation_labels     = array();
				foreach ( $variation_attributes as $label => $value ) {
					if ( is_null( $value ) || '' == $value ) {
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

		$pro_price    = $exchanged_product['qty'] * $exchanged_product['price'];
		$total_price += $pro_price;
		$product      = new WC_Product( $exchanged_product['id'] );
		$title1       = '';
		if ( isset( $exchanged_product['p_id'] ) ) {
			$title1 .= $grouped_product_title . ' -> ';
		}
		$title1 .= $product->get_title();

		if ( isset( $variation_attributes ) && ! empty( $variation_attributes ) ) {
			$title1 .= wc_get_formatted_variation( $variation_attributes );
		}
		$message .= '<tr>
                        <td style="border: 1px solid #c7c7c7;">' . $title1 . '</td>
                        <td style="border: 1px solid #c7c7c7;">' . $exchanged_product['qty'] . '</td>
                        <td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $pro_price, $get_order_currency ) . '</td>
                    </tr>';
	}
}
$message         .= '<tr>
                <th colspan="2" style="border: 1px solid #c7c7c7;">' . esc_html__( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ) . ':</th>
                <td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $total_price, $get_order_currency ) . '</td>
            </tr></tbody>
    </table>';
$wps_shipping_fee = get_post_meta( $order_id, 'ex_ship_amount', true );
if ( ! empty( $wps_shipping_fee ) ) {
	$message .= '<h4>' . esc_html__( 'Extra Shipping Charges', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
	<table style="width: 100%; border-collapse: collapse;">
					<tbody>
						<tr>
							<th colspan="2" style="border: 1px solid #c7c7c7;">' . esc_html__( 'Shipping', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
							<th style="border: 1px solid #c7c7c7;">' . esc_html__( 'Charge', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
						</tr>';
	foreach ( $wps_shipping_fee as $name_key => $name_value ) {
		$message .= ' <tr>
					<th colspan="2" style="border: 1px solid #c7c7c7;;">' . $name_key . ':</th>
					<td style="border: 1px solid #c7c7c7;">' . wps_wrma_format_price( $name_value, $get_order_currency ) . '</td>
					</tr>';
	}
	$message .= '</tbody></table>';
}
if ( $total_price - $total > 0 ) {
	$extra_amount = $total_price - $total;
	$message     .= '<h2 style="margin-top: 20px;">' . esc_html__( 'Extra Amount', 'woocommerce-rma-for-return-refund-and-exchange' ) . ' : ' . wps_wrma_format_price( $extra_amount, $get_order_currency ) . '</h2>';
}
$message       .= ' <div class="customer-detail">
                    <h4>' . esc_html__( 'Customer details', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h4>
                    <ul>
                        <li><p class="info">
                                <span class="bold">' . esc_html__( 'Email', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </span>' . get_post_meta( $order_id, '_billing_email', true ) . '
                            </p></li>
                        <li><p class="info">
                                <span class="bold">' . esc_html__( 'Tel', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </span>' . get_post_meta( $order_id, '_billing_phone', true ) . '
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
$to             = get_option( 'woocommerce_email_from_address', get_option( 'admin_email' ) );
$admin_email    = WC()->mailer()->emails['wps_rma_exchange_request_email'];
$restrict_mail1 = apply_filters( 'wps_rma_restrict_exchange_request_user_mail', false );
$restrict_mail2 = apply_filters( 'wps_rma_restrict_exchange_request_admin_mail', false );
if ( ! $restrict_mail2 ) {
	$admin_email->trigger( $message, $attachment, $to, $order_id );
}
if ( ! $restrict_mail1 ) {
	$admin_email->trigger( $message, $attachment, $order_obj->get_billing_email(), $order_id );
}
