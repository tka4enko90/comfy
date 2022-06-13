<?php
/**
 * Refund Amount template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials/email_template
 */

$order_obj          = wc_get_order( $orderid );
$get_order_currency = get_woocommerce_currency_symbol( $order_obj->get_currency() );
$message            = '<div>After the exchange. The amount ' . $get_order_currency . $refund_amount . ' is refunded into the wallet for the order #' . $orderid . '</div>';

$attachment     = array();
$customer_email = WC()->mailer()->emails['wps_rma_refund_email'];
$customer_email->trigger( $message, $attachment, $order_obj->get_billing_email(), $orderid, $refund_amount );
