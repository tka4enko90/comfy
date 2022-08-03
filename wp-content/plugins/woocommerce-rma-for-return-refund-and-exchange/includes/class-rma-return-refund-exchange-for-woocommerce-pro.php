<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  https://wpswings.com/
 * @since 1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/includes
 */
class Rma_Return_Refund_Exchange_For_Woocommerce_Pro {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 1.0.0
	 * @var   Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $mwr_onboard    To initializsed the object of class onboard.
	 */
	protected $mwr_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area,
	 * the public-facing side of the site and common side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if ( defined( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_VERSION' ) ) {
			$this->version = RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'rma-return-refund-exchange-for-woocommerce-pro';

		$this->rma_return_refund_exchange_for_woocommerce_pro_dependencies();
		$this->rma_return_refund_exchange_for_woocommerce_pro_locale();
		if ( is_admin() ) {
			$this->rma_return_refund_exchange_for_woocommerce_pro_admin_hooks();
		} else {
			$this->rma_return_refund_exchange_for_woocommerce_pro_public_hooks();
		}
		$this->rma_return_refund_exchange_for_woocommerce_pro_common_hooks();

		$this->rma_return_refund_exchange_for_woocommerce_pro_api_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Loader. Orchestrates the hooks of the plugin.
	 * - Rma_Return_Refund_Exchange_For_Woocommerce_Pro_i18n. Defines internationalization functionality.
	 * - Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Admin. Defines all hooks for the admin area.
	 * - Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common. Defines all hooks for the common area.
	 * - Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 1.0.0
	 */
	private function rma_return_refund_exchange_for_woocommerce_pro_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rma-return-refund-exchange-for-woocommerce-pro-admin.php';

		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-rma-return-refund-exchange-for-woocommerce-pro-public.php';

		}

		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'package/rest-api/class-rma-return-refund-exchange-for-woocommerce-pro-rest-api.php';

		/**
		 * This class responsible for defining common functionality
		 * of the plugin.
		 */
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-rma-return-refund-exchange-for-woocommerce-pro-common.php';

		$this->loader = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Rma_Return_Refund_Exchange_For_Woocommerce_Pro_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since 1.0.0
	 */
	private function rma_return_refund_exchange_for_woocommerce_pro_locale() {

		$plugin_i18n = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Define the name of the hook to save admin notices for this plugin.
	 *
	 * @since 1.0.0
	 */
	private function wps_saved_notice_hook_name() {
		$wps_plugin_name                            = ! empty( explode( '/', plugin_basename( __FILE__ ) ) ) ? explode( '/', plugin_basename( __FILE__ ) ) [0] : '';
		$wps_plugin_settings_saved_notice_hook_name = $wps_plugin_name . '_settings_saved_notice';
		return $wps_plugin_settings_saved_notice_hook_name;
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function rma_return_refund_exchange_for_woocommerce_pro_admin_hooks() {
		$mwr_plugin_admin = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Admin( $this->mwr_get_plugin_name(), $this->mwr_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $mwr_plugin_admin, 'mwr_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $mwr_plugin_admin, 'mwr_admin_enqueue_scripts' );
		// License validation.

		$this->loader->add_action( 'wp_ajax_wps_mwr_validate_license_key', $mwr_plugin_admin, 'wps_mwr_validate_license_key' );
		// Hooks extend in org .
		$this->loader->add_filter( 'wrael_developer_admin_hooks_array', $mwr_plugin_admin, 'wrael_developer_admin_hooks_array_callback', 15 );
		$this->loader->add_filter( 'wrael_developer_public_hooks_array', $mwr_plugin_admin, 'wrael_developer_public_hooks_array_callback', 15 );
		// Add tabs in the org plugin .
		$this->loader->add_filter( 'wps_rma_plugin_standard_admin_settings_tabs', $mwr_plugin_admin, 'wps_rma_plugin_standard_admin_settings_tabs', 10 );

		// Show license info in the RMA org dashboard.
		$this->loader->add_action( 'wps_rma_show_license_info', $mwr_plugin_admin, 'wps_rma_show_license_info' );

		// Saving tab settings.
		$this->loader->add_action( 'wps_mwr_settings_saved_notice', $mwr_plugin_admin, 'mwr_admin_save_tab_settings' );
		$this->loader->add_action( 'wps_rma_settings_saved_notice', $mwr_plugin_admin, 'mwr_admin_save_tab_settings' );
		// License variables.

		$callname_lic_initial = self::$lic_ini_callback_function;
		$day_count            = self::$callname_lic_initial();
		if ( get_option( 'wps_mwr_license_check', 0 ) || $day_count > 0 ) {
			// Setting addon in the lite start.
			$this->loader->add_filter( 'wps_rma_plugin_admin_settings_tabs_addon_before', $mwr_plugin_admin, 'wps_rma_plugin_admin_settings_tabs_addon_before', 10 );
			$this->loader->add_filter( 'wps_rma_plugin_admin_settings_tabs_addon_after', $mwr_plugin_admin, 'wps_rma_plugin_admin_settings_tabs_addon_after', 10 );

			$this->loader->add_filter( 'wps_rma_refund_setting_extend', $mwr_plugin_admin, 'wps_rma_refund_setting_extend', 10 );

			$this->loader->add_filter( 'wps_rma_exchange_settings_array', $mwr_plugin_admin, 'wps_rma_exchange_settings_array', 10 );

			$this->loader->add_filter( 'wps_rma_general_setting_extend', $mwr_plugin_admin, 'wps_rma_general_setting_extend', 10 );

			$this->loader->add_filter( 'wps_rma_cancel_settings_array', $mwr_plugin_admin, 'wps_rma_cancel_settings_array', 10 );

			$this->loader->add_filter( 'wps_rma_wallet_settings_array', $mwr_plugin_admin, 'wps_rma_wallet_settings_array', 10 );

			$this->loader->add_filter( 'wps_rma_refund_appearance_setting_extend', $mwr_plugin_admin, 'wps_rma_refund_appearance_setting_extend', 10 );

			$this->loader->add_filter( 'wps_rma_order_message_setting_extend', $mwr_plugin_admin, 'wps_rma_order_message_setting_extend', 10 );

			$this->loader->add_action( 'wps_rma_setting_extend_column1', $mwr_plugin_admin, 'wps_rma_setting_extend_column1', 10 );
			$this->loader->add_action( 'wps_rma_setting_extend_show_column1', $mwr_plugin_admin, 'wps_rma_setting_extend_show_column1' );
			$this->loader->add_action( 'wps_rma_setting_extend_show_column3', $mwr_plugin_admin, 'wps_rma_setting_extend_show_column3', 10 );
			$this->loader->add_action( 'wps_rma_setting_extend_column3', $mwr_plugin_admin, 'wps_rma_setting_extend_column3' );
			$this->loader->add_action( 'wps_rma_setting_extend_column5', $mwr_plugin_admin, 'wps_rma_setting_extend_column5' );
			$this->loader->add_action( 'wps_rma_setting_extend_show_column5', $mwr_plugin_admin, 'wps_rma_setting_extend_show_column5', 10, 2 );
			// Setting addon in the lite end.

			// Save global shipping setting.
			$this->loader->add_action( 'init', $mwr_plugin_admin, 'wps_wrma_save_ship_setting' );

			// Add the global shipping fee the refund request meta.
			$this->loader->add_action( 'wps_rma_global_shipping_fee', $mwr_plugin_admin, 'wps_rma_global_shipping_fee' );

			// Refund Amount for Refund process.
			$this->loader->add_action( 'wps_rma_refund_price', $mwr_plugin_admin, 'wps_rma_refund_price', 10, 1 );

			// RMA Wallet related functionality start.
			$wallet_enable        = get_option( 'wps_rma_wallet_enable', 'no' );
			$wallet_plugin_enable = get_option( 'wps_rma_wallet_plugin', 'no' );
			if ( 'on' !== $wallet_plugin_enable && 'on' === $wallet_enable ) {
				$this->loader->add_filter( 'manage_users_columns', $mwr_plugin_admin, 'wps_rma_add_coupon_column' );
				$this->loader->add_filter( 'manage_users_custom_column', $mwr_plugin_admin, 'wps_rma_add_coupon_column_row', 10, 3 );
				$this->loader->add_action( 'edit_user_profile', $mwr_plugin_admin, 'wps_rma_add_customer_wallet_price_field' );
				$this->loader->add_action( 'show_user_profile', $mwr_plugin_admin, 'wps_rma_add_customer_wallet_price_field' );
				$this->loader->add_action( 'wp_ajax_wps_rma_change_customer_wallet_amount', $mwr_plugin_admin, 'wps_rma_change_customer_wallet_amount' );
			}
			$this->loader->add_action( 'wp_ajax_wps_rma_generate_user_wallet_code', $mwr_plugin_admin, 'wps_rma_generate_user_wallet_code' );
			// RMA Wallet related functionality send.

			// Add metabox for exchange.
			$this->loader->add_action( 'admin_menu', $mwr_plugin_admin, 'wps_wrma_product_exchange_meta_box' );

			// Save the new shipping fee.
			$this->loader->add_action( 'wp_ajax_wps_exchange_add_new_fee', $mwr_plugin_admin, 'wps_exchange_add_new_fee_callback' );

			// Modify the total refund amount for refund process.
			$this->loader->add_filter( 'wps_rma_refund_total_amount', $mwr_plugin_admin, 'wps_rma_refund_total_amount', 10, 2 );

			// Accept Exchange Request.
			$this->loader->add_action( 'wp_ajax_wps_exchange_req_approve', $mwr_plugin_admin, 'wps_exchange_req_approve' );
			$this->loader->add_action( 'woocommerce_admin_order_items_after_fees', $mwr_plugin_admin, 'wps_wrma_show_order_exchange_product' );

			// Redund amount for exchange.
			$this->loader->add_action( 'wp_ajax_wps_exchange_req_approve_refund', $mwr_plugin_admin, 'wps_exchange_req_approve_refund' );

			// cancel Exchange Request.
			$this->loader->add_filter( 'wp_ajax_wps_exchange_req_cancel', $mwr_plugin_admin, 'wps_wrma_exchange_req_cancel' );

			// Manage_stock.
			$this->loader->add_filter( 'wp_ajax_wps_wrma_manage_stock', $mwr_plugin_admin, 'wps_wrma_manage_stock' );

			// auto refund products.
			$this->loader->add_filter( 'wps_rma_auto_restock_item_refund', $mwr_plugin_admin, 'wps_rma_auto_restock_item_refund', 10, 2 );

			// Shipstation select state according to country.
			$this->loader->add_action( 'wp_ajax_wps_wrma_select_state', $mwr_plugin_admin, 'wps_wrma_select_state' );

			// ShipEngine Login and logout.
			$this->loader->add_action( 'wp_ajax_wps_wrma_validate_api_key', $mwr_plugin_admin, 'wps_wrma_validate_api_key' );
			$this->loader->add_action( 'wp_ajax_wps_wrma_logout', $mwr_plugin_admin, 'wps_wrma_logout' );

			// Shipstation return label link.
			global $save_post_flag;
			$save_post_flag = 0;
			$this->loader->add_action( 'save_post', $mwr_plugin_admin, 'wps_wrma_validate_return_label_link' );

			// ShipStation Login and logout.
			$this->loader->add_action( 'wp_ajax_wps_wrma_validate_shipstation_api_key', $mwr_plugin_admin, 'wps_wrma_validate_shipstation_api_key' );
			$this->loader->add_action( 'wp_ajax_wps_wrma_shipstation_logout', $mwr_plugin_admin, 'wps_wrma_shipstation_logout' );

			// Returnship label functionality.
			$this->loader->add_action( 'wps_rma_return_ship_attach_upload_html', $mwr_plugin_admin, 'wps_rma_return_ship_attach_upload_html' );
			$this->loader->add_action( 'post_edit_form_tag', $mwr_plugin_admin, 'wps_edit_form_tag' );
			$this->loader->add_action( 'save_post', $mwr_plugin_admin, 'wps_upload_return_label' );
			$this->loader->add_action( 'save_post', $mwr_plugin_admin, 'wps_upload_return_label_for_exchange' );

			$this->loader->add_filter( 'wps_rma_show_wfwp', $mwr_plugin_admin, 'wps_rma_show_wfwp_callback' );

			$this->loader->add_filter( 'wps_rma_policies_setting', $mwr_plugin_admin, 'wps_rma_policies_setting_callback', 10, 1 );

			$this->loader->add_action( 'after_plugin_row_woocommerce-rma-for-return-refund-and-exchange/mwb-woocommerce-rma.php', $mwr_plugin_admin, 'wps_rma_pro_upgrade_notice', 0, 3 );
		}
	}

	/**
	 * Register all of the hooks related to the common functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function rma_return_refund_exchange_for_woocommerce_pro_common_hooks() {

		$mwr_plugin_common = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common( $this->mwr_get_plugin_name(), $this->mwr_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwr_plugin_common, 'mwr_common_enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwr_plugin_common, 'mwr_common_enqueue_scripts' );
		$this->loader->add_filter( 'wps_rma_check_pro_active', $mwr_plugin_common, 'wps_rma_check_pro_active' );

		$callname_lic_initial = self::$lic_ini_callback_function;
		$day_count            = self::$callname_lic_initial();
		if ( get_option( 'wps_mwr_license_check', 0 ) || $day_count > 0 ) {
			$this->loader->add_filter( 'wps_rma_policies_functionality_extend', $mwr_plugin_common, 'wps_rma_policies_functionality_extend', 10, 4 );
			// Regnerate the wallet coupon code.
			$this->loader->add_action( 'wp_ajax_wps_rma_coupon_regenertor', $mwr_plugin_common, 'wps_rma_coupon_regenertor' );

			// Custom order status register and display.
			$this->loader->add_action( 'init', $mwr_plugin_common, 'wps_rma_register_custom_order_status' );
			$this->loader->add_filter( 'wc_order_statuses', $mwr_plugin_common, 'wps_rma_add_custom_order_status' );

			// This function is used to save selected exchange products.
			$this->loader->add_action( 'wp_ajax_wps_rma_exchange_products', $mwr_plugin_common, 'wps_rma_exchange_products_callback' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_rma_exchange_products', $mwr_plugin_common, 'wps_rma_exchange_products_callback' );

			// set the session for the exchange process.
			$this->loader->add_action( 'wp_ajax_wps_set_exchange_session', $mwr_plugin_common, 'wps_rma_set_exchange_session' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_set_exchange_session', $mwr_plugin_common, 'wps_rma_set_exchange_session' );

			// Show exchange button on the product detail page.
			$this->loader->add_action( 'woocommerce_after_add_to_cart_form', $mwr_plugin_common, 'wps_wrma_exchnaged_product_add_button' );

			// This function use to show exchange button shop page.
			$this->loader->add_action( 'woocommerce_after_shop_loop_item', $mwr_plugin_common, 'wps_rma_add_exchange_products', 8 );

			// To add the exchange product.
			$this->loader->add_action( 'wp_ajax_wps_wrma_add_to_exchange', $mwr_plugin_common, 'wps_rma_add_to_exchange_callback' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_wrma_add_to_exchange', $mwr_plugin_common, 'wps_rma_add_to_exchange_callback' );

			// To remove the exchange product.
			$this->loader->add_action( 'wp_ajax_wps_wrma_exchnaged_product_remove', $mwr_plugin_common, 'wps_wrma_exchnaged_product_remove_callback' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_wrma_exchnaged_product_remove', $mwr_plugin_common, 'wps_wrma_exchnaged_product_remove_callback' );

			// Upload the exchange related files.
			$this->loader->add_action( 'wp_ajax_wps_wrma_exchange_upload_files', $mwr_plugin_common, 'wps_wrma_order_exchange_attach_files' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_wrma_exchange_upload_files', $mwr_plugin_common, 'wps_wrma_order_exchange_attach_files' );

			// saving the exchange request.
			$this->loader->add_action( 'wp_ajax_wps_wrma_submit_exchange_request', $mwr_plugin_common, 'wps_wrma_submit_exchange_request' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_wrma_submit_exchange_request', $mwr_plugin_common, 'wps_wrma_submit_exchange_request' );

			$this->loader->add_action( 'wps_rma_do_something_on_refund', $mwr_plugin_common, 'wps_rma_do_something_on_refund', 10, 2 );

			// add custom order status for payment.
			$this->loader->add_filter( 'woocommerce_valid_order_statuses_for_payment', $mwr_plugin_common, 'wps_wrma_order_need_payment' );

			// change the order number for the new generated order after exchange approved.
			$this->loader->add_filter( 'woocommerce_order_number', $mwr_plugin_common, 'wps_wrma_update_order_number_callback' );

			// enable cancel for exchange approved order.
			$this->loader->add_filter( 'woocommerce_valid_order_statuses_for_cancel', $mwr_plugin_common, 'wps_wrma_order_can_cancel' );

			// Refund Request.
			$this->loader->add_filter( 'wps_rma_auto_accept_refund', $mwr_plugin_common, 'wps_rma_auto_accept_refund' );

			// Auto refund request accepted.
			$this->loader->add_action( 'wp_ajax_wps_rma_auto_return_req_approve', $mwr_plugin_common, 'wps_rma_auto_return_req_approve' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_rma_auto_return_req_approve', $mwr_plugin_common, 'wps_rma_auto_return_req_approve' );

			// cancel order/ order's products.
			$this->loader->add_action( 'wp_ajax_wps_rma_cancel_customer_order', $mwr_plugin_common, 'wps_rma_cancel_customer_order' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_rma_cancel_customer_order', $mwr_plugin_common, 'wps_rma_cancel_customer_order' );
			$this->loader->add_action( 'wp_ajax_wps_rma_cancel_customer_order_products', $mwr_plugin_common, 'wps_rma_cancel_customer_order_products' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_rma_cancel_customer_order_products', $mwr_plugin_common, 'wps_rma_cancel_customer_order_products' );
			$this->loader->add_action( 'wps_cancel_order_total_to_wallet', $mwr_plugin_common, 'wps_rma_woocommerce_order_status_changed', 10, 2 );

			// extend the role capabilities.
			$this->loader->add_action( 'init', $mwr_plugin_common, 'wps_rma_role_capability_extend', 15 );

			// Add the Extend RMA Email.
			$this->loader->add_filter( 'woocommerce_email_classes', $mwr_plugin_common, 'wps_rma_woocommerce_emails', 11 );

			// Send Emails.
			$this->loader->add_action( 'wps_rma_exchange_req_email', $mwr_plugin_common, 'wps_rma_exchange_req_email' );
			$this->loader->add_action( 'wps_rma_cancel_prod_email', $mwr_plugin_common, 'wps_rma_cancel_prod_email', 10, 2 );
			$this->loader->add_action( 'wps_rma_cancel_order_email', $mwr_plugin_common, 'wps_rma_cancel_order_email' );

			$this->loader->add_action( 'woocommerce_order_status_changed', $mwr_plugin_common, 'wps_rma_order_change', 99, 3 );
			$this->loader->add_action( 'wps_order_status_start_date', $mwr_plugin_common, 'wps_order_status_start_date', 10, 2 );

			// Restrict mail.
			$this->loader->add_action( 'wps_rma_restrict_refund_request_user_mail', $mwr_plugin_common, 'wps_rma_restrict_refund_request_mails' );
			$this->loader->add_action( 'wps_rma_restrict_exchange_request_user_mail', $mwr_plugin_common, 'wps_rma_restrict_exchange_request_mails' );
			$this->loader->add_action( 'wps_rma_restrict_order_msg_mails', $mwr_plugin_common, 'wps_rma_restrict_order_msg_mails' );

			$this->loader->add_filter( 'wps_rma_refund_will_made', $mwr_plugin_common, 'wps_rma_refund_will_made', 10, 2 );
			if ( function_exists( 'vc_lean_map' ) ) {
				// w-bakery compatibility.
				$this->loader->add_action( 'init', $mwr_plugin_common, 'wps_rma_map_shortocde_widget' );
				$this->loader->add_action( 'init', $mwr_plugin_common, 'wps_rma_add_wp_bakery_widgets' );
			}

			// Multisite compatibility.
			$this->loader->add_action( 'wp_initialize_site', $mwr_plugin_common, 'wps_rma_pro_plugin_on_create_blog', 900 );

			// Send Emails.
			$this->loader->add_action( 'wps_rma_exchange_req_accept_email', $mwr_plugin_common, 'wps_rma_exchange_req_accept_email', 10, 2 );
			$this->loader->add_action( 'wps_rma_exchange_req_cancel_email', $mwr_plugin_common, 'wps_rma_exchange_req_cancel_email' );
			$this->loader->add_action( 'wps_rma_ex_refund_amount_mail', $mwr_plugin_common, 'wps_rma_ex_refund_amount_mail', 10, 2 );
			$this->loader->add_action( 'wps_rma_refunded_amount_mail', $mwr_plugin_common, 'wps_rma_refunded_amount_mail', 10, 2 );

			// Wallet Gateways management.
			$this->loader->add_action( 'woocommerce_new_order_item', $mwr_plugin_common, 'wps_rma_woocommerce_order_add_coupon', 10, 3 );
			$this->loader->add_action( 'woocommerce_after_checkout_validation', $mwr_plugin_common, 'wps_rma_woocommerce_after_checkout_validation' );
			$this->loader->add_filter( 'woocommerce_available_payment_gateways', $mwr_plugin_common, 'wps_rma_woocommerce_available_payment_gateways', 5, 1 );

			$this->loader->add_action( 'wp_ajax_wps_rma_update_exchange_to_prod', $mwr_plugin_common, 'wps_rma_update_exchange_to_prod' );
			$this->loader->add_action( 'wp_ajax_nopriv_wps_rma_update_exchange_to_prod', $mwr_plugin_common, 'wps_rma_update_exchange_to_prod' );

			// Shortocde.
			$this->loader->add_filter( 'wps_rma_refund_shortcode', $mwr_plugin_common, 'wps_rma_refund_shortcode' );
			$this->loader->add_filter( 'wps_rma_shortcode_extend', $mwr_plugin_common, 'wps_rma_shortcode_extend', 10, 2 );

		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function rma_return_refund_exchange_for_woocommerce_pro_public_hooks() {

		$mwr_plugin_public = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Public( $this->mwr_get_plugin_name(), $this->mwr_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwr_plugin_public, 'mwr_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $mwr_plugin_public, 'mwr_public_enqueue_scripts' );

		// License validation.
		$callname_lic_initial = self::$lic_ini_callback_function;
		$day_count            = self::$callname_lic_initial();
		if ( get_option( 'wps_mwr_license_check', 0 ) || $day_count > 0 ) {
			// Add checkbox on the refund form.
			$this->loader->add_action( 'wps_rma_add_extra_column_refund_form', $mwr_plugin_public, 'wps_rma_add_extra_column_refund_form', 1 );
			$this->loader->add_action( 'wps_rma_add_extra_column_field_value', $mwr_plugin_public, 'wps_rma_add_extra_column_field_value', 10, 2 );
			// Add the refund metthod/Global Shipping charges on the refund request form.
			$this->loader->add_action( 'wps_rma_after_table', $mwr_plugin_public, 'wps_rma_after_table' );

			$wallet_enable        = get_option( 'wps_rma_wallet_enable', 'no' );
			$wallet_plugin_enable = get_option( 'wps_rma_wallet_plugin', 'no' );
			if ( 'on' !== $wallet_plugin_enable && 'on' === $wallet_enable ) {
				// Add the wallet on the myaccount dashboard section.
				$this->loader->add_action( 'woocommerce_after_my_account', $mwr_plugin_public, 'wps_rma_woocommerce_after_my_account' );
			}

			// Show/hide sidebar.
			$this->loader->add_filter( 'wps_rma_refund_form_sidebar', $mwr_plugin_public, 'wps_rma_refund_form_sidebar', 10 );

			// Show exchange and cancel button on the order page.
			$this->loader->add_filter( 'woocommerce_my_account_my_orders_actions', $mwr_plugin_public, 'wps_rma_exchange_cancel_button', 10, 2 );

			// Show exchange and cancel button and exchange details on the order detail page.
			$this->loader->add_action( 'woocommerce_order_details_after_order_table', $mwr_plugin_public, 'wps_rma_exchange_button_and_details' );

			// Include the templates.
			$this->loader->add_filter( 'template_include', $mwr_plugin_public, 'wps_rma_template_include' );

			// Add the pay button.
			$this->loader->add_filter( 'woocommerce_thankyou', $mwr_plugin_public, 'wps_wrma_exchange_pay_button', 10, 1 );

			// Delete cancel button for this exchange-aaprove status.
			$this->loader->add_filter( 'woocommerce_my_account_my_orders_actions', $mwr_plugin_public, 'wps_rma_remove_cancel_button', 100, 2 );

			$this->loader->add_action( 'woocommerce_product_meta_end', $mwr_plugin_public, 'wps_rma_show_note_on_product' );

			$this->loader->add_filter( 'wps_rma_change_quanity', $mwr_plugin_public, 'wps_rma_change_quanity', 10, 2 );

			$this->loader->add_action( 'woocommerce_init', $mwr_plugin_public, 'wps_rma_session_start' );

			// Add shortcodes.
			$this->loader->add_action( 'init', $mwr_plugin_public, 'wps_rma_add_shortcode' );
		}
	}

	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since 1.0.0
	 */
	private function rma_return_refund_exchange_for_woocommerce_pro_api_hooks() {

		$mwr_plugin_api = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Rest_Api( $this->mwr_get_plugin_name(), $this->mwr_get_version() );

		$this->loader->add_action( 'rest_api_init', $mwr_plugin_api, 'wps_mwr_add_endpoint' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function mwr_run() {
		$this->loader->mwr_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  1.0.0
	 * @return string    The name of the plugin.
	 */
	public function mwr_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Loader    Orchestrates the hooks of the plugin.
	 */
	public function mwr_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function mwr_get_onboard() {
		return $this->mwr_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  1.0.0
	 * @return string    The version number of the plugin.
	 */
	public function mwr_get_version() {
		return $this->version;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since 1.0.0
	 * @param string $path   path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function wps_mwr_plug_load_template( $path, $params = array() ) {
		// $mwr_file_path = RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . $path;

		if ( file_exists( $path ) ) {

			include $path;
		} else {

			/* translators: %s: file path */
			$mwr_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'woocommerce-rma-for-return-refund-and-exchange' ), $path );
			$this->wps_mwr_plug_admin_notice( $mwr_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param string $mwr_message Message to display.
	 * @param string $type        notice type, accepted values - error/update/update-nag.
	 * @since 1.0.0
	 */
	public static function wps_mwr_plug_admin_notice( $mwr_message, $type = 'error' ) {
		$mwr_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$mwr_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$mwr_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$mwr_classes .= 'notice-success is-dismissible';
				break;

			default:
				$mwr_classes .= 'notice-error is-dismissible';
		}

		$mwr_notice  = '<div class="' . esc_attr( $mwr_classes ) . '">';
		$mwr_notice .= '<p>' . esc_html( $mwr_message ) . '</p>';
		$mwr_notice .= '</div>';

		echo wp_kses_post( $mwr_notice );
	}


	/**
	 * Show WordPress and server info.
	 *
	 * @return Array $mwr_system_data       returns array of all WordPress and server related information.
	 * @since  1.0.0
	 */
	public function wps_mwr_plug_system_status() {
		global $wpdb;
		$mwr_system_status    = array();
		$mwr_wordpress_status = array();
		$mwr_system_data      = array();

		// Get the web server.
		$mwr_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$mwr_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : esc_html__( 'N/A (phpversion function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the server's IP address.
		$mwr_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$mwr_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$mwr_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : esc_html__( 'N/A (make sure exec function is enabled)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the server path.
		$mwr_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : esc_html__( 'N/A (ABSPATH constant not defined)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the OS.
		$mwr_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : esc_html__( 'N/A (php_uname function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get WordPress version.
		$mwr_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : esc_html__( 'N/A (get_bloginfo function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get and count active WordPress plugins.
		$mwr_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : esc_html__( 'N/A (get_option function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// See if this site is multisite or not.
		$mwr_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? esc_html__( 'Yes', 'woocommerce-rma-for-return-refund-and-exchange' ) : esc_html__( 'No', 'woocommerce-rma-for-return-refund-and-exchange' );

		// See if WP Debug is enabled.
		$mwr_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? esc_html__( 'Yes', 'woocommerce-rma-for-return-refund-and-exchange' ) : esc_html__( 'No', 'woocommerce-rma-for-return-refund-and-exchange' );

		// See if WP Cache is enabled.
		$mwr_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? esc_html__( 'Yes', 'woocommerce-rma-for-return-refund-and-exchange' ) : esc_html__( 'No', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the total number of WordPress users on the site.
		$mwr_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : esc_html__( 'N/A (count_users function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the number of published WordPress posts.
		$mwr_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : esc_html__( '0', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get PHP memory limit.
		$mwr_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : esc_html__( 'N/A (ini_get function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the PHP error log path.
		$mwr_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? esc_html__( 'N/A', 'woocommerce-rma-for-return-refund-and-exchange' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$mwr_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : esc_html__( 'N/A (ini_get function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get PHP max post size.
		$mwr_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : esc_html__( 'N/A (ini_get function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$mwr_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$mwr_system_status['php_architecture'] = '64-bit';
		} else {
			$mwr_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$mwr_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : esc_html__( 'N/A (gethostname function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Show the number of processes currently running on the server.
		$mwr_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : esc_html__( 'N/A (make sure exec is enabled)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the memory usage.
		$mwr_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$mwr_system_status['is_windows']        = true;
			$mwr_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : esc_html__( 'N/A (make sure exec is enabled)', 'woocommerce-rma-for-return-refund-and-exchange' );
		}

		// Get the memory limit.
		$mwr_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : esc_html__( 'N/A (ini_get function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		// Get the PHP maximum execution time.
		$mwr_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : esc_html__( 'N/A (ini_get function does not exist)', 'woocommerce-rma-for-return-refund-and-exchange' );

		$mwr_system_data['php'] = $mwr_system_status;
		$mwr_system_data['wp']  = $mwr_wordpress_status;

		return $mwr_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param string $mwr_components html to display.
	 * @since 1.0.0
	 */
	public function wps_mwr_plug_generate_html( $mwr_components = array() ) {
		if ( is_array( $mwr_components ) && ! empty( $mwr_components ) ) {
			foreach ( $mwr_components as $mwr_component ) {
				if ( ! empty( $mwr_component['type'] ) && ! empty( $mwr_component['id'] ) ) {
					switch ( $mwr_component['type'] ) {
						case 'hidden':
						case 'number':
						case 'email':
						case 'text':
							?>
						<div class="wps-form-group wps-mwr-<?php echo esc_attr( $mwr_component['type'] ); ?>">
							<div class="wps-form-group__label">
								<label for="<?php echo esc_attr( $mwr_component['id'] ); ?>" class="wps-form-label"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
							</div>
							<div class="wps-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
							<?php if ( 'number' !== $mwr_component['type'] ) { ?>
												<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $mwr_component['placeholder'] ) ? esc_attr( $mwr_component['placeholder'] ) : '' ); ?></span>
						<?php } ?>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input
									class="mdc-text-field__input <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>" 
									name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $mwr_component['id'] ); ?>"
									type="<?php echo esc_attr( $mwr_component['type'] ); ?>"
									value="<?php echo ( isset( $mwr_component['value'] ) ? esc_attr( $mwr_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $mwr_component['placeholder'] ) ? esc_attr( $mwr_component['placeholder'] ) : '' ); ?>"
									<?php
									if ( 'number' === $mwr_component['type'] ) {
										?>
									min = "<?php echo ( isset( $mwr_component['min'] ) ? esc_attr( $mwr_component['min'] ) : '' ); ?>"
									max = "<?php echo ( isset( $mwr_component['max'] ) ? esc_attr( $mwr_component['max'] ) : '' ); ?>"
										<?php
									}
									?>
									>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent wps-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwr_component['description'] ) ? esc_attr( $mwr_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'password':
							?>
						<div class="wps-form-group">
							<div class="wps-form-group__label">
								<label for="<?php echo esc_attr( $mwr_component['id'] ); ?>" class="wps-form-label"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
							</div>
							<div class="wps-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input 
									class="mdc-text-field__input <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?> wps-form__password" 
									name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $mwr_component['id'] ); ?>"
									type="<?php echo esc_attr( $mwr_component['type'] ); ?>"
									value="<?php echo ( isset( $mwr_component['value'] ) ? esc_attr( $mwr_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $mwr_component['placeholder'] ) ? esc_attr( $mwr_component['placeholder'] ) : '' ); ?>"
									>
									<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing wps-password-hidden" tabindex="0" role="button">visibility</i>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent wps-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwr_component['description'] ) ? esc_attr( $mwr_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'textarea':
							?>
						<div class="wps-form-group">
							<div class="wps-form-group__label">
								<label class="wps-form-label" for="<?php echo esc_attr( $mwr_component['id'] ); ?>"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
							</div>
							<div class="wps-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"      for="text-field-hero-input">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<span class="mdc-floating-label"><?php echo ( isset( $mwr_component['placeholder'] ) ? esc_attr( $mwr_component['placeholder'] ) : '' ); ?></span>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<span class="mdc-text-field__resizer">
										<textarea rows=<?php echo ( isset( $mwr_component['rows'] ) ) ? esc_attr( $mwr_component['rows'] ) : ''; ?> cols=<?php echo ( isset( $mwr_component['cols'] ) ) ? esc_attr( $mwr_component['cols'] ) : ''; ?> class="mdc-text-field__input <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwr_component['id'] ); ?>" placeholder="<?php echo ( isset( $mwr_component['placeholder'] ) ? esc_attr( $mwr_component['placeholder'] ) : '' ); ?>"><?php echo ( isset( $mwr_component['value'] ) ? esc_textarea( $mwr_component['value'] ) : '' ); ?></textarea>
									</span>
								</label>
							</div>
						</div>
							<?php
							break;

						case 'select':
						case 'multiselect':
							?>
						<div class="wps-form-group">
							<div class="wps-form-group__label">
								<label class="wps-form-label" for="<?php echo esc_attr( $mwr_component['id'] ); ?>"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
							</div>
							<div class="wps-form-group__control">
								<div class="wps-form-select">
									<select id="<?php echo esc_attr( $mwr_component['id'] ); ?>" name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?><?php echo ( 'multiselect' === $mwr_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $mwr_component['id'] ); ?>" class="mdl-textfield__input <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>" <?php echo 'multiselect' === $mwr_component['type'] ? 'multiple="multiple"' : ''; ?> >
							<?php
							foreach ( $mwr_component['options'] as $mwr_key => $mwr_val ) {
								?>
											<option value="<?php echo esc_attr( $mwr_key ); ?>"
												<?php
												if ( is_array( $mwr_component['value'] ) ) {
													selected( in_array( (string) $mwr_key, $mwr_component['value'], true ), true );
												} else {
														selected( $mwr_component['value'], (string) $mwr_key );
												}
												?>
												>
												<?php echo esc_html( $mwr_val ); ?>
											</option>
										<?php
							}
							?>
									</select>
									<label class="mdl-textfield__label" for="<?php echo esc_attr( $mwr_component['id'] ); ?>"><?php echo esc_html( $mwr_component['description'] ); ?><?php echo ( isset( $mwr_component['description'] ) ? esc_attr( $mwr_component['description'] ) : '' ); ?></label>
								</div>
							</div>
						</div>

							<?php
							break;

						case 'checkbox':
							?>
						<div class="wps-form-group">
							<div class="wps-form-group__label">
								<label for="<?php echo esc_attr( $mwr_component['id'] ); ?>" class="wps-form-label"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
							</div>
							<div class="wps-form-group__control wps-pl-4">
								<div class="mdc-form-field">
									<div class="mdc-checkbox">
										<input 
										name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwr_component['id'] ); ?>"
										type="checkbox"
										class="mdc-checkbox__native-control <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>"
										value="<?php echo ( isset( $mwr_component['value'] ) ? esc_attr( $mwr_component['value'] ) : '' ); ?>"
							<?php checked( $mwr_component['value'], '1' ); ?>
										/>
										<div class="mdc-checkbox__background">
											<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
												<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
											</svg>
											<div class="mdc-checkbox__mixedmark"></div>
										</div>
										<div class="mdc-checkbox__ripple"></div>
									</div>
									<label for="checkbox-1"><?php echo ( isset( $mwr_component['description'] ) ? esc_attr( $mwr_component['description'] ) : '' ); ?></label>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio':
							?>
						<div class="wps-form-group">
							<div class="wps-form-group__label">
								<label for="<?php echo esc_attr( $mwr_component['id'] ); ?>" class="wps-form-label"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
							</div>
							<div class="wps-form-group__control wps-pl-4">
								<div class="wps-flex-col">
							<?php
							foreach ( $mwr_component['options'] as $mwr_radio_key => $mwr_radio_val ) {
								?>
										<div class="mdc-form-field">
											<div class="mdc-radio">
												<input
												name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
												value="<?php echo esc_attr( $mwr_radio_key ); ?>"
												type="radio"
												class="mdc-radio__native-control <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>"
								<?php checked( $mwr_radio_key, $mwr_component['value'] ); ?>
												>
												<div class="mdc-radio__background">
													<div class="mdc-radio__outer-circle"></div>
													<div class="mdc-radio__inner-circle"></div>
												</div>
												<div class="mdc-radio__ripple"></div>
											</div>
											<label for="radio-1"><?php echo esc_html( $mwr_radio_val ); ?></label>
										</div>    
								<?php
							}
							?>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio-switch':
							?>

						<div class="wps-form-group">
							<div class="wps-form-group__label">
								<label for="" class="wps-form-label"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
							</div>
							<div class="wps-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
										<div class="mdc-switch__thumb-underlay">
											<div class="mdc-switch__thumb"></div>
											<input name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>" type="checkbox" id="<?php echo esc_html( $mwr_component['id'] ); ?>" value="on" class="mdc-switch__native-control <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>" role="switch" aria-checked="
							<?php
							if ( 'on' === $mwr_component['value'] ) {
								echo 'true';
							} else {
								echo 'false';
							}
							?>
											"
											<?php checked( $mwr_component['value'], 'on' ); ?>
											>
										</div>
									</div>
								</div>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent wps-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwr_component['description'] ) ? esc_attr( $mwr_component['description'] ) : '' ); ?></div>
								</div>
								<?php
								if ( isset( $mwr_component['show_link'] ) ) {
									echo wp_kses_post( apply_filters( 'wps_rma_show_wfwp', true ) );
								}
								?>
							</div>
						</div>
							<?php
							break;

						case 'button':
							?>
						<div class="wps-form-group">
							<div class="wps-form-group__control">
								<button class="mdc-button mdc-button--raised" name= "<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $mwr_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
									<span class="mdc-button__label <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>"><?php echo ( isset( $mwr_component['button_text'] ) ? esc_html( $mwr_component['button_text'] ) : '' ); ?></span>
								</button>
							</div>
						</div>

							<?php
							break;

						case 'multi':
							?>
							<div class="wps-form-group wps-mwr-<?php echo esc_attr( $mwr_component['type'] ); ?>">
								<div class="wps-form-group__label">
									<label for="<?php echo esc_attr( $mwr_component['id'] ); ?>" class="wps-form-label"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
									</div>
									<div class="wps-form-group__control">
							<?php
							foreach ( $mwr_component['value'] as $component ) {
								?>
											<label class="mdc-text-field mdc-text-field--outlined">
												<span class="mdc-notched-outline">
													<span class="mdc-notched-outline__leading"></span>
													<span class="mdc-notched-outline__notch">
								<?php if ( 'number' !== $component['type'] ) { ?>
															<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $mwr_component['placeholder'] ) ? esc_attr( $mwr_component['placeholder'] ) : '' ); ?></span>
							<?php } ?>
													</span>
													<span class="mdc-notched-outline__trailing"></span>
												</span>
												<input 
												class="mdc-text-field__input <?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>" 
												name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
												id="<?php echo esc_attr( $component['id'] ); ?>"
												type="<?php echo esc_attr( $component['type'] ); ?>"
												value="<?php echo ( isset( $mwr_component['value'] ) ? esc_attr( $mwr_component['value'] ) : '' ); ?>"
												placeholder="<?php echo ( isset( $mwr_component['placeholder'] ) ? esc_attr( $mwr_component['placeholder'] ) : '' ); ?>"
								<?php echo esc_attr( ( 'number' === $component['type'] ) ? 'max=10 min=0' : '' ); ?>
												>
											</label>
							<?php } ?>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent wps-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwr_component['description'] ) ? esc_attr( $mwr_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
								<?php
							break;
						case 'color':
						case 'date':
						case 'file':
							?>
							<div class="wps-form-group wps-mwr-<?php echo esc_attr( $mwr_component['type'] ); ?>">
								<div class="wps-form-group__label">
									<label for="<?php echo esc_attr( $mwr_component['id'] ); ?>" class="wps-form-label"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
								</div>
								<div class="wps-form-group__control">
									<label>
										<input 
										class="<?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>" 
										name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwr_component['id'] ); ?>"
										type="<?php echo esc_attr( $mwr_component['type'] ); ?>"
										value="<?php echo ( isset( $mwr_component['value'] ) ? esc_attr( $mwr_component['value'] ) : '' ); ?>"
									<?php echo esc_html( ( 'date' === $mwr_component['type'] ) ? 'max=' . gmdate( 'Y-m-d', strtotime( gmdate( 'Y-m-d', mktime() ) . ' + 365 day' ) ) . 'min=' . gmdate( 'Y-m-d' ) . '' : '' ); ?>
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent wps-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwr_component['description'] ) ? esc_attr( $mwr_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'submit':
							?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary" 
								name="<?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?>"
								id="<?php echo esc_attr( $mwr_component['id'] ); ?>"
								class="<?php echo ( isset( $mwr_component['class'] ) ? esc_attr( $mwr_component['class'] ) : '' ); ?>"
								value="<?php echo esc_attr( $mwr_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
							<?php
							break;
						case 'breaker':
							?>
						<hr>
						<div class="wps-form-group__breaker">
						<span><b><?php echo ( isset( $mwr_component['name'] ) ? esc_html( $mwr_component['name'] ) : esc_html( $mwr_component['id'] ) ); ?></span></b>
						</div>
						<hr>
							<?php
							break;
						case 'wp_editor':
							?>
							<div class="wps-form-group">
								<div class="wps-form-group__label">
									<label class="wps-form-label" for="<?php echo esc_attr( $mwr_component['id'] ); ?>"><?php echo ( isset( $mwr_component['title'] ) ? esc_html( $mwr_component['title'] ) : '' ); ?></label>
								</div>
								<div class="wps-form-group__control">
									<span class="mdc-text-field__resizer">
											<?php echo wp_kses_post( wp_editor( $mwr_component['value'], esc_attr( $mwr_component['id'] ), array( 'editor_height' => 200 ) ) ); ?>
									</span>
								</div>
							</div>
							<?php
							break;

						default:
							break;
					}
				}
			}
		}
	}

	/**
	 *  Public static variable to be accessed in this plugin.
	 *
	 * @var string
	 */
	public static $lic_callback_function = 'check_lcns_validity';

	/**
	 *  Public static variable to be accessed in this plugin.
	 *
	 * @var string
	 */
	public static $lic_ini_callback_function = 'check_lcns_initial_days';

	/**
	 * Validate the use of features of this plugin.
	 *
	 * @since 1.0.0
	 */
	public static function check_lcns_validity() {
		$wps_mwr_lcns_key    = get_option( 'wps_mwr_license_key', '' );
		$wps_mwr_lcns_status = get_option( 'wps_mwr_license_check', '' );
		if ( $wps_mwr_lcns_key && true == $wps_mwr_lcns_status ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate the use of features of this plugin for initial days.
	 *
	 * @since 1.0.0
	 */
	public static function check_lcns_initial_days() {
		$thirty_days  = get_option( 'wps_mwr_activated_timestamp', 0 );
		$current_time = current_time( 'timestamp' );
		$day_count    = ( $thirty_days - $current_time ) / ( 24 * 60 * 60 );
		return $day_count;
	}
}
