<?php
/**
 * WC_GC_Admin class
 *
 * @package  WooCommerce Gift Cards
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Class.
 *
 * Loads admin scripts, includes admin classes and adds admin hooks.
 *
 * @class    WC_GC_Admin
 * @version  1.10.0
 */
class WC_GC_Admin {

	/**
	 * Bundled selectSW library version.
	 *
	 * @var string
	 */
	private static $bundled_selectsw_version = '1.1.7';

	/**
	 * Setup Admin class.
	 */
	public static function init() {

		add_action( 'init', array( __CLASS__, 'admin_init' ) );

		// selectSW scripts.
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'maybe_register_selectsw' ), 0 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'maybe_load_selectsw' ), 1 );
		add_action( 'admin_notices', array( __CLASS__, 'maybe_display_selectsw_notice' ), 1 );

		// Add a message in the WP Privacy Policy Guide page.
		add_action( 'admin_init', array( __CLASS__, 'add_privacy_policy_guide_content' ) );

		// Enqueue scripts.
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_resources' ), 11 );
		add_filter( 'woocommerce_screen_ids', array( __CLASS__, 'add_wc_screens' ) );

		// Add a custom body class.
		add_filter( 'admin_body_class', array( __CLASS__, 'gc_body_class' ) );

		// Add debug data in the system status report.
		add_action( 'woocommerce_system_status_report', array( __CLASS__ , 'render_system_status_items' ) );

		// Settings.
		add_filter( 'woocommerce_get_settings_pages', array( __CLASS__, 'add_settings_page' ) );
	}

	/**
	 * Admin init.
	 */
	public static function admin_init() {
		self::includes();
	}

	/**
	 * Inclusions.
	 */
	protected static function includes() {

		// Admin Menus.
		require_once  WC_GC_ABSPATH . 'includes/admin/class-wc-gc-admin-menus.php' ;

		// Metaboxes.
		require_once  WC_GC_ABSPATH . 'includes/admin/meta-boxes/class-wc-gc-meta-box-product-data.php' ;
		require_once  WC_GC_ABSPATH . 'includes/admin/meta-boxes/class-wc-gc-meta-box-order.php' ;

		// Admin Refunds.
		require_once  WC_GC_ABSPATH . 'includes/admin/class-wc-gc-admin-refunds.php' ;

		// Reports.
		require_once  WC_GC_ABSPATH . 'includes/admin/reports/class-wc-gc-admin-reports.php' ;

		// Admin AJAX.
		require_once  WC_GC_ABSPATH . 'includes/admin/class-wc-gc-admin-ajax.php' ;

		// Import/Export
		require_once  WC_GC_ABSPATH . 'includes/admin/class-wc-gc-admin-importers.php' ;
		require_once  WC_GC_ABSPATH . 'includes/admin/class-wc-gc-admin-exporters.php' ;
	}

	/**
	 * Register own version of select2 library.
	 *
	 * @since 1.2.0
	 */
	public static function maybe_register_selectsw() {

		$is_registered      = wp_script_is( 'sw-admin-select-init', $list = 'registered' );
		$registered_version = $is_registered ? wp_scripts()->registered[ 'sw-admin-select-init' ]->ver : '';
		$register           = ! $is_registered || version_compare( self::$bundled_selectsw_version, $registered_version, '>' );

		if ( $register ) {

			if ( $is_registered ) {
				wp_deregister_script( 'sw-admin-select-init' );
			}

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			// Register own select2 initialization library.
			wp_register_script( 'sw-admin-select-init', WC_GC()->get_plugin_url() . '/assets/js/admin/select2-init' . $suffix . '.js', array( 'jquery', 'sw-admin-select' ), self::$bundled_selectsw_version );
		}
	}

	/**
	 * Load own version of select2 library.
	 *
	 * @since 1.2.0
	 */
	public static function maybe_load_selectsw() {

		// Responsible for loading selectsw?
		if ( self::load_selectsw() ) {

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			// Register selectSW library.
			wp_register_script( 'sw-admin-select', WC_GC()->get_plugin_url() . '/assets/js/admin/select2' . $suffix . '.js', array( 'jquery' ), self::$bundled_selectsw_version );

			// Enqueue selectSW styles.
			wp_register_style( 'sw-admin-css-select', WC_GC()->get_plugin_url() . '/assets/css/admin/select2.css', array(), self::$bundled_selectsw_version );
			wp_style_add_data( 'sw-admin-css-select', 'rtl', 'replace' );
		}
	}

	/**
	 * Display notice when selectSW library is unsupported.
	 *
	 * @since 1.2.0
	 */
	public static function maybe_display_selectsw_notice() {

		$registered_version       = wp_scripts()->registered[ 'sw-admin-select-init' ]->ver;
		$registered_version_major = strstr( $registered_version, '.', true );
		$bundled_version_major    = strstr( self::$bundled_selectsw_version, '.', true );

		if ( version_compare( $bundled_version_major, $registered_version_major, '<' ) ) {

			$notice = __( 'The installed version of <strong>Gift Cards</strong> is not compatible with the <code>selectSW</code> library found on your system. Please update Gift Cards to the latest version.', 'woocommerce-gift-cards' );
			WC_GC_Admin_Notices::add_notice( $notice, 'error' );
		}
	}

	/**
	 * Whether to load own version of select2 library or not.
	 *
	 * @since 1.2.0
	 *
	 * @return boolean
	 */
	private static function load_selectsw() {
		$load_selectsw_from = wp_scripts()->registered[ 'sw-admin-select-init' ]->src;
		return strpos( $load_selectsw_from, WC_GC()->get_plugin_url() ) === 0;
	}

	/**
	 * Add a message in the WP Privacy Policy Guide page.
	 */
	public static function add_privacy_policy_guide_content() {
		if ( function_exists( 'wp_add_privacy_policy_content' ) ) {
			wp_add_privacy_policy_content( 'WooCommerce Gift Cards', self::get_privacy_policy_guide_message() );
		}
	}

	/**
	 * Message to add in the WP Privacy Policy Guide page.
	 *
	 * @return string
	 */
	protected static function get_privacy_policy_guide_message() {

		$content = '
			<div class="wp-suggested-text">' .
				'<p class="privacy-policy-tutorial">' .
					__( 'WooCommerce Gift Cards stores the following information, as provided by gift card buyers:', 'woocommerce-gift-cards' ) .
				'</p>' .
				'<ul class="privacy-policy-tutorial">' .
					'<li>' . __( 'Sender name.', 'woocommerce-gift-cards' ) . '</li>' .
					'<li>' . __( 'Recipient name.', 'woocommerce-gift-cards' ) . '</li>' .
					'<li>' . __( 'Recipient email.', 'woocommerce-gift-cards' ) . '</li>' .
					'<li>' . __( 'Message from sender to recipient.', 'woocommerce-gift-cards' ) . '</li>' .
				'</ul>' .
				'<p class="privacy-policy-tutorial">' .
					__( 'This information can be used to personally identify the sender and recipient(s), and is stored indefinitely.', 'woocommerce-gift-cards' ) .
				'</p>' .
				'<p class="privacy-policy-tutorial">' .
					__( 'Full access to all gift card data is restricted to Store Administators only. Store Managers may view and search by sender, recipient and gift card code. However, gift card messages cannot be viewed by Store Managers.', 'woocommerce-gift-cards' ) .
				'</p>' .
			'</div>';

		return $content;
	}

	/**
	 * Admin scripts.
	 */
	public static function admin_resources() {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_register_style( 'wc-gc-admin-css', WC_GC()->get_plugin_url() . '/assets/css/admin/admin.css', array( 'sw-admin-css-select' ), WC_GC()->get_plugin_version() );
		wp_style_add_data( 'wc-gc-admin-css', 'rtl', 'replace' );

		wp_register_script( 'wc-gc-writepanel', WC_GC()->get_plugin_url() . '/assets/js/admin/wc-gc-admin' . $suffix . '.js', array( 'jquery', 'jquery-ui-datepicker', 'wp-util', 'sw-admin-select-init', 'wc-backbone-modal' ), WC_GC()->get_plugin_version() );

		$params = array(
			'wc_ajax_url'                       => admin_url( 'admin-ajax.php' ),
			'wc_placeholder_img_src'            => wc_placeholder_img_src(),
			'is_wc_version_gte_3_4'             => WC_GC_Core_Compatibility::is_wc_version_gte( '3.4' ) ? 'yes' : 'no',
			'is_wc_version_gte_3_6'             => WC_GC_Core_Compatibility::is_wc_version_gte( '3.6' ) ? 'yes' : 'no',

			'edit_gift_card_order_item_nonce'   => wp_create_nonce( 'wc_gc_edit_gift_card_order_item' ),
			'i18n_configure_order_item'         => __( 'Configure Gift Card', 'woocommerce-gift-cards' ),
			'i18n_edit_order_item'              => __( 'Edit Gift Card', 'woocommerce-gift-cards' ),
			'i18n_form_error'                   => __( 'Failed to initialize form. If this issue persists, please reload the page and try again.', 'woocommerce-gift-cards' ),
			'i18n_validation_error'             => __( 'Failed to validate configuration. If this issue persists, please reload the page and try again.', 'woocommerce-gift-cards' ),

			'i18n_wc_delete_card_warning'       => __( 'You are about to delete a gift card permanently. Are you sure?', 'woocommerce-gift-cards' ),
			'i18n_wc_bulk_delete_card_warning'  => __( 'You are about to delete the selected gift cards permanently. Are you sure?', 'woocommerce-gift-cards' ),
			'i18n_wc_edit_message_warning'      => __( 'The gift card message has been modified. Are you sure?', 'woocommerce-gift-cards' ),
			'i18n_select_image_frame_title'     => __( 'Choose Recipient Email Image', 'woocommerce-gift-cards' ),
			'i18n_select_image_frame_button'    => __( 'Set Image', 'woocommerce-gift-cards' ),
			'i18n_wc_delete_order_item_warning' => __( 'Remove and refund gift card code %%code%%?', 'woocommerce-gift-cards' ),
			'i18n_wc_add_order_item_prompt'     => __( 'Enter gift card code:', 'woocommerce-gift-cards' ),

			// Refunds.
			'i18n_refund_button_text'           => __( 'Refund %%amount%% to gift cards', 'woocommerce-gift-cards' ),
			'i18n_refund_button_tip_text'       => __( 'The amount to refund will be automatically distributed to any applied gift cards.', 'woocommerce-gift-cards' ),

			// Export modal.
			'modal_export_giftcards_nonce'      => wp_create_nonce( 'wc-gc-modal-giftcards-export' ),
			'export_giftcards_nonce'            => wp_create_nonce( 'wc-gc-giftcards-export' ),
			'i18n_export_modal_title'           => __( 'Export Gift Cards', 'woocommerce-gift-cards' ),
		);

		/*
		 * Enqueue specific styles & scripts.
		 */
		if ( WC_GC()->is_current_screen( array( 'shop_order', 'product', wc_gc_get_formatted_screen_id( 'woocommerce_page_wc-settings', false ) ) ) ) {
			wp_enqueue_script( 'wc-gc-writepanel' );
			wp_localize_script( 'wc-gc-writepanel', 'wc_gc_admin_params', $params );
		}

		wp_enqueue_style( 'wc-gc-admin-css' );
	}

	/**
	 * Add PB debug data in the system status.
	 */
	public static function render_system_status_items() {

		$debug_data = array(
			'db_version'           => get_option( 'wc_gc_db_version', null ),
			'loopback_test_result' => WC_GC_Notices::get_notice_option( 'loopback', 'last_result', '' ),
			'queue_test_result'    => WC_GC_Notices::has_overdue_deliveries() ? 'fail' : 'pass'
		);

		include  WC_GC_ABSPATH . 'includes/admin/status/views/html-admin-page-status-report.php' ;
	}

	/**
	 * Add screen ids.
	 */
	public static function add_wc_screens( $screens ) {
		$screens = array_merge( $screens, WC_GC()->get_screen_ids() );
		return $screens;
	}


	/**
	 * Include admin classes.
	 *
	 * @param  String  $classes
	 * @return String
	 */
	public static function gc_body_class( $classes ) {

		$classes = "$classes wc-gc";
		if ( strpos( $classes, 'sw-wp-version-gte-53' ) !== false ) {
			return $classes;
		}

		if ( WC_GC_Core_Compatibility::is_wp_version_gte( '5.3' ) ) {
			$classes .= ' sw-wp-version-gte-53';
		}

		return $classes;
	}

	/**
	 * Add 'Gift Cards' tab to WooCommerce Settings tabs.
	 *
	 * @param  array $settings
	 * @return array $settings
	 */
	public static function add_settings_page( $settings ) {

		$settings[] = include  'settings/class-wc-gc-admin-settings.php' ;

		return $settings;
	}

}

WC_GC_Admin::init();
