<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://wpswings.com/
 * @since 1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin
 */
class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @var   string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/admin_setting/class-wps-rma-policies-setting-html.php';
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/admin_setting/class-wps-rma-setting-extend.php';
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/admin_setting/class-wps-rma-returnship-html.php';
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function mwr_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();

		if ( isset( $screen->id ) && 'wp-swings_page_woo_refund_and_exchange_lite_menu' === $screen->id || 'wpswings_page_woo_refund_and_exchange_lite_menu' === $screen->id ) {

			wp_enqueue_style( 'wps-mwr-select2-css', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/select-2/rma-return-refund-exchange-for-woocommerce-pro-select2.css', array(), time(), 'all' );
			wp_enqueue_style( 'wps-mwr-meterial-lite', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'wps-mwr-meterial-icons-css', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( $this->plugin_name . '-wps-admin-min-css', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'admin/css/wps-rma-return-refund-exchange-for-woocommerce-pro-admin.min.css', array(), $this->version, 'all' );
		}
		if ( isset( $screen->id ) && 'shop_order' === $screen->id ) {
			wp_enqueue_style( 'wps-datatable-css', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'admin/css/wps-rma-return-refund-exchange-for-woocommerce-pro-order-edit-page.min.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 * @param string $hook The plugin page slug.
	 */
	public function mwr_admin_enqueue_scripts( $hook ) {
		global $pagenow;
		$screen                 = get_current_screen();

		if ( isset( $screen->id ) && 'wp-swings_page_woo_refund_and_exchange_lite_menu' === $screen->id || 'wpswings_page_woo_refund_and_exchange_lite_menu' === $screen->id || 'shop_order' === $screen->id || 'users' === $screen->id || 'plugins' === $screen->id || 'edit-shop_order' === $screen->id || 'users' === $screen->id || 'profile' === $screen->id || 'user-edit' === $screen->id ) {
			wp_enqueue_script( 'wps-mwr-select2', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/select-2/rma-return-refund-exchange-for-woocommerce-pro-select2.js', array( 'jquery' ), time(), false );

			wp_enqueue_script( 'wps-mwr-metarial-js', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'wps-mwr-metarial-js2', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'wps-mwr-metarial-lite', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );
			wp_enqueue_script( 'wps-mwr-datatable', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/datatables.net/js/jquery.dataTables.min.js', array(), time(), false );
			wp_enqueue_script( 'wps-mwr-datatable-btn', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/datatables.net/buttons/dataTables.buttons.min.js', array(), time(), false );
			wp_enqueue_script( 'wps-mwr-datatable-btn-2', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'package/lib/datatables.net/buttons/buttons.html5.min.js', array(), time(), false );
			wp_register_script( $this->plugin_name . 'admin-js', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'admin/js/wps-rma-return-refund-exchange-for-woocommerce-pro-admin.min.js', array( 'jquery', 'wps-mwr-select2', 'wps-mwr-metarial-js', 'wps-mwr-metarial-js2', 'wps-mwr-metarial-lite' ), $this->version, false );
			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'mwr_admin_param',
				array(
					'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
					'reloadurl'                => admin_url( 'admin.php?page=woo_refund_and_exchange_lite_menu' ),
					'mwr_gen_tab_enable'       => get_option( 'mwr_radio_switch_demo' ),
					'mwr_admin_param_location' => ( admin_url( 'admin.php' ) . '?page=woo_refund_and_exchange_lite_menu' ),
					'wps_rma_nonce'            => wp_create_nonce( 'wps_rma_ajax_security' ),
					'wps_rma_currency_symbol'  => get_woocommerce_currency_symbol(),

				)
			);
			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
	}

	/**
	 * Wps_developer_admin_hooks_listing .
	 *
	 * @param array $admin_hooks .
	 */
	public function wrael_developer_admin_hooks_array_callback( $admin_hooks ) {
		$val = $this->wps_developer_hooks_function( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/' );
		if ( ! empty( $val['hooks'] ) ) {
			$admin_hooks[] = $val['hooks'];
			unset( $val['hooks'] );
		}
		$data = array();
		foreach ( $val['files'] as $v ) {
			if ( 'css' !== $v && 'js' !== $v && 'images' !== $v ) {
				$helo = $this->wps_developer_hooks_function( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/' . $v . '/' );
				if ( ! empty( $helo['hooks'] ) ) {
					$admin_hooks[] = $helo['hooks'];
					unset( $helo['hooks'] );
				}
				if ( ! empty( $helo ) ) {
					$data[] = $helo;
				}
			}
		}
		return $admin_hooks;
	}

	/**
	 * Wps_developer_public_hooks_listing .
	 *
	 * @param array $public_hooks .
	 */
	public function wrael_developer_public_hooks_array_callback( $public_hooks ) {
		$val = $this->wps_developer_hooks_function( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'public/' );

		if ( ! empty( $val['hooks'] ) ) {
			$public_hooks[] = $val['hooks'];
			unset( $val['hooks'] );
		}
		$data = array();
		foreach ( $val['files'] as $v ) {
			if ( 'css' !== $v && 'js' !== $v && 'images' !== $v ) {
				$helo = $this->wps_developer_hooks_function( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'public/' . $v . '/' );
				if ( ! empty( $helo['hooks'] ) ) {
					$public_hooks[] = $helo['hooks'];
					unset( $helo['hooks'] );
				}
				if ( ! empty( $helo ) ) {
					$data[] = $helo;
				}
			}
		}
		return $public_hooks;
	}
	/**
	 * Wps_developer_hooks_function .
	 *
	 * @param string $path .
	 */
	public function wps_developer_hooks_function( $path ) {
		$all_hooks = array();
		$scan      = scandir( $path );
		$response  = array();
		foreach ( $scan as $file ) {
			if ( strpos( $file, '.php' ) ) {
				$myfile = file( $path . $file );
				foreach ( $myfile as $key => $lines ) {
					if ( preg_match( '/do_action/i', $lines ) && ! strpos( $lines, 'str_replace' ) && ! strpos( $lines, 'preg_match' ) ) {
						$all_hooks[ $key ]['action_hook'] = $lines;
						$all_hooks[ $key ]['desc']        = $myfile[ $key - 1 ];
					}
					if ( preg_match( '/apply_filters/i', $lines ) && ! strpos( $lines, 'str_replace' ) && ! strpos( $lines, 'preg_match' ) ) {
						$all_hooks[ $key ]['filter_hook'] = $lines;
						$all_hooks[ $key ]['desc']        = $myfile[ $key - 1 ];
					}
				}
			} elseif ( strpos( $file, '.' ) == '' && strpos( $file, '.' ) !== 0 ) {
				$response['files'][] = $file;
			}
		}
		if ( ! empty( $all_hooks ) ) {
			$response['hooks'] = $all_hooks;
		}
		return $response;
	}

	/**
	 * WP Swings WooCommerce Rma save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function mwr_admin_save_tab_settings() {
		global $mwr_wps_mwr_obj;
		if ( isset( $_POST['mwr_button_demo'] ) || isset( $_POST['wps_rma_save_wallet_setting'] ) || isset( $_POST['wps_rma_save_exchange_setting'] ) || isset( $_POST['wps_rma_save_cancel_setting'] )
			&& ( ! empty( $_POST['wps_tabs_nonce'] )
			&& wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wps_tabs_nonce'] ) ), 'admin_save_data' ) )
		) {
			$wps_mwr_gen_flag = false;
			if ( isset( $_POST['mwr_button_demo'] ) ) {
					$wrael_genaral_settings =
				// The general tab settings.
				apply_filters( 'mwr_general_settings_array', array() );
			} elseif ( isset( $_POST['wps_rma_save_wallet_setting'] ) ) {
				$mwr_genaral_settings =
				// The wallet tab settings.
				apply_filters( 'wps_rma_wallet_settings_array', array() );
			} elseif ( isset( $_POST['wps_rma_save_exchange_setting'] ) ) {
				$mwr_genaral_settings =
				// The exchange tab settings.
				apply_filters( 'wps_rma_exchange_settings_array', array() );
			} elseif ( isset( $_POST['wps_rma_save_cancel_setting'] ) ) {
				$mwr_genaral_settings =
				// The cancel tab settings.
				apply_filters( 'wps_rma_cancel_settings_array', array() );
			}
			$mwr_button_index = array_search( 'submit', array_column( $mwr_genaral_settings, 'type' ), true );
			if ( isset( $mwr_button_index ) && ( null == $mwr_button_index || '' == $mwr_button_index ) ) {
				$mwr_button_index = array_search( 'button', array_column( $mwr_genaral_settings, 'type' ), true );
			}
			if ( isset( $mwr_button_index ) && '' !== $mwr_button_index ) {
				unset( $mwr_genaral_settings[ $mwr_button_index ] );
				if ( is_array( $mwr_genaral_settings ) && ! empty( $mwr_genaral_settings ) ) {
					foreach ( $mwr_genaral_settings as $mwr_genaral_setting ) {
						if ( isset( $mwr_genaral_setting['id'] ) && '' !== $mwr_genaral_setting['id'] ) {
							if ( isset( $_POST[ $mwr_genaral_setting['id'] ] ) ) {
								if ( 'textarea' === $mwr_genaral_setting['type'] || 'text' === $mwr_genaral_setting['type'] ) {
									$setting = sanitize_text_field( wp_unslash( $_POST[ $mwr_genaral_setting['id'] ] ) );
									$setting = trim( preg_replace( '/\s\s+/', ' ', $setting ) );
								}
								if ( 'wps_rma_exchange_rules_editor' === $mwr_genaral_setting['id'] ) {
									update_option( 'wps_rma_exchange_rules_editor', wp_kses_post( wp_unslash( $_POST[ $mwr_genaral_setting['id'] ] ) ) );
								} elseif ( 'wps_rma_exchange_form_css' === $mwr_genaral_setting['id'] ) {
									update_option( 'wps_rma_exchange_form_css', wp_kses_post( wp_unslash( $_POST[ $mwr_genaral_setting['id'] ] ) ) );
								} else {
									update_option( sanitize_text_field( wp_unslash( $mwr_genaral_setting['id'] ) ), is_array( $_POST[ $mwr_genaral_setting['id'] ] ) ? map_deep( wp_unslash( $_POST[ $mwr_genaral_setting['id'] ] ), 'sanitize_text_field' ) : stripslashes( sanitize_text_field( wp_unslash( $_POST[ $mwr_genaral_setting['id'] ] ) ) ) ); // phpcs:ignore
								}
							} else {
								update_option( sanitize_text_field( wp_unslash( $mwr_genaral_setting['id'] ) ), '' );
							}
						} else {
							$wps_mwr_gen_flag = true;
						}
					}
				}
				if ( $wps_mwr_gen_flag ) {
					$wps_mwr_error_text = esc_html__( 'Id of some field is missing', 'woocommerce-rma-for-return-refund-and-exchange' );
					$mwr_wps_mwr_obj->wps_mwr_plug_admin_notice( $wps_mwr_error_text, 'error' );
				} else {
					$wps_mwr_error_text = esc_html__( 'Settings saved !', 'woocommerce-rma-for-return-refund-and-exchange' );
					$mwr_wps_mwr_obj->wps_mwr_plug_admin_notice( $wps_mwr_error_text, 'success' );
				}
			}
		}
	}

	/**
	 * Sanitation for an array
	 *
	 * @param $array $wps_input_array .
	 *
	 * @return array
	 */
	public function wps_sanitize_array( $wps_input_array ) {
		if ( ! empty( $wps_input_array ) ) {
			foreach ( $wps_input_array as $key => $value ) {
				$key   = sanitize_text_field( $key );
				$value = stripslashes( sanitize_text_field( $value ) );
			}
		}
		return $wps_input_array;
	}

	/**
	 * Checking wpswings license on daily basis
	 *
	 * @since 1.0.0
	 */
	public function wps_mwr_check_license() {

		$user_license_key = get_option( 'wps_mwr_license_key', '' );

		$server_name = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';

		$api_params = array(
			'slm_action'         => 'slm_check',
			'secret_key'         => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY,
			'license_key'        => $user_license_key,
			'_registered_domain' => is_multisite() ? site_url() : $server_name,
			'item_reference'     => urlencode( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE ),
			'product_reference'  => 'WPSPK-67570',
		);

		$query = esc_url_raw( add_query_arg( $api_params, RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL ) );

		$wps_response = wp_remote_get(
			$query,
			array(
				'timeout'   => 20,
				'sslverify' => false,
			)
		);
		$license_data = json_decode( wp_remote_retrieve_body( $wps_response ) );

		if ( isset( $license_data->result ) && 'success' === $license_data->result && isset( $license_data->status ) && 'active' === $license_data->status ) {

			update_option( 'wps_mwr_license_check', true );

		} else {

			delete_option( 'wps_mwr_license_check' );
		}
	}

	/**
	 * Plugin org setting tab addon
	 *
	 * @param array $mwr_default_tabs .
	 */
	public function wps_rma_plugin_admin_settings_tabs_addon_before( $mwr_default_tabs ) {
		$mwr_default_tabs['rma-return-refund-exchange-for-woocommerce-pro-exchange'] = array(
			'title'     => esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'name'      => 'rma-return-refund-exchange-for-woocommerce-pro-exchange',
			'file_path' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-exchange.php',
		);
		$mwr_default_tabs['rma-return-refund-exchange-for-woocommerce-pro-cancel']   = array(
			'title'     => esc_html__( 'Cancel', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'name'      => 'rma-return-refund-exchange-for-woocommerce-pro-cancel',
			'file_path' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-cancel.php',
		);
		return $mwr_default_tabs;
	}

	/**
	 * Plugin org setting tab addon
	 *
	 * @param array $mwr_default_tabs .
	 */
	public function wps_rma_plugin_admin_settings_tabs_addon_after( $mwr_default_tabs ) {
		$mwr_default_tabs['rma-return-refund-exchange-for-woocommerce-pro-wallet']           = array(
			'title'     => esc_html__( 'Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'name'      => 'rma-return-refund-exchange-for-woocommerce-pro-wallet',
			'file_path' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-wallet.php',
		);
		$mwr_default_tabs['rma-return-refund-exchange-for-woocommerce-pro-global-shipping']  = array(
			'title'     => esc_html__( 'Global Shipping', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'name'      => 'rma-return-refund-exchange-for-woocommerce-pro-global-shipping',
			'file_path' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-global-shipping.php',
		);
		$mwr_default_tabs['rma-return-refund-exchange-for-woocommerce-pro-returnship-label'] = array(
			'title'     => esc_html__( 'Integration', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'name'      => 'rma-return-refund-exchange-for-woocommerce-pro-returnship-label',
			'file_path' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-returnship-label.php',
		);
		return $mwr_default_tabs;
	}
	/**
	 * Plugin org setting tab addon
	 *
	 * @param array $mwr_default_tabs .
	 */
	public function wps_rma_plugin_standard_admin_settings_tabs( $mwr_default_tabs ) {
		if ( ! get_option( 'wps_mwr_license_check', 0 ) ) {
			$mwr_default_tabs['rma-return-refund-exchange-for-woocommerce-pro-license'] = array(
				'title'     => esc_html__( 'License', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'name'      => 'rma-return-refund-exchange-for-woocommerce-pro-license',
				'file_path' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-license.php',
			);
		}
		$mwr_default_tabs['rma-return-refund-exchange-for-woocommerce-pro-system-status'] = array(
			'title'     => esc_html__( 'System Status', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'name'      => 'rma-return-refund-exchange-for-woocommerce-pro-system-status',
			'file_path' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-system-status.php',
		);
		return $mwr_default_tabs;
	}

	/**
	 * Validating wpswings license.
	 *
	 * @since    1.0.0
	 */
	public function wps_mwr_validate_license_key() {
		check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		$wps_mwr_purchase_code = isset( $_POST['purchase_code'] ) ? sanitize_text_field( wp_unslash( $_POST['purchase_code'] ) ) : '';
		global $wpdb;
		// check if the plugin has been activated on the network.
		if ( is_multisite() ) {
			// Get all blogs in the network and activate plugins on each one.
			if ( function_exists( 'get_sites' ) ) {
				$blog_ids = get_sites( array( 'fields' => 'ids' ) );
			} else {
				$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			}
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$response = wps_rma_license_activate( $wps_mwr_purchase_code );
				if ( ! $response['status'] ) {
					echo wp_json_encode( $response );
					break;
				}
				restore_current_blog();
			}
		} else {
			// activated on a single site, in a multi-site or on a single site.
			$response = wps_rma_license_activate( $wps_mwr_purchase_code );
			echo wp_json_encode( $response );
		}
		wp_die();
	}

	/**
	 * General setting extend
	 *
	 * @param array $wps_rma_settings_general .
	 */
	public function wps_rma_general_setting_extend( $wps_rma_settings_general ) {
		$setting_obj = new Wps_Rma_Setting_Extend();
		return $setting_obj->wps_rma_general_setting_extend_set( $wps_rma_settings_general );
	}

	/**
	 * Refund setting extend
	 *
	 * @param array $wps_rma_settings_refund .
	 */
	public function wps_rma_refund_setting_extend( $wps_rma_settings_refund ) {
		$setting_obj = new Wps_Rma_Setting_Extend();
		return $setting_obj->wps_rma_refund_setting_extend_set( $wps_rma_settings_refund );

	}

	/**
	 * Refund appearance setting extend
	 *
	 * @param array $refund_app_setting_extend .
	 */
	public function wps_rma_refund_appearance_setting_extend( $refund_app_setting_extend ) {
		$setting_obj = new Wps_Rma_Setting_Extend();
		return $setting_obj->wps_rma_refund_appearance_setting_extend_set( $refund_app_setting_extend );

	}

	/**
	 * Exchange setting register.
	 *
	 * @param array $wps_rma_settings_exchange .
	 */
	public function wps_rma_exchange_settings_array( $wps_rma_settings_exchange ) {
		$setting_obj = new Wps_Rma_Setting_Extend();
		return $setting_obj->wps_rma_exchange_settings_array_set( $wps_rma_settings_exchange );
	}

	/**
	 * Cancel setting register.
	 *
	 * @param array $wps_rma_settings_cancel .
	 */
	public function wps_rma_cancel_settings_array( $wps_rma_settings_cancel ) {
		$setting_obj = new Wps_Rma_Setting_Extend();
		return $setting_obj->wps_rma_cancel_settings_array_set( $wps_rma_settings_cancel );

	}

	/**
	 * Wallet setting register.
	 *
	 * @param array $wps_rma_settings_wallet .
	 */
	public function wps_rma_wallet_settings_array( $wps_rma_settings_wallet ) {
		$setting_obj = new Wps_Rma_Setting_Extend();
		return $setting_obj->wps_rma_wallet_settings_array_set( $wps_rma_settings_wallet );
	}

	/**
	 * Order message seting extend.
	 *
	 * @param array $cancel_setting_array .
	 */
	public function wps_rma_order_message_setting_extend( $cancel_setting_array ) {
		$setting_obj = new Wps_Rma_Setting_Extend();
		return $setting_obj->wps_rma_order_message_setting_extend_set( $cancel_setting_array );

	}

	/**
	 * Policy Setting column1 extend.
	 */
	public function wps_rma_setting_extend_column1() {
		$setting_obj = new Wps_Rma_Policies_Setting_Html();
		$setting_obj->wps_rma_setting_extend_column1_set();
	}

	/**
	 * Policy Setting column1 extend.
	 *
	 * @param string $value .
	 * @return void
	 */
	public function wps_rma_setting_extend_show_column1( $value ) {
		$setting_obj = new Wps_Rma_Policies_Setting_Html();
		$setting_obj->wps_rma_setting_extend_show_column1_set( $value );
	}


	/** Policy Setting column3 extend. */
	public function wps_rma_setting_extend_column3() {
		$setting_obj = new Wps_Rma_Policies_Setting_Html();
		$setting_obj->wps_rma_setting_extend_column3_set();
	}

	/**
	 * Policy Setting column3 extend.
	 *
	 * @param array $value .
	 */
	public function wps_rma_setting_extend_show_column3( $value ) {
		$setting_obj = new Wps_Rma_Policies_Setting_Html();
		$setting_obj->wps_rma_setting_extend_show_column3_set( $value );
	}

	/** Policy Setting column5 extend */
	public function wps_rma_setting_extend_column5() {
		$setting_obj = new Wps_Rma_Policies_Setting_Html();
		$setting_obj->wps_rma_setting_extend_column5_set();
	}

	/**
	 * Policy Setting column5 extend.
	 *
	 * @param string $value .
	 * @param string $count .
	 * @return void
	 */
	public function wps_rma_setting_extend_show_column5( $value, $count ) {
		$setting_obj = new Wps_Rma_Policies_Setting_Html();
		$setting_obj->wps_rma_setting_extend_show_column5_set( $value, $count );
	}

	/** Add the exchange metabox */
	public function wps_wrma_product_exchange_meta_box() {
		add_meta_box(
			'wps_wrma_order_exchange',
			esc_html__( 'Exchange Products Requested', 'woocommerce-rma-for-return-refund-and-exchange' ),
			array( $this, 'wps_wrma_order_exchange' ),
			'shop_order'
		);
	}

	/** Add the exchange product meta */
	public function wps_wrma_order_exchange() {
		global $post, $thepostid, $theorder;
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-exchange-meta.php';
	}

	/** Save Ship setting */
	public function wps_wrma_save_ship_setting() {
		if ( isset( $_POST['save_ship_setting'] ) && isset( $_POST['get_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['get_nonce'] ) ), 'create_form_nonce' ) ) {
			$wps_enable_ship_setting = isset( $_POST['wps_enable_ship_setting'] ) ? sanitize_text_field( wp_unslash( $_POST['wps_enable_ship_setting'] ) ) : '';
			$wps_rnx_shipping_name   = isset( $_POST['add_ship_fee_name'] ) ? map_deep( wp_unslash( $_POST['add_ship_fee_name'] ), 'sanitize_text_field' ) : array();
			$wps_rnx_shipping_cost   = isset( $_POST['add_ship_fee_cost'] ) ? map_deep( wp_unslash( $_POST['add_ship_fee_cost'] ), 'sanitize_text_field' ) : array();
			$wps_ship_pro_cb         = isset( $_POST['wps_ship_pro_cb'] ) ? sanitize_text_field( wp_unslash( $_POST['wps_ship_pro_cb'] ) ) : '';
			$wps_ship_pro_types      = isset( $_POST['wps_wrma_ship_products'] ) ? map_deep( wp_unslash( $_POST['wps_wrma_ship_products'] ), 'sanitize_text_field' ) : array();
			$wps_rnx_global_shipping = array();
			$wps_rnx_global_shipping = array(
				'enable'   => $wps_enable_ship_setting,
				'fee_name' => $wps_rnx_shipping_name,
				'fee_cost' => $wps_rnx_shipping_cost,
				'pro_cb'   => $wps_ship_pro_cb,
				'ship_pro' => $wps_ship_pro_types,
			);
			update_option( 'wps_wrma_shipping_global_data', $wps_rnx_global_shipping );
		}
		if ( isset( $_POST['wps_wrma_noti_save_return_slip'] ) ) {
			unset( $_POST['wps_wrma_noti_save_return_slip'] );
			$post = $_POST;
			foreach ( $post as $k => $val ) {
				update_option( $k, $val );
			}
			if ( ! isset( $post['wps_wrma_enable_return_ship_label'] ) ) {
				update_option( 'wps_wrma_enable_return_ship_label', 'no' );
			}
			if ( ! isset( $post['wps_wrma_enable_return_ship_station_label'] ) ) {
				update_option( 'wps_wrma_enable_return_ship_station_label', 'no' );
			}
			if ( ! isset( $post['wps_wrma_enable_ss_return_ship_station_label'] ) ) {
				update_option( 'wps_wrma_enable_ss_return_ship_station_label', 'no' );
			}
		}
		if ( isset( $_POST['wps_wrma_save_shipstation'] ) ) {
			unset( $_POST['wps_wrma_save_shipstation'] );
			$post = $_POST;
			foreach ( $post as $k => $val ) {
				update_option( $k, $val );
			}
			if ( ! isset( $post['wps_wrma_ship_station_state'] ) ) {
				update_option( 'wps_wrma_ship_station_state', '' );
			}
		}
	}

	/**
	 * Show sipping fee fields
	 *
	 * @param string $order_id .
	 * @return void
	 */
	public function wps_rma_global_shipping_fee( $order_id ) {
		$setting_obj = new Wps_Rma_Policies_Setting_Html();
		$setting_obj->wps_rma_global_shipping_fee_set( $order_id );

	}

	/**
	 * Refund the amount
	 *
	 * @param array $data .
	 * @return true
	 */
	public function wps_rma_refund_price( $data ) {
		$order_id        = isset( $data['order_id'] ) ? sanitize_text_field( wp_unslash( $data['order_id'] ) ) : '';
		$refund_amount   = isset( $data['refund_amount'] ) ? sanitize_text_field( wp_unslash( $data['refund_amount'] ) ) : '';
		$order           = wc_get_order( $order_id );
		$customer_email  = $order->billing_email;
		$today           = gmdate( 'F j, Y' );
		$timezone_format = esc_html( 'h:i a' );
		$time            = date_i18n( $timezone_format );
		$mess            = '#' . $order_id . ' Refund  - ' . get_woocommerce_currency_symbol() . $refund_amount . ' ' . $today . ', ' . $time . ' by admin in wallet';

		$enable_wallet_plugin = get_option( 'wps_rma_wallet_plugin', true );
		// Active Plugins.
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		if ( 'on' === $enable_wallet_plugin && in_array( 'wallet-system-for-woocommerce/wallet-system-for-woocommerce.php', $active_plugins ) ) {
			$flag_return = true;
			include_once WP_PLUGIN_DIR . 'wallet-system-for-woocommerce/includes/class-wallet-system-for-woocommerce.php';
			$wallet_payment_gateway              = new Wallet_System_For_Woocommerce();
			$transactiondata                     = array();
			$transactiondata['user_id']          = $order->get_user_id();
			$transactiondata['amount']           = $refund_amount;
			$transactiondata['currency']         = $order->get_currency();
			$transactiondata['transaction_type'] = $mess;
			$transactiondata['payment_method']   = esc_html__( 'Manually By Admin(RMA)', 'woocommerce-rma-for-return-refund-and-exchange' );
			$transactiondata['transaction_id']   = $order_id;
			$transactiondata['note']             = '';
			$trans_id                            = $wallet_payment_gateway->insert_transaction_data_in_table( $transactiondata );
			$wallet_amount                       = get_user_meta( get_current_user_id(), 'wps_wallet', true );
			update_user_meta( get_current_user_id(), 'wps_wallet', $wallet_amount + $refund_amount );
		} else {
			$value       = get_post_meta( $order_id, '_customer_user', true );
			$customer_id = $value ? absint( $value ) : '';
			if ( $customer_id > 0 ) {
				$walletcoupon = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
				if ( empty( $walletcoupon ) ) {
					$coupon_code        = wps_rma_coupon_generator( 5 ); // Code .
					$amount             = $refund_amount; // Amount .
					$coupon_description = esc_html__( 'REFUND ACCEPTED - ORDER ', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $order_id;

					$coupon = array(
						'post_title'   => $coupon_code,
						'post_content' => $coupon_description,
						'post_excerpt' => $coupon_description,
						'post_status'  => 'publish',
						'post_author'  => get_current_user_id(),
						'post_type'    => 'shop_coupon',
					);
					$new_coupon_id = wp_insert_post( $coupon );

					update_post_meta( $new_coupon_id, 'discount_type', 'fixed_cart' );
					update_post_meta( $new_coupon_id, 'wrmawallet', true );
					update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $coupon_code );
					update_post_meta( $new_coupon_id, 'customer_email', $customer_email );
					update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
				} else {
					$the_coupon = new WC_Coupon( $walletcoupon );
					$coupon_id  = $the_coupon->get_id();
					if ( isset( $coupon_id ) ) {
						$amount           = get_post_meta( $coupon_id, 'coupon_amount', true );
						$remaining_amount = $amount + $refund_amount;

						update_post_meta( $coupon_id, 'coupon_amount', $remaining_amount );
						update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $walletcoupon );
						update_post_meta( $coupon_id, 'wrmawallet', true );
					}
				}
				$flag_return = true;
			}
		}
		if ( $flag_return ) {
			remove_action( 'woocommerce_order_partially_refunded', 2 );
			remove_action( 'woocommerce_order_fully_refunded', 2 );
			wc_create_refund(
				array(
					'amount'         => $refund_amount,
					'reason'         => $mess,
					'order_id'       => $order_id,
					'refund_payment' => false,
				)
			);
			$order_total = $order->calculate_totals();

		}
		$mail =
		// Refund Amount Amount Mail.
		apply_filters( 'refund_amount_mail', true );
		if ( $mail ) {
			// Refund Amount Email Template.
			do_action( 'wps_rma_refunded_amount_mail', $order_id, $refund_amount );
		}
		$order->save();
		$order->calculate_totals();
		update_post_meta( $order_id, 'refundable_amount', '0' );
		update_post_meta( $order_id, 'refund_amount_refunded', '1' );
		return true;
	}

	/**
	 * Add wallet Coupon column on user list page.
	 *
	 * @param array $column .
	 */
	public function wps_rma_add_coupon_column( $column ) {
		if ( wps_rma_wallet_feature_enable() ) {
			$column['wps_rma_coupon_column'] = esc_html__( 'User Wallet', 'woocommerce-rma-for-return-refund-and-exchange' );
		}
		return $column;
	}

	/**
	 * Add user wallet data to the custom column created.
	 *
	 * @param [type] $val .
	 * @param [type] $column_name .
	 * @param [type] $user_id .
	 */
	public function wps_rma_add_coupon_column_row( $val, $column_name, $user_id ) {
		switch ( $column_name ) {
			case 'wps_rma_coupon_column':
				$coupon_code = get_user_meta( $user_id, 'wps_wrma_refund_wallet_coupon', true );
				$the_coupon  = new WC_Coupon( $coupon_code );
				if ( WC()->version < '3.0.0' ) {
					$coupon_id = $the_coupon->id;
				} else {
					$coupon_id = $the_coupon->get_id();
				}
				if ( isset( $coupon_id ) && '' != $coupon_id ) {
					$coupon_amount = get_post_meta( $coupon_id, 'coupon_amount', true );
					$coupon_amount = wc_price( $coupon_amount );
					$val           = $coupon_code . '<br><b>( ' . $coupon_amount . ' )</b>';
					return $val;
				} else {
					$val = '<div id="user' . $user_id . '"><input type="button" class="button button-primary wps_rma_add_customer_wallet" data-id = "' . $user_id . '" id="wps_wrma_add_customer_wallet-' . $user_id . '" value="Create Wallet"><img id="regenerate_coupon_code_image-' . $user_id . '" src = ' . RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'admin/image/loading.gif width="20px" style="display:none;"></div>';
				}
				break;
			default:
		}
		return $val;
	}
	/**
	 * Add Wallet Coupon amount change field on user edit page .
	 *
	 * @param object $user .
	 */
	public function wps_rma_add_customer_wallet_price_field( $user ) {
		$coupon_code = get_user_meta( $user->ID, 'wps_wrma_refund_wallet_coupon', true );
		$the_coupon  = new WC_Coupon( $coupon_code );
		if ( WC()->version < '3.0.0' ) {
			$coupon_id = $the_coupon->id;
		} else {
			$coupon_id = $the_coupon->get_id();
		}
		if ( isset( $coupon_id ) && '' != $coupon_id && wps_rma_wallet_feature_enable() ) {
			$customer_coupon_id = $coupon_id;
			$amount             = get_post_meta( $customer_coupon_id, 'coupon_amount', true );
			?>
			<h3><?php esc_html_e( 'Add amount to Customer Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="wps_rma_customer_wallet_price"><?php echo esc_html( $coupon_code ); ?></label></th>
					<td>
						<input type="text" id="wps_rma_customer_wallet_price" class="regular-text" 
					value="<?php echo esc_html( $amount ); ?>" /><br />
						<span class="description"><?php esc_html_e( 'Provide Coupon Amount (Enter only number and decimal amount)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></span>
					</td>
					<td>
						<input type="button" class="button button-primary wps_wrma_change_customer_wallet_amount" id="wps_wrma_change_customer_wallet_amount" data-id = "<?php echo esc_html( $user->ID ); ?>" data-couponcode = "<?php echo esc_html( $coupon_code ); ?>" value="<?php esc_html_e( 'Change Coupon Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>"></input>
						<img class="regenerate_coupon_code_image" src = '<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . 'public/images/loading.gif'; ?>' width="20px" style="display:none;">
					</td>
				</tr>
			</table>
			<?php
		}
	}

	/** Generate User Wallet Coupon Code with no wallet. */
	public function wps_rma_generate_user_wallet_code() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$wps_user_id   = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';
			$wps_user_data = get_userdata( $wps_user_id );
			foreach ( $wps_user_data as $data_key => $data_value ) {
				if ( 'data' === $data_key ) {
					foreach ( $data_value as $data_key1 => $data_value1 ) {
						if ( 'user_email' === $data_key1 ) {
							$customer_email = $data_value1;
						}
					}
				}
			}
			// Coupon code .
			$coupon_code   = wps_rma_coupon_generator( 5 );
			$coupon        = array(
				'post_title'  => $coupon_code,
				'post_status' => 'publish',
				'post_author' => get_current_user_id(),
				'post_type'   => 'shop_coupon',
			);
			$new_coupon_id = wp_insert_post( $coupon );
			$discount_type = 'fixed_cart';
			update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
			update_post_meta( $new_coupon_id, 'coupon_amount', 0 );
			update_post_meta( $new_coupon_id, 'wrmawallet', true );
			update_post_meta( $new_coupon_id, 'customer_email', $customer_email );
			update_user_meta( sanitize_text_field( wp_unslash( $_POST['id'] ) ), 'wps_wrma_refund_wallet_coupon', $coupon_code );
			echo esc_html( $coupon_code );
			wp_die();
		}
	}

	/**
	 * Store the shipping charges in the database if have.
	 *
	 * @return void
	 */
	public function wps_exchange_add_new_fee_callback() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$orderid = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : '';
			$fees    = isset( $_POST['fees'] ) ? map_deep( wp_unslash( $_POST['fees'] ), 'sanitize_text_field' ) : array();
			$type    = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : array();
			if ( 'refund' === $type ) {
				update_post_meta( $orderid, 'ex_ship_amount1', $fees );
				$response['response'] = 'success';
			} elseif ( 'exchange' === $type ) {
				update_post_meta( $orderid, 'ex_ship_amount', $fees );
				$response['response'] = 'success';
			} else {
				$response['response'] = 'error';
			}
			echo wp_json_encode( $response );
			wp_die();
		}
	}

	/**
	 * Change total refund amount or add shipping charges if have
	 *
	 * @param string $total .
	 * @param string $order_id .
	 */
	public function wps_rma_refund_total_amount( $total, $order_id ) {
		$wps_fee_cost     = get_post_meta( $order_id, 'ex_ship_amount1', true );
		$shipping_charges = 0;
		if ( ! empty( $wps_fee_cost ) ) {
			foreach ( $wps_fee_cost as $key => $value ) {
				if ( ! empty( $value ) ) {
					$shipping_charges += $value;
				}
			}
		}
		$total1 = $total - $shipping_charges;
		if ( 0 <= $total1 ) {
			return $total1;
		} else {
			return $total;
		}
	}

	/**
	 * This function is approve exchange request and Create new order for exchnage product and decrease product quantity from order.
	 */
	public function wps_exchange_req_approve() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$orderid  = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : '';
			$response = wps_exchange_req_approve_callback( $orderid );
			echo wp_json_encode( $response );
			wp_die();

		}
	}

	/**
	 * This function is show exchange request product on new exchange order.
	 *
	 * @param string $order_id .
	 */
	public function wps_wrma_show_order_exchange_product( $order_id ) {
		$exchanged_order    = get_post_meta( $order_id, 'wps_wrma_exchange_order', true );
		$exchange_details   = get_post_meta( $exchanged_order, 'wps_wrma_exchange_product', true );
		$order              = new WC_Order( $exchanged_order );
		$get_order_currency = get_woocommerce_currency_symbol( $order->get_currency() );
		$item_type          =
		// Order Item Type.
		apply_filters( 'woocommerce_admin_order_item_types', 'line_item' );
		$line_items = $order->get_items( $item_type );

		if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
			foreach ( $exchange_details as $date => $exchange_detail ) {
				if ( 'complete' === $exchange_detail['status'] ) {
					$exchanged_products = $exchange_detail['from'];
					break;
				}
			}
		}

		if ( isset( $exchanged_products ) && ! empty( $exchanged_products ) ) {
			?>
			<thead>
			<tr>
				<th colspan="7"><b><?php esc_html_e( 'Exchange Products', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></b></th>
			</tr>       
				<tr>
					<th><?php esc_html_e( 'Item', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
					<th colspan="2"><?php esc_html_e( 'Name', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
					<th><?php esc_html_e( 'Cost', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
					<th><?php esc_html_e( 'Qty', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
					<th><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
					<th></th>
				</tr>
			</thead>
			<?php
			foreach ( $line_items as $item_id => $item ) {
				foreach ( $exchanged_products as $key => $exchanged_product ) {
					if ( $item_id == $exchanged_product['item_id'] ) {
						$_product  = $item->get_product();
						$item_meta = wc_get_order_item_meta( $item_id, $key );
						$pro_thumb =
						// order item Thumb.
						apply_filters( 'woocommerce_admin_order_item_thumbnail', $_product->get_image( 'thumbnail', array( 'title' => '' ), false ), $item_id, $item );
						$thumbnail = $_product ? $pro_thumb : '';
						?>
						<tr>
							<td class="thumb">
							<?php
								echo '<div class="wc-order-item-thumbnail">' . wp_kses_post( $thumbnail ) . '</div>';
							?>
							</td>
							<td class="name" colspan="2">
							<?php
								echo esc_html( $item['name'] );
							if ( $_product && $_product->get_sku() ) {
								echo '<div class="wc-order-item-sku"><strong>' . esc_html__( 'SKU:', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</strong> ' . esc_html( $_product->get_sku() ) . '</div>';
							}
							if ( ! empty( $item['variation_id'] ) ) {
								echo '<div class="wc-order-item-variation"><strong>' . esc_html__( 'Variation ID:', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</strong> ';
								if ( ! empty( $item['variation_id'] ) && 'product_variation' === get_post_type( $item['variation_id'] ) ) {
									echo esc_html( $item['variation_id'] );
								} elseif ( ! empty( $item['variation_id'] ) ) {
									echo esc_html( $item['variation_id'] ) . ' (' . esc_html__( 'No longer exists', 'woocommerce-rma-for-return-refund-and-exchange' ) . ')';
								}
								echo '</div>';
							}
							if ( WC()->version < '3.1.0' ) {
								$item_meta = new WC_Order_Item_Meta( $item, $_product );
								$item_meta->display();
							} else {
								$item_meta = new WC_Order_Item_Product( $item, $_product );
								wc_display_item_meta( $item_meta );
							}
							?>
							</td>
							<td><?php echo wp_kses_post( wps_wrma_format_price( $exchanged_product['price'], $get_order_currency ) ); ?></td>
							<td><?php echo esc_html( $exchanged_product['qty'] ); ?></td>
							<td><?php echo wp_kses_post( wps_wrma_format_price( $exchanged_product['price'] * $exchanged_product['qty'], $get_order_currency ) ); ?></td>
							<td></td>
						</tr>
						<?php
					}
				}
			}
		}
	}

	/** Refund amount for exchange left amount */
	public function wps_exchange_req_approve_refund() {

		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$order_id                   = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : 0;
			update_post_meta( $order_id, 'wps_wrma_left_amount', '0' );
			update_post_meta( $order_id, 'refundable_amount', '0' );
			$wps_wrma_order             = new WC_Order( $order_id );
			$customer_email             = $wps_wrma_order->billing_email;
			$wps_wrma_amount_for_refund = isset( $_POST['amount'] ) ? sanitize_text_field( wp_unslash( $_POST['amount'] ) ) : 0;
			$request_type               = get_post_meta( $order_id, 'wps_wrma_exchange_refund_method', true );
			$wallet_enable              = get_option( 'wps_rma_wallet_enable', 'no' );
			$enable_wallet_plugin       = get_option( 'wps_rma_wallet_plugin', 'no' );
			if ( 'on' === $wallet_enable && $order_id > 0 && ( 'wallet_method' === $request_type || '' == $request_type ) ) {
				// Active Plugins.
				$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
				if ( 'on' === $enable_wallet_plugin && in_array( 'wallet-system-for-woocommerce/wallet-system-for-woocommerce.php', $active_plugins ) ) {
					$order           = wc_get_order( $order_id );
					$today           = gmdate( 'F j, Y' );
					$timezone_format = esc_html__( 'h:i a' );
					$time            = date_i18n( $timezone_format );
					$mess            = '#' . $order_id . ' Refund  - ' . get_woocommerce_currency_symbol() . $wps_wrma_amount_for_refund . ' ' . $today . ', ' . $time . ' by admin in wallet';
					include_once WP_PLUGIN_DIR . 'wallet-system-for-woocommerce/includes/class-wallet-system-for-woocommerce.php';

					$wallet_payment_gateway              = new Wallet_System_For_Woocommerce();
					$transactiondata                     = array();
					$transactiondata['user_id']          = $order->get_user_id();
					$transactiondata['amount']           = $wps_wrma_amount_for_refund;
					$transactiondata['currency']         = $order->get_currency();
					$transactiondata['transaction_type'] = $mess;
					$transactiondata['payment_method']   = esc_html__( 'Manually By Admin(RMA)', 'woocommerce-rma-for-return-refund-and-exchange' );
					$transactiondata['transaction_id']   = $order_id;
					$transactiondata['note']             = '';
					$trans_id                            = $wallet_payment_gateway->insert_transaction_data_in_table( $transactiondata );
					$wallet_amount                       = get_user_meta( get_current_user_id(), 'wps_wallet', true );
					remove_action( 'woocommerce_order_partially_refunded', 2 );
					remove_action( 'woocommerce_order_fully_refunded', 2 );
					wc_create_refund(
						array(
							'amount'         => $wps_wrma_amount_for_refund,
							'reason'         => $mess,
							'order_id'       => $order_id,
							'refund_payment' => false,
						)
					);
					$order->save();
					$order_total = $order->calculate_totals();

					update_user_meta( get_current_user_id(), 'wps_wallet', $wallet_amount + $wps_wrma_amount_for_refund );

					$response['result'] = true;
					$response['msg']    = esc_html__( 'Amount is added in customer wallet.', 'woocommerce-rma-for-return-refund-and-exchange' );
				} elseif ( 'on' === $wallet_enable ) {
					$value       = get_post_meta( $order_id, '_customer_user', true );
					$customer_id = ( $value ) ? absint( $value ) : '';
					if ( $customer_id > 0 ) {
						$walletcoupon = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
						if ( empty( $walletcoupon ) ) {
							$coupon_code        = wps_rma_coupon_generator( 5 ); // Code .
							$amount             = $total_price; // Amount .
							$discount_type      = 'fixed_cart';
							$coupon_description = esc_html__( 'REFUND ACCEPTED - ORDER ', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $order_id;

							$coupon = array(
								'post_title'   => $coupon_code,
								'post_content' => $coupon_description,
								'post_excerpt' => $coupon_description,
								'post_status'  => 'publish',
								'post_author'  => get_current_user_id(),
								'post_type'    => 'shop_coupon',
							);

							$new_coupon_id = wp_insert_post( $coupon );
							$discount_type = 'fixed_cart';
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
							update_post_meta( $new_coupon_id, 'wrmawallet', true );
							update_post_meta( $new_coupon_id, 'customer_email', $customer_email );
							update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $coupon_code );
						} else {
							$the_coupon = new WC_Coupon( $walletcoupon );
							$coupon_id  = $the_coupon->get_id();
							if ( isset( $coupon_id ) ) {
								$amount           = get_post_meta( $coupon_id, 'coupon_amount', true );
								$remaining_amount = $amount + $wps_wrma_amount_for_refund;
								update_post_meta( $coupon_id, 'coupon_amount', $remaining_amount );
								update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $walletcoupon );
								update_post_meta( $coupon_id, 'wrmawallet', true );
							}
						}
						$order           = wc_get_order( $order_id );
						$today           = gmdate( 'F j, Y' );
						$timezone_format = esc_html__( 'h:i a' );
						$time            = date_i18n( $timezone_format );
						$mess            = '#' . $order_id . ' Refund  - ' . get_woocommerce_currency_symbol() . $wps_wrma_amount_for_refund . ' ' . $today . ', ' . $time . ' by admin in wallet';
						remove_action( 'woocommerce_order_partially_refunded', 2 );
						remove_action( 'woocommerce_order_fully_refunded', 2 );
						wc_create_refund(
							array(
								'amount'         => $wps_wrma_amount_for_refund,
								'reason'         => $mess,
								'order_id'       => $order_id,
								'refund_payment' => false,
							)
						);
						$order->save();
						$order_total = $order->calculate_totals();

						$response['result'] = true;
						$response['msg']    = esc_html__( 'Amount is added in customer wallet.', 'woocommerce-rma-for-return-refund-and-exchange' );
					}
				}
				$mail =
				// Exchange Refund Amount Mail.
				apply_filters( 'ex_refund_amount_mail', true );
				if ( $mail ) {
					// Exchange refund amount mail template.
					do_action( 'wps_rma_ex_refund_amount_mail', $order_id, $wps_wrma_amount_for_refund );
				}
				echo wp_json_encode( $response );
				wp_die();
			} else {
				$response['result'] = false;
				$response['msg']    = esc_html__( 'The wallet is not enabled, Please Enable the wallet to add the amount to the customer wallet.', 'woocommerce-rma-for-return-refund-and-exchange' );
				echo wp_json_encode( $response );
				die();
			}
		}
	}


	/**
	 * Exchange cancel callback.
	 */
	public function wps_wrma_exchange_req_cancel() {

		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$orderid  = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : '';
			$response = wps_wrma_exchange_req_cancel_callback( $orderid );
			echo wp_json_encode( $response );
			die;
		}
	}

	/**
	 * Manage stock when product because of exchange and back in stock.
	 */
	public function wps_wrma_manage_stock() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$order_id = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : 0;
			$order    = wc_get_order( $order_id );
			if ( $order_id > 0 ) {
				$wps_wrma_type = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';

				if ( '' != $wps_wrma_type ) {
					$manage_stock = get_option( 'wps_rma_exchange_manage_stock' );
					if ( 'on' === $manage_stock ) {
						$wps_wrma_exchange_deta = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
						if ( is_array( $wps_wrma_exchange_deta ) && ! empty( $wps_wrma_exchange_deta ) ) {
							foreach ( $wps_wrma_exchange_deta as $date => $requested_data ) {
								$wps_wrma_exchanged_products = $requested_data['from'];
								if ( is_array( $wps_wrma_exchanged_products ) && ! empty( $wps_wrma_exchanged_products ) ) {
									foreach ( $wps_wrma_exchanged_products as $key => $product_data ) {
										if ( $product_data['variation_id'] > 0 ) {
											$product = wc_get_product( $product_data['variation_id'] );
										} else {
											$product = wc_get_product( $product_data['product_id'] );
										}
										if ( $product->managing_stock() ) {
											$avaliable_qty = $product_data['qty'];

											if ( $product_data['variation_id'] > 0 ) {
												$total_stock = get_post_meta( $product_data['variation_id'], '_stock', true );
												$total_stock = $total_stock + $avaliable_qty;
												wc_update_product_stock( $product_data['variation_id'], $total_stock, 'set' );
											} else {
												$total_stock = get_post_meta( $product_data['product_id'], '_stock', true );
												$total_stock = $total_stock + $avaliable_qty;
												wc_update_product_stock( $product_data['product_id'], $total_stock, 'set' );
											}

											update_post_meta( $order_id, 'wps_wrma_manage_stock_for_exchange', 'no' );
											$response['result'] = true;
											$response['msg']    = esc_html__( 'Product Stock is updated Successfully.', 'woocommerce-rma-for-return-refund-and-exchange' );
											/* translators: %s: product name */
											$order->add_order_note( sprintf( esc_html__( '%s Product Stock is updated Successfully.', 'woocommerce-rma-for-return-refund-and-exchange' ), $product->get_name() ), false, true );
										} else {
											$response['result'] = false;
											$response['msg']    = esc_html__( 'Product Stock is not updated as manage stock setting of product is disable.', 'woocommerce-rma-for-return-refund-and-exchange' );
											/* translators: %s: product name */
											$order->add_order_note( sprintf( esc_html__( '%s Product Stock is not updated as manage stock setting of product is disable.', 'woocommerce-rma-for-return-refund-and-exchange' ), $product->get_name() ), false, true );
										}
									}
								}
							}
						}
					}
				}
			}
		}
		echo wp_json_encode( $response );
		die();
	}

	/**
	 * Auto refund product stock and returnship label email.
	 *
	 * @param boolean $flag .
	 * @param int     $order_id .
	 * @return $flag
	 */
	public function wps_rma_auto_restock_item_refund( $flag, $order_id ) {
		// restock Stock related code start .
		$manage_stock = get_option( 'wps_rma_auto_refund_stock' );
		if ( 'on' === $manage_stock ) {
			$flag = true;
		}
		// Stock related code end .

		// Check returnshiplabel and send returnship label mail.
		$wps_wrma_enable_return_ship_label = get_option( 'wps_wrma_enable_return_ship_label', 'no' );
		if ( 'on' === $wps_wrma_enable_return_ship_label ) {
			$to                         = get_post_meta( $order_id, '_billing_email', true );
			$label_link                 = get_post_meta( $order_id, 'wps_wrma_return_label_link', true );
			$message                    = __( 'Here the Returnship Label Link for Order', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $order_id . ' ' . $label_link;
			$wps_wrma_targetpath_refund = get_post_meta( $order_id, 'wps_return_label_attachment_path', true );
			$customer_email             = WC()->mailer()->emails['wps_rma_returnship_email'];
			$customer_email->trigger( $message, $wps_wrma_targetpath_refund, $to, $order_id );
		}

		return $flag;
	}

	/** Show the statewps_rma_change_quanity */
	public function wps_wrma_select_state() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$response = '';
			if ( isset( $_POST['country'] ) ) {
				$country = isset( $_POST['country'] ) ? sanitize_text_field( wp_unslash( $_POST['country'] ) ) : '';
				$states  = WC()->countries->get_states();
				if ( 'Select' !== $country ) {
					foreach ( $states as $key => $value ) {
						if ( $country == $key ) {
							if ( ! empty( $value ) ) {
								$response  = '<th class="titledesc" scope="row">
                                            <label for="wps_wrma_ship_station_state">' . esc_html__( 'State', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</label></th>';
								$response .= '<td class="forminp forminp-text">';
								$response .= '<select id="wps_wrma_ship_station_state" name="wps_wrma_ship_station_state">';
								foreach ( $value as $key1 => $value1 ) {
									$response .= '<option value=<?php $key1?>' . $value1 . '</option>';
								}
								$response .= '</select></td>';
							}
						}
					}
				}
				echo esc_html( $response );
				wp_die();
			}
		}
	}


	/**
	 * Callback function for the Shipstation Api key validation
	 */
	public function wps_wrma_validate_api_key() {
		check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		$api_key = ! empty( $_POST['api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['api_key'] ) ) : '';

		if ( ! empty( $api_key ) ) {

			// Got the api key, Lets Authenticate .
			$url                          = WPS_WRMA_SHIPSTATION_CARRIERS_URL;
			$method                       = 'GET';
			$wps_wrma_validation_response = $this->wps_wrma_do_curl_request( array(), $api_key, $url, $method );

			if ( $wps_wrma_validation_response->errors ) {
				echo wp_json_encode( 'Invalid Api key' );

			} else {

				update_option( ' wps_wrma_connected_ship_station_account ', $wps_wrma_validation_response->carriers[0]->account_number );
				update_option( ' wps_wrma_validated_ship_station_api_key ', $api_key );
				echo wp_json_encode( 'success' );

			}
		} else {
			echo wp_json_encode( 'Api key is required' );
		}
		wp_die();
	}

	/**
	 * Callback function for the Curl Requests
	 *
	 * @param array  $data .
	 * @param string $api_key .
	 * @param string $url .
	 * @param string $method .
	 * @return $result
	 */
	public function wps_wrma_do_curl_request( $data = array(), $api_key = '', $url = '', $method = 'POST' ) {

		$ch = curl_init( $url );

		$headers = array(
			'Content-type: application/json',
			'api-key: ' . $api_key,
		);

		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $method );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
		if ( ! empty( $data ) ) {
			$jsondata = json_encode( $data );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $jsondata );
		}
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec( $ch );
		curl_close( $ch );
		return json_decode( $result );

	}

	/**
	 * Callback function for Request carriers
	 */
	public function wps_wrma_request_carriers() {

		// Request curl for carriers activated .
		$api_key                      = get_option( 'wps_wrma_validated_ship_station_api_key', '' );
		$url                          = WPS_WRMA_SHIPSTATION_CARRIERS_URL;
		$method                       = 'GET';
		$wps_wrma_validation_response = $this->wps_wrma_do_curl_request( array(), $api_key, $url, $method );
		update_option( 'wps_wrma_saved_carriers', $wps_wrma_validation_response );

		/* return object carriers only*/
		return $wps_wrma_validation_response;
	}

	/** Shipstation carrier html */
	public function wps_wrma_list_shipstation_carriers_html() {
		// Get object of carrier services activated.
		$wps_wrma_carriers_obj = get_option( 'wps_wrma_ship_saved_carriers' );
		if ( empty( $wps_wrma_carriers_obj ) ) {
			// run only when carriers is not present or have to update.
			$wps_wrma_carriers_obj = $this->wps_wrma_request_carriers();
		}
			// Retrieve all the data.
			$wps_wrma_ss_carrier_index         = get_option( 'wps_wrma_ss_carrier_index', 0 );
			$wps_wrma_selected_ss_carrier_id   = get_option( 'wps_wrma_selected_ss_carrier_id', '' );
			$wps_wrma_selected_ss_carrier_id   = $wps_wrma_selected_ss_carrier_id . $wps_wrma_ss_carrier_index;
			$wps_wrma_selected_ss_service_code = get_option( 'wps_wrma_selected_ss_service_code' . $wps_wrma_ss_carrier_index, '' );
		?>
			<!-- Account details listing start -->
					<div class="wps_wrma_ship_setting_account_display">
						<table class="form-table">
							<thead>
								<tr>
									<th class="wps_wrma_ship_account"><?php esc_html_e( 'Accounts', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
									<th colspan="4"><?php esc_html_e( 'Accounts settings', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								</tr>
							</thead>

							<tbody>
								<?php
								foreach ( $wps_wrma_carriers_obj as $key => $value ) {
									?>
									<tr>
										<td rowspan="2">
											<span class="wps_wrma_custom_radio">
												<input type="radio" required="required" id="radio1" name="wps_wrma_ss_carrier_index" value="<?php echo esc_html( $key ); ?>" 
												<?php
												if ( $key == $wps_wrma_selected_ss_carrier_id ) {
														echo 'checked';
												}
												?>
												>
											</span>
										</td>
										<th>
											<?php esc_html_e( 'Carrier ID', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> 
										</th>
										<th>
											<?php esc_html_e( 'Carrier Name', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>       
										</th>
										<th>
											<?php esc_html_e( 'Carrier Services', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>       
										</th>
									</tr>
									<tr>
										<td>
											<?php echo esc_html( $value['carrier_id'] ); ?>
											<input type="hidden" name="<?php echo 'wps_wrma_selected_ss_carrier_id' . esc_html( $key ); ?>"value="<?php echo esc_html( $value['code'] ); ?>" >
										</td>

										<td>
											<?php echo esc_html( $value['nickname'] ); ?>
											<input type="hidden" name="<?php echo 'wps_wrma_selected_ss_carrier_name' . esc_html( $key ); ?>" value="<?php echo esc_html( $value['nickname'] ); ?>" > 
										</td>
										<td>
											<select name="<?php echo 'wps_wrma_selected_ss_service_code' . esc_html( $key ); ?>" >
												<?php
												foreach ( $value['services'] as $skey => $service ) {

													?>
														<option  value="<?php echo esc_html( $service['service_code'] ); ?>" <?php selected( $wps_wrma_selected_ss_service_code, $service['service_code'] ); ?> > <?php echo esc_html( $service['service_name'] ); ?></option>
													<?php
												}
												?>
											</select>     
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
			<!-- Account details listing start -->
		<?php
	}

	/**
	 * Shipengine carrier html
	 */
	public function wps_wrma_list_carriers_html() {

		// Get object of carrier services activated.
		$wps_wrma_carriers_obj = get_option( 'wps_wrma_saved_carriers' );
		if ( empty( $wps_wrma_carriers_obj ) ) {
			// run only when carriers is not present or have to update.
			$wps_wrma_carriers_obj = $this->wps_wrma_request_carriers();
		}
			// Retrieve all the data.
			$wps_wrma_carrier_index         = get_option( 'wps_wrma_carrier_index', 0 );
			$wps_wrma_selected_carrier_id   = get_option( 'wps_wrma_selected_carrier_id', '' );
			$wps_wrma_selected_carrier_id   = $wps_wrma_selected_carrier_id . $wps_wrma_carrier_index;
			$wps_wrma_selected_service_code = get_option( 'wps_wrma_selected_service_code' . $wps_wrma_carrier_index, '' );
		?>
			<!-- Account details listing start -->
				<div class="wps_wrma_ship_setting_account_display">
					<table class="form-table">
						<thead>
							<tr>
								<th class="wps_wrma_ship_account"><?php esc_html_e( 'Accounts', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th colspan="4"><?php esc_html_e( 'Accounts settings', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php
							foreach ( $wps_wrma_carriers_obj->carriers as $key => $value ) {
								?>
								<tr>
									<td rowspan="2">
										<span class="wps_wrma_custom_radio">
											<input type="radio" required="required" id="radio1" name="wps_wrma_carrier_index" value="<?php echo esc_html( $key ); ?>" 
											<?php
											if ( $key == $wps_wrma_selected_carrier_id ) {
												echo 'checked';
											}
											?>
											>
											<label for="radio1"></label>
										</span>
									</td>
									<th>
										<?php esc_html_e( 'Carrier ID', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> 
									</th>
									<th>
										<?php esc_html_e( 'Carrier Name', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>       
									</th>
									<th>
										<?php esc_html_e( 'Carrier Services', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>       
									</th>
								</tr>
								<tr>
									<td>
										<?php echo esc_html( $value->carrier_id ); ?>
										<input type="hidden" name="<?php echo 'wps_wrma_selected_carrier_id' . esc_html( $key ); ?>"value="<?php echo esc_html( $value->carrier_id ); ?>" >
									</td>

									<td>
										<?php echo esc_html( $value->nickname ); ?>
										<input type="hidden" name="<?php echo 'wps_wrma_selected_carrier_name' . esc_html( $key ); ?>" value="<?php echo esc_html( $value->nickname ); ?>" > 
									</td>
									<td>
										<select name="<?php echo 'wps_wrma_selected_service_code' . esc_html( $key ); ?>" >
											<?php
											foreach ( $value->services as $key => $service ) {

												?>
													<option  value="<?php echo esc_html( $service->service_code ); ?>" <?php selected( $wps_wrma_selected_service_code, $service->service_code ); ?> > <?php echo esc_html( $service->name ); ?></option>
												<?php
											}
											?>
										</select>     
									</td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			<!-- Account details listing start -->
		<?php
	}
	/**
	 * Callback function for the Shipengine Api Logout
	 */
	public function wps_wrma_logout() {
		delete_option( ' wps_wrma_connected_ship_station_account ' );
		delete_option( ' wps_wrma_validated_ship_station_api_key ' );
		delete_option( ' wps_wrma_saved_carriers ' );
		delete_option( ' wps_wrma_shipping_details ' );
		echo wp_json_encode( 'logout' );
		wp_die();
	}

	/**
	 * Callback function for the Shipstation Api Logout.
	 */
	public function wps_wrma_shipstation_logout() {
		delete_option( ' wps_wrma_validated_real_ship_station_api_key ' );
		delete_option( ' wps_wrma_validated_real_ship_station_secret_key ' );
		delete_option( ' wps_wrma_ship_saved_carriers ' );
		echo wp_json_encode( 'logout' );
		wp_die();
	}

	/**
	 * Generate returnshp label link.
	 *
	 * @param array $order_id .
	 * @return void
	 */
	public function wps_wrma_validate_return_label_link( $order_id ) {
		global $post , $save_post_flag;
		if ( 0 == $save_post_flag ) {
			$save_post_flag = 1;
			if ( isset( $post ) && ! empty( $post ) ) {
				if ( 'shop_order' === $post->post_type ) {
					$order = wc_get_order( $order_id );
					$value_check = isset( $_POST['message-save_button_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['message-save_button_nonce'] ) ) : '';
					wp_verify_nonce( $value_check, 'save_button_nonce' );
					if ( ( ! empty( $_POST['wps_wrma_save_button'] ) && isset( $_POST['return_type'] ) ) ) {
						$return_type = isset( $_POST['return_type'] ) ? sanitize_text_field( wp_unslash( $_POST['return_type'] ) ) : '';
						$url         = $this->wps_wrma_generate_return_label_link( $order_id, $return_type );
						$response    = wp_http_validate_url( $url );
						if ( $response ) {
							update_post_meta( $order_id, 'wps_wrma_return_label_link', $response );
							$order->add_order_note( 'Return Label Succesfully Generated' );
						} else {
							// In case of error add error message.
							$order->add_order_note( $url );
						}
					}
				}
			}
		}
	}


	/**
	 * This function is generates return or exchange label pdf link.
	 *
	 * @param integer $order_id .
	 * @param string  $type .
	 */
	public function wps_wrma_generate_return_label_link( $order_id, $type ) {
		// Get the return label shipment details.
		$order                           = wc_get_order( $order_id );
		$weight_unit                     = get_option( 'woocommerce_weight_unit' );
		$dimention_unit                  = get_option( 'woocommerce_dimension_unit' );
		$wps_wrma_ship_station_weight    = get_option( 'wps_wrma_ship_station_weight', '' );
		$wps_wrma_ship_station_dimension = get_option( 'wps_wrma_ship_station_dimension', '' );

		$products = array();
		if ( 'return' === $type ) {
			$products = get_post_meta( $order_id, 'wps_rma_return_product', true );
		} elseif ( 'exchange' === $type ) {
			$products = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
		}
		$total_weight = 0;
		$total_length = 1;
		$total_width  = 1;
		$total_height = 1;
		if ( isset( $products ) && ! empty( $products ) && is_array( $products ) ) {
			foreach ( $products as $refunded_date ) {
				foreach ( $refunded_date as $key1 => $single_product ) {
					if ( 'products' === $key1 || 'from' === $key1 ) {
						foreach ( $single_product as $key2 => $product ) {
							$item           = wc_get_product( $product['product_id'] );
							$quantity       = $product['qty'];
							$product_weight = $item->get_weight(); // get the product weight.
							$product_lenght = floatval( $item->get_length() );
							$product_width  = floatval( $item->get_width() );
							$product_height = floatval( $item->get_height() );

							$dim_abbr = '';
							switch ( $wps_wrma_ship_station_dimension ) {
								case 'inch':
									$dim_abbr = 'in';
									break;
								case 'centimeter':
									$dim_abbr = 'cm';
									break;
							}

							$total_length = wc_get_dimension( $product_lenght, $dim_abbr, $dimention_unit );
							$total_width  = wc_get_dimension( $product_width, $dim_abbr, $dimention_unit );
							$total_height = wc_get_dimension( $product_height, $dim_abbr, $dimention_unit );

							if ( $total_length < $product_lenght ) {
								$total_length = $product_lenght;
							}
							if ( $total_width < $product_width ) {
								$total_width = $product_width;
							}
							if ( $total_height < $product_height ) {
								$total_height = $product_height;
							}

							// Add the line item weight to the total weight calculation.
							$total_weight += floatval( $product_weight * $quantity );

							$weight_abbr = '';
							switch ( $wps_wrma_ship_station_weight ) {
								case 'pound':
									$weight_abbr = 'lbs';
									break;
								case 'ounce':
									$weight_abbr = 'oz';
									break;
								case 'gram':
									$weight_abbr = 'g';
									break;
								case 'kilogram':
									$weight_abbr = 'kg';
									break;
							}
							$total_weight = wc_get_weight( $total_weight, $weight_abbr, $weight_unit );
						}
					}
				}
			}
		}

		$wps_ship_name                  = get_option( 'wps_wrma_ship_station_name', '' );
		$wps_ship_comp_name             = get_option( 'wps_wrma_ship_station_comp_name', '' );
		$wps_wrma_ship_station_addr1    = get_option( 'wps_wrma_ship_station_addr1', '' );
		$wps_wrma_ship_station_city     = get_option( 'wps_wrma_ship_station_city', '' );
		$wps_wrma_ship_station_postcode = get_option( 'wps_wrma_ship_station_postcode', '' );
		$wps_wrma_ship_station_country  = get_option( 'wps_wrma_ship_station_country', '' );
		$wps_wrma_ship_station_state    = get_option( 'wps_wrma_ship_station_state', '' );
		$wps_wrma_ship_station_phone    = get_option( 'wps_wrma_ship_station_phone', '' );
		$order                          = wc_get_order( $order_id );

		$wps_wrma_enable_ss_return_ship_station_label = get_option( 'wps_wrma_enable_ss_return_ship_station_label', 'no' );
		$wps_wrma_enable_return_ship_station_label    = get_option( 'wps_wrma_enable_return_ship_station_label', 'no' );
		$ship_chosen                                  = '';

		if ( isset( $wps_wrma_enable_return_ship_station_label ) && 'on' === $wps_wrma_enable_return_ship_station_label ) {
			$ship_chosen = 'shipengine';
		} elseif ( isset( $wps_wrma_enable_ss_return_ship_station_label ) && 'on' === $wps_wrma_enable_ss_return_ship_station_label ) {
			$ship_chosen = 'shipstation';
		}
		if ( 'shipstation' === $ship_chosen ) {

			$api_key                         = get_option( ' wps_wrma_validated_real_ship_station_api_key ', '' );
			$api_secretkey                   = get_option( ' wps_wrma_validated_real_ship_station_secret_key ', '' );
			$wps_wrma_ss_carrier_index       = get_option( 'wps_wrma_ss_carrier_index', 0 );
			$wps_wrma_selected_ss_carrier_id = get_option( 'wps_wrma_selected_ss_carrier_id' . $wps_wrma_ss_carrier_index, '' );

			$wps_wrma_ss_service_code = get_option( 'wps_wrma_selected_ss_service_code' . $wps_wrma_ss_carrier_index, '' );

			$order_date  = gmdate( 'Y-m-d' );
			$ship_date   = gmdate( 'Y-m-d', strtotime( $order_date ) + ( 2 * 24 * 60 * 60 ) );
			$action      = 'shipments/createlabel';
			$url         = 'https://ssapi.shipstation.com/' . $action;
			$method      = 'POST';
			$header_data = base64_encode( $api_key . ':' . $api_secretkey );
			$headers     = array(
				'Content-type: application/json',
				'Authorization: Basic ' . $header_data,
			);
			$data        = array(
				'carrierCode' => $wps_wrma_selected_ss_carrier_id,
				'serviceCode' => $wps_wrma_ss_service_code,
				'packageCode' => 'package',
				'shipDate'    => $ship_date,
				'weight'      => array(
					'value' => $total_weight,
					'units' => $wps_wrma_ship_station_weight,
				),
				'dimensions'  => array(
					'units'  => $wps_wrma_ship_station_dimension,
					'length' => $total_length,
					'width'  => $total_width,
					'height' => $total_height,
				),
				'shipFrom'    => array(
					'name'        => empty( $order->get_shipping_first_name() ) ? $order->get_billing_first_name() : $order->get_shipping_first_name(),
					'company'     => empty( $order->get_shipping_company() ) ? $order->get_billing_company() : $order->get_shipping_company(),
					'street1'     => empty( $order->get_shipping_address_1() ) ? $order->get_billing_address_1() : $order->get_shipping_address_1(),
					'street2'     => empty( $order->get_shipping_address_2() ) ? $order->get_billing_address_2() : $order->get_shipping_address_2(),
					'street3'     => null,
					'city'        => empty( $order->get_shipping_city() ) ? $order->get_billing_city() : $order->get_shipping_city(),
					'state'       => empty( $order->get_shipping_state() ) ? $order->get_billing_state() : $order->get_shipping_state(),
					'postalCode'  => empty( $order->get_shipping_postcode() ) ? $order->get_billing_postcode() : $order->get_shipping_postcode(),
					'country'     => empty( $order->get_shipping_country() ) ? $order->get_billing_country() : $order->get_shipping_country(),
					'phone'       => $order->get_billing_phone(),
					'residential' => false,
				),
				'shipTo'      => array(
					'name'        => $wps_ship_name,
					'company'     => $wps_ship_comp_name,
					'street1'     => $wps_wrma_ship_station_addr1,
					'street2'     => null,
					'street3'     => null,
					'city'        => $wps_wrma_ship_station_city,
					'state'       => $wps_wrma_ship_station_state,
					'postalCode'  => $wps_wrma_ship_station_postcode,
					'country'     => $wps_wrma_ship_station_country,
					'phone'       => $wps_wrma_ship_station_phone,
					'residential' => false,
				),
				'testLabel'   => false,
			);
			$ch          = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $data ) );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
			$response = curl_exec( $ch );
		} else {
			$wps_wrma_carrier_index = get_option( 'wps_wrma_carrier_index', 0 );
			$wps_wrma_carrier_id    = get_option( 'wps_wrma_selected_carrier_id' . $wps_wrma_carrier_index, '' );
			$wps_wrma_service_code  = get_option( 'wps_wrma_selected_service_code' . $wps_wrma_carrier_index, '' );
			$shipment               = array(
				'test_label'      => false, // for test mode put test_label=true.
				'is_return_label' => true, // for test mode put is_return_label=false.
				'carrier_id'      => $wps_wrma_carrier_id,
				'shipment'        => array(
					'service_code' => $wps_wrma_service_code,
					'ship_to'      => array(
						'name'                          => $wps_ship_name,
						'phone'                         => $wps_wrma_ship_station_phone,
						'company_name'                  => $wps_ship_comp_name,
						'address_line1'                 => $wps_wrma_ship_station_addr1,
						'city_locality'                 => $wps_wrma_ship_station_city,
						'state_province'                => $wps_wrma_ship_station_state,
						'postal_code'                   => $wps_wrma_ship_station_postcode,
						'country_code'                  => $wps_wrma_ship_station_country,
						'address_residential_indicator' => 'No',
					),

					'ship_from'    => array(
						'name'                          => empty( $order->get_shipping_first_name() ) ? $order->get_billing_first_name() : $order->get_shipping_first_name(),
						'phone'                         => $order->get_billing_phone(),
						'company_name'                  => empty( $order->get_shipping_company() ) ? $order->get_billing_company() : $order->get_shipping_company(),
						'address_line1'                 => empty( $order->get_shipping_address_1() ) ? $order->get_billing_address_1() : $order->get_shipping_address_1(),
						'address_line2'                 => empty( $order->get_shipping_address_2() ) ? $order->get_billing_address_2() : $order->get_shipping_address_2(),
						'city_locality'                 => empty( $order->get_shipping_city() ) ? $order->get_billing_city() : $order->get_shipping_city(),
						'state_province'                => empty( $order->get_shipping_state() ) ? $order->get_billing_state() : $order->get_shipping_state(),
						'postal_code'                   => empty( $order->get_shipping_postcode() ) ? $order->get_billing_postcode() : $order->get_shipping_postcode(),
						'country_code'                  => empty( $order->get_shipping_country() ) ? $order->get_billing_country() : $order->get_shipping_country(),
						'address_residential_indicator' => 'No',
						'address_residential_indicator' => 'No',
					),
					'packages'     => array(
						0 => array(
							'weight'     => array(
								'value' => $total_weight,
								'unit'  => $wps_wrma_ship_station_weight,
							),
							'dimensions' => array(
								'unit'   => $wps_wrma_ship_station_dimension,
								'length' => $total_length,
								'width'  => $total_width,
								'height' => $total_height,
							),
						),
					),
				),
			);
			$api_key  = get_option( 'wps_wrma_validated_ship_station_api_key', '' );
			$url      = WPS_WRMA_SHIPSTATION_LABEL_URL;
			$method   = 'POST';
			$response = $this->wps_wrma_do_curl_request( $shipment, $api_key, $url, $method );

		}
		// If error caused up it return with message.
		if ( isset( $response ) && ! empty( $response ) ) {
			if ( isset( $ship_chosen ) && 'shipstation' === $ship_chosen ) {
				$response_data = json_decode( $response, true );
				if ( ! empty( $response_data['labelData'] ) ) {
					$data = base64_decode( $response_data['labelData'] );

					// Write data back to pdf file.
					$pdf_filename = $order_id . '-return_ship_label.pdf';
					$directory    = ABSPATH . 'wp-content/plugins/woocommerce-rma-for-return-refund-and-exchange/labelcreated/';
					if ( ! file_exists( $directory ) ) {
						mkdir( $directory, 0777, true );
					}
					file_put_contents( $directory . $pdf_filename, $data );
					$dir_link = home_url() . '/wp-content/plugins/woocommerce-rma-for-return-refund-and-exchange/labelcreated/' . $pdf_filename;
					update_post_meta( $order_id, 'wps_ship_return_label_attachment_path', $dir_link );

					$label_link = $dir_link;
				} else {
					return $response_data['ExceptionMessage'];
				}
			} else {
				if ( empty( $response->errors ) ) {
					$label_link = $response->label_download->pdf;

				} else {
					foreach ( $response->errors as $key => $error ) {
						return $error->message;
					}
				}
			}
			return $label_link;

		} else {
			foreach ( $response->errors as $key => $error ) {
				return $error->message;
			}
		}
	}

	/**
	 * Callback function for the Shipstation validation
	 */
	public function wps_wrma_validate_shipstation_api_key() {
		check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		$ship_api_key    = ! empty( $_POST['ship_api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['ship_api_key'] ) ) : '';
		$ship_secret_key = ! empty( $_POST['ship_secret_key'] ) ? sanitize_text_field( wp_unslash( $_POST['ship_secret_key'] ) ) : '';

		if ( ! empty( $ship_api_key ) && ! empty( $ship_secret_key ) ) {
			$action = 'carriers';
			$url    = 'https://ssapi.shipstation.com/' . $action;
			// Got the api key, Lets Authenticate.
			$method      = 'GET';
			$header_data = base64_encode( $ship_api_key . ':' . $ship_secret_key );
			$headers     = array(
				'Content-type: application/json',
				'Authorization: Basic ' . $header_data,
			);
			// Curl start.
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$result = curl_exec( $ch );
			curl_close( $ch );
			$get_carrier   = json_decode( $result );
			$ship_carrires = array();
			if ( isset( $get_carrier ) && ! empty( $get_carrier ) && is_array( $get_carrier ) ) {
				foreach ( $get_carrier as $gc_key => $gc_value ) {
					$ship_carrires[ $gc_key ]['nickname']   = $gc_value->name;
					$ship_carrires[ $gc_key ]['code']       = $gc_value->code;
					$ship_carrires[ $gc_key ]['carrier_id'] = $gc_value->shippingProviderId; // phpcs:ignore

					if ( ! empty( $gc_value->code ) ) {
						$action = 'carriers/listservices?carrierCode=' . $gc_value->code;
						$url    = 'https://ssapi.shipstation.com/' . $action;

						// Got the api key, Lets Authenticate.
						$method      = 'GET';
						$header_data = base64_encode( $ship_api_key . ':' . $ship_secret_key );
						$headers     = array(
							'Content-type: application/json',
							'Authorization: Basic ' . $header_data,
						);

						$ch = curl_init();
						curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch, CURLOPT_URL, $url );
						curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
						$result = curl_exec( $ch );
						curl_close( $ch );

						$get_services = json_decode( $result );

						if ( isset( $get_services ) && ! empty( $get_services ) && is_array( $get_services ) ) {
							foreach ( $get_services as $gs_key => $gs_value ) {
								$ship_carrires[ $gc_key ]['services'][ $gs_key ]['service_code'] = $gs_value->code;
								$ship_carrires[ $gc_key ]['services'][ $gs_key ]['service_name'] = $gs_value->name;
							}
						}
					}
				}
			}

			if ( empty( $ship_carrires ) ) {
				echo wp_json_encode( 'Invalid Api key' );
			} else {
				update_option( ' wps_wrma_ship_saved_carriers', $ship_carrires );
				update_option( ' wps_wrma_validated_real_ship_station_api_key ', $ship_api_key );
				update_option( ' wps_wrma_validated_real_ship_station_secret_key ', $ship_secret_key );
				echo wp_json_encode( 'success' );
			}
		} else {
			echo wp_json_encode( 'Api key & Secret Key is required' );
		}
		wp_die();
	}

	/**
	 * Show returnship label setting
	 *
	 * @param string $order_id .
	 */
	public function wps_rma_return_ship_attach_upload_html( $order_id ) {
		$setting_obj = new Wps_Rma_Returnship_Html();
		$setting_obj->wps_rma_return_ship_attach_upload_html_set( $order_id );
	}

	/** Enctype . */
	public function wps_edit_form_tag() {
		echo 'enctype="multipart/form-data"';
	}

	/**
	 * Returnship label.
	 *
	 * @param string $post_id .
	 */
	public function wps_upload_return_label( $post_id ) {
		$message = '';
		if ( isset( $_FILES['wps_return_label_attachment'] ) && ! empty( $_FILES['wps_return_label_attachment'] ) ) {
			if ( isset( $_FILES['wps_return_label_attachment']['tmp_name'] ) && ! empty( $_FILES['wps_return_label_attachment']['tmp_name'] ) ) {
				$finfo = finfo_open( FILEINFO_MIME_TYPE );
				$mime  = finfo_file( $finfo, sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment']['tmp_name'] ) ) );
				finfo_close( $finfo );
				if ( 'image/png' === $mime || 'image/jpeg' === $mime || 'image/jpg' === $mime || 'application/pdf' === $mime ) {
					$directory = ABSPATH . 'wp-content/return-label-attachments';
					if ( ! file_exists( $directory ) ) {
						mkdir( $directory, 0777, true );
					}
					$sourcepath = sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment']['tmp_name'] ) );
					$targetpath = $directory . '/' . $post_id . '-' . isset( $_FILES['wps_return_label_attachment']['name'] ) ? sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment']['name'] ) ) : '';
					$filename   = $post_id . '-' . sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment']['name'] ) );
					move_uploaded_file( $sourcepath, $targetpath );
					update_post_meta( $post_id, 'wps_return_label_attachment_path', $targetpath );
					update_post_meta( $post_id, 'wps_return_label_attachment_name', $filename );
					update_post_meta( $post_id, 'wps_wrma_return_attachment_error', '' );
				} else {
					$message = esc_html__( 'Please upload only image or pdf', 'woocommerce-rma-for-return-refund-and-exchange' );
					update_post_meta( $post_id, 'wps_wrma_return_attachment_error', $message );
				}
			}
		}
	}

	/**
	 * Returnship label for exchange.
	 *
	 * @param string $post_id .
	 */
	public function wps_upload_return_label_for_exchange( $post_id ) {
		$message = '';
		if ( isset( $_FILES['wps_return_label_attachment_exchange'] ) && ! empty( $_FILES['wps_return_label_attachment_exchange'] ) ) {
			if ( isset( $_FILES['wps_return_label_attachment_exchange']['tmp_name'] ) && ! empty( $_FILES['wps_return_label_attachment_exchange']['tmp_name'] ) ) {
				$finfo = finfo_open( FILEINFO_MIME_TYPE );
				$mime  = finfo_file( $finfo, sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment_exchange']['tmp_name'] ) ) );
				finfo_close( $finfo );
				if ( 'image/png' === $mime || 'image/jpeg' === $mime || 'image/jpg' === $mime || 'application/pdf' === $mime ) {
					$directory = ABSPATH . 'wp-content/return-label-attachments-exchange';
					if ( ! file_exists( $directory ) ) {
						mkdir( $directory, 0777, true );
					}
					$sourcepath_exchange = sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment_exchange']['tmp_name'] ) );
					$targetpath_exchange = $directory . '/' . $post_id . '-' . isset( $_FILES['wps_return_label_attachment_exchange']['name'] ) ? sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment_exchange']['name'] ) ) : '';
					$filename_exchange   = $post_id . '-' . sanitize_text_field( wp_unslash( $_FILES['wps_return_label_attachment_exchange']['name'] ) );
					move_uploaded_file( $sourcepath_exchange, $targetpath_exchange );
					update_post_meta( $post_id, 'wps_return_label_attachment_exchange_path', $targetpath_exchange );
					update_post_meta( $post_id, 'wps_return_label_attachment_exchange_name', $filename_exchange );
					update_post_meta( $post_id, 'wps_wrma_exchange_attachment_error', '' );
				} else {
					$message = esc_html__( 'Please upload only image or pdf', 'woocommerce-rma-for-return-refund-and-exchange' );
					update_post_meta( $post_id, 'wps_wrma_exchange_attachment_error', $message );
				}
			}
		}
	}

	/** Show license related info in the RMA org admin dashboard */
	public function wps_rma_show_license_info() {
		require RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/rma-return-refund-exchange-for-woocommerce-pro-license-info.php';
	}

	/**
	 * Add link for Wallet for WooCommerce
	 *
	 * @param bool $flag .
	 */
	public function wps_rma_show_wfwp_callback( $flag ) {
		$link                = 'To Download The Plugin <a href="https://wordpress.org/plugins/wallet-system-for-woocommerce/"  target="_blank" >Click Here</a>';
		$check_plugin_active = in_array(
			'wallet-system-for-woocommerce/wallet-system-for-woocommerce.php',
			// Active Plugins.
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		);
		if ( $check_plugin_active ) {
			return false;
		} else {
			return $link;
		}
	}

	/**
	 * Change coupon amount for customers from user listing panel.
	 */
	public function wps_rma_change_customer_wallet_amount() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$coupon_code = isset( $_POST['coupon_code'] ) ? sanitize_text_field( wp_unslash( $_POST['coupon_code'] ) ) : '';
			$amount      = isset( $_POST['amount'] ) ? sanitize_text_field( wp_unslash( $_POST['amount'] ) ) : '';
			if ( ! isset( $amount ) || '' == $amount ) {
				$amount = 0;
			}
			$the_coupon         = new WC_Coupon( $coupon_code );
			$customer_coupon_id = $the_coupon->get_id();
			if ( isset( $the_coupon ) && '' != $the_coupon ) {
				update_post_meta( $customer_coupon_id, 'coupon_amount', $amount );
			}
		}
		wp_die();
	}
	/**
	 * Setting values
	 *
	 * @param array $value for value.
	 * @return array
	 */
	public function wps_rma_policies_setting_callback( $value ) {
		if ( isset( $value['wps_rma_setting'] ) ) {
			foreach ( $value['wps_rma_setting'] as $setting_index => $setting_value ) {
				if ( 'wps_rma_min_order' === $setting_value['row_policy'] && empty( $setting_value['row_value'] ) ) {
					unset( $value['wps_rma_setting'][ $setting_index ] );
				}
				if ( 'wps_rma_exclude_via_categories' === $setting_value['row_policy'] && empty( $setting_value['row_ex_cate'] ) ) {
					unset( $value['wps_rma_setting'][ $setting_index ] );
				}
				if ( 'wps_rma_exclude_via_products' === $setting_value['row_policy'] && empty( $setting_value['row_ex_prod'] ) ) {
					unset( $value['wps_rma_setting'][ $setting_index ] );
				}
			}
		}
		return $value;
	}

	/**
	 * Migration to new domain notice.
	 *
	 * @param string $plugin_file Path to the plugin file relative to the plugins directory.
	 * @param array  $plugin_data An array of plugin data.
	 * @param string $status Status filter currently applied to the plugin list.
	 */
	public function wps_rma_pro_upgrade_notice( $plugin_file, $plugin_data, $status ) {
		if ( is_plugin_active( 'woo-refund-and-exchange-lite/woocommerce-refund-and-exchange-lite.php' ) ) {
			if ( class_exists( 'Woo_Refund_And_Exchange_Lite_Admin' ) ) {
				$rma_lite_admin_obj = new Woo_Refund_And_Exchange_Lite_Admin( 'Return Refund and Exchange for WooCommerce', '4.0.2' );
				$wps_rma_pending_orders_count     = $rma_lite_admin_obj->wps_rma_get_count( 'pending', 'count', 'orders' );
				$wps_rma_pending_users_count      = $rma_lite_admin_obj->wps_rma_get_count( 'pending', 'count', 'users' );
				$wps_rma_pending_order_msgs_count = $rma_lite_admin_obj->wps_rma_get_count( 'pending', 'count', 'order_messages' );
				if ( ! empty( $wps_rma_pending_orders_count ) || ! empty( $wps_rma_pending_users_count ) || ! empty( $wps_rma_pending_order_msgs_count ) ) {
					?>
					<tr class="plugin-update-tr active notice-warning notice-alt">
						<td  colspan="4" class="plugin-update colspanchange">
							<div class="notice notice-warning inline update-message notice-alt">	
								<p><b>
									<?php esc_html_e( 'Please Click', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
									<a href="<?php echo esc_attr( admin_url( 'admin.php' ) . '?page=woo_refund_and_exchange_lite_menu&wrael_tab=woo-refund-and-exchange-lite-general' ); ?>"> here </a><?php esc_html_e( 'To Goto the Migration Page to the Start Migration', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>.</b></p>
							</div>
						</td>
					</tr>
					<style>
						.wps-notice-section > p:before {
							content: none;
						}
					</style>
					<?php
				}
			}
		}
	}
}
