<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    https://wpswings.com/
 * @since   1.0.0
 * @package woocommerce-rma-for-return-refund-and-exchange
 *
 * @wordpress-plugin
 * Plugin Name:       RMA Return Refund & Exchange for WooCommerce Pro
 * Plugin URI:        https://wpswings.com/product/rma-return-refund-exchange-for-woocommerce-pro/?utm_source=wpswings-rma-pro&utm_medium=rma-pro-backend&utm_campaign=pro-plugin
 * Description:       <code><strong>RMA Return Refund & Exchange for WooCommerce Pro</code></strong> extension allows users to submit product refund and exchange request. The plugin provides a dedicated mailing system that would help to communicate better between store owner and customers. <a target="_blank" href="https://wpswings.com/woocommerce-plugins/?utm_source=wpswings-rma-shop&utm_medium=rma-pro-backend&utm_campaign=shop-page">Elevate your e-commerce store by exploring more on WP Swings</a>
 * Version:           5.0.3
 * Author:            WP Swings
 * Author URI:        https://wpswings.com/?utm_source=wpswings-official&utm_medium=rma-pro-backend&utm_campaign=official/
 * Text Domain:       woocommerce-rma-for-return-refund-and-exchange
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to: 6.0.0
 * WC requires at least: 4.0
 * WC tested up to: 6.5.1
 *
 * License:           Software License Agreement
 * License URI:       http://wpswings.com/license-agreement.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
include_once ABSPATH . 'wp-admin/includes/plugin.php';
$activated      = true;
$active_plugins = get_option( 'active_plugins', array() );
if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	$active_network_wide     = get_site_option( 'active_sitewide_plugins', array() );
	if ( ! empty( $active_network_wide ) ) {
		foreach ( $active_network_wide as $key => $value ) {
			$active_plugins[] = $key;
		}
	}
	$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
	if ( ! in_array( 'woocommerce/woocommerce.php', $active_plugins, true ) ) {
		$activated = false;
	}
} else {
	if ( ! in_array( 'woocommerce/woocommerce.php', $active_plugins, true ) ) {
		$activated = false;
	}
}

add_action( 'init', 'wps_rma_pro_old_redirect' );

if ( ! function_exists( 'wps_rma_pro_old_redirect' ) ) {
	/** RMA Pro old setting url redirect */
	function wps_rma_pro_old_redirect() {
		if ( isset( $_GET['tab'] ) && ( 'mwb_wrma_setting' === $_GET['tab'] || 'mwb_wrma_license_section' === $_GET['tab'] ) ) { // phpcs:ignore
			wp_safe_redirect( admin_url( 'plugins.php' ) );
			exit();
		}
	}
}

