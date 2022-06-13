<?php
/**
 * Exit if accessed directly
 *
 * @package  woocommerce-rma-for-return-refund-and-exchange
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.

}
/**
 * A custom Expedited Order WooCommerce Email class
 *
 * @since 0.1
 * @extends \WC_Email
 */
class Wps_Rma_Exchange_Request_Accept_Email extends WC_Email {
	/**
	 * Set email defaults
	 *
	 * @since 0.1
	 */
	public function __construct() {
		// set ID, this simply needs to be a unique name.
		$this->id = 'wps_rma_exchange_request_accept_email';

		// this is the title in WooCommerce Email settings.
		$this->title = 'RMA Exchange Request Accept Email';
		// this is the description in WooCommerce email settings.
		$this->description = 'Admin to Customer Side Refund Request Accept Emails<h1>These are shorcodes available for the custom email</h1><br><span>{site_title}, {site_address}, {site_url}, {message_date},{order_id},{order_total},{billing_first_name},{billing_last_name},{billing_email},{billing_phone},{billing_country},{billing_address_1},{billing_address_2},{billing_state},{billing_postcode},{shipping_first_name},{shipping_last_name},{shipping_postcode},{shipping_country},{shipping_address_1},{shipping_address_2},{shipping_state},{shipping_postcode},{order_shipping},{payment_method_title},{refundable_amount},{new_order_id}</span></b>';
		// these are the default heading and subject lines that can be overridden using the settings.
		$this->heading = 'RMA Exchange Request Accept Email';
		$this->subject = 'New message has been received';

		// these define the locations of the templates that this email should use, we'll just use the new order template since this email is similar.
		$this->template_html  = 'wps-rma-exchange-request-accept-email-template.php';
		$this->template_plain = 'wps-rma-exchange-request-accept-email-template.php';
		$this->template_base  = RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/templates/';
		$this->placeholders   = array(
			'{site_title}'       => $this->get_blogname(),
			'{message_date}' => '',
			'{order_id}' => '',
		);
		$this->order_id = '';
		$this->to = '';
		// Call parent constructor to load any other defaults not explicity defined here.
		parent::__construct();

	}

	/**
	 * Determine if the email should actually be sent and setup email merge variables
	 *
	 * @param string $msg is message.
	 * @param array  $attachment is media attachment.
	 * @param string $to send to mail.
	 * @param array  $order_id is order.
	 * @param array  $orderid is new order id.
	 */
	public function trigger( $msg, $attachment, $to, $order_id, $orderid ) {
		$billing_first_name  = get_post_meta( $order_id, '_billing_first_name', true );
		$billing_last_name  = get_post_meta( $order_id, '_billing_last_name', true );
		$billing_email       = get_post_meta( $order_id, '_billing_email', true );
		$billing_phone       = get_post_meta( $order_id, '_billing_phone', true );
		$billing_country     = get_post_meta( $order_id, '_billing_country', true );
		$billing_address_1   = get_post_meta( $order_id, '_billing_address_1', true );
		$billing_address_2   = get_post_meta( $order_id, '_billing_address_2', true );
		$billing_state       = get_post_meta( $order_id, '_billing_state', true );
		$billing_postcode    = get_post_meta( $order_id, '_billing_postcode', true );
		$shipping_first_name = get_post_meta( $order_id, '_shipping_first_name', true );
		$shipping_last_name  = get_post_meta( $order_id, '_shipping_last_name', true );
		$shipping_company    = get_post_meta( $order_id, '_shipping_company', true );
		$shipping_country    = get_post_meta( $order_id, '_shipping_country', true );
		$shipping_address_1  = get_post_meta( $order_id, '_shipping_address_1', true );
		$shipping_address_2  = get_post_meta( $order_id, '_shipping_address_2', true );
		$shipping_state      = get_post_meta( $order_id, '_shipping_state', true );
		$shipping_postcode   = get_post_meta( $order_id, '_shipping_postcode', true );
		$payment_method_title = get_post_meta( $order_id, '_payment_method_title', true );
		$order_shipping     = get_post_meta( $order_id, '_order_shipping', true );
		$order_total        = get_post_meta( $order_id, '_order_total', true );
		$refundable_amount  = get_post_meta( $order_id, 'refundable_amount', true );
		if ( $to ) {
			$this->setup_locale();
			$this->receicer                       = $to;
			$this->msg                            = $msg;
			$this->placeholders['{message_date}'] = gmdate( 'M d, Y' );
			$this->placeholders['{order_id}']     = '#' . $order_id;
			$this->placeholders['{order_total}']     = $order_total;
			$this->placeholders['{billing_first_name}']     = $billing_first_name;
			$this->placeholders['{billing_last_name}']     = $billing_last_name;
			$this->placeholders['{billing_email}']     = $billing_email;
			$this->placeholders['{billing_phone}']     = $billing_phone;
			$this->placeholders['{billing_country}']     = $billing_country;
			$this->placeholders['{billing_address_1}']     = $billing_address_1;
			$this->placeholders['{billing_address_2}']     = $billing_address_2;
			$this->placeholders['{billing_state}']     = $billing_state;
			$this->placeholders['{billing_postcode}']     = $billing_postcode;
			$this->placeholders['{shipping_first_name}']     = $shipping_first_name;
			$this->placeholders['{shipping_last_name}']     = $shipping_last_name;
			$this->placeholders['{shipping_postcode}']     = $shipping_company;
			$this->placeholders['{shipping_country}']     = $shipping_country;
			$this->placeholders['{shipping_address_1}']     = $shipping_address_1;
			$this->placeholders['{shipping_address_2}']     = $shipping_address_2;
			$this->placeholders['{shipping_state}']     = $shipping_state;
			$this->placeholders['{shipping_postcode}']     = $shipping_postcode;
			$this->placeholders['{order_shipping}']     = $order_shipping;
			$this->placeholders['{payment_method_title}']     = $payment_method_title;
			$this->placeholders['{refundable_amount}']     = $refundable_amount;
			$this->placeholders['{new_order_id}']     = $orderid;
			$this->send( $this->receicer, $this->get_subject(), $this->get_content(), $this->get_headers(), $attachment );
		}
		$this->restore_locale();
	}

