<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://wpswings.com/
 * @since 1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */

/**
 * The admin-specific functionality of the plugin.
 * Register the settings.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */
class Wps_Rma_Setting_Extend {
	/**
	 * Extend the general setting.
	 *
	 * @param array $wps_rma_settings_general .
	 */
	public function wps_rma_general_setting_extend_set( $wps_rma_settings_general ) {
		$status                     = wc_get_order_statuses();
		$none_status                = array( 'wc-none' => 'Order Created Date' );
		$t_s                        = array_merge( $none_status, $status );
		$wps_rma_settings_general[] = array(
			'title'   => esc_html__( 'Enable Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_exchange_enable',
			'value'   => get_option( 'wps_rma_exchange_enable' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title'       => esc_html__( 'Enable Cancel', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'radio-switch',
			'id'          => 'wps_rma_cancel_enable',
			'value'       => get_option( 'wps_rma_cancel_enable' ),
			'class'       => 'wrael-radio-switch-class',
			'placeholder' => '',
			'options'     => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title'   => esc_html__( 'Enable wallet', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_wallet_enable',
			'value'   => get_option( 'wps_rma_wallet_enable' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title'   => esc_html__( 'Enable Single Refund and Exchange Request Per Order', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_single_refund_exchange',
			'value'   => get_option( 'wps_rma_single_refund_exchange' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title'   => esc_html__( 'Enable Refund & Exchange For Exchange Approved Order', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_exchange_app_check',
			'value'   => get_option( 'wps_rma_exchange_app_check' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title'   => esc_html__( 'Show Sidebar For Refund,Exchange & Cancel Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_show_sidebar',
			'value'   => get_option( 'wps_rma_show_sidebar' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title'   => esc_html__( 'Hide Refund,Exchange,Cancel Button For COD When Processing', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_hide_rec',
			'value'   => get_option( 'wps_rma_hide_rec' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title'   => esc_html__( 'Guest Feature via Phone Number', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_guest_phone',
			'value'   => get_option( 'wps_rma_guest_phone' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_general[] = array(
			'title' => esc_html__( 'Refund,Exchange,Cancel Functionality Start From Order Status Date', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'  => 'select',
			'id'    => 'wps_rma_order_status_start',
			'value' => get_option( 'wps_rma_order_status_start' ),
			'class' => 'mwr-select-class',
			'options' => $t_s,
		);
		$wps_rma_settings_general[] = array(
			'title' => esc_html__( 'Guest Form Shortcode', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'  => 'text',
			'id'    => 'wps_rma_guest_form',
			'value' => '[Wps_Rma_Guest_Form]',
			'attr'  => 'readonly',
			'class' => 'mwr-select-class',
		);
		$wps_rma_settings_general[] = array(
			'title' => esc_html__( 'Enable To Reset The License On Deactivation Of The Plugin.', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'  => 'radio-switch',
			'description'  => '',
			'id'    => 'mwr_radio_reset_license',
			'value' => get_option( 'mwr_radio_reset_license' ),
			'class' => 'mwr-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no' => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		return $wps_rma_settings_general;
	}

	/**
	 * Extend the refund setting.
	 *
	 * @param array $wps_rma_settings_refund .
	 */
	public function wps_rma_refund_setting_extend_set( $wps_rma_settings_refund ) {
		$wps_rma_settings_refund[] =
		array(
			'title'   => esc_html__( 'Enable To Refund on Sales Item', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_refund_on_sale',
			'value'   => get_option( 'wps_rma_refund_on_sale' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_refund[] = array(
			'title'   => esc_html__( 'Deduct Coupon Amount During Refund', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_refund_deduct_coupon',
			'value'   => get_option( 'wps_rma_refund_deduct_coupon' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_refund[] =
		array(
			'title'   => esc_html__( 'Enable Auto Accept Refund Request', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_refund_auto',
			'value'   => get_option( 'wps_rma_refund_auto' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_refund[] = array(
			'title'   => esc_html__( 'Enable To Block Customer Refund Request Mail', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_block_refund_req_email',
			'value'   => get_option( 'wps_rma_block_refund_req_email' ),
			'class'   => 'wrael-number-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_refund[] = array(
			'title'   => esc_html__( 'Enable To Auto Restock When Refund Request Accepted', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_auto_refund_stock',
			'value'   => get_option( 'wps_rma_auto_refund_stock' ),
			'class'   => 'wrael-number-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		return $wps_rma_settings_refund;
	}

	/**
	 * Extend the refund appearance setting.
	 *
	 * @param array $refund_app_setting_extend .
	 */
	public function wps_rma_refund_appearance_setting_extend_set( $refund_app_setting_extend ) {
		$refund_app_setting_extend[] = array(
			'title'       => esc_html__( 'Reason of Refund Placeholder', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_rma_refund_reason_placeholder',
			'value'       => get_option( 'wps_rma_refund_reason_placeholder' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Enter Reason of Refund Placeholder Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$refund_app_setting_extend[] = array(
			'title'       => esc_html__( 'Refund Request Form Shipping Fee Description', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_rma_refund_shipping_descr',
			'value'       => empty( get_option( 'wps_rma_refund_shipping_descr' ) ) ? esc_html__( 'This Extra Shipping Fee Will be Deducted from Total Amount When the Refund Request is approved', 'woocommerce-rma-for-return-refund-and-exchange' ) : get_option( 'wps_rma_refund_shipping_descr' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Change Shipping Fee Description on Refund Request Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$refund_app_setting_extend[] = array(
			'title'   => esc_html__( 'Enable Refund Note On Product Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_refund_note',
			'value'   => get_option( 'wps_rma_refund_note' ),
			'class'   => 'wrael-number-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$refund_app_setting_extend[] = array(
			'title'       => esc_html__( 'Refund Note on Product Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_rma_refund_note_text',
			'value'       => get_option( 'wps_rma_refund_note_text' ),
			'class'       => 'wrael-radio-switch-class',
			'placeholder' => 'Enter the Product Notes',
		);
		$refund_app_setting_extend[] = array(
			'title'       => esc_html__( 'Refund Form Wrapper Class', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_wrma_refund_form_wrapper_class',
			'value'       => get_option( 'wps_wrma_refund_form_wrapper_class' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Enter Refund Form Wrapper Class', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$refund_app_setting_extend[] = array(
			'title'       => esc_html__( 'Refund Form Custom CSS', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'textarea',
			'id'          => 'wps_rma_refund_form_css',
			'value'       => get_option( 'wps_rma_refund_form_css' ),
			'class'       => 'wrael-text-class',
			'rows'        => '5',
			'cols'        => '80',
			'placeholder' => esc_html__( 'Write the Refund Form CSS', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		return $refund_app_setting_extend;
	}

	/**
	 * Register the exchange setting.
	 *
	 * @param array $wps_rma_settings_exchange .
	 */
	public function wps_rma_exchange_settings_array_set( $wps_rma_settings_exchange ) {
		$button_view = array(
			'order-page' => esc_html__( 'Order Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'My account' => esc_html__( 'Order View Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'Checkout'   => esc_html__( 'Thank You Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$pages       = get_pages();
		$get_pages   = array( '' => esc_html__( 'Default', 'woocommerce-rma-for-return-refund-and-exchange' ) );
		foreach ( $pages as $page ) {
			$get_pages[ $page->ID ] = $page->post_title;
		}
		$wps_rma_settings_exchange = array(
			array(
				'title'       => esc_html__( 'Select Pages To Hide Exchange Button', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'multiselect',
				'description' => '',
				'id'          => 'wps_rma_exchange_button_pages',
				'value'       => get_option( 'wps_rma_exchange_button_pages' ),
				'class'       => 'wrael-multiselect-class wps-defaut-multiselect',
				'placeholder' => '',
				'options'     => $button_view,
			),
			array(
				'title'   => esc_html__( 'Enable Exchange Request With Same Product Or Its Variations', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_exchange_same_product',
				'value'   => get_option( 'wps_rma_exchange_same_product' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Enable to show Manage Stock Button', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_exchange_manage_stock',
				'value'   => get_option( 'wps_rma_exchange_manage_stock' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Enable Attachment', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_exchange_attachment',
				'value'   => get_option( 'wps_rma_exchange_attachment' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'       => esc_html__( 'Attachement Limit', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'number',
				'description' => esc_html__( 'By default, It will take 5. If not given any.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'id'          => 'wps_rma_exchange_attachment_limit',
				'value'       => get_option( 'wps_rma_exchange_attachment_limit' ),
				'class'       => 'wrael-number-class',
				'min'         => '0',
				'max'         => '15',
				'placeholder' => 'Enter the attachment limit',
			),
			array(
				'title'   => esc_html__( 'Enable to Exchange on Sales Item', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_exchange_on_sale',
				'value'   => get_option( 'wps_rma_exchange_on_sale' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Deduct Coupon Amount During Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_exchange_deduct_coupon',
				'value'   => get_option( 'wps_rma_exchange_deduct_coupon' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Enable To Block Customer Exchange Request Mail', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_block_exchange_req_email',
				'value'   => get_option( 'wps_rma_block_exchange_req_email' ),
				'class'   => 'wrael-number-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Enable To Auto Restock When Exchange Request Accepted', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_auto_exchange_stock',
				'value'   => get_option( 'wps_rma_auto_exchange_stock' ),
				'class'   => 'wrael-number-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Show Add-To-Cart Button', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_remove_add_to_cart',
				'value'   => get_option( 'wps_rma_remove_add_to_cart' ),
				'class'   => 'wrael-number-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
		);
		$wps_rma_settings_exchange =
		// To extend the refund setting.
		apply_filters( 'wps_rma_exchange_setting_extend', $wps_rma_settings_exchange );
		$wps_rma_settings_exchange[] = array(
			'type' => 'breaker',
			'id'   => 'Appearance',
			'name' => 'Appearance',
		);
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Exchange Button Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_rma_exchange_button_text',
			'value'       => get_option( 'wps_rma_exchange_button_text' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Enter Exchange Button Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$wps_rma_settings_exchange[] = array(
			'title'   => esc_html__( 'Enable Exchange Reason Description', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_exchange_description',
			'value'   => get_option( 'wps_rma_exchange_description' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Predefined Exchange Reason', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'textarea',
			'id'          => 'wps_rma_exchange_reasons',
			'value'       => get_option( 'wps_rma_exchange_reasons' ),
			'class'       => 'wrael-textarea-class',
			'rows'        => '2',
			'cols'        => '80',
			'placeholder' => esc_html__( 'Enter the multiple reason separated by comma', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$wps_rma_settings_exchange[] = array(
			'title'   => esc_html__( 'Enable Exchange Rules', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_exchange_rules',
			'value'   => get_option( 'wps_rma_exchange_rules' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Exchange Rules Editor', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'wp_editor',
			'id'          => 'wps_rma_exchange_rules_editor',
			'value'       => get_option( 'wps_rma_exchange_rules_editor' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Write the Refund Rules( HTML + CSS )', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		if ( function_exists( 'vc_lean_map' ) ) {
			$wps_rma_settings_exchange[] = array(
				'title'       => esc_html__( 'Select The Page To Redirect', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'select',
				'description' => '',
				'id'          => 'wps_rma_exchange_page',
				'value'       => get_option( 'wps_rma_exchange_page' ),
				'class'       => 'wrael-textarea-class',
				'options'     => $get_pages,
			);
		}
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Reason Of Exchange Placeholder', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_rma_exchange_reason_placeholder',
			'value'       => get_option( 'wps_rma_exchange_reason_placeholder' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Enter Reason of Exchange Placeholder Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Exchange Request Form Shipping Fee Description', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_rma_exchange_shipping_descr',
			'value'       => empty( get_option( 'wps_rma_exchange_shipping_descr' ) ) ? esc_html__( 'This Extra Shipping Fee Will be Deducted from Total Amount When the Exchange Request is approved', 'woocommerce-rma-for-return-refund-and-exchange' ) : get_option( 'wps_rma_exchange_shipping_descr' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Change Shipping Fee Description on Exchange Request Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$wps_rma_settings_exchange[] = array(
			'title'   => esc_html__( 'Enable Exchange Note on Product Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_exchange_note',
			'value'   => get_option( 'wps_rma_exchange_note' ),
			'class'   => 'wrael-number-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		$wps_rma_settings_exchange[] = array(
			'title'   => esc_html__( 'Exchange Note On Product Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'text',
			'id'      => 'wps_rma_exchange_note_text',
			'value'   => get_option( 'wps_rma_exchange_note_text' ),
			'class'   => 'wrael-radio-switch-class',
			'placeholder' => 'Enter the Product Notes',
		);
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Exchange With Same Product Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_rma_exchange_same_product_text',
			'value'       => empty( get_option( 'wps_rma_exchange_same_product_text' ) ) ? esc_html__( 'Click on the product(s) to exchange with selected product(s) or its variation(s).', 'woocommerce-rma-for-return-refund-and-exchange' ) : get_option( 'wps_rma_exchange_same_product_text' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Add text to display on Exchange form to Exchanging with the same product(s) and it\'s variation(s).', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Exchange Form Wrapper Class', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'text',
			'id'          => 'wps_wrma_exchange_form_wrapper_class',
			'value'       => get_option( 'wps_wrma_exchange_form_wrapper_class' ),
			'class'       => 'wrael-text-class',
			'placeholder' => esc_html__( 'Enter Exchange Form Wrapper Class', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$wps_rma_settings_exchange[] = array(
			'title'       => esc_html__( 'Exchange Form Custom CSS', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'        => 'textarea',
			'id'          => 'wps_rma_exchange_form_css',
			'value'       => get_option( 'wps_rma_exchange_form_css' ),
			'class'       => 'wrael-text-class',
			'rows'        => '5',
			'cols'        => '80',
			'placeholder' => esc_html__( 'Write the Exchange form CSS', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$wps_rma_settings_exchange   =
		// To extend Refund Apperance setting.
		apply_filters( 'wps_rma_exchange_appearance_setting_extend', $wps_rma_settings_exchange );
		$wps_rma_settings_exchange[] = array(
			'type'        => 'button',
			'id'          => 'wps_rma_save_exchange_setting',
			'button_text' => esc_html__( 'Save Setting', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'class'       => 'wrael-button-class',
		);
		return $wps_rma_settings_exchange;
	}

	/**
	 * Register the cancel setting.
	 *
	 * @param array $wps_rma_settings_cancel .
	 */
	public function wps_rma_cancel_settings_array_set( $wps_rma_settings_cancel ) {
		$button_view = array(
			'order-page' => esc_html__( 'Order Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'My account' => esc_html__( 'Order View Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'Checkout'   => esc_html__( 'Thank You Page', 'woocommerce-rma-for-return-refund-and-exchange' ),
		);
		$pages       = get_pages();
		$get_pages   = array( '' => esc_html__( 'Default', 'woocommerce-rma-for-return-refund-and-exchange' ) );
		foreach ( $pages as $page ) {
			$get_pages[ $page->ID ] = $page->post_title;
		}
		$wps_rma_settings_cancel = array(
			array(
				'title'   => esc_html__( 'Enable Cancel Order\'s Product', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_cancel_product',
				'value'   => get_option( 'wps_rma_cancel_product' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'       => esc_html__( 'Select Pages To Hide Cancel Button', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'multiselect',
				'description' => '',
				'id'          => 'wps_rma_cancel_button_pages',
				'value'       => get_option( 'wps_rma_cancel_button_pages' ),
				'class'       => 'wrael-multiselect-class wps-defaut-multiselect',
				'placeholder' => '',
				'options'     => $button_view,
			),
			array(
				'type' => 'breaker',
				'id'   => 'Appearance',
				'name' => 'Appearance',
			),
			array(
				'title'       => esc_html__( 'Cancel Order Button Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'text',
				'id'          => 'wps_rma_cancel_button_text',
				'value'       => get_option( 'wps_rma_cancel_button_text' ),
				'class'       => 'wrael-text-class',
				'placeholder' => esc_html__( 'Enter Cancel Button Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
			array(
				'title'       => esc_html__( 'Cancel Product Button Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'text',
				'id'          => 'wps_rma_cancel_prod_button_text',
				'value'       => get_option( 'wps_rma_cancel_prod_button_text' ),
				'class'       => 'wrael-text-class',
				'placeholder' => esc_html__( 'Enter Cancel Button Text', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
			array(
				'title'       => esc_html__( 'Cancel Form Wrapper Class', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'text',
				'id'          => 'wps_wrma_cancel_form_wrapper_class',
				'value'       => get_option( 'wps_wrma_cancel_form_wrapper_class' ),
				'class'       => 'wrael-text-class',
				'placeholder' => esc_html__( 'Enter Cancel Form Wrapper Class', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
			array(
				'title'       => esc_html__( 'Cancel Form Custom CSS', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'textarea',
				'id'          => 'wps_rma_cancel_form_css',
				'value'       => get_option( 'wps_rma_cancel_form_css' ),
				'class'       => 'wrael-text-class',
				'rows'        => '5',
				'cols'        => '80',
				'placeholder' => esc_html__( 'Write the Cancel form CSS', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		if ( function_exists( 'vc_lean_map' ) ) {
			$wps_rma_settings_cancel[] = array(
				'title'       => esc_html__( 'Select The Page To Redirect', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'select',
				'description' => '',
				'id'          => 'wps_rma_cancel_page',
				'value'       => get_option( 'wps_rma_cancel_page' ),
				'class'       => 'wrael-textarea-class',
				'options'     => $get_pages,
			);
		}
		$wps_rma_settings_cancel[] = array(
			'type'        => 'button',
			'id'          => 'wps_rma_save_cancel_setting',
			'button_text' => esc_html__( 'Save Setting', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'class'       => 'wrael-button-class',
		);
		return $wps_rma_settings_cancel;
	}

	/**
	 * Register the wallet setting.
	 *
	 * @param array $wps_rma_settings_wallet .
	 */
	public function wps_rma_wallet_settings_array_set( $wps_rma_settings_wallet ) {
		$wps_rma_settings_wallet = array(
			array(
				'title'       => esc_html__( 'Enable To Use Wallet System For WooCommerce Plugin', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'radio-switch',
				'id'          => 'wps_rma_wallet_plugin',
				'value'       => get_option( 'wps_rma_wallet_plugin' ),
				'description' => 'All The Wallet Amount Will Be Migrate Into Wallet System For WooCommerce Plugin For Every Users.',
				'show_link'   => true,
				'class'       => 'wrael-radio-switch-class',
				'options'     => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Enable To Select Refund Method For The Customer', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_refund_method',
				'value'   => get_option( 'wps_rma_refund_method' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'   => esc_html__( 'Cancel Order Amount to Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'    => 'radio-switch',
				'id'      => 'wps_rma_cancel_order_wallet',
				'value'   => get_option( 'wps_rma_cancel_order_wallet' ),
				'class'   => 'wrael-radio-switch-class',
				'options' => array(
					'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
				),
			),
			array(
				'title'       => esc_html__( 'Wallet Coupon Prefix', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'        => 'text',
				'id'          => 'wps_rma_wallet_prefix',
				'value'       => empty( get_option( 'wps_rma_wallet_prefix' ) ) ? 'wps' : get_option( 'wps_rma_wallet_prefix' ),
				'class'       => 'wrael-text-class',
				'placeholder' => esc_html__( 'Please Enter the Wallet Coupon Prefix', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
			array(
				'title' => esc_html__( 'Wallet Shortcode', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'type'  => 'text',
				'id'    => 'wps_rma_wallet_shorcode',
				'value' => '[Wps_Rma_Customer_Wallet]',
				'attr'  => 'readonly',
				'class' => 'wrael-text-class',
			),
			array(
				'type'        => 'button',
				'id'          => 'wps_rma_save_wallet_setting',
				'button_text' => esc_html__( 'Save Setting', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'class'       => 'wrael-button-class',
			),
		);
		return $wps_rma_settings_wallet;
	}

	/**
	 * Extend Order Message setting.
	 *
	 * @param array $order_msg_setting_array .
	 */
	public function wps_rma_order_message_setting_extend_set( $order_msg_setting_array ) {
		$order_msg_setting_array[] = array(
			'title'   => esc_html__( 'Enable To Block Mail', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'type'    => 'radio-switch',
			'id'      => 'wps_rma_order_email',
			'value'   => get_option( 'wps_rma_order_email' ),
			'class'   => 'wrael-radio-switch-class',
			'options' => array(
				'yes' => esc_html__( 'YES', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'no'  => esc_html__( 'NO', 'woocommerce-rma-for-return-refund-and-exchange' ),
			),
		);
		return $order_msg_setting_array;
	}
}
