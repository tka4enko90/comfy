<?php
/**
 * Partial Refund Order Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/common/partials/email_template
 */

$msg = '<div class="order"><h2>' . esc_html__( 'Order', 'woocommerce-rma-for-return-refund-and-exchange' ) . ' #' . $order_id . ' ' . esc_html__( 'Cancelled by the Customer', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</h2></div>';

$attachment    = array();
$to            = get_option( 'woocommerce_email_from_address', get_option( 'admin_email' ) );
$admin_email   = WC()->mailer()->emails['wps_rma_cancel_request_email'];
$restrict_mail = apply_filters( 'wps_rma_restrict_cancel_request_mail', false );
if ( ! $restrict_mail ) {
	$admin_email->trigger( $msg, $attachment, $to, $order_id );
}
