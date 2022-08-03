<?php
/**
 * Partial Refund Order Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/common/partials/email_template
 */

$order_obj = wc_get_order( $order_id );
$items     = $order_obj->get_items();
$message   = '';
$message  .= '<div class="order">
                <h2>' . esc_html__( 'Product(s) cancelled by the customer of the order #', 'woocommerce-rma-for-return-refund-and-exchange' ) . $order_id .
				'</h2><table width="100%" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #C7C7C7;">' . esc_html__( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
                            <th style="border: 1px solid #C7C7C7;">' . esc_html__( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
                            <th style="border: 1px solid #C7C7C7;">' . esc_html__( 'Price', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</th>
                        </tr>
                    </thead>
                    <tbody>';
foreach ( $items as $item_id => $item ) {
	foreach ( $item_ids as $item_detail ) {
		if ( $item_id == $item_detail[0] ) {
			$product_name = $item['name'];
			$product_id = $item['product_id'];
			$product_variation_id = $item['variation_id'];
			if ( $product_variation_id > 0 ) {
				$product = wc_get_product( $product_variation_id );
			} else {
				$product = wc_get_product( $product_id );
			}
			if ( WC()->version < '3.1.0' ) {
				$item_meta      = new WC_Order_Item_Meta( $item, $_product );
				$item_meta_html = $item_meta->display( true, true );
			} else {
				$item_meta      = new WC_Order_Item_Product( $item, $_product );
				$item_meta_html = wc_display_item_meta( $item_meta, array( 'echo' => false ) );
			}

			$message .= '<tr><td style="border: 1px solid #C7C7C7;">' . $item['name'] . '<br>';
			$message .= '<small>' . $item_meta_html . '</small>
                                            <td style="border: 1px solid #C7C7C7;">' . $item_detail[1] . '</td>
                                            <td style="border: 1px solid #C7C7C7;">' . wc_price( $item_detail[1] * wc_get_price_to_display( $product ) ) . '</td>
                                        </tr>';
		}
	}
}

$message .= '</tbody></table></div>';
$attachment    = array();
$to            = get_option( 'woocommerce_email_from_address', get_option( 'admin_email' ) );
$admin_email   = WC()->mailer()->emails['wps_rma_cancel_request_email'];
$restrict_mail = apply_filters( 'wps_rma_restrict_cancel_request_mail', false );
if ( ! $restrict_mail ) {
	$admin_email->trigger( $message, $attachment, $to, $order_id );
}
