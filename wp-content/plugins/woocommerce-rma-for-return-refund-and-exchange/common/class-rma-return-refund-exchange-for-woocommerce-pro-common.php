<?php
/**
 * The common functionality of the plugin.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace rma_return_refund_exchange_for_woocommerce_pro_common.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/common
 */
class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwr_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'common/css/rma-return-refund-exchange-for-woocommerce-pro-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwr_common_enqueue_scripts() {
		$get_wps_rnx_global_shipping              = get_option( 'wps_wrma_shipping_global_data', array() );
		$wps_ship_fee_name                        = isset( $get_wps_rnx_global_shipping['fee_name'] ) ? $get_wps_rnx_global_shipping['fee_name'] : '';
		$wps_ship_fee_cost                        = isset( $get_wps_rnx_global_shipping['fee_cost'] ) ? $get_wps_rnx_global_shipping['fee_cost'] : '';
		$wps_ship_enable                          = isset( $get_wps_rnx_global_shipping['enable'] ) ? $get_wps_rnx_global_shipping['enable'] : '';
		$wps_ship_pro_cb                          = isset( $get_wps_rnx_global_shipping['pro_cb'] ) ? $get_wps_rnx_global_shipping['pro_cb'] : '';
		$myaccount_page                           = get_option( 'woocommerce_myaccount_page_id' );
		$myaccount_page_url                       = get_permalink( $myaccount_page );
		$return_auto_accept                       = get_option( 'wps_rma_refund_auto' );
		$current_currency                         = get_woocommerce_currency_symbol();
		$shop_url                                 = get_permalink( wc_get_page_id( 'shop' ) );
		$wps_wrma_exchange_variation_enable       = get_option( 'wps_rma_exchange_same_product' );
		$wps_wrma_exchnage_with_same_product_text = empty( get_option( 'wps_rma_exchange_same_product_text' ) ) ? esc_html__( 'Click on the product(s) to exchange with selected product(s) or its variation(s).', 'woocommerce-rma-for-return-refund-and-exchange' ) : get_option( 'wps_rma_exchange_same_product_text' );
		$wps_rma_session_running                  = 0;
		if ( WC()->session && WC()->session->get( 'wps_wrma_exchange' ) ) {
			$wps_rma_session_running = 1;
		}
		wp_register_script( $this->plugin_name . 'common', RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'common/js/rma-return-refund-exchange-for-woocommerce-pro-common.min.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name . 'common',
			'mwr_common_param',
			array(
				'ajaxurl'                                  => admin_url( 'admin-ajax.php' ),
				'wallet_msg'                               => esc_html__( 'My Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'wps_rma_nonce'                            => wp_create_nonce( 'wps_rma_ajax_security' ),
				'myaccount_url'                            => $myaccount_page_url,
				'auto_accept'                              => $return_auto_accept,
				'shop_url'                                 => $shop_url,
				'exchange_text'                            => esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'select_product_msg'                       => esc_html__( 'Please Select Products You Want to Refund.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'return_subject_msg'                       => esc_html__( 'Please Enter Refund Subject.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'return_reason_msg'                        => esc_html__( 'Please Enter Refund Reason.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'correct_quantity'                         => esc_html__( 'Please Enter Correct Quantity.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'select_product_msg_exchange'              => esc_html__( 'Please Select Products You Want to Exchange.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'exchange_subject_msg'                     => esc_html__( 'Please Enter Exchange Subject.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'exchange_reason_msg'                      => esc_html__( 'Please Enter Exchange reason.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'before_submit_exchange'                   => esc_html__( 'Choose Exchange Products Before Submitting The Request.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'left_amount_msg'                          => esc_html__( 'Remaining Amount After Exchange.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'extra_amount_msg'                         => esc_html__( 'Extra Amount Need to Pay', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'enter_login_email'                        => esc_html__( 'Please Enter Order Email', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'enter_login_phone'                        => esc_html__( 'Please Enter Order Phone Number', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'enter_login_id'                           => esc_html__( 'Please Enter Order Id', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'enter_login_details'                      => esc_html__( 'Please Enter Order Id & Order Email', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'enter_login_details1'                     => esc_html__( 'Please Enter Order Id & Phone Number', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'refund_product'                           => esc_html__( 'Please Select Product To Make a Refund Request', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'exchange_session'                         => $wps_rma_session_running,
				'wps_wrma_exchange_variation_enable'       => $wps_wrma_exchange_variation_enable,
				'wps_wrma_exchnage_with_same_product_text' => $wps_wrma_exchnage_with_same_product_text,
				'price_decimal_separator'                  => wc_get_price_decimal_separator(),
				'price_thousand_separator'                 => wc_get_price_thousand_separator(),
				'price_decima_separator'                 => wc_get_price_decimals(),
				'wps_rma_ship_fee_name'                    => $wps_ship_fee_name,
				'wps_rma_ship_fee_cost'                    => $wps_ship_fee_cost,
				'enable_ship_cb'                           => $wps_ship_enable,
				'enable_ship_pro_cb'                       => $wps_ship_pro_cb,
				'ship_currency'                            => $current_currency,
				'wallet_amount_insufficient'               => esc_html__( 'You have insufficient Wallet Amount.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'correct_pay_amount'                       => esc_html__( 'Please Enter the valid wallet amount.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'wps_wrma_confirm_products'                => esc_html__( 'Do you want to cancel the product(s)?', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'wps_wmrma_confirm_order'                  => esc_html__( 'Do you want to cancel the whole order?', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'select_product_msg_cancel'                => esc_html__( 'Please Select Product(s) you want to Cancel.', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'wps_wrma_add_to_cart_enable'              => get_option( 'wps_rma_remove_add_to_cart', 'no' ),
			)
		);
		wp_enqueue_script( $this->plugin_name . 'common' );
	}

	/** Return true that pro is active. */
	public function wps_rma_check_pro_active() {
		return true;
	}

	/**
	 * Extend the functionality to show or not the refund/exchange/cancel buttons.
	 *
	 * @param string $show_button .
	 * @param string $func .
	 * @param object $order .
	 * @param array  $get_specific_setting .
	 */
	public function wps_rma_policies_functionality_extend( $show_button, $func, $order, $get_specific_setting ) {
		$wps_rma_min_order = strpos( wp_json_encode( $get_specific_setting ), 'wps_rma_min_order' ) > 0 ? true : false;
		if ( 'yes' === $show_button ) {
			if ( ! empty( $wps_rma_min_order ) ) {
				foreach ( $get_specific_setting as $key => $value ) {
					if ( isset( $value['row_policy'] ) && 'wps_rma_min_order' === $value['row_policy'] ) {
						if ( isset( $value['row_conditions1'] ) && 'wps_rma_less_than' === $value['row_conditions1'] ) {
							if ( isset( $value['row_value'] ) && $order->get_total() < floatval( $value['row_value'] ) ) {
								$show_button = 'yes';
							} else {
								$show_button = ucfirst( $func ) . esc_html__( ' minimum order exceed must be less than ', 'woocommerce-rma-for-return-refund-and-exchange' ) . get_woocommerce_currency_symbol() . $value['row_value'];
								break;
							}
						} elseif ( $value['row_conditions1'] && 'wps_rma_greater_than' === $value['row_conditions1'] ) {
							if ( isset( $value['row_value'] ) && $order->get_total() > floatval( $value['row_value'] ) ) {
								$show_button = 'yes';
							} else {
								$show_button = ucfirst( $func ) . esc_html__( ' order must be greater than ', 'woocommerce-rma-for-return-refund-and-exchange' ) . get_woocommerce_currency_symbol() . $value['row_value'];
								break;
							}
						} elseif ( $value['row_conditions1'] && 'wps_rma_less_than_equal' === $value['row_conditions1'] ) {
							if ( isset( $value['row_value'] ) && $order->get_total() <= floatval( $value['row_value'] ) ) {
								$show_button = 'yes';
							} else {
								$show_button = ucfirst( $func ) . esc_html__( ' order must be less than equal to ', 'woocommerce-rma-for-return-refund-and-exchange' ) . get_woocommerce_currency_symbol() . $value['row_value'];
								break;
							}
						} elseif ( $value['row_conditions1'] && 'wps_rma_greater_than_equal' === $value['row_conditions1'] ) {
							if ( isset( $value['row_value'] ) && $order->get_total() >= floatval( $value['row_value'] ) ) {
								$show_button = 'yes';
							} else {
								$show_button = ucfirst( $func ) . esc_html__( ' order must be greater than equal to ', 'woocommerce-rma-for-return-refund-and-exchange' ) . get_woocommerce_currency_symbol() . $value['row_value'];
								break;
							}
						}
					}
				}
			}
		}
		$hide_for_cod = get_option( 'wps_rma_hide_rec', 'no' );
		if ( 'yes' === $show_button && 'on' === $hide_for_cod && 'cod' === $order->get_payment_method() && 'processing' === $order->get_status() ) {
			return ucfirst( $func ) . esc_html__( ' Can\'t make on the order on COD during processing', 'woocommerce-rma-for-return-refund-and-exchange' );
		}
		$ex_app_op = get_option( 'wps_rma_exchange_app_check', 'no' );
		if ( 'yes' === $show_button && 'on' !== $ex_app_op && 'exchange-approve' === $order->get_status() ) {
			$show_button = esc_html__( 'Refund & Exchange Can\'t make on Exchange Approved Order', 'woocommerce-rma-for-return-refund-and-exchange' );
		}
		return $show_button;
	}

	/**
	 * Dyamically regenerate coupon code
	 */
	public function wps_rma_coupon_regenertor() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$id = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';

			$coupon_code   = wps_rma_coupon_generator( 5 );
			$coupon        = array(
				'ID'         => isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '',
				'post_title' => $coupon_code,
			);
			$customer_id   = get_current_user_id();
			$wps_user_data = get_userdata( $customer_id );
			foreach ( $wps_user_data as $data_key => $data_value ) {
				if ( 'data' === $data_key ) {
					foreach ( $data_value as $data_key1 => $data_value1 ) {
						if ( 'user_email' === $data_key1 ) {
							$customer_email = $data_value1;
						}
					}
				}
			}
			wp_update_post( $coupon );
			update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $coupon_code );
			$coupon_price = get_post_meta( $id, 'coupon_amount', true );
			$response     = array(
				'coupon_code'        => $coupon_code,
				'currency_symbol'    => get_woocommerce_currency_symbol(),
				'coupon_price'       => wps_rma_currency_seprator( $coupon_price ),
				'coupon_code_text'   => esc_html__( 'Coupon Code', 'woocommerce-rma-for-return-refund-and-exchange' ),
				'wallet_amount_text' => esc_html__( 'Wallet Amount', 'woocommerce-rma-for-return-refund-and-exchange' ),
			);
			echo wp_json_encode( $response );
			wp_die();
		}
	}

	/**
	 * This function is to add custom order status for return and exchange
	 */
	public function wps_rma_register_custom_order_status() {
		register_post_status(
			'wc-exchange-request',
			array(
				'label'                     => 'Exchange Requested',
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true, /* translators: %s: search term */
				'label_count'               => _n_noop( 'Exchange Requested <span class="count">(%s)</span>', 'Exchange Requested <span class="count">(%s)</span>', 'woocommerce-rma-for-return-refund-and-exchange' ),
			)
		);

		register_post_status(
			'wc-exchange-approve',
			array(
				'label'                     => 'Exchange Approved',
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,  /* translators: %s: search term */
				'label_count'               => _n_noop( 'Exchange Approved <span class="count">(%s)</span>', 'Exchange Approved <span class="count">(%s)</span>', 'woocommerce-rma-for-return-refund-and-exchange' ),
			)
		);

		register_post_status(
			'wc-exchange-cancel',
			array(
				'label'                     => 'Exchange Cancelled',
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,  /* translators: %s: search term */
				'label_count'               => _n_noop( 'Exchange Cancelled <span class="count">(%s)</span>', 'Exchange Cancelled <span class="count">(%s)</span>', 'woocommerce-rma-for-return-refund-and-exchange' ),
			)
		);

		register_post_status(
			'wc-partial-cancel',
			array(
				'label'                     => 'Partially Cancelled',
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,  /* translators: %s: search term */
				'label_count'               => _n_noop( 'Partially Cancelled <span class="count">(%s)</span>', 'Partially Cancelled <span class="count">(%s)</span>', 'woocommerce-rma-for-return-refund-and-exchange' ),
			)
		);
	}

	/**
	 * This function is to register custom order status
	 *
	 * @param array $order_statuses .
	 */
	public function wps_rma_add_custom_order_status( $order_statuses ) {
		$new_order_statuses = array();
		foreach ( $order_statuses as $key => $status ) {
			$new_order_statuses[ $key ] = $status;

			if ( 'wc-completed' === $key ) {
				$new_order_statuses['wc-exchange-request'] = esc_html__( 'Exchange Requested', 'woocommerce-rma-for-return-refund-and-exchange' );
				$new_order_statuses['wc-exchange-approve'] = esc_html__( 'Exchange Approved', 'woocommerce-rma-for-return-refund-and-exchange' );
				$new_order_statuses['wc-exchange-cancel']  = esc_html__( 'Exchange Cancelled', 'woocommerce-rma-for-return-refund-and-exchange' );
				$new_order_statuses['wc-partial-cancel']   = esc_html__( 'Partially Cancelled', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
		}

		return $new_order_statuses;
	}

	/**
	 * This function is used to save selected exchange products
	 */
	public function wps_rma_exchange_products_callback() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$orderid = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : 0;
			if ( ! empty( $orderid ) ) {
				$wps_wrma_obj = wc_get_order( $orderid );
				$wps_cpn_dis  = $wps_wrma_obj->get_discount_total();
				$wps_cpn_tax  = $wps_wrma_obj->get_discount_tax();
				$wps_dis_tot  = $wps_cpn_dis + $wps_cpn_tax;
				$wps_dis_tot  = 0;
				if ( isset( $_POST['products'] ) ) {
					if ( strpos( isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '', '/exchange-request-form/' ) >= 0 ) {
						WC()->session->__unset( 'wps_wrma_exchange' );
					}
					$products = array();
					if ( null != WC()->session->get( 'exchange_requset' ) ) {
						$products = WC()->session->get( 'exchange_requset' );
					}
					$pending   = true;
					$_products = isset( $_POST['products'] ) ? map_deep( wp_unslash( $_POST['products'] ), 'sanitize_text_field' ) : array();
					if ( isset( $products ) && ! empty( $products ) ) {
						foreach ( $products as $date => $product ) {
							if ( 'pending' === $product['status'] ) {
								$products[ $date ]['status'] = 'pending';
								$products[ $date ]['from']   = $_products;
								$pending                     = false;
								break;
							}
						}
					}
					if ( $pending ) {
						$date                        = gmdate( 'd-m-Y' );
						$products                    = array();
						$products[ $date ]['status'] = 'pending';
						$products[ $date ]['from']   = $_products;
					}
					WC()->session->set( 'exchange_requset', $products );

					$response['response']       = 'success';
					$response['wps_coupon_amt'] = 0;
					echo wp_json_encode( $response );
					wp_die();
				} else {
					$response['wps_coupon_amt'] = 0;
					echo wp_json_encode( $response );
					wp_die();
				}
			}
		}
	}

	/** Set the session for the exchange process */
	public function wps_rma_set_exchange_session() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			if ( isset( $_POST['products'] ) ) {
				$products = isset( $_POST['products'] ) ? map_deep( wp_unslash( $_POST['products'] ), 'sanitize_text_field' ) : array();
				$orderid  = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : 0;
				WC()->session->set( 'wps_wrma_exchange', $orderid );
				$wps_wrma_exchange_variation_enable = get_option( 'wps_rma_exchange_same_product', false );
				if ( 'on' === $wps_wrma_exchange_variation_enable ) {
					$product_ids = array();
					foreach ( $products as $key => $value ) {
						$product_ids[] = $value['product_id'];
					}
					WC()->session->set( 'wps_wrma_exchange_variable_product', $product_ids );
				}

				return 'true';
				wp_die();
			}
		}
	}

	/**
	 * This function is to add exchange product
	 */
	public function wps_rma_add_to_exchange_callback() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$products         = array();
			$order_id         = WC()->session->get( 'wps_wrma_exchange' );
			$exchange_product = isset( $_POST['products'] ) ? map_deep( wp_unslash( $_POST['products'] ), 'sanitize_text_field' ) : array();
			$product_id       = $exchange_product['id'];
			// Start for variation.
			if ( isset( $exchange_product['variation_id'] ) ) {
				$product_variation          = new WC_Product_Variation( $exchange_product['variation_id'] );
				$wps_woo_tax_enable_setting = get_option( 'woocommerce_calc_taxes' );
				if ( 'yes' === $wps_woo_tax_enable_setting ) {
					$price                     = wc_get_price_including_tax( $product_variation );
					$exchange_product['price'] = $price;
				} else {
					$price                     = $product_variation->get_price();
					$exchange_product['price'] = $price;
				}
			}

			$exchange_details = array();
			if ( null != WC()->session->get( 'exchange_requset' ) ) {
				$exchange_details = WC()->session->get( 'exchange_requset' );
			}
			if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
				foreach ( $exchange_details as $date => $exchange_detail ) {
					if ( 'pending' === $exchange_detail['status'] ) {
						$pending_key = $date;
						if ( isset( $exchange_detail['to'] ) ) {
							$exchange_products = $exchange_detail['to'];
						} else {
							$exchange_products = array();
						}
						$pending = false;
						break;
					}
				}
			}

			if ( $pending ) {
				$exchange_products = array();
			}

			if ( isset( $exchange_product['grouped'] ) ) {
				$exchange_pro = array();
				foreach ( $exchange_product['grouped'] as $k => $val ) {
					$g_child        = array();
					$child_product  = new WC_Product( $k );
					$g_child['id']  = $k;
					$g_child['qty'] = $val;
					$g_child['sku'] = $child_product->get_sku();

					$g_child['price'] = $child_product->get_price();

					$exchange_pro[] = $g_child;
				}
				$exchange_product = $exchange_pro;
			}

			if ( isset( $exchange_products ) && ! empty( $exchange_products ) ) {
				foreach ( $exchange_products as $key => $product ) {
					$exist = true;
					if ( ! isset( $exchange_product['id'] ) ) {
						if ( is_array( $exchange_product ) ) {
							foreach ( $exchange_product as $a => $exchange_pro ) {
								if ( $product['id'] == $exchange_pro['id'] && $product['sku'] == $exchange_pro['sku'] ) {
									$exist                             = false;
									$exchange_products[ $key ]['qty'] += $exchange_pro['qty'];
									unset( $exchange_product[ $a ] );
								}
							}
						}
					} elseif ( $product['id'] == $exchange_product['id'] ) {
						if ( isset( $exchange_product['variation_id'] ) ) {
							if ( $product['variation_id'] == $exchange_product['variation_id'] ) {
								$var_matched = true;
								if ( isset( $exchange_product['variations'] ) && ! empty( $exchange_product['variations'] ) ) {
									$saved_product_variations = $exchange_product['variations'];
									foreach ( $saved_product_variations as $saved_product_key => $saved_product_variation ) {
										if ( array_key_exists( $saved_product_key, $product['variations'] ) ) {
											if ( $product['variations'][ $saved_product_key ] != $saved_product_variation ) {
												$var_matched = false;
											}
										}
									}
								}

								if ( $var_matched ) {
									$exist                             = false;
									$exchange_products[ $key ]['qty'] += $exchange_product['qty'];
									break;
								}
							}
						} else {
							$exist                             = false;
							$exchange_products[ $key ]['qty'] += $exchange_product['qty'];
							break;
						}
					}
				}
				if ( isset( $exchange_product ) ) {
					if ( ! isset( $exchange_product['id'] ) ) {
						if ( is_array( $exchange_product ) ) {
							foreach ( $exchange_product as $a => $exchange_pro ) {
								$exchange_products[] = $exchange_pro;
								unset( $exchange_product[ $a ] );
							}
						}
					}
				}
				if ( $exist ) {
					if ( ! empty( $exchange_product ) ) {
						$exchange_products[] = $exchange_product;
					}
				}
			} else {
				if ( isset( $exchange_product ) ) {
					if ( ! isset( $exchange_product['id'] ) ) {
						if ( is_array( $exchange_product ) ) {
							foreach ( $exchange_product as $a => $exchange_pro ) {
								$exchange_products[] = $exchange_pro;
							}
						}
					} elseif ( ! empty( $exchange_product ) ) {
						$exchange_products[] = $exchange_product;
					}
				}
			}

			if ( $pending ) {
				$exchange_details                = array();
				$date                            = gmdate( 'd-m-Y' );
				$exchange_details[ $date ]['to'] = $exchange_products;
			} else {
				$exchange_details[ $pending_key ]['to'] = $exchange_products;
			}

			WC()->session->set( 'exchange_requset', $exchange_details );
			$response['response'] = 'success';
			$response['message']  = apply_filters( 'wps_wrma_product_exchanged_message', esc_html__( 'View Order', 'woocommerce-rma-for-return-refund-and-exchange' ) );
			$page_id              = get_option( 'wps_rma_exchange_req_page', true );
			$exchange_url         = get_permalink( $page_id );
			$exchange_url         = add_query_arg( 'order_id', $order_id, $exchange_url );
			$exchange_url         = wp_nonce_url( $exchange_url, 'wps_rma_nonce', 'wps_rma_nonce' );
			$response['url']      = $exchange_url;
			echo json_encode( $response );
			wp_die();
		}
	}

	/**
	 * This function is add exchange button on shop page
	 */
	public function wps_rma_add_exchange_products() {
		global $product;
		if ( is_admin() ) {
			return;
		}
		$order_id = WC()->session->get( 'wps_wrma_exchange' );
		if ( WC()->version < '3.0.0' ) {
			$product_type = $product->product_type;
			$product_id   = $product->id;
			$price        = $product->get_display_price();
		} else {
			$product_id   = $product->get_id();
			$product_type = $product->get_type();
		}

		$wps_woo_tax_enable_setting = get_option( 'woocommerce_calc_taxes' );
		if ( 'yes' === $wps_woo_tax_enable_setting ) {
			$price = wc_get_price_including_tax( $product );
		} else {
			$price = $product->get_price();
		}
		$wps_wrma_exchange_variation_enable = get_option( 'wps_rma_exchange_same_product', false );

		$wps_wrma_add_to_cart_enable = get_option( 'wps_rma_remove_add_to_cart', 'no' );
		if ( 'on' === $wps_wrma_exchange_variation_enable && null != WC()->session->get( 'wps_wrma_exchange_variable_product' ) ) {
			if ( 'on' !== $wps_wrma_add_to_cart_enable ) {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
			}
		} elseif ( null != WC()->session->get( 'wps_wrma_exchange' ) ) {
			if ( 'on' !== $wps_wrma_add_to_cart_enable ) {
				remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
			}
			if ( 'simple' === $product_type && $product->is_in_stock() ) {
				?>
				<div class="wps_wrma_exchange_wrapper"><a class="button wps_wrma_ajax_add_to_exchange" data-product_sku="<?php echo esc_html( $product->get_sku() ); ?>" data-product_id="<?php echo esc_html( $product_id ); ?>" data-quantity="1" data-price="<?php echo esc_html( $price ); ?>"><?php echo esc_html( apply_filters( 'wps_wrma_exchange_product_button', esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ) ) ); ?></a></div>
				<?php
			}
		}
	}

	/**
	 * This function is to remove exchange product.
	 */
	public function wps_wrma_exchnaged_product_remove_callback() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$order_id         = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : '';
			$key              = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';
			$exchange_details = array();
			if ( null != WC()->session->get( 'exchange_requset' ) ) {
				$exchange_details = WC()->session->get( 'exchange_requset' );
			}
			if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
				foreach ( $exchange_details as $date => $exchange_detail ) {
					if ( 'pending' === $exchange_detail['status'] ) {
						$exchange_products = $exchange_detail['to'];
						unset( $exchange_products[ $key ] );
						$exchange_details[ $date ]['to'] = $exchange_products;
						break;
					}
				}
			}

			WC()->session->set( 'exchange_requset', $exchange_details );
			$exchange_details = array();
			if ( null != WC()->session->get( 'exchange_requset' ) ) {
				$exchange_details = WC()->session->get( 'exchange_requset' );
			}

			$total_price = 0;

			if ( isset( $exchange_products ) && ! empty( $exchange_products ) ) {
				foreach ( $exchange_products as $key => $exchanged_product ) {
					$pro_price    = $exchanged_product['qty'] * $exchanged_product['price'];
					$total_price += $pro_price;
				}
			}
			$response['response']    = 'success';
			$response['total_price'] = $total_price;
			echo wp_json_encode( $response );
			die;
		}
	}

	/**
	 * This function is to save exchange request Attachment
	 */
	public function wps_wrma_order_exchange_attach_files() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax && isset( $_FILES['wps_wrma_exchange_request_files'] ) ) {
			if ( isset( $_FILES['wps_wrma_exchange_request_files']['tmp_name'] ) ) {
				$filename = array();
				$order_id = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : 0;
				$count    = count( $_FILES['wps_wrma_exchange_request_files']['tmp_name'] );
				for ( $i = 0; $i < $count; $i++ ) {
					if ( isset( $_FILES['wps_wrma_exchange_request_files']['tmp_name'][ $i ] ) ) {
						$directory = ABSPATH . 'wp-content/attachment';
						if ( ! file_exists( $directory ) ) {
							mkdir( $directory, 0755, true );
						}
						$sourcepath = sanitize_text_field( wp_unslash( $_FILES['wps_wrma_exchange_request_files']['tmp_name'][ $i ] ) );
						$file_name  = isset( $_FILES['wps_wrma_exchange_request_files']['name'][ $i ] ) ? sanitize_text_field( wp_unslash( $_FILES['wps_wrma_exchange_request_files']['name'][ $i ] ) ) : '';
						$targetpath = $directory . '/' . $order_id . '-' . $file_name;
						$filename[] = $order_id . '-' . $file_name;
						move_uploaded_file( $sourcepath, $targetpath );
					}
				}

				$request_files = get_post_meta( $order_id, 'wps_wrma_exchange_attachment', true );

				$pending = true;
				if ( isset( $request_files ) && ! empty( $request_files ) ) {
					foreach ( $request_files as $date => $request_file ) {
						if ( 'pending' === $request_file['status'] ) {
							unset( $request_files[ $date ][0] );
							$request_files[ $date ]['files']  = $filename;
							$request_files[ $date ]['status'] = 'pending';
							$pending                          = false;
							break;
						}
					}
				}

				if ( $pending ) {
					$request_files                    = array();
					$date                             = gmdate( 'd-m-Y' );
					$request_files[ $date ]['files']  = $filename;
					$request_files[ $date ]['status'] = 'pending';
				}
				update_post_meta( $order_id, 'wps_wrma_exchange_attachment', $request_files );
				echo 'success';
			}
		}
		echo 'success';
		wp_die();
	}

	/**
	 * This function is to submit exchange product request.
	 */
	public function wps_wrma_submit_exchange_request() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$order_id               = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : '';
			$subject                = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
			$reason                 = isset( $_POST['reason'] ) ? sanitize_text_field( wp_unslash( $_POST['reason'] ) ) : '';
			$wps_wrma_refund_method = isset( $_POST['refund_method'] ) ? sanitize_text_field( wp_unslash( $_POST['refund_method'] ) ) : '';
			$bank_details           = isset( $_POST['bankdetails'] ) ? sanitize_text_field( wp_unslash( $_POST['bankdetails'] ) ) : '';
			$re_bank                = get_option( 'wps_rma_refund_manually_de', false );
			if ( 'on' === $re_bank && ! empty( $bank_details ) ) {
				update_post_meta( $order_id, 'wps_rma_bank_details', $bank_details );
			}
			$wallet_enabled = get_option( 'wps_rma_wallet_enable', 'no' );
			$refund_method  = get_option( 'wps_rma_refund_method', 'no' );
			if ( 'on' === $wallet_enabled && 'on' !== $refund_method ) {
				$wps_wrma_refund_method = 'wallet_method';
			}
			$response = wps_wrma_submit_exchange_request_callback( $order_id, $subject, $reason, $wps_wrma_refund_method );
			echo wp_json_encode( $response );
			wp_die();
		}
	}

	/**
	 * Do the global shipping related functionality
	 *
	 * @param integer $order_id .
	 * @param array   $item_ids .
	 * @return void
	 */
	public function wps_rma_do_something_on_refund( $order_id, $item_ids ) {
		update_post_meta( $order_id, 'wps_rma_left_amount_done', '' );
		$ex_added_fees   = get_option( 'wps_wrma_shipping_global_data', array() );
		$wps_fee_cost    = isset( $ex_added_fees['fee_cost'] ) ? $ex_added_fees['fee_cost'] : array();
		$wps_fee_name    = isset( $ex_added_fees['fee_name'] ) ? $ex_added_fees['fee_name'] : array();
		$global_shipping = global_shipping_charges( $order_id, $item_ids );
		if ( $global_shipping ) {
			$add_fee = array_combine( $wps_fee_name, $wps_fee_cost );
			update_post_meta( $order_id, 'ex_ship_amount1', $add_fee );
		}
	}

	/**
	 * This function is to add Exchange button on order detail page.
	 */
	public function wps_wrma_exchnaged_product_add_button() {
		global $product;
		$sku = $product->get_sku();
		if ( WC()->version < '3.0.0' ) {
			$product_id   = $product->id;
			$product_type = $product->product_type;
			$price        = $product->get_display_price();
		} else {
			$product_id   = $product->get_id();
			$product_type = $product->get_type();
			$price        = wc_get_price_including_tax( $product );
		}
		$order_id          = WC()->session->get( 'wps_wrma_exchange' );
		$wps_rma_check_tax = get_option( $order_id . 'check_tax', false );
		if ( empty( $wps_rma_check_tax ) ) {
			$price = $product->get_price();
		} elseif ( 'wps_rma_inlcude_tax' === $wps_rma_check_tax ) {
			$price = wc_get_price_including_tax( $product );
		} elseif ( 'wps_rma_exclude_tax' === $wps_rma_check_tax ) {
			$price = wc_get_price_excluding_tax( $product );
		}
		$price = apply_filters( 'formatted_woocommerce_price', number_format( $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() ), $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() );

		$wps_wrma_exchange_variation_enable = get_option( 'wps_rma_exchange_same_product', false );

		if ( 'on' === $wps_wrma_exchange_variation_enable ) {
			if ( 'variable' === $product_type && $product->is_in_stock() ) {
				if ( null != WC()->session->get( 'wps_wrma_exchange_variable_product' ) ) {
					foreach ( WC()->session->get( 'wps_wrma_exchange_variable_product' ) as $key => $value ) {
						if ( get_the_ID() == $value ) {
							?>
						<div class="wps_wrma_exchange_wrapper">
							<button  data-product_id="<?php echo esc_html( $product_id ); ?>" class="wps_wrma_add_to_exchanged_detail_variable button alt">
								<?php echo esc_html( apply_filters( 'wps_wrma_exchange_product_button', esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ) ) ); ?>
							</button>
						</div>
							<?php
						}
					}
				}
			}
			if ( 'simple' === $product_type && $product->is_in_stock() ) {
				if ( null != WC()->session->get( 'wps_wrma_exchange_variable_product' ) ) {
					foreach ( WC()->session->get( 'wps_wrma_exchange_variable_product' ) as $key => $value ) {
						if ( get_the_ID() == $value ) {
							?>
						<div class="wps_wrma_exchange_wrapper"><button data-price="<?php echo esc_html( $price ); ?>" data-product_sku="<?php echo esc_html( $sku ); ?>" data-product_id="<?php echo esc_html( $product_id ); ?>" class="wps_wrma_add_to_exchanged_detail button alt"><?php echo esc_html( apply_filters( 'wps_wrma_exchange_product_button', esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ) ) ); ?></button></div>
							<?php
						}
					}
				}
			}
		} elseif ( null != WC()->session->get( 'wps_wrma_exchange' ) ) {

			if ( 'simple' === $product_type && $product->is_in_stock() ) {
				if ( null != WC()->session->get( 'wps_wrma_exchange' ) ) {
					?>
					<div class="wps_wrma_exchange_wrapper"><button data-price="<?php echo esc_html( $price ); ?>" data-product_sku="<?php echo esc_html( $sku ); ?>" data-product_id="<?php echo esc_html( $product_id ); ?>" class="wps_wrma_add_to_exchanged_detail button alt"><?php echo esc_html( apply_filters( 'wps_wrma_exchange_product_button', esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ) ) ); ?></button></div>
					<?php
				}
			}
			if ( 'variable' === $product_type && $product->is_in_stock() ) {
				if ( null != WC()->session->get( 'wps_wrma_exchange' ) ) {
					?>
					<div class="wps_wrma_exchange_wrapper">
						<button  data-product_id="<?php echo esc_html( $product_id ); ?>" class="wps_wrma_add_to_exchanged_detail_variable button alt">
							<?php echo esc_html( apply_filters( 'wps_wrma_exchange_product_button', esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ) ) ); ?>
						</button>
					</div>
					<?php
				}
			}
			if ( 'grouped' === $product_type && $product->is_in_stock() ) {
				if ( null != WC()->session->get( 'wps_wrma_exchange' ) ) {
					?>
					<div class="wps_wrma_exchange_wrapper"><button data-price="<?php echo esc_html( $price ); ?>" data-product_sku="<?php echo esc_html( $sku ); ?>" data-product_id="<?php echo esc_html( $product_id ); ?>" class="wps_wrma_add_to_exchanged_detail button alt"><?php echo esc_html( apply_filters( 'wps_wrma_exchange_product_button', esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ) ) ); ?></button></div>
					<?php
				}
			}
		}
	}

	/**
	 * This function is update order number listing for exhanged Order
	 *
	 * @param array $order_id .
	 */
	public function wps_wrma_update_order_number_callback( $order_id ) {
		$orderid = get_post_meta( $order_id, 'wps_wrma_exchange_order', true );
		if ( isset( $orderid ) && ! empty( $orderid ) ) {
			$order_id = $order_id . ' → ' . $orderid;
		}
		return $order_id;
	}

	/**
	 * This function is enable cancel for exchange approved order
	 *
	 * @param array $status .
	 */
	public function wps_wrma_order_can_cancel( $status ) {
		$status[] = 'exchange-approve';
		return $status;
	}

	/**
	 * This function is enable Payment for exchange approved order
	 *
	 * @param array $status i.
	 */
	public function wps_wrma_order_need_payment( $status ) {
		$status[] = 'exchange-approve';
		return $status;
	}

	/**
	 * Check if refund/exchange will made on the order or not.
	 *
	 * @param bool $flag .
	 * @param int  $order_id .
	 * @return bool
	 */
	public function wps_rma_refund_will_made( $flag, $order_id ) {
		$wps_wrma_made   = get_post_meta( $order_id, 'wps_rma_request_made', false );
		$wps_wrma_enable = get_option( 'wps_rma_single_refund_exchange', false );
		if ( 'on' === $wps_wrma_enable && ! empty( $wps_wrma_made ) ) {
			$flag = false;
		}
		return $flag;
	}

	/**
	 * Check if auto refund is enable.
	 *
	 * @param bool $disallow .
	 */
	public function wps_rma_auto_accept_refund( $disallow ) {
		$auto_refund = get_option( 'wps_rma_refund_auto', 'no' );
		if ( 'on' === $auto_refund ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Auto refund request accept.
	 */
	public function wps_rma_auto_return_req_approve() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$orderid  = isset( $_POST['orderid'] ) ? sanitize_text_field( wp_unslash( $_POST['orderid'] ) ) : 0;
			$products = get_post_meta( $orderid, 'wps_rma_return_product', true );
			$order    = wc_get_order( $orderid );
			if ( function_exists( 'wps_rma_return_req_approve_callback' ) && ! empty( $order ) ) {
				$show_refund_button = wps_rma_show_buttons( 'refund', $order );
				if ( 'yes' === $show_refund_button ) {
					$response = wps_rma_return_req_approve_callback( $orderid, $products );
					echo wp_json_encode( $response );
				}
			}
		}
		wp_die();
	}

	/**
	 * Cancel whole order and manage stock of cancelled product.
	 */
	public function wps_rma_cancel_customer_order() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$order_id = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : 0;
			$url      = wps_rma_cancel_customer_order_callback( $order_id );
			if ( $url ) {
				wc_add_notice( esc_html__( 'Your order is cancelled', 'woocommerce-rma-for-return-refund-and-exchange' ) );
			}
			echo esc_html( $url );
			wp_die();
		}
	}


	/**
	 * Cancel order's profucts and manage stock of cancelled product.
	 */
	public function wps_rma_cancel_customer_order_products() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$order_id = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : 0;
			$item_ids = isset( $_POST['item_ids'] ) ? map_deep( wp_unslash( $_POST['item_ids'] ), 'sanitize_text_field' ) : array();
			$response = wps_rma_cancel_customer_order_products_callback( $order_id, $item_ids );
			if ( $response ) {
				wc_add_notice( esc_html__( 'Your selected product(s) removed from the order.', 'woocommerce-rma-for-return-refund-and-exchange' ) );
			}
			echo esc_html( $response );
			wp_die();
		}
	}

	/**
	 * Manage Customer Wallet on Order cancelled.
	 *
	 * @name wps_wrma_woocommerce_order_status_changed
	 * @param int    $order_id .
	 * @param string $new_status .
	 */
	public function wps_rma_woocommerce_order_status_changed( $order_id, $new_status ) {
		if ( wps_rma_wallet_feature_enable() ) {
			$cancelstatusenable = get_option( 'wps_rma_cancel_order_wallet', 'no' );
			if ( 'on' === $cancelstatusenable ) {
				$value       = get_post_meta( $order_id, '_customer_user', true );
				$customer_id = $value ? absint( $value ) : '';
				if ( $customer_id > 0 ) {
					$order          = wc_get_order( $order_id );
					$payment_method = $order->get_payment_method();
					$statuses       = array( 'pending', 'processing', 'completed' );
					if ( 'cod' !== $payment_method && 'cancelled' === $new_status ) {
						$order_discount = $order->get_total_discount();
						$walletcoupon   = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
						if ( empty( $walletcoupon ) ) {
							$coupon_code   = wps_rma_coupon_generator( 5 );
							$order_id      = $order->get_id();
							$coupon        = array(
								'post_title'   => $coupon_code,
								'post_content' => esc_html__( 'CANCELLED - ORDER ', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $order_id,
								'post_excerpt' => esc_html__( 'CANCELLED - ORDER ', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $order_id,
								'post_status'  => 'publish',
								'post_author'  => get_current_user_id(),
								'post_type'    => 'shop_coupon',
							);
							$new_coupon_id = wp_insert_post( $coupon );
							update_post_meta( $new_coupon_id, 'discount_type', 'fixed_cart' );
							update_post_meta( $new_coupon_id, 'coupon_amount', $order_discount );
							update_post_meta( $new_coupon_id, 'wrmawallet', true );
							update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $coupon_code );
						} else {
							$the_coupon = new WC_Coupon( $walletcoupon );
							$coupon_id  = $the_coupon->get_id();
							if ( isset( $coupon_id ) ) {
								$amount           = get_post_meta( $coupon_id, 'coupon_amount', true );
								$remaining_amount = $amount + $order_discount;
								update_post_meta( $coupon_id, 'coupon_amount', $remaining_amount );
								update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $walletcoupon );
								update_post_meta( $coupon_id, 'wrmawallet', true );
							}
						}
					}
				}
			}
		}
	}

	/** Extend the role capability */
	public function wps_rma_role_capability_extend() {
		if ( ! is_user_logged_in() ) {
			add_role( 'guest', 'Guest', array( 'read' => true ) );
			$wps_rma_customer_role = get_role( 'guest' );
			if ( ! empty( $wps_rma_customer_role ) ) {
				$wps_rma_customer_role->add_cap( 'wps-rma-refund-request', true );
				$wps_rma_customer_role->add_cap( 'wps-rma-exchange-request', true );
				$wps_rma_customer_role->add_cap( 'wps-rma-cancel-request', true );
			}
		}

		$wps_rma_customer_role = get_role( 'customer' );
		if ( ! empty( $wps_rma_customer_role ) ) {
			$wps_rma_customer_role->add_cap( 'wps-rma-refund-request', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-request', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-cancel-request', true );
		}

		$wps_rma_customer_role = get_role( 'administrator' );
		if ( ! empty( $wps_rma_customer_role ) ) {
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-request', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-approve', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-cancel', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-cancel-request', true );
		}

		$wps_rma_customer_role = get_role( 'editor' );
		if ( ! empty( $wps_rma_customer_role ) ) {
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-request', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-approve', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-cancel', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-cancel-request', true );
		}

		$wps_rma_customer_role = get_role( 'shop_manager' );
		if ( ! empty( $wps_rma_customer_role ) ) {
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-request', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-approve', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-exchange-cancel', true );
			$wps_rma_customer_role->add_cap( 'wps-rma-cancel-request', true );
		}
	}

	/**
	 * Register our emails.
	 *
	 * @param array $email_classes email classes.
	 */
	public function wps_rma_woocommerce_emails( $email_classes ) {

		// include our email class.
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/class-wps-rma-exchange-request-email.php';
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/class-wps-rma-exchange-request-accept-email.php';
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/class-wps-rma-exchange-request-cancel-email.php';
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/class-wps-rma-cancel-request-email.php';
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/class-wps-rma-returnship-email.php';
		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'emails/class-wps-rma-refund-email.php';

		// add the email class to the list of email classes that WooCommerce loads.
		$email_classes['wps_rma_exchange_request_email']        = new Wps_Rma_Exchange_Request_Email();
		$email_classes['wps_rma_exchange_request_accept_email'] = new Wps_Rma_Exchange_Request_Accept_Email();
		$email_classes['wps_rma_exchange_request_cancel_email'] = new Wps_Rma_Exchange_Request_Cancel_Email();
		$email_classes['wps_rma_cancel_request_email']          = new Wps_Rma_Cancel_Request_Email();
		$email_classes['wps_rma_returnship_email']              = new Wps_Rma_Returnship_Email();
		$email_classes['wps_rma_refund_email']                  = new Wps_Rma_Refund_Email();
		return $email_classes;
	}

	/**
	 * Exchange Request template
	 *
	 * @param int $order_id .
	 */
	public function wps_rma_exchange_req_email( $order_id ) {
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'common/partials/email_template/wps-rma-exchange-request-email-template.php';
	}

	/**
	 * Cancel Order's product template
	 *
	 * @param int   $order_id .
	 * @param array $item_ids .
	 */
	public function wps_rma_cancel_prod_email( $order_id, $item_ids ) {
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'common/partials/email_template/wps-rma-cancel-prod-email-template.php';
	}

	/**
	 * Cancel Order template
	 *
	 * @param int $order_id .
	 */
	public function wps_rma_cancel_order_email( $order_id ) {
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'common/partials/email_template/wps-rma-cancel-order-email-template.php';
	}

	/**
	 * Save the slected status change date.
	 *
	 * @param [type] $order_id current order_id.
	 * @param [type] $old_status old status.
	 * @param [type] $new_status new status.
	 */
	public function wps_rma_order_change( $order_id, $old_status, $new_status ) {
		$order             = wc_get_order( $order_id );
		$start_date_status = get_option( 'wps_rma_order_status_start' );
		if ( 'wc-none' !== $start_date_status && 'wc-' . $new_status === $start_date_status ) {
			$date           = date_i18n( 'd-m-Y', strtotime( $order->get_date_modified() ) );
			$get_saved_date = get_post_meta( $order_id, 'wps_rma_start_date', true );
			if ( empty( $get_saved_date ) ) {
				update_post_meta( $order_id, 'wps_rma_start_date', $date );
			}
		}
	}

	/**
	 * Functionality to change the order start date from the selected status in the setting.
	 *
	 * @param [type] $order_status_date .
	 * @param [type] $order .
	 * @return $oorder_status_date date .
	 */
	public function wps_order_status_start_date( $order_status_date, $order ) {
		$start_date_status = get_option( 'wps_rma_order_status_start' );
		if ( ! empty( $start_date_status ) && 'wc-none' !== $start_date_status ) {
			$get_saved_date = get_post_meta( $order->get_id(), 'wps_rma_start_date', true );
			if ( ! empty( $get_saved_date ) ) {
				$order_status_date = strtotime( $get_saved_date );
			}
		}
		return $order_status_date;
	}

	/**
	 * Restrict the Refund Request Related Mail for Customer.
	 *
	 * @param bool $flag .
	 */
	public function wps_rma_restrict_refund_request_mails( $flag ) {
		$enable = get_option( 'wps_rma_block_refund_req_email', 'no' );
		if ( 'on' === $enable ) {
			$flag = false;
		}
		return $flag;
	}

	/**
	 * Restrict the exchange request related mail for customer.
	 *
	 * @param bool $flag .
	 */
	public function wps_rma_restrict_exchange_request_mails( $flag ) {
		$enable = get_option( 'wps_rma_block_exchange_req_email', 'no' );
		if ( 'on' === $enable ) {
			$flag = false;
		}
		return $flag;
	}

	/**
	 * Restrict the order related mail.
	 *
	 * @param bool $flag .
	 */
	public function wps_rma_restrict_order_msg_mails( $flag ) {
		$enable = get_option( 'wps_rma_order_email', 'no' );
		if ( 'on' === $enable ) {
			$flag = false;
		}
		return $flag;
	}

	/** Registers the shortcode in WordPress */
	public function wps_rma_add_wp_bakery_widgets() {
		add_shortcode( 'wps_rma_exchange_form', array( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common', 'wps_rma_exchange_form_shortcode' ) );
		add_shortcode( 'wps_rma_cancel_form', array( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common', 'wps_rma_cancel_form_shortcode' ) );
		add_shortcode( 'wps_rma_guest_form_wb', array( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common', 'wps_rma_guest_form_wb_shortcode' ) );
	}

	/** Map shortcode to Visual Composer. */
	public function wps_rma_map_shortocde_widget() {
		vc_lean_map( 'wps_rma_exchange_form', array( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common', 'wps_rma_exchange_form_map' ) );
		vc_lean_map( 'wps_rma_cancel_form', array( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common', 'wps_rma_cancel_form_map' ) );
		vc_lean_map( 'wps_rma_guest_form_wb', array( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Common', 'wps_rma_guest_form_wb_map' ) );
	}

	/**
	 * Map shortcode to VC
	 *
	 * This is an array of all your settings which become the shortcode attributes ($atts)
	 * for the output.
	 */
	public static function wps_rma_exchange_form_map() {
		return array(
			'name'        => esc_html__( 'Exchange Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'description' => esc_html__( 'Add Exchange Form into your page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'base'        => 'vc_infobox',
			'category'    => esc_html__( 'RMA FORMS', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'icon'        => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
		);
	}

	/**
	 * Map shortcode to VC
	 *
	 * This is an array of all your settings which become the shortcode attributes ($atts)
	 * for the output.
	 */
	public static function wps_rma_cancel_form_map() {
		return array(
			'name'        => esc_html__( 'Cancel Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'description' => esc_html__( 'Add Cancel Form into your page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'base'        => 'vc_infobox',
			'category'    => esc_html__( 'RMA FORMS', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'icon'        => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
		);
	}

	/**
	 * Map shortcode to VC
	 *
	 * This is an array of all your settings which become the shortcode attributes ($atts)
	 * for the output.
	 */
	public static function wps_rma_guest_form_wb_map() {
		return array(
			'name'        => esc_html__( 'Guest Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'description' => esc_html__( 'Add Guest Form into your page', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'base'        => 'vc_infobox',
			'category'    => esc_html__( 'RMA FORMS', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'icon'        => plugin_dir_path( __FILE__ ) . 'assets/img/note.png',
		);
	}

	/**
	 * Shortcode output .
	 *
	 * @param [type] $atts .
	 * @param [type] $content .
	 */
	public static function wps_rma_exchange_form_shortcode( $atts, $content = null ) {
		return include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'public/partials/wps-exchange-request-form.php';

	}

	/**
	 * Shortcode output .
	 *
	 * @param [type] $atts .
	 * @param [type] $content .
	 */
	public static function wps_rma_cancel_form_shortcode( $atts, $content = null ) {
		return include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'public/partials/wps-cancel-request-form.php';

	}

	/**
	 * Shortcode output .
	 *
	 * @param [type] $atts .
	 * @param [type] $content .
	 */
	public static function wps_rma_guest_form_wb_shortcode( $atts, $content = null ) {
		return include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'public/partials/wps-guest-form.php';

	}

	/**
	 * Multisite compatibility on new site creation
	 *
	 * @param object $new_site .
	 * @return void
	 */
	public function wps_rma_pro_plugin_on_create_blog( $new_site ) {
		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}
		// Check if the plugin has been activated on the network.
		$license_code      = get_option( 'wps_mwr_license_key' );
		$activate_timetamp = get_option( 'wps_mwr_activated_timestamp' );
		if ( is_plugin_active_for_network( 'woocommerce-rma-for-return-refund-and-exchange/rma-return-refund-exchange-for-woocommerce-pro.php' ) ) {
			$blog_id = $new_site->blog_id;

			// Switch to newly created site.
			switch_to_blog( $blog_id );

			require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'includes/class-rma-return-refund-exchange-for-woocommerce-pro-activator.php';
			Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Activator::wps_rma_create_pages( $new_site );
			if ( $license_code && function_exists( 'wps_rma_license_activate' ) ) {
				wps_rma_license_activate( $license_code );
			}
			if ( $activate_timetamp ) {
				update_option( 'wps_mwr_activated_timestamp', $activate_timetamp );
			}

			restore_current_blog();
		}
	}

	/**
	 * Exchange Request Accept template.
	 *
	 * @param string $order_id .
	 * @param string $orderid .
	 */
	public function wps_rma_exchange_req_accept_email( $order_id, $orderid ) {
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/email_template/wps-rma-exchange-request-accept-email-template.php';
	}

	/**
	 * Exchange Request Cancel template.
	 *
	 * @param string $order_id .
	 */
	public function wps_rma_exchange_req_cancel_email( $order_id ) {
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/email_template/wps-rma-exchange-request-cancel-email-template.php';
	}

	/**
	 * Send the refund amount mail for exchange
	 *
	 * @param integer $orderid .
	 * @param integer $refund_amount .
	 * @return void
	 */
	public function wps_rma_ex_refund_amount_mail( $orderid, $refund_amount ) {
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/email_template/wps-rma-exchange-refund-email-template.php';
	}

	/**
	 * Send the refund amount mail for refund
	 *
	 * @param string $orderid .
	 * @param string $refund_amu .
	 */
	public function wps_rma_refunded_amount_mail( $orderid, $refund_amu ) {
		include_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'admin/partials/email_template/wps-rma-refund-email-template.php';
	}

	/**
	 * Shortcode extend
	 *
	 * @param array  $placeholders .
	 * @param string $order_id .
	 */
	public function wps_rma_shortcode_extend( $placeholders, $order_id ) {
		$billing_first_name                     = get_post_meta( $order_id, '_billing_first_name', true );
		$billing_last_name                      = get_post_meta( $order_id, '_billing_last_name', true );
		$billing_email                          = get_post_meta( $order_id, '_billing_email', true );
		$billing_phone                          = get_post_meta( $order_id, '_billing_phone', true );
		$billing_country                        = get_post_meta( $order_id, '_billing_country', true );
		$billing_address_1                      = get_post_meta( $order_id, '_billing_address_1', true );
		$billing_address_2                      = get_post_meta( $order_id, '_billing_address_2', true );
		$billing_state                          = get_post_meta( $order_id, '_billing_state', true );
		$billing_postcode                       = get_post_meta( $order_id, '_billing_postcode', true );
		$shipping_first_name                    = get_post_meta( $order_id, '_shipping_first_name', true );
		$shipping_last_name                     = get_post_meta( $order_id, '_shipping_last_name', true );
		$shipping_company                       = get_post_meta( $order_id, '_shipping_company', true );
		$shipping_country                       = get_post_meta( $order_id, '_shipping_country', true );
		$shipping_address_1                     = get_post_meta( $order_id, '_shipping_address_1', true );
		$shipping_address_2                     = get_post_meta( $order_id, '_shipping_address_2', true );
		$shipping_state                         = get_post_meta( $order_id, '_shipping_state', true );
		$shipping_postcode                      = get_post_meta( $order_id, '_shipping_postcode', true );
		$payment_method_title                   = get_post_meta( $order_id, '_payment_method_title', true );
		$order_shipping                         = get_post_meta( $order_id, '_order_shipping', true );
		$order_total                            = get_post_meta( $order_id, '_order_total', true );
		$refundable_amount                      = get_post_meta( $order_id, 'refundable_amount', true );
		$placeholders['{order_total}']          = $order_total;
		$placeholders['{billing_first_name}']   = $billing_first_name;
		$placeholders['{billing_last_name}']    = $billing_last_name;
		$placeholders['{billing_email}']        = $billing_email;
		$placeholders['{billing_phone}']        = $billing_phone;
		$placeholders['{billing_country}']      = $billing_country;
		$placeholders['{billing_address_1}']    = $billing_address_1;
		$placeholders['{billing_address_2}']    = $billing_address_2;
		$placeholders['{billing_state}']        = $billing_state;
		$placeholders['{billing_postcode}']     = $billing_postcode;
		$placeholders['{shipping_first_name}']  = $shipping_first_name;
		$placeholders['{shipping_last_name}']   = $shipping_last_name;
		$placeholders['{shipping_postcode}']    = $shipping_company;
		$placeholders['{shipping_country}']     = $shipping_country;
		$placeholders['{shipping_address_1}']   = $shipping_address_1;
		$placeholders['{shipping_address_2}']   = $shipping_address_2;
		$placeholders['{shipping_state}']       = $shipping_state;
		$placeholders['{shipping_postcode}']    = $shipping_postcode;
		$placeholders['{order_shipping}']       = $order_shipping;
		$placeholders['{payment_method_title}'] = $payment_method_title;
		$placeholders['{refundable_amount}']    = $refundable_amount;

		$products     = get_post_meta( $order_id, 'wps_rma_return_product', true );
		$product_table = '<table style="width: 100%; text-align: left; border-collapse: collapse; color : #767676 ;">
		<tbody>
		<tr>
		<th style="border: 2px solid #ddd; padding: 5px;">' . __( 'Product', 'mwb-woocommerce-rma' ) . '</th>
		<th style="border: 2px solid #ddd; padding: 5px;">' . __( 'Quantity', 'mwb-woocommerce-rma' ) . '</th>
		<th style="border: 2px solid #ddd; padding: 5px;">' . __( 'Price', 'mwb-woocommerce-rma' ) . '</th>
		</tr>';
		if ( isset( $products ) && ! empty( $products ) ) {
			foreach ( $products as $date => $product ) {
				foreach ( $product['products'] as $product_data ) {
					$item_meta      = new WC_Order_Item_Product( $product_data['item_id'] );
					$item_meta_html = wc_display_item_meta( $item_meta, array( 'echo' => false ) );
					$product_table .= '<tr><td style="border: 2px solid #ddd; padding: 5px;">' . $item_meta->get_name() . '<br>';
					$product_table .= '<small>' . $item_meta_html . '</small>
								<td style="border: 2px solid #ddd; padding: 5px;">' . $product_data['qty'] . '</td>
								<td style="border: 2px solid #ddd; padding: 5px;">' . ( $product_data['price'] * $product_data['qty'] ) . '</td>
								</tr>';
				}
			}
		}
		$placeholders['{product_table}'] = $product_table;
		return $placeholders;
	}

	/**
	 * Extend Refund Shortcode email desc
	 *
	 * @param string $shortcodes .
	 * @return shortcodes
	 */
	public function wps_rma_refund_shortcode( $shortcodes ) {
		return $shortcodes . '{order_total},{billing_first_name},{billing_last_name},{billing_email},{billing_phone},{billing_country},{billing_address_1},{billing_address_2},{billing_state},{billing_postcode},{shipping_first_name},{shipping_last_name},{shipping_postcode},{shipping_country},{shipping_address_1},{shipping_address_2},{shipping_state},{shipping_postcode},{order_shipping},{payment_method_title},{refundable_amount},{product_table}';
	}

	/**
	 * This function is to update wallet coupon amount
	 *
	 * @param [type] $item_id .
	 * @param [type] $item .
	 * @param [type] $order_id .
	 * @return void
	 */
	public function wps_rma_woocommerce_order_add_coupon( $item_id, $item, $order_id ) {
		if ( wps_rma_wallet_feature_enable() ) {
			$order_obj = wc_get_order( $order_id );
			if ( ! empty( $order_id ) && ! empty( $order_obj ) ) {
				foreach ( $order_obj->get_coupon_codes() as $coupon_code ) {
					// Get the WC_Coupon object.
					$the_coupon      = new WC_Coupon( $coupon_code );
					$discount_amount = $order_obj->get_discount_total(); // Get coupon amount.
					$coupon_id       = $the_coupon->get_id();
					if ( $coupon_code ) {
						$wrma_coupon = get_post_meta( $coupon_id, 'wrmawallet', true );
						if ( $wrma_coupon ) {
							$amount           = get_post_meta( $coupon_id, 'coupon_amount', true );
							$remaining_amount = $amount - $discount_amount;
							update_post_meta( $coupon_id, 'coupon_amount', $remaining_amount );
							break;
						}
					}
				}
			}
		}
	}

	/**
	 * This function is used to validate the wallet amount in respect to cart total
	 *
	 * @param array $posted .
	 */
	public function wps_rma_woocommerce_after_checkout_validation( $posted ) {
		if ( wps_rma_wallet_feature_enable() ) {
			if ( isset( $posted['payment_method'] ) ) {
				$payment_type = $posted['payment_method'];
				if ( 'wallet_gateway' === $payment_type ) {
					$customer_id = get_current_user_id();
					if ( $customer_id > 0 ) {
						global $woocommerce;
						$carttotal    = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->total ) );
						$walletcoupon = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
						if ( ! empty( $walletcoupon ) ) {
							$the_coupon = new WC_Coupon( $walletcoupon );
							$coupon_id  = $the_coupon->get_id();
							if ( isset( $coupon_id ) ) {
								$amount = get_post_meta( $coupon_id, 'coupon_amount', true );
								if ( $carttotal > $amount ) {
									wc_add_notice( sprintf( __( "Your wallet doesn't have a sufficient amount to place an order. For using Wallet amount use the Coupon Code: %1\$s %2\$s %3\$s", 'woocommerce-rma-for-return-refund-and-exchange' ), '<b>', $walletcoupon, '</b>' ), 'error' );
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Manage wallet payment gateway avaliability .
	 *
	 * @param [type] $payment_gateways .
	 */
	public function wps_rma_woocommerce_available_payment_gateways( $payment_gateways ) {
		if ( wps_rma_wallet_feature_enable() ) {
			$customer_id = get_current_user_id();
			if ( $customer_id > 0 ) {
				$customer_coupon_id = 0;
				$walletcoupon       = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
				if ( ! empty( $walletcoupon ) ) {
					$the_coupon         = new WC_Coupon( $walletcoupon );
					$customer_coupon_id = $the_coupon->get_id();
					if ( isset( $customer_coupon_id ) ) {
						$amount = get_post_meta( $customer_coupon_id, 'coupon_amount', true );
						if ( $amount <= 0 ) {
							if ( isset( $payment_gateways['wallet_gateway'] ) ) {
								unset( $payment_gateways['wallet_gateway'] );
								return $payment_gateways;
							}
						}
					}
					$applied_coupon_ids = array();
					if ( isset( WC()->cart ) && ! empty( WC()->cart ) ) {
						$applied_coupons = WC()->cart->applied_coupons;
						foreach ( $applied_coupons as $applied_coupon ) {
							$the_coupon = new WC_Coupon( $applied_coupon );
							$coupon_id  = $the_coupon->get_id();
							if ( isset( $coupon_id ) ) {
								$applied_coupon_ids[] = $coupon_id;
							}
						}
					}
					if ( in_array( $customer_coupon_id, $applied_coupon_ids ) ) {
						if ( isset( $payment_gateways['wallet_gateway'] ) ) {
							unset( $payment_gateways['wallet_gateway'] );
						}
					}
				} else {
					if ( isset( $payment_gateways['wallet_gateway'] ) ) {
						unset( $payment_gateways['wallet_gateway'] );
					}
				}
			} else {
				if ( isset( $payment_gateways['wallet_gateway'] ) ) {
					unset( $payment_gateways['wallet_gateway'] );
				}
			}
		} else {
			if ( isset( $payment_gateways['wallet_gateway'] ) ) {
				unset( $payment_gateways['wallet_gateway'] );
			}
		}
		return $payment_gateways;
	}

	/** Update the product qty for exchange to products */
	public function wps_rma_update_exchange_to_prod() {
		$check_ajax = check_ajax_referer( 'wps_rma_ajax_security', 'security_check' );
		if ( $check_ajax ) {
			$exchange_details = WC()->session->get( 'exchange_requset' );
			foreach ( $exchange_details as $date => $value ) {
				foreach ( $value['to'] as $key1 => $value1 ) {
					if ( isset( $_POST['id'] ) == $value1['id'] ) {
						$exchange_details[ $date ]['to'][ $key1 ]['qty'] = isset( $_POST['qty'] ) ? sanitize_text_field( wp_unslash( $_POST['qty'] ) ) : '';
						echo wp_json_encode( 'success' );
					}
				}
			}
			WC()->session->set( 'exchange_requset', $exchange_details );

		}
	}
}
