<?php
/**
 * Add the update plugin functionality.
 *
 * @link  https://wpswings.com/
 * @since 1.0.0
 *
 * @package woocommerce-rma-for-return-refund-and-exchange
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Update' ) ) {
	/**
	 * Add the update plugin functionality.
	 *
	 * @link  https://wpswings.com/
	 * @since 1.0.0
	 *
	 * @package woocommerce-rma-for-return-refund-and-exchange
	 */
	class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Update {
		/** Main Constructor */
		public function __construct() {
			register_activation_hook( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_BASE_FILE, array( $this, 'wps_check_activation' ) );
			add_action( 'wps_rma_return_refund_exchange_for_woocommerce_pro_check_event', array( $this, 'wps_rma_check_update' ) );
			add_filter( 'http_request_args', array( $this, 'wps_updates_exclude' ), 5, 2 );
			register_deactivation_hook( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_BASE_FILE, array( $this, 'wps_check_deactivation' ) );

			$plugin_update = get_option( 'wps_mwr_plugin_update', false );
			if ( $plugin_update ) {

				// To add view details content in plugin update notice on plugins page.
				add_action( 'install_plugins_pre_plugin-information', array( $this, 'wps_mwr_details' ) );
				// To add plugin update notice after plugin update message.
				add_action( 'in_plugin_update_message-woocommerce-rma-for-return-refund-and-exchange/mwb-woocommerce-rma.php', array( $this, 'wps_mwr_in_plugin_update_notice' ), 10, 2 );
			}

		}
		/** Clear schedule on the deactivation */
		public function wps_check_deactivation() {
			wp_clear_scheduled_hook( 'wps_rma_return_refund_exchange_for_woocommerce_pro_check_event' );
		}

		/** Shedule event to check updation */
		public function wps_check_activation() {
			wp_schedule_event( time(), 'daily', 'wps_rma_return_refund_exchange_for_woocommerce_pro_check_event' );
		}

		/** Show install_plugins_pre_plugin-information */
		public function wps_mwr_details() {
			global $tab;
			// change $_REQUEST['plugin] to your plugin slug name.
			if ( 'plugin-information' === $tab && isset( $_REQUEST['plugin'] ) && 'woocommerce-rma-for-return-refund-and-exchange' === $_REQUEST['plugin'] ) {

				$data = $this->get_plugin_update_data();

				if ( is_wp_error( $data ) || empty( $data ) ) {

					return;
				}

				if ( ! empty( $data['body'] ) ) {

					$all_data = json_decode( $data['body'], true );

					if ( ! empty( $all_data ) && is_array( $all_data ) ) {

						$this->create_html_data( $all_data );

						die();
					}
				}
			}
		}

		/** Update plugin data */
		public function get_plugin_update_data() {

			// replace with your plugin url.
			$url      = 'https://wpswings.com/pluginupdates/woocommerce-rma-for-return-refund-and-exchange/update.php';
			$postdata = array(
				'action'       => 'check_update',
				'license_code' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_LICENSE_KEY,
			);

			$args = array(
				'method' => 'POST',
				'body'   => $postdata,
			);

			$data = wp_remote_post( $url, $args );

			return $data;
		}
		/**
		 * Render HTML content.
		 *
		 * @param array() $all_data is the plugin data .
		 * @return void
		 */
		public function create_html_data( $all_data ) {
			?>
			<style>
				#TB_window{
					top : 4% !important;
				}
				.wps_mwr_banner > img {
					width: 50%;
				}
				.wps_mwr_banner > h1 {
					margin-top: 0px;
				}
				.wps_mwr_banner {
					text-align: center;
				}
				.wps_mwr_description > h4 {
					background-color: #3779B5;
					padding: 5px;
					color: #ffffff;
					border-radius: 5px;
				}
				.wps_mwr_changelog_details > h4 {
					background-color: #3779B5;
					padding: 5px;
					color: #ffffff;
					border-radius: 5px;
				}
			</style>
			<div class="wps_mwr_details_wrapper">
				<div class="wps_mwr_banner">
					<h1><?php echo wp_kses_post( $all_data['name'] ) . ' ' . wp_kses_post( $all_data['version'] ); ?></h1>
					<img src="<?php echo esc_html( $all_data['banners']['logo'] ); ?>"> 
				</div>

				<div class="wps_mwr_description">
					<h4><?php esc_html_e( 'Plugin Description', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></h4>
					<span><?php echo wp_kses_post( $all_data['sections']['description'] ); ?></span>
				</div>
				<div class="wps_mwr_changelog_details">
					<h4><?php esc_html_e( 'Plugin Change Log', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></h4>
					<span><?php echo wp_kses_post( $all_data['sections']['changelog'] ); ?></span>
				</div> 
			</div>
			<?php
		}

		/** Show update notice. */
		public function wps_mwr_in_plugin_update_notice() {
			$data = $this->get_plugin_update_data();

			if ( is_wp_error( $data ) || empty( $data ) ) {

				return;
			}

			if ( isset( $data['body'] ) ) {

				$all_data = json_decode( $data['body'], true );

				if ( is_array( $all_data ) && ! empty( $all_data['sections']['update_notice'] ) ) {

					?>

					<style type="text/css">
						#rma-return-refund-exchange-for-woocommerce-pro-update .dummy {
							display: none;
						}

						#wps_mwr_in_plugin_update_div p:before {
							content: none;
						}

						#wps_mwr_in_plugin_update_div {
							border-top: 1px solid #ffb900;
							margin-left: -13px;
							padding-left: 20px;
							padding-top: 10px;
							padding-bottom: 5px;
						}

						#wps_mwr_in_plugin_update_div ul {
							list-style-type: decimal;
							padding-left: 20px;
						}
						.dummy {
							display: none;
						}

					</style>

					<?php

					echo '</p><div id="wps_mwr_in_plugin_update_div">' . wp_kses_post( $all_data['sections']['update_notice'] ) . '</div><p class="dummy">';
				}
			}
		}

		/** Check the plugin update */
		public function wps_rma_check_update() {
			global $wp_version;
			$update_check_mwr = 'https://wpswings.com/pluginupdates/woocommerce-rma-for-return-refund-and-exchange/update.php';
			$plugin_folder    = plugin_basename( dirname( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_BASE_FILE ) );
			$plugin_file      = basename( ( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_BASE_FILE ) );
			if ( defined( 'WP_INSTALLING' ) ) {
				return false;
			}
			$postdata = array(
				'action'      => 'check_update',
				'license_key' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_LICENSE_KEY,
			);

			$args = array(
				'method' => 'POST',
				'body'   => $postdata,
			);

			$response = wp_remote_post( $update_check_mwr, $args );
			if ( is_wp_error( $response ) || empty( $response['body'] ) ) {

				return;
			}
			if ( empty( $response['response']['code'] ) || 200 !== (int) $response['response']['code'] ) {

				$plugin_transient  = get_site_transient( 'update_plugins' );
				unset( $plugin_transient->response[ $plugin_folder . '/' . $plugin_file ] );
				set_site_transient( 'update_plugins', $plugin_transient );
				return;
			}

			list($version, $url) = explode( '~', $response['body'] );
			if ( $this->wps_plugin_get( 'Version' ) >= $version ) {

				update_option( 'wps_mwr_plugin_update', false );

				return false;
			}

			update_option( 'wps_mwr_plugin_update', true );

			$plugin_transient = get_site_transient( 'update_plugins' );
			$a                = array(
				'slug'        => $plugin_folder,
				'new_version' => $version,
				'url'         => $this->wps_plugin_get( 'AuthorURI' ),
				'package'     => $url,
			);
			$o                = (object) $a;
			$plugin_transient->response[ $plugin_folder . '/' . $plugin_file ] = $o;
			set_site_transient( 'update_plugins', $plugin_transient );
		}

		/**
		 * Exclude update
		 *
		 * @param array  $r .
		 * @param string $url .
		 */
		public function wps_updates_exclude( $r, $url ) {
			if ( 0 !== strpos( $url, 'http://api.wordpress.org/plugins/update-check' ) ) {
				return $r;
			}
			$plugins = unserialize( $r['body']['plugins'] );
			if ( ! empty( $plugins->plugins ) ) {
				unset( $plugins->plugins[ plugin_basename( __FILE__ ) ] );
			}
			if ( ! empty( $plugins->active ) ) {
				unset( $plugins->active[ array_search( plugin_basename( __FILE__ ), $plugins->active ) ] );
			}
			$r['body']['plugins'] = serialize( $plugins );
			return $r;
		}

		/**
		 * Returns current plugin info.
		 *
		 * @param string $i .
		 */
		public function wps_plugin_get( $i ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$plugin_folder = get_plugins( '/' . plugin_basename( dirname( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_BASE_FILE ) ) );
			$plugin_file   = basename( ( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_BASE_FILE ) );
			return $plugin_folder[ $plugin_file ][ $i ];
		}
	}
	new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Update();
}