add_action( 'admin_notices', 'wps_rma_admin_notices' );
/** RMA plugins compatibility notices */
function wps_rma_admin_notices() {
	$installed               = false;
	$active_plugins          = get_option( 'active_plugins', array() );
	$wps_wrma_lite_activated = false;
	if ( in_array( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php', $active_plugins, true ) ) {
		$wps_wrma_lite_activated = true;
	}
	$plugin_slug            = 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php';
	$plugin_name            = 'RMA Return Refund & Exchange for WooCommerce';
	$plugin_zip             = 'https://downloads.wordpress.org/plugin/woo-refund-and-exchange-lite.zip';
	$check_if_rma_org_exist = false;
	if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin_slug ) ) {
		$check_if_rma_org_exist = true;
	}
	if ( $check_if_rma_org_exist ) {
		$installed = true;
	} else {
		wps_rma_install_plugin( $plugin_zip );
		activate_plugin( $plugin_slug );
		$installed = true;
	}
	if ( in_array( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php', $active_plugins, true ) ) {
		$wps_wrma_lite_activated = true;
	}
	if ( $installed ) {
		$mess = esc_html__( 'Heads up, We highly recommend Also Update Latest Org Plugin. From Now the Pro version is dependent upon our Org Plugin. The latest update includes some substantial changes across different areas of the plugin', 'woocommerce-rma-for-return-refund-and-exchange' ) . '.<b><br/>' . esc_html__( 'Please download and activate the Return Refund and Exchange for WooCommerce From WordPress', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</b><br/>' . esc_html__( 'It requires minimum 4.0.0 Version to work', 'woocommerce-rma-for-return-refund-and-exchange' ) . '. ' . esc_html__( 'To download the Return Refund and Exchange for WooCommerce, Please ', 'woocommerce-rma-for-return-refund-and-exchange' ) . '<a target="_blank" href="https://wordpress.org/plugins/woo-refund-and-exchange-lite/">click here</a>';
		if ( $wps_wrma_lite_activated ) {
			if ( wps_rma_get_plugin_version( $plugin_slug ) < '4.0.0' ) {
				?>
				<tr class="plugin-update-tr active notice-warning notice-alt">
				<td  colspan="4" class="plugin-update colspanchange">
					<div class="notice notice-warning inline update-message notice-alt wps-notice-section">
						<p>
						<?php
						printf(
							wp_kses_post( '<div>%s</div>' ),
							wp_kses_post( $mess ) // phpcs:ignore
						);
						?>
						</p>
					</div>
				</td>
				</tr>
				<style>
					.wps-notice-section > p:before {
						content: none;
					}
				</style>
				<?php
				deactivate_plugins( 'woocommerce-rma-for-return-refund-and-exchange/mwb-woocommerce-rma.php' );
			} else {
				return;
			}
		} else {
			if ( wps_rma_get_plugin_version( $plugin_slug ) < '4.0.0' ) {
				wps_rma_install_plugin( $plugin_zip );
				activate_plugin( $plugin_slug );
			} else {
				?>
				<tr class="plugin-update-tr active notice-warning notice-alt">
				<td  colspan="4" class="plugin-update colspanchange">
					<div class="notice notice-warning inline update-message notice-alt wps-notice-section">
						<p>
						<?php
						printf(
							wp_kses_post( '<div>%s</div>' ),
							esc_html__( 'Please activate ', 'woocommerce-rma-for-return-refund-and-exchange' ) . esc_html( $plugin_name )
						);
						?>
						</p>
						</div>
					</td>
				</tr>
				<style>
					.wps-notice-section > p:before {
						content: none;
					}
				</style>
				<?php
				deactivate_plugins( 'woocommerce-rma-for-return-refund-and-exchange/mwb-woocommerce-rma.php' );
			}
		}
	} else {
		printf(
			wp_kses_post( '<div>%1$s %2$s %3$s</div>' ),
			esc_html__( 'please install', 'woocommerce-rma-for-return-refund-and-exchange' ) . esc_html( $plugin_name ) . esc_html__( 'from WordPress before installing the pro plugin.', 'woocommerce-rma-for-return-refund-and-exchange' )
		);
	}
}
if ( $activated ) {
	/**
	 * Define plugin constants.
	 *
	 * @since 1.0.0
	 */
	function define_rma_return_refund_exchange_for_woocommerce_pro_constants() {

		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_VERSION', '5.0.3' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH', plugin_dir_path( __FILE__ ) );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL', plugin_dir_url( __FILE__ ) );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_SERVER_URL', 'https://wpswings.com' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE', 'RMA Return Refund & Exchange for WooCommerce Pro' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY', '59f32ad2f20102.74284991' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL', 'https://wpswings.com' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'WPS_WRMA_SHIPSTATION_CARRIERS_URL', 'https://api.shipengine.com/v1/carriers' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'WPS_WRMA_SHIPSTATION_LABEL_URL', 'https://api.shipengine.com/v1/labels' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_BASE_FILE', __FILE__ );
		$wps_mwr_license_key = get_option( 'wps_mwr_license_key', '' );
		rma_return_refund_exchange_for_woocommerce_pro_constants( 'RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_LICENSE_KEY', $wps_mwr_license_key );
	}

	/**
	 * Define wps-site update feature.
	 */
	function auto_load_rma_return_refund_exchange_for_woocommerce_pro() {
		$wallet_enable        = get_option( 'wps_rma_wallet_enable', 'no' );
		$wallet_plugin_enable = get_option( 'wps_rma_wallet_plugin', 'no' );
		if ( 'on' !== $wallet_plugin_enable && 'on' === $wallet_enable ) {
			require RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'gateway/class-wps-rma-wallet-gateway.php';
		}
		require RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'includes/rma-return-refund-exchange-for-woocommerce-pro-common-functions.php';
		// check plugin update.
		include_once 'class-rma-return-refund-exchange-for-woocommerce-pro-update.php';
	}

	/**
	 * Callable function for defining plugin constants.
	 *
	 * @param String $key   Key for contant.
	 * @param String $value value for contant.
	 * @since 1.0.0
	 */
	function rma_return_refund_exchange_for_woocommerce_pro_constants( $key, $value ) {

		if ( ! defined( $key ) ) {

			define( $key, $value );
		}
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-rma-return-refund-exchange-for-woocommerce-pro-activator.php
	 *
	 * @param string $network_wide .
	 */
	function activate_rma_return_refund_exchange_for_woocommerce_pro( $network_wide ) {
		if ( ! wp_next_scheduled( 'wps_mwr_check_license_daily' ) ) {
			wp_schedule_event( time(), 'daily', 'wps_mwr_check_license_daily' );
		}

		include_once plugin_dir_path( __FILE__ ) . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro-activator.php';
		Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Activator::rma_return_refund_exchange_for_woocommerce_pro_activate( $network_wide );
		$wps_mwr_active_plugin = get_option( 'wps_all_plugins_active', false );
		if ( is_array( $wps_mwr_active_plugin ) && ! empty( $wps_mwr_active_plugin ) ) {
			$wps_mwr_active_plugin['rma-return-refund-exchange-for-woocommerce-pro'] = array(
				'plugin_name' => esc_html__( 'RMA Return Refund & Exchange for WooCommerce Pro', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'active'      => '1',
			);
		} else {
			$wps_mwr_active_plugin = array();
			$wps_mwr_active_plugin['rma-return-refund-exchange-for-woocommerce-pro'] = array(
				'plugin_name' => esc_html__( 'RMA Return Refund & Exchange for WooCommerce Pro', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'active'      => '1',
			);
		}
		update_option( 'wps_all_plugins_active', $wps_mwr_active_plugin );
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-rma-return-refund-exchange-for-woocommerce-pro-deactivator.php
	 *
	 * @param string $network_wide .
	 */
	function deactivate_rma_return_refund_exchange_for_woocommerce_pro( $network_wide ) {
		include_once plugin_dir_path( __FILE__ ) . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro-deactivator.php';
		Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Deactivator::rma_return_refund_exchange_for_woocommerce_pro_deactivate( $network_wide );
		$wps_mwr_deactive_plugin = get_option( 'wps_all_plugins_active', false );
		if ( is_array( $wps_mwr_deactive_plugin ) && ! empty( $wps_mwr_deactive_plugin ) ) {
			foreach ( $wps_mwr_deactive_plugin as $wps_mwr_deactive_key => $wps_mwr_deactive ) {
				if ( 'rma-return-refund-exchange-for-woocommerce-pro' === $wps_mwr_deactive_key ) {
					$wps_mwr_deactive_plugin[ $wps_mwr_deactive_key ]['active'] = '0';
				}
			}
		}
		update_option( 'wps_all_plugins_active', $wps_mwr_deactive_plugin );
	}

	register_activation_hook( __FILE__, 'activate_rma_return_refund_exchange_for_woocommerce_pro' );
	register_deactivation_hook( __FILE__, 'deactivate_rma_return_refund_exchange_for_woocommerce_pro' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro.php';


	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since 1.0.0
	 */
	function run_rma_return_refund_exchange_for_woocommerce_pro() {
		define_rma_return_refund_exchange_for_woocommerce_pro_constants();
		auto_load_rma_return_refund_exchange_for_woocommerce_pro();
		$mwr_rrrefwp_plugin_standard = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro();
		$mwr_rrrefwp_plugin_standard->mwr_run();
		$GLOBALS['mwr_wps_mwr_obj'] = $mwr_rrrefwp_plugin_standard;
	}
	run_rma_return_refund_exchange_for_woocommerce_pro();

	/**
	 * Adding custom setting links at the plugin activation list.
	 *
	 * @param  array  $links_array      array containing the links to plugin.
	 * @param  string $plugin_file_name plugin file name.
	 * @return array
	 */
	function rma_return_refund_exchange_for_woocommerce_pro_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
		if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
			$links_array[] = '<a target="_blank" href="https://demo.wpswings.com/rma-return-refund-exchange-for-woocommerce-pro/?utm_source=wpswings-rma-demo&utm_medium=rma-pro-backend&utm_campaign=demo"><img src="' . esc_url( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . 'admin/image/Demo.svg" class="wps-info-img" alt="Demo image">' . esc_html__( 'Demo', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</a>';
			$links_array[] = '<a href="https://docs.wpswings.com/rma-return-refund-exchange-for-woocommerce-pro/?utm_source=wpswings-rma-doc&utm_medium=rma-pro-backend&utm_campaign=doc" target="_blank"><img src="' . esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . 'admin/image/Documentation.svg" class="wps-info-img" alt="documentation image">' . esc_html__( 'Documentation', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</a>';
			$links_array[] = '<a href="https://wpswings.com/submit-query/?utm_source=wpswings-rma-support&utm_medium=rma-pro-backend&utm_campaign=support" target="_blank"><img src="' . esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . 'admin/image/Support.svg" class="wps-info-img" alt="support image">' . esc_html__( 'Support', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</a>';
		}
		return $links_array;
	}
	add_filter( 'plugin_row_meta', 'rma_return_refund_exchange_for_woocommerce_pro_custom_settings_at_plugin_tab', 10, 2 );

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wps_rma_pro_settings_link' );

	/**
	 * Settings tab of the plugin.
	 *
	 * @name wps_rma_pro_settings_link
	 * @param array $links array of the links.
	 * @since    1.0.0
	 */
	function wps_rma_pro_settings_link( $links ) {

		if ( is_plugin_active( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php' ) ) {

			$my_link['settings'] = '<a href="' . admin_url( 'admin.php?page=woo_refund_and_exchange_lite_menu' ) . '">' . esc_html__( 'Settings', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</a>';
			return array_merge( $my_link, $links );
		} else {
			return $links;
		}
	}

	/**
	 * This function perform refund/exchange for guest user.
	 */
	function wps_rma_guest_user() {
		if ( isset( $_POST['wps_wrma_order_id_submit'] ) && isset( $_POST['get_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['get_nonce'] ) ), 'create_form_nonce' ) ) {
			$order_id     = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : 0;
			$phone_enable = get_option( 'wps_rma_guest_phone' );
			if ( 'on' === $phone_enable ) {
				$billing_phone = get_post_meta( $order_id, '_billing_phone', true );
				$req_phone     = isset( $_POST['order_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['order_phone'] ) ) : '';
			} else {
				$billing_email = get_post_meta( $order_id, '_billing_email', true );
				$req_email     = isset( $_POST['order_email'] ) ? sanitize_text_field( wp_unslash( $_POST['order_email'] ) ) : '';
			}
			if ( ( isset( $req_email ) && isset( $billing_email ) && $req_email === $billing_email ) || ( isset( $req_phone ) && isset( $billing_phone ) && $req_phone === $billing_phone ) ) {
				if ( 'yes' === $phone_enable ) {
					WC()->session->set( 'wps_wrma_phone', $billing_phone );
				} else {
					WC()->session->set( 'wps_wrma_email', $billing_email );
				}
				$order = new WC_Order( $order_id );
				$url   = $order->get_checkout_order_received_url();
				wp_safe_redirect( $url );
				exit();
			} else {
				if ( 'on' === $phone_enable ) {
					WC()->session->set( 'wps_wrma_notification', esc_html__( 'OrderId or Phone Number is Invalid', 'woocommerce-rma-for-return-refund-and-exchange' ) );
				} else {
					WC()->session->set( 'wps_wrma_notification', esc_html__( 'OrderId or Email is Invalid', 'woocommerce-rma-for-return-refund-and-exchange' ) );
				}
			}
		}
	}
	add_action( 'init', 'wps_rma_guest_user' );


	/** Function to migrate to settings and data */
	function wps_rma_pro_migrate_settings_and_data() {
		global $wpdb;
		// Check if the plugin has been activated on the network.
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			// Get all blogs in the network and activate plugins on each one.
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );

				// Setting And DB Migration Code.
				$check_key_exist          = get_option( 'wps_rma_pro_setting_restore', false );
				$get_active_plugins       = get_option( 'active_plugins', array() );
				$check_rma_org_activation = in_array( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php', $get_active_plugins, true );

				$enable_sale    = get_option( 'mwb_wrma_return_sale_enable', 'not_exist' );
				$auto_restock   = get_option( 'mwb_wrma_return_request_auto_stock', 'not_exist' );
				$auto_refund    = get_option( 'mwb_wrma_return_autoaccept_enable', 'not_exist' );
				$return_sub     = get_option( 'mwb_wrma_notification_return_subject', 'not_exist' );
				$return_content = get_option( 'mwb_wrma_notification_return_rcv', 'not_exist' );
				if ( $check_rma_org_activation && function_exists( 'wps_rma_get_plugin_version' ) && wps_rma_get_plugin_version( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php' ) >= '4.0.0' && ( 'not_exist' !== $enable_sale || 'not_exist' !== $auto_restock || 'not_exist' !== $auto_refund || 'not_exist' !== $auto_refund || 'not_exist' !== $return_sub || 'not_exist' !== $return_content ) ) {
					if ( ! get_option( 'wps_rma_pro_pages_migrate', false ) ) {
						$mwb_wrma_pages = get_option( 'mwb_wrma_pages' );
						$page_id        = $mwb_wrma_pages['pages']['mwb_exchange_from'];
						if ( isset( $mwb_wrma_pages['pages']['mwb_exchange_from'] ) ) {
							$page_id = $mwb_wrma_pages['pages']['mwb_exchange_from'];
							wp_delete_post( $page_id );
						}
						if ( isset( $mwb_wrma_pages['pages']['mwb_exchange_from'] ) ) {
							$page_id = $mwb_wrma_pages['pages']['mwb_exchange_from'];
							wp_delete_post( $page_id );
						}
						if ( isset( $mwb_wrma_pages['pages']['mwb_request_from'] ) ) {
							$page_id = $mwb_wrma_pages['pages']['mwb_request_from'];
							wp_delete_post( $page_id );
						}
						if ( isset( $mwb_wrma_pages['pages']['mwb_cancel_request_from'] ) ) {
							$page_id = $mwb_wrma_pages['pages']['mwb_cancel_request_from'];
							wp_delete_post( $page_id );
						}
						$page_id = get_option( 'wps_rma_exchange_req_page' );
						wp_delete_post( $page_id );
						$page_id = get_option( 'wps_rma_guest_form_page' );
						wp_delete_post( $page_id );
						$page_id = get_option( 'wps_rma_cancel_req_page' );
						wp_delete_post( $page_id );

						include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro-activator.php';
						$activator_class_obj = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Activator();
						$activator_class_obj::wps_rma_create_pages();
						update_option( 'wps_rma_pro_pages_migrate', true );
					}

					if ( function_exists( 'wps_rma_pro_migrate_settings' ) && ! get_option( 'wps_rma_pro_migrate_settings', false ) ) {
						wps_rma_pro_migrate_settings();
						update_option( 'wps_rma_pro_migrate_settings', true );
					}
					if ( function_exists( 'wps_rma_pro_wp_option_migrate' ) && ! get_option( 'wps_rma_pro_wp_option_migrate', false ) ) {
						wps_rma_pro_wp_option_migrate();
						update_option( 'wps_rma_pro_wp_option_migrate', true );
					}
					if ( function_exists( 'wps_rma_pro_shortcode_migrate' ) && ! get_option( 'wps_rma_pro_shortcode_migrate', false ) ) {
						wps_rma_pro_shortcode_migrate();
						update_option( 'wps_rma_pro_shortcode_migrate', true );
					}
				}
				restore_current_blog();
			}
		} else {
			// Setting And DB Migration Code.
			$check_key_exist          = get_option( 'wps_rma_pro_setting_restore', false );
			$get_active_plugins       = get_option( 'active_plugins', array() );
			$check_rma_org_activation = in_array( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php', $get_active_plugins, true );
			$enable_sale    = get_option( 'mwb_wrma_return_sale_enable', 'not_exist' );
			$auto_restock   = get_option( 'mwb_wrma_return_request_auto_stock', 'not_exist' );
			$auto_refund    = get_option( 'mwb_wrma_return_autoaccept_enable', 'not_exist' );
			$return_sub     = get_option( 'mwb_wrma_notification_return_subject', 'not_exist' );
			$return_content = get_option( 'mwb_wrma_notification_return_rcv', 'not_exist' );
			if ( $check_rma_org_activation && function_exists( 'wps_rma_get_plugin_version' ) && wps_rma_get_plugin_version( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php' ) >= '4.0.0' && ( 'not_exist' !== $enable_sale || 'not_exist' !== $auto_restock || 'not_exist' !== $auto_refund || 'not_exist' !== $auto_refund || 'not_exist' !== $return_sub || 'not_exist' !== $return_content ) ) {
				if ( ! get_option( 'wps_rma_pro_pages_migrate', false ) ) {
					$mwb_wrma_pages = get_option( 'mwb_wrma_pages' );
					if ( isset( $mwb_wrma_pages['pages']['mwb_exchange_from'] ) ) {
						$page_id = $mwb_wrma_pages['pages']['mwb_exchange_from'];
						wp_delete_post( $page_id );
					}
					if ( isset( $mwb_wrma_pages['pages']['mwb_exchange_from'] ) ) {
						$page_id = $mwb_wrma_pages['pages']['mwb_exchange_from'];
						wp_delete_post( $page_id );
					}
					if ( isset( $mwb_wrma_pages['pages']['mwb_request_from'] ) ) {
						$page_id = $mwb_wrma_pages['pages']['mwb_request_from'];
						wp_delete_post( $page_id );
					}
					if ( isset( $mwb_wrma_pages['pages']['mwb_cancel_request_from'] ) ) {
						$page_id = $mwb_wrma_pages['pages']['mwb_cancel_request_from'];
						wp_delete_post( $page_id );
					}
					$page_id = get_option( 'wps_rma_exchange_req_page' );
					wp_delete_post( $page_id );
					$page_id = get_option( 'wps_rma_guest_form_page' );
					wp_delete_post( $page_id );
					$page_id = get_option( 'wps_rma_cancel_req_page' );
					wp_delete_post( $page_id );

					include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro-activator.php';
					$activator_class_obj = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Activator();
					$activator_class_obj::wps_rma_create_pages();
					update_option( 'wps_rma_pro_pages_migrate', true );
				}

				if ( function_exists( 'wps_rma_pro_migrate_settings' ) && ! get_option( 'wps_rma_pro_migrate_settings', false ) ) {
					wps_rma_pro_migrate_settings();
					update_option( 'wps_rma_pro_migrate_settings', true );
				}
				if ( function_exists( 'wps_rma_pro_wp_option_migrate' ) && ! get_option( 'wps_rma_pro_wp_option_migrate', false ) ) {
					wps_rma_pro_wp_option_migrate();
					update_option( 'wps_rma_pro_wp_option_migrate', true );
				}
				if ( function_exists( 'wps_rma_pro_shortcode_migrate' ) && ! get_option( 'wps_rma_pro_shortcode_migrate', false ) ) {
					wps_rma_pro_shortcode_migrate();
					update_option( 'wps_rma_pro_shortcode_migrate', true );
				}
			}
		}
		deactivate_plugins( 'woocommerce-rma-for-return-refund-and-exchange/rma-return-refund-exchange-for-woocommerce-pro.php' );
	}
	add_action( 'admin_init', 'wps_rma_pro_migrate_settings_and_data', 90 );
} else {
	/**
	 * Show warning message if woocommerce is not install
	 */
	function wps_wrma_plugin_error_notice() {
		?>
		<div class="error notice is-dismissible">
			<p><?php esc_html_e( 'Woocommerce is not activated, Please activate Woocommerce first to install WooCommerce RMA | Return-Refund-Exchange.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></p>
		</div>
		<style>
		#message{display:none;}
		</style>
		<?php
	}
	add_action( 'admin_init', 'wps_wrma_plugin_deactivate' );


	/**
	 * Call Admin notices
	 */
	function wps_wrma_plugin_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'network_admin_notices', 'wps_wrma_plugin_error_notice' );
		add_action( 'admin_notices', 'wps_wrma_plugin_error_notice' );
	}
}
