<?php
/**
 * Exchange Request Cancel Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials/email_template
 */

$order_obj      = wc_get_order( $order_id );
$message        =
'<div class="wps_rma_refund_cancel_email>
    <div class="Order">
        <h4>Order #' . $order_id . '</h4>
    </div>
    <div class="header">
        <h2>' . esc_html__( 'Your Exchange Request is Cancelled', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h2>
    </div>';
$attachment     = array();
$customer_email = WC()->mailer()->emails['wps_rma_exchange_request_cancel_email'];
$customer_email->trigger( $message, $attachment, $order_obj->get_billing_email(), $order_id );
