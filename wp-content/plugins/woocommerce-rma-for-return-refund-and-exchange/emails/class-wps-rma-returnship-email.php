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
class Wps_Rma_Returnship_Email extends WC_Email {
	/**
	 * Set email defaults
	 *
	 * @since 0.1
	 */
	public function __construct() {
		// set ID, this simply needs to be a unique name.
		$this->id = 'wps_rma_returnship_email';

		// this is the title in WooCommerce Email settings.
		$this->title = 'RMA Returnship Email';
		// this is the description in WooCommerce email settings.
		$this->description = 'Admin to Customer Side Returnship Emails<h1>These are shorcodes available for the custom email</h1><br><span>{Tracking_Id},{Order_shipping_address},{siteurl},{username},{label_link},{Formatted_billing_address},{Formatted_shipping_address}</span></b>';
		// these are the default heading and subject lines that can be overridden using the settings.
		$this->heading = 'RMA Returnship Email';
		$this->subject = 'New message has been received';

		// these define the locations of the templates that this email should use, we'll just use the new order template since this email is similar.
		$this->template_html  = 'wps-rma-returnship-email-template.php';
		$this->template_plain = 'wps-rma-returnship-email-template.php';
		$this->template_base  = RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/templates/';
		$this->placeholders   = array(
			'{site_title}'       => $this->get_blogname(),
			'{message_date}' => '',
			'{order_id}' => '',
		);
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
	 */
	public function trigger( $msg, $attachment, $to, $order_id ) {
		$label_link               = get_post_meta( $order_id, 'wps_wrma_return_label_link', true );
		$wps_wrma_order_for_label = wc_get_order( $order_id );
		$wps_wrma_address         = $wps_wrma_order_for_label->get_formatted_shipping_address();
		if ( '' == $wps_wrma_address ) {
			$wps_wrma_address     = $wps_wrma_order_for_label->get_formatted_shipping_address();
		}
		$wps_wrma_shiping_address = $wps_wrma_order_for_label->get_formatted_shipping_address();
		$wps_wrma_billing_address = $wps_wrma_order_for_label->get_formatted_billing_address();
		$site_url                 = home_url();
		$billing_first_name       = $wps_wrma_order_for_label->get_billing_first_name();
		$billing_last_name        = $wps_wrma_order_for_label->get_billing_last_name();
		$full_name                = $billing_first_name . ' ' . $billing_last_name;
		if ( $to ) {
			$this->setup_locale();
			$this->receicer                                     = $to;
			$this->msg                                          = $msg;
			$this->order_id                                     = $order_id;
			$this->placeholders['{message_date}']               = gmdate( 'M d, Y' );
			$this->placeholders['{order_id}']                   = '#' . $order_id;
			$this->placeholders['{Tracking_Id}']                = '#' . $order_id;
			$this->placeholders['{Order_shipping_address}']     = $wps_wrma_address;
			$this->placeholders['{Formatted_billing_address}']  = $wps_wrma_billing_address;
			$this->placeholders['{Formatted_shipping_address}'] = $wps_wrma_shiping_address;
			$this->placeholders['{username}']                   = $full_name;
			$this->placeholders['{label_link}']                 = $label_link;
			$this->placeholders['{siteurl}']                    = $site_url;
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
		return esc_html__( 'Returnship for order {order_id} message from {message_date}', 'woocommerce-rma-for-return-refund-and-exchange' );
	}

	/**
	 * Get email heading.
	 */
	public function get_default_heading() {
		return esc_html__( 'Returnship Email', 'woocommerce-rma-for-return-refund-and-exchange' );
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