	/**
	 * Get_content_html function.
	 *
	 * @return string
	 */
	public function get_content_html() {
		ob_start();
		wc_get_template(
			$this->template_html,
			array(
				'msg' => $this->msg,
				'order_id' => $this->order_id,
				'to' => $this->to,
				'email_heading'  => $this->get_heading(),
				'sent_to_admin'  => false,
				'plain_text'     => false,
				'email'          => $this,
				'additional_content' => $this->get_additional_content(),
			),
			'',
			$this->template_base
		);

		return ob_get_clean();
	}

	/**
	 * Get email subject.
	 */
	public function get_default_subject() {
		return esc_html__( 'Exchange Reuqest Accept for order {order_id} message from {message_date}', 'woocommerce-rma-for-return-refund-and-exchange' );
	}

	/**
	 * Get email heading.
	 */
	public function get_default_heading() {
		return esc_html__( 'Exchange Request Accept Email', 'woocommerce-rma-for-return-refund-and-exchange' );
	}

	/**
	 * Get_content_plain function.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		ob_start();
		wc_get_template(
			$this->template_plain,
			array(
				'msg' => $this->msg,
				'order_id' => $this->order_id,
				'to' => $this->to,
				'email_heading'  => $this->get_heading(),
				'sent_to_admin'  => false,
				'plain_text'     => true,
				'email'          => $this,
				'additional_content' => $this->get_additional_content(),
			),
			'',
			$this->template_base
		);
		return ob_get_clean();
	}

	/**
	 * Initialize Settings Form Fields
	 */
	public function init_form_fields() {
		// translators: %s: list of placeholders.
		$placeholder_text  = sprintf( esc_html__( 'Available placeholders: %s', 'woocommerce-rma-for-return-refund-and-exchange' ), '<code>' . esc_html( implode( '</code>, <code>', array_keys( $this->placeholders ) ) ) . '</code>' );
		$this->form_fields = array(
			'enabled'    => array(
				'title'   => 'Enable/Disable',
				'type'    => 'checkbox',
				'label'   => 'Enable this email notification',
				'default' => 'yes',
			),
			'subject'    => array(
				'title'       => esc_html__( 'Subject', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'text',
				'desc_tip'    => true,
				'description' => $placeholder_text,
				'placeholder' => $this->get_default_subject(),
				'default'     => '',
			),
			'heading'    => array(
				'title'       => esc_html__( 'Heading', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'text',
				'desc_tip'    => true,
				'description' => $placeholder_text,
				'placeholder' => $this->get_default_heading(),
				'default'     => '',
			),
			'additional_content' => array(
				'title'       => esc_html__( 'Custom Email', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'description' => esc_html__( 'If N/A then default email will send.', 'woocommerce-rma-for-return-refund-and-exchange' ) . ' ' . $placeholder_text,
				'css'         => 'width:400px; height: 75px;',
				'placeholder' => esc_html__( 'N/A', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'textarea',
				'default'     => $this->get_default_additional_content(),
				'desc_tip'    => true,
			),
			'email_type' => array(
				'title'       => 'Email type',
				'type'        => 'select',
				'description' => 'Choose which format of email to send.',
				'default'     => 'html',
				'class'       => 'email_type',
				'options'     => array(
					'plain'     => esc_html__( 'Plain text', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'html'      => esc_html__( 'HTML', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'multipart' => esc_html__( 'Multipart', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
		);
	}

} // end \WPS_Rma_Order_Messages_Email class
