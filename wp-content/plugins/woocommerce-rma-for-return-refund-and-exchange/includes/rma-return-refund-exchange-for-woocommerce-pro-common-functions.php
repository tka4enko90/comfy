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

if ( ! function_exists( 'wps_rma_coupon_generator' ) ) {
	/**
	 * Dynamically Generate Coupon Code
	 *
	 * @param number $length .
	 * @return string
	 */
	function wps_rma_coupon_generator( $length = 10 ) {
		$password    = '';
		$alphabets   = range( 'A', 'Z' );
		$numbers     = range( '0', '9' );
		$final_array = array_merge( $alphabets, $numbers );
		while ( $length-- ) {
			$key       = array_rand( $final_array );
			$password .= $final_array[ $key ];
		}
		$wrma_prefix = get_option( 'wps_rma_wallet_prefix', '' );
		if ( ! empty( $wrma_prefix ) ) {
			$password = $wrma_prefix . $password;
		} else {
			$password = $wrma_prefix . 'wps';
		}
		return $password;
	}
}
if ( ! function_exists( 'wps_rma_wallet_feature_enable' ) ) {
	/** Check if wallet enable */
	function wps_rma_wallet_feature_enable() {
		$enabled        = false;
		$wallet_enabled = get_option( 'wps_rma_wallet_enable', 'no' );
		if ( 'on' === $wallet_enabled ) {
			$enabled = true;
		}
		return $enabled;
	}
}
if ( ! function_exists( 'global_shipping_charges' ) ) {
	/**
	 * Check if global shipping is applicable or not.
	 *
	 * @param string  $order_id .
	 * @param array() $item_ids .
	 */
	function global_shipping_charges( $order_id, $item_ids ) {
		$flag            = false;
		$global_shipping = get_option( 'wps_wrma_shipping_global_data', array() );
		if ( isset( $global_shipping['ship_pro'] ) ) {
			$ship_prod = $global_shipping['ship_pro'];
		}
		if ( isset( $global_shipping['enable'] ) && 'on' === $global_shipping['enable'] && isset( $global_shipping['pro_cb'] ) && 'on' === $global_shipping['pro_cb'] && ! empty( $global_shipping['ship_pro'] ) ) {
			$order_obj = wc_get_order( $order_id );
			foreach ( $order_obj->get_items() as $item_id => $item ) {
				foreach ( $item_ids as $key => $item_id1 ) {
					if ( intval( $item_id1 ) === $item_id ) {
						if ( isset( $ship_prod ) && has_term( $ship_prod, 'product_cat', $item->get_product_id() ) ) {
							$flag = true;
							break;
						}
					}
				}
			}
		} elseif ( isset( $global_shipping['enable'] ) && 'on' === $global_shipping['enable'] ) {
			$flag = true;
		} else {
			$flag = false;
		}
		return $flag;
	}
}
if ( ! function_exists( 'wps_rma_currency_seprator' ) ) {
	/**
	 * This function is used for formatting the price seprator
	 *
	 * @param int $price .
	 * @return price
	 */
	function wps_rma_currency_seprator( $price ) {
		$price = apply_filters( 'formatted_woocommerce_price', number_format( $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() ), $price, wc_get_price_decimals(), wc_get_price_decimal_separator(), wc_get_price_thousand_separator() );
		return $price;
	}
}
if ( ! function_exists( 'wps_rma_exclude_product' ) ) {
	/**
	 * Check if current product is applicable for refund/exchange/cancel.
	 *
	 * @param string $product_id .
	 * @param string $func .
	 */
	function wps_rma_exclude_product( $product_id, $func ) {
		$policies_setting     = get_option( 'policies_setting_option' );
		$get_specific_setting = array();
		if ( isset( $policies_setting['wps_rma_setting'] ) && ! empty( $policies_setting['wps_rma_setting'] ) ) {
			foreach ( $policies_setting['wps_rma_setting'] as $key => $value ) {
				if ( $func === $value['row_functionality'] ) {
					array_push( $get_specific_setting, $value );
				}
			}
		}
		$cat_arr       = '';
		$prod_arr      = '';
		$check_ex_cate = strpos( wp_json_encode( $get_specific_setting ), 'row_ex_cate' ) > 0 ? true : false;
		$check_ex_prod = strpos( wp_json_encode( $get_specific_setting ), 'row_ex_prod' ) > 0 ? true : false;
		if ( $check_ex_cate ) {
			foreach ( $get_specific_setting as $key => $value ) {
				if ( isset( $value['row_ex_cate'] ) ) {
					$cat_arr = $value['row_ex_cate'];
					if ( isset( $value['row_conditions2'] ) ) {
						if ( 'wps_rma_equal_to' === $value['row_conditions2'] ) {
							$flag_condition1 = 'wps_rma_equal_to';
						} elseif ( 'wps_rma_not_equal_to' === $value['row_conditions2'] ) {
							$flag_condition1 = 'wps_rma_not_equal_to';
						}
					}
				}
			}
		}
		if ( $check_ex_prod ) {
			foreach ( $get_specific_setting as $key => $value ) {
				if ( isset( $value['row_ex_prod'] ) ) {
					$prod_arr = $value['row_ex_prod'];
					if ( isset( $value['row_conditions2'] ) ) {
						if ( 'wps_rma_equal_to' === $value['row_conditions2'] ) {
							$flag_condition2 = 'wps_rma_equal_to';
						} elseif ( 'wps_rma_not_equal_to' === $value['row_conditions2'] ) {
							$flag_condition2 = 'wps_rma_not_equal_to';
						}
					}
				}
			}
		}
		$terms_arr = array();
		$terms     = get_the_terms( $product_id, 'product_cat' );
		if ( $terms && ! empty( $terms ) ) {
			foreach ( $terms as $key => $value ) {
				array_push( $terms_arr, $value->term_id );
			}
		}

		$flag = true;
		if ( isset( $cat_arr ) && ! empty( $cat_arr ) ) {
			foreach ( $cat_arr as $key => $cat_id ) {
				if ( isset( $flag_condition1 ) && 'wps_rma_equal_to' === $flag_condition1 ) {
					if ( in_array( $cat_id, $terms_arr ) ) {
						$flag = false;
					}
				} elseif ( isset( $flag_condition1 ) && 'wps_rma_not_equal_to' === $flag_condition1 ) {
					if ( ! in_array( $cat_id, $terms_arr ) ) {
						$flag = false;
					}
				}
			}
		}
		if ( isset( $prod_arr ) && ! empty( $prod_arr ) ) {
			foreach ( $prod_arr as $key => $prod_id ) {
				if ( isset( $flag_condition2 ) && 'wps_rma_equal_to' === $flag_condition2 ) {
					if ( $prod_id == $product_id ) {
						$flag = false;
					}
				} elseif ( isset( $flag_condition2 ) && 'wps_rma_not_equal_to' === $flag_condition2 ) {
					if ( $prod_id != $product_id ) {
						$flag = false;
					}
				}
			}
		}
		return $flag;
	}
}
if ( ! function_exists( 'wps_wrma_submit_exchange_request_callback' ) ) {
	/**
	 * This function is to submit exchange product request.
	 *
	 * @param string $order_id .
	 * @param string $subject .
	 * @param string $reason .
	 * @param string $wps_wrma_refund_method .
	 */
	function wps_wrma_submit_exchange_request_callback( $order_id, $subject, $reason, $wps_wrma_refund_method ) {
		update_post_meta( $order_id, 'wps_wrma_exchange_refund_method', $wps_wrma_refund_method );

		// Save Exchange Request Product.
		$products = array();
		if ( WC()->session && WC()->session->get( 'exchange_requset' ) ) {
			$products = WC()->session->get( 'exchange_requset' );
		} else {
			$products = get_post_meta( $order_id, 'wps_rma_exchange_details', true );
		}
		$pending = true;
		if ( isset( $products ) && ! empty( $products ) ) {
			foreach ( $products as $date => $product ) {
				if ( 'pending' === $product['status'] ) {
					$products[ $date ]['orderid'] = $order_id;
					$products[ $date ]['subject'] = $subject;
					$products[ $date ]['reason']  = $reason;
					$products[ $date ]['status']  = 'pending';
					$pending                      = false;
					break;
				}
			}
		}
		if ( $pending ) {
			$date                         = gmdate( 'd-m-Y' );
			$products                     = array();
			$products[ $date ]['orderid'] = $order_id;
			$products[ $date ]['subject'] = $subject;
			$products[ $date ]['reason']  = $reason;
			$products[ $date ]['status']  = 'pending';
		}

		update_post_meta( $order_id, 'wps_wrma_exchange_product', $products );

		if ( empty( get_post_meta( $order_id, 'wps_rma_request_made', true ) ) ) {
			$item_id = array();
		} else {
			$item_id = get_post_meta( $order_id, 'wps_rma_request_made', true );
		}
		$item_ids = array();
		// Gift Card Code Compatibility.
		$gift_card_product = false;
		$gift_item_id      = '';
		$exp_flag          = false;
		foreach ( $products as $date => $value ) {
			if ( is_array( $value['from'] ) && ! empty( $value['from'] ) ) {
				foreach ( $value['from'] as $item => $value ) {
					$item_id[ $value['item_id'] ] = 'pending';
					$item_ids[]                   = $value['item_id'];

					// Giftcard compatibility code.
					$product_id = $value['product_id'];

					$product_types = wp_get_object_terms( $product_id, 'product_type' );
					if ( isset( $product_types[0] ) ) {
						$product_type = $product_types[0]->slug;
						if ( 'wgm_gift_card' === $product_type || 'gw_gift_card' === $product_type ) {
							$gift_card_product = true;
							$gift_item_id      = $value['item_id'];
						}
					}
				}
			}
		}
		if ( $gift_card_product && ! empty( $gift_item_id ) ) {

			$coupon = get_post_meta( $order_id, $order_id . '#' . $gift_item_id, true );

			$couponcode = $coupon[0];

			$coupons = new WC_Coupon( $couponcode );

			$usage_count = $coupons->usage_count;

			$exp_date = $coupons->get_data();
			if ( isset( $exp_date['date_expires'] ) && ! empty( $exp_date['date_expires'] ) ) {
				$expiry_date   = $exp_date['date_expires']->date( 'd M Y H:i:s' );
				$now_date      = date_i18n( wc_date_format(), time() ) . ' ' . date_i18n( wc_time_format(), time() );
				$todaydatetime = strtotime( $now_date );
				$expdatetime   = strtotime( $expiry_date );
				$diff          = $expdatetime - $todaydatetime;
				if ( $diff < 0 ) {
					$exp_flag = true;
				}
			}

			if ( $exp_flag ) {
				$response['flag'] = false;
				$response['msg']  = esc_html__( 'Your Giftcard has been expired so you can not proceed with the exchange. Thanks', 'woocommerce-rma-for-return-refund-and-exchange' );

				return $response;
			}

			if ( ! empty( $usage_count ) ) {
				$response['flag'] = false;
				$response['msg']  = esc_html__( 'Your Giftcard has been used so you can not proceed with the exchange. Thanks', 'woocommerce-rma-for-return-refund-and-exchange' );

				return $response;
			}
		}
		update_post_meta( $order_id, 'wps_rma_request_made', $item_id );

		$prod   = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
		$sel_pr = 0;
		$ex_pr  = 0;
		if ( isset( $prod ) && ! empty( $prod ) ) {
			foreach ( $prod as $date => $value ) {
				if ( isset( $value['from'] ) && is_array( $value['from'] ) ) {
					foreach ( $value['from'] as $prod1 => $price1 ) {
						if ( isset( $price1['price'] ) ) {
							$sel_pr += $price1['price'];
						}
					}
				}

				if ( isset( $value['to'] ) && is_array( $value['to'] ) ) {

					foreach ( $value['to'] as $prod2 => $price2 ) {
						if ( isset( $price2['price'] ) ) {
							$ex_pr += $price2['price'];
						}
					}
				}
			}
		}
		update_post_meta( $order_id, 'wps_wrma_left_amount', $sel_pr - $ex_pr );
		// Add global shipping if have any.
		$ex_added_fees   = get_option( 'wps_wrma_shipping_global_data', array() );
		$wps_fee_cost    = isset( $ex_added_fees['fee_cost'] ) ? $ex_added_fees['fee_cost'] : array();
		$wps_fee_name    = isset( $ex_added_fees['fee_name'] ) ? $ex_added_fees['fee_name'] : array();
		$global_shipping = global_shipping_charges( $order_id, $item_ids );
		if ( $global_shipping ) {
			$add_fee = array_combine( $wps_fee_name, $wps_fee_cost );
			update_post_meta( $order_id, 'ex_ship_amount', $add_fee );
		}

		$restrict_mail = apply_filters( 'wps_rma_restrict_exchange_request_mails', true );
		if ( $restrict_mail ) {
			do_action( 'wps_rma_exchange_req_email', $order_id );
		}
		$order = new WC_Order( $order_id );
		$order->update_status( 'wc-exchange-request', esc_html__( 'User Request to Exchange Product', 'woocommerce-rma-for-return-refund-and-exchange' ) );
		$order->save();
		if ( WC()->session ) {
			if ( WC()->session->get( 'exchange_requset' ) ) {
				WC()->session->__unset( 'exchange_requset' );
			}
			if ( WC()->session->get( 'wps_wrma_exchange' ) ) {
				WC()->session->__unset( 'wps_wrma_exchange' );
			}
		}
		$response         = array();
		$response['flag'] = true;
		$response['msg']  = esc_html__( 'Exchange request placed successfully. You have received a notification mail regarding this, Please check your mail. Soon You redirect to the My Account Page. Thanks', 'woocommerce-rma-for-return-refund-and-exchange' );
		return $response;
	}
}
if ( ! function_exists( 'wps_exchange_req_approve_callback' ) ) {
	/**
	 * This function is approve exchange request and Create new order for exchnage product and decrease product quantity from order
	 *
	 * @param string $orderid .
	 */
	function wps_exchange_req_approve_callback( $orderid ) {
		$order_detail     = wc_get_order( $orderid );
		$currency         = $order_detail->get_currency();
		$user_id          = $order_detail->user_id;
		$exchange_details = get_post_meta( $orderid, 'wps_wrma_exchange_product', true );
		$order_data       = array(
			'name'        => 'order-' . gmdate( 'M-d-Y-hi-a' ),
			'status'      => 'wc-exchange-approve',
			'customer_id' => $user_id,
		);
		// New Order Object.
		$new_order = wc_create_order( $order_data );
		$new_order->set_currency( $currency );
		$new_order_id = $new_order->get_id();

		$wps_wrma_enable_return_ship_label = get_option( 'wps_wrma_enable_return_ship_label', 'no' );
		if ( 'on' === $wps_wrma_enable_return_ship_label ) {
			$to                           = get_post_meta( $orderid, '_billing_email', true );
			$label_link                   = get_post_meta( $orderid, 'wps_wrma_return_label_link', true );
			$message                      = __( 'Here the Returnship Label Link for Order', 'woocommerce-rma-for-return-refund-and-exchange' ) . '#' . $orderid . ' ' . $label_link;
			$wps_wrma_targetpath_exchange = get_post_meta( $orderid, 'wps_return_label_attachment_exchange_path', true );
			$customer_email               = WC()->mailer()->emails['wps_rma_returnship_email'];
			$customer_email->trigger( $message, $wps_wrma_targetpath_exchange, $to, $new_order_id );
		}

		update_post_meta( $new_order_id, 'wps_wrma_exchange_order', $orderid );

		update_post_meta( $orderid, 'new_order_id', $new_order_id );

		$order_detail->calculate_totals();
		$order_detail->update_status( 'wc-completed' );
		$order = (object) $order_detail->get_address( 'shipping' );

		// Shipping info.

		update_post_meta( $new_order_id, '_customer_user', $user_id );
		update_post_meta( $new_order_id, '_shipping_address_1', $order->address_1 );
		update_post_meta( $new_order_id, '_shipping_address_2', $order->address_2 );
		update_post_meta( $new_order_id, '_shipping_city', $order->city );
		update_post_meta( $new_order_id, '_shipping_state', $order->state );
		update_post_meta( $new_order_id, '_shipping_postcode', $order->postcode );
		update_post_meta( $new_order_id, '_shipping_country', $order->country );
		update_post_meta( $new_order_id, '_shipping_company', $order->company );
		update_post_meta( $new_order_id, '_shipping_first_name', $order->first_name );
		update_post_meta( $new_order_id, '_shipping_last_name', $order->last_name );

		// billing info.

		$order_detail = wc_get_order( $orderid );
		$order_detail->calculate_totals();
		$order = (object) $order_detail->get_address( 'billing' );

		add_post_meta( $new_order_id, '_billing_first_name', $order->first_name, true );
		add_post_meta( $new_order_id, '_billing_last_name', $order->last_name, true );
		add_post_meta( $new_order_id, '_billing_company', $order->company, true );
		add_post_meta( $new_order_id, '_billing_address_1', $order->address_1, true );
		add_post_meta( $new_order_id, '_billing_address_2', $order->address_2, true );
		add_post_meta( $new_order_id, '_billing_city', $order->city, true );
		add_post_meta( $new_order_id, '_billing_state', $order->state, true );
		add_post_meta( $new_order_id, '_billing_postcode', $order->postcode, true );
		add_post_meta( $new_order_id, '_billing_country', $order->country, true );
		add_post_meta( $new_order_id, '_billing_email', $order->email, true );
		add_post_meta( $new_order_id, '_billing_phone', $order->phone, true );

		// $exchanged_products

		$order = wc_get_order( $new_order_id );

		if ( ! $order->get_order_key() ) {
			update_post_meta( $new_order_id, '_order_key', 'wc-' . uniqid( 'order_' ) );
		}
		if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
			foreach ( $exchange_details as $date => $exchange_detail ) {
				$exchanged_products      = $exchange_detail['to'];
				$exchanged_from_products = $exchange_detail['from'];
				if ( 'pending' === $exchange_detail['status'] ) {
					$exchange_details[ $date ]['status']  = 'complete';
					$exchange_details[ $date ]['approve'] = gmdate( 'd-m-Y' );
					break;
				}
			}
		}
		// Add the shipping fee in the new order.
		$wps_fee_cost = get_post_meta( $orderid, 'ex_ship_amount', true );
		if ( ! empty( $wps_fee_cost ) ) {
			foreach ( $wps_fee_cost as $key => $value ) {
					$new_fee = new WC_Order_Item_Fee();
					$new_fee->set_name( esc_attr( $key ) );
					$new_fee->set_total( $value );
					$new_fee->set_tax_class( '' );
					$new_fee->set_tax_status( 'none' );
					$new_fee->save();
					$order->add_item( $new_fee );
			}
		}
		$line_items1 = array();
		$discount    = 0;
		// Reduce the item qty because of exchange item .
		foreach ( $order_detail->get_items() as $item_id => $item ) {
			if ( isset( $exchanged_from_products ) && ! empty( $exchanged_from_products ) ) {
				foreach ( $exchanged_from_products as $k => $product_data ) {
					if ( $item_id == $product_data['item_id'] ) {
						if ( $item['product_id'] == $product_data['product_id'] || $item['variation_id'] == $product_data['variation_id'] ) {
							$discount += $product_data['qty'] * $product_data['price'];
							$product   =
							// Woo Order Item Product.
							apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );

							$line_items1[ $item_id ]['qty']          = $product_data['qty'];
							$line_items1[ $item_id ]['refund_total'] = 0;
							/* translators: %s: product qty */

						}
					}
				}
			}
		}
		// Auto Restock.
		$flag_stock              = false;
		$get_auto_stock_exchange = get_option( 'wps_rma_auto_exchange_stock' );
		if ( 'on' === $get_auto_stock_exchange ) {
			$flag_stock = true;
			update_post_meta( $orderid, 'wps_wrma_manage_stock_for_exchange', 'no' );
		}
		// Add the exchange item info.
		if ( ! empty( $line_items1 ) ) {
			$refund       = wc_create_refund(
				array(
					'amount'         => 0,
					'reason'         => esc_html__( 'Added the Exchanged item info', 'woocommerce-rma-for-return-refund-and-exchange' ),
					'order_id'       => $orderid,
					'line_items'     => $line_items1,
					'refund_payment' => false,
					'restock_items'  => $flag_stock,
				)
			);
			$wps_refund = get_post_meta( $orderid, 'wps_rma_refund_info', true );
			if ( empty( $wps_refund ) ) {
				$wps_refund = array();
			}
			$wps_refund[] = $refund->get_id();
			update_post_meta( $orderid, 'wps_rma_refund_info', $wps_refund );
		}

		// Add the product in new order .
		if ( isset( $exchanged_products ) && ! empty( $exchanged_products ) ) {
			foreach ( $exchanged_products as $exchanged_product ) {
				if ( isset( $exchanged_product['variation_id'] ) ) {
					$product              = wc_get_product( $exchanged_product['variation_id'] );
					$variation_product    = new WC_Product_Variation( $exchanged_product['variation_id'] );
					$variation_attributes = $variation_product->get_variation_attributes();
					if ( isset( $exchanged_product['variations'] ) && ! empty( $exchanged_product['variations'] ) ) {
						$variation_attributes = $exchanged_product['variations'];
					}

					$variation_product_price = wc_get_price_excluding_tax( $variation_product, array( 'qty' => 1 ) );

					$variation_att['variation'] = $variation_attributes;

					$variation_att['totals']['total']    = $exchanged_product['qty'] * $variation_product_price;
					$variation_att['totals']['subtotal'] = $exchanged_product['qty'] * $variation_product_price;

					$order->add_product( $variation_product, $exchanged_product['qty'], $variation_att );

				} else {
					$product = wc_get_product( $exchanged_product['id'] );
					$order->add_product( $product, $exchanged_product['qty'] );
				}
			}
		}

		// Add the discount fee in new order (discount= exchange items price).
		$coupons_amount = 0;
		if ( $discount > 0 ) {
			$wps_wrma_obj          = wc_get_order( $orderid );
			$coupon_discount_check = get_option( 'wps_rma_exchange_deduct_coupon', 'no' );
			if ( 'on' === $coupon_discount_check ) {
				$coupons_amount = $wps_wrma_obj->get_total_discount();
				if ( ! empty( $coupon_discount ) ) {
					$discount = $discount - $coupons_amount;
				}
			}
			$wps_woo_tax_enable_setting = get_option( 'woocommerce_calc_taxes' );
			if ( 'yes' === $wps_woo_tax_enable_setting ) {
				$tax_rate     = 0;
				$country_code = $wps_wrma_obj->get_billing_country();
				$tax          = new WC_Tax();
				$rates        = $tax->find_rates( array( 'country' => $country_code ) );
				foreach ( $rates as $rate ) {
					$tax_rate = $rate['rate'];
				}
				$discount = ( $discount * 100 ) / ( 100 + $tax_rate );
			}
			$new_fee = new WC_Order_Item_Fee();
			$new_fee->set_name( esc_attr( 'Discount' ) );
			$new_fee->set_total( -$discount );
			$new_fee->set_tax_class( '' );
			$new_fee->set_tax_status( 'none' );
			$new_fee->save();
			$order->add_item( $new_fee );
		}

		$order_total = $order->calculate_totals();

		$order->set_total( $order_total, 'total' );

		if ( 0 == $order_total ) {
			$order->update_status( 'wc-processing' );
		}

		// Update the exchange details.
		update_post_meta( $orderid, 'wps_wrma_exchange_product', $exchange_details );

		// Invoice compatibility hook.
		do_action( 'wps_wrma_exchanged_approve_request_after', $new_order_id, $orderid );

		// update the request file status to completed.
		$request_files = get_post_meta( $orderid, 'wps_wrma_exchange_attachment', true );
		if ( isset( $request_files ) && ! empty( $request_files ) ) {
			foreach ( $request_files as $date => $request_file ) {
				if ( 'pending' === $request_file['status'] ) {
					$request_files[ $date ]['status'] = 'complete';
				}
			}
		}
		// update the completed item status to completed.
		$update_item_status = get_post_meta( $orderid, 'wps_rma_request_made', true );
		foreach ( get_post_meta( $orderid, 'wps_wrma_exchange_product', true ) as $key => $value ) {
			foreach ( $value['from'] as $key => $value ) {
				if ( isset( $update_item_status[ $value['item_id'] ] ) ) {
					$update_item_status[ $value['item_id'] ] = 'completed';
				}
			}
		}
		update_post_meta( $orderid, 'wps_rma_request_made', $update_item_status );

		$restrict_mail =
		// Exchange request accept mail.
		apply_filters( 'wps_rma_restrict_exchange_request_accept_mails', true );
		if ( $restrict_mail ) {
			// Exchange request accept mail template.
			do_action( 'wps_rma_exchange_req_accept_email', $new_order_id, $orderid );
		}
		// Update the status.
		update_post_meta( $orderid, 'wps_wrma_exchange_attachment', $request_files );
		$response['response'] = 'success';
		return $response;
	}
}
if ( ! function_exists( 'wps_wrma_exchange_req_cancel_callback' ) ) {
	/**
	 * Exchange cancel callback.
	 *
	 * @param string $orderid .
	 */
	function wps_wrma_exchange_req_cancel_callback( $orderid ) {
		$products = get_post_meta( $orderid, 'wps_wrma_exchange_product', true );

		// Fetch the return request product.
		if ( isset( $products ) && ! empty( $products ) ) {
			foreach ( $products as $date => $product ) {
				if ( 'pending' === $product['status'] ) {
					$products[ $date ]['status']      = 'cancel';
					$approvdate                       = gmdate( 'd-m-Y' );
					$products[ $date ]['cancel_date'] = $approvdate;
					break;
				}
			}
		}

		// Update the status.
		update_post_meta( $orderid, 'wps_wrma_exchange_product', $products );

		$request_files = get_post_meta( $orderid, 'wps_wrma_exchange_attachment', true );
		if ( isset( $request_files ) && ! empty( $request_files ) ) {
			foreach ( $request_files as $date => $request_file ) {
				if ( 'pending' === $request_file['status'] ) {
					$request_files[ $date ]['status'] = 'cancel';
				}
			}
		}

		$restrict_mail =
		// Restrict the cancel request mail.
		apply_filters( 'wps_rma_restrict_exchange_request_cancel_mails', true );
		if ( $restrict_mail ) {
			// Cancel request mail tempate.
			do_action( 'wps_rma_exchange_req_cancel_email', $orderid );
		}

		// Update the status.
		update_post_meta( $orderid, 'wps_wrma_exchange_attachment', $request_files );
		$order = wc_get_order( $orderid );
		$order->update_status( 'wc-exchange-cancel', esc_html__( 'User Request of Exchange Product is Cancelled.', 'woocommerce-rma-for-return-refund-and-exchange' ) );
		$response             = array();
		$response['response'] = 'success';
		return $response;
	}
}
if ( ! function_exists( 'wps_rma_cancel_customer_order_products_callback' ) ) {
	/**
	 * Cancel order's profucts and manage stock of cancelled product.
	 *
	 * @param string  $order_id .
	 * @param array() $item_ids .
	 */
	function wps_rma_cancel_customer_order_products_callback( $order_id, $item_ids ) {
		$the_order    = wc_get_order( $order_id );
		$items        = $the_order->get_items();
		$total_amount = 0;
		foreach ( $items as $item_id => $item ) {
			foreach ( $item_ids as $item_detail ) {
				if ( $item_id == $item_detail[0] ) {
					$product_id           = $item['product_id'];
					$product_variation_id = $item['variation_id'];
					if ( $product_variation_id > 0 ) {
						$product = wc_get_product( $product_variation_id );
					} else {
						$product = wc_get_product( $product_id );
					}
					$total_amount += $item_detail[1] * wc_get_price_to_display( $product );

					$product_quantity = $item_detail[1];

					$product =
					// Woo Order Item Product.
					apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );

					$item['qty'] = $item['qty'] - $item_detail[1];
					$args['qty'] = $item['qty'];
					wc_update_order_item_meta( $item_id, '_qty', $item['qty'] );

					$product = wc_get_product( $product->get_id() );

					if ( $product->backorders_require_notification() && $product->is_on_backorder( $args['qty'] ) ) {
						$item->add_meta_data( apply_filters( 'woocommerce_backordered_item_meta_name', esc_html__( 'Backordered', 'woocommerce-rma-for-return-refund-and-exchange' ) ), $args['qty'] - max( 0, $product->get_stock_quantity() ), true );
					}
					$item_data = $item->get_data();

					$price_excluded_tax = wc_get_price_excluding_tax( $product, array( 'qty' => 1 ) );
					$price_tax_excluded = $item_data['total'] / $item_data['quantity'];

					$args['subtotal'] = $price_excluded_tax * $args['qty'];
					$args['total']    = $price_tax_excluded * $args['qty'];

					$item->set_order_id( $order_id );
					$item->set_props( $args );
					$item->save();

					$product =
					// Woo Order Item Product.
					apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
					if ( $product->managing_stock() ) {
						if ( $product_variation_id > 0 ) {
							$total_stock = get_post_meta( $product_variation_id, '_stock', true );
							$total_stock = $total_stock + $product_quantity;
							wc_update_product_stock( $product_variation_id, $total_stock, 'set' );
						} else {
							$total_stock = get_post_meta( $product_id, '_stock', true );
							$total_stock = $total_stock + $product_quantity;
							wc_update_product_stock( $product_id, $total_stock, 'set' );
						}
					}
				}
			}
		}

		$the_order->calculate_totals();

		if ( wps_rma_wallet_feature_enable() ) {
			$cancelstatusenable = get_option( 'wps_rma_cancel_order_wallet', 'no' );

			if ( 'on' === $cancelstatusenable ) {
				$value       = get_post_meta( $order_id, '_customer_user', true );
				$customer_id = $value ? absint( $value ) : '';
				if ( $customer_id > 0 && 'cod' !== $the_order->get_payment_method() ) {
					$walletcoupon = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
					if ( empty( $walletcoupon ) ) {
						$coupon_code   = wps_rma_coupon_generator( 5 );
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
						update_post_meta( $new_coupon_id, 'wrmawallet', true );
						update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $coupon_code );
						update_post_meta( $new_coupon_id, 'coupon_amount', $total_amount );
					} else {
						$the_coupon = new WC_Coupon( $walletcoupon );
						$coupon_id  = $the_coupon->get_id();
						if ( isset( $coupon_id ) ) {
							$amount           = get_post_meta( $coupon_id, 'coupon_amount', true );
							$remaining_amount = $amount + $total_amount;
							update_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', $walletcoupon );
							update_post_meta( $coupon_id, 'wrmawallet', true );
							update_post_meta( $coupon_id, 'coupon_amount', $remaining_amount );
						}
					}
				}
			}
		}
		$the_order->update_status( 'wc-partial-cancel', esc_html__( 'User has cancelled some product of order.', 'woocommerce-rma-for-return-refund-and-exchange' ) );

		$restrict_mail = apply_filters( 'wps_rma_restrict_cancel_prod_mails', true );
		if ( $restrict_mail ) {
			do_action( 'wps_rma_cancel_prod_email', $order_id, $item_ids );
		}
		$endpoints = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );

		$url  = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		$url .= "$endpoints";
		return $url;
	}
}
if ( ! function_exists( 'wps_rma_cancel_customer_order_callback' ) ) {
	/**
	 * Cancel whole order and manage stock of cancelled product.
	 *
	 * @param string $order_id .
	 */
	function wps_rma_cancel_customer_order_callback( $order_id ) {
		$the_order = wc_get_order( $order_id );
		$items     = $the_order->get_items();
		foreach ( $items as $item ) {
			if ( WC()->version < '3.0.0' ) {
				$product_quantity = $item['qty'];
			} else {
				$product_quantity = $item['quantity'];
			}
			$product_id           = $item['product_id'];
			$product_variation_id = $item['variation_id'];
			$product              =
			// Woo Order Item Product.
			apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
			if ( $product->managing_stock() ) {
				if ( WC()->version < '3.0.0' ) {
					$product->set_stock( $product_quantity, 'add' );
				} else {
					if ( $product_variation_id > 0 ) {
						$total_stock = get_post_meta( $product_variation_id, '_stock', true );
						$total_stock = $total_stock + $product_quantity;
						wc_update_product_stock( $product_variation_id, $total_stock, 'set' );
					} else {
						$total_stock = get_post_meta( $product_id, '_stock', true );
						$total_stock = $total_stock + $product_quantity;
						wc_update_product_stock( $product_id, $total_stock, 'set' );
					}
				}
			}
		}
		$restrict_mail = apply_filters( 'wps_rma_restrict_cancel_order_mails', true );
		if ( $restrict_mail ) {
			do_action( 'wps_rma_cancel_order_email', $order_id );
		}
		$the_order->update_status( 'wc-cancelled', esc_html__( 'An order cancelled by a customer.', 'woocommerce-rma-for-return-refund-and-exchange' ) );
		do_action( 'wps_cancel_order_total_to_wallet', $order_id, $the_order->get_status() );
		$endpoints = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
		$url       = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		$url      .= $endpoints;
		return $url;
	}
}
if ( ! function_exists( 'wps_rma_license_activate' ) ) {
	/**
	 * Function to activate the license .
	 *
	 * @param string $wps_mwr_purchase_code .
	 */
	function wps_rma_license_activate( $wps_mwr_purchase_code ) {
		$server_name = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
		$api_params  = array(
			'slm_action'         => 'slm_activate',
			'secret_key'         => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY,
			'license_key'        => $wps_mwr_purchase_code,
			'_registered_domain' => is_multisite() ? site_url() : $server_name,
			'item_reference'     => urlencode( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE ),
			'product_reference'  => 'WPSPK-67570',
		);

		$query = esc_url_raw( add_query_arg( $api_params, RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL ) );

		$wps_mwr_response = wp_remote_get(
			$query,
			array(
				'timeout'   => 20,
				'sslverify' => false,
			)
		);

		if ( is_wp_error( $wps_mwr_response ) ) {
			return array(
				'status' => false,
				'msg'    => esc_html__(
					'An unexpected error occurred. Please try again.',
					'rma-return-refund-exchange-for-woocommerce-pro'
				),
			);
		} else {
			$wps_mwr_license_data = json_decode( wp_remote_retrieve_body( $wps_mwr_response ) );

			if ( isset( $wps_mwr_license_data->result ) && 'success' === $wps_mwr_license_data->result ) {
				update_option( 'wps_mwr_license_key', $wps_mwr_purchase_code );
				update_option( 'wps_mwr_license_check', true );

				return array(
					'status' => true,
					'msg'    => esc_html__(
						'Successfully Verified. Please Wait.',
						'rma-return-refund-exchange-for-woocommerce-pro'
					),
				);
			} else {
				return array(
					'status' => false,
					'msg'    => $wps_mwr_license_data->message,
				);
			}
		}
	}
}
if ( ! function_exists( 'wps_rma_pro_migrate_settings' ) ) {
	/**
	 * Function to migrate the settings old plugin into new renovation plugin
	 */
	function wps_rma_pro_migrate_settings() {
		$policies_setting = get_option( 'policies_setting_option', array() );
		if ( empty( $policies_setting ) ) {
			$policies_setting = array( 'wps_rma_setting' => array() );
		}
		// Refund Setting Migrate Start.
		$enable_sale = get_option( 'mwb_wrma_return_sale_enable', false );
		if ( 'yes' === $enable_sale ) {
			update_option( 'wps_rma_refund_on_sale', 'on' );
		}
		$deduct_coupon = get_option( 'mwb_wrma_return_deduct_coupon_amount_enable', false );
		if ( 'yes' === $deduct_coupon ) {
			update_option( 'wps_rma_refund_deduct_coupon', 'on' );
		}
		$auto_refund = get_option( 'mwb_wrma_return_autoaccept_enable', false );
		if ( 'yes' === $auto_refund ) {
			update_option( 'wps_rma_refund_auto', 'on' );
		}
		$refund_note_enable = get_option( 'mwb_wrma_return_note_enable', false );
		if ( 'yes' === $refund_note_enable ) {
			update_option( 'wps_rma_refund_note', 'on' );
		}
		$refund_note_text = get_option( 'mwb_wrma_return_note_message', false );
		if ( ! empty( $refund_note_text ) ) {
			update_option( 'wps_rma_refund_note_text', $refund_note_text );
		}
		$block_mail = get_option( 'mwb_wrma_return_restrict_customer_mails', false );
		if ( 'yes' === $block_mail ) {
			update_option( 'wps_rma_block_refund_req_email', 'on' );
		}
		$auto_restock = get_option( 'mwb_wrma_return_request_auto_stock', false );
		if ( 'yes' === $auto_restock ) {
			update_option( 'wps_rma_auto_refund_stock', 'on' );
		}
		$refund_reason_placeholder = get_option( 'mwb_wrma_return_placeholder_text', false );
		if ( 'yes' === $refund_reason_placeholder ) {
			update_option( 'wps_rma_refund_reason_placeholder', 'on' );
		}
		$shipping_desc = get_option( 'mwb_wrma_refund_shipping_fee_desc', false );
		if ( ! empty( $shipping_desc ) ) {
			update_option( 'wps_rma_refund_shipping_descr', $shipping_desc );
		}
		$wrapper_class = get_option( 'mwb_wrma_return_exchange_class', false );
		if ( ! empty( $wrapper_class ) ) {
			update_option( 'wps_wrma_refund_form_wrapper_class', $wrapper_class );
		}
		$css = get_option( 'mwb_wrma_return_custom_css', false );
		if ( ! empty( $css ) ) {
			update_option( 'wps_rma_refund_form_css', $css );
		}

		$refund_exclude_cate = get_option( 'mwb_wrma_return_ex_cats', false );
		if ( ! empty( $refund_exclude_cate ) ) {
			$ex_cate = array(
				'row_policy'           => 'wps_rma_exclude_via_categories',
				'row_functionality'    => 'refund',
				'row_conditions2'      => 'wps_rma_equal_to',
				'incase_functionality' => 'incase',
				'row_ex_cate'          => $refund_exclude_cate,
			);
			array_push( $policies_setting['wps_rma_setting'], $ex_cate );
		}
		$refund_minimum = get_option( 'mwb_wrma_return_minimum_amount', false );
		if ( ! empty( $refund_minimum ) ) {
			$min = array(
				'row_policy'        => 'wps_rma_min_order',
				'row_functionality' => 'refund',
				'row_conditions1'   => 'wps_rma_less_than',
				'row_value'         => $refund_minimum,
			);
			array_push( $policies_setting['wps_rma_setting'], $min );
		}
		$enable_tax = get_option( 'mwb_wrma_return_tax_enable', false );
		if ( 'yes' === $enable_tax ) {
			$min = array(
				'row_policy'           => 'wps_rma_tax_handling',
				'row_functionality'    => 'refund',
				'row_conditions2'      => 'wps_rma_equal_to',
				'row_tax'              => 'wps_rma_inlcude_tax',
				'incase_functionality' => 'incase',
			);
			array_push( $policies_setting['wps_rma_setting'], $min );
		}
		// Refund Setting Migrate end.

		// Exchange Setting Migrate start.
		$enable_exchange = get_option( 'mwb_wrma_exchange_enable', false );
		if ( 'yes' === $enable_exchange ) {
			update_option( 'wps_rma_exchange_enable', 'on' );
		}
		$manage_stock = get_option( 'mwb_wrma_exchange_request_manage_stock', false );
		if ( 'yes' === $manage_stock ) {
			update_option( 'wps_rma_exchange_manage_stock', 'on' );
		}
		$same_vari = get_option( 'mwb_wrma_exchange_variation_enable', false );
		if ( 'yes' === $same_vari ) {
			update_option( 'wps_rma_exchange_same_product', 'on' );
		}
		$enable_attach = get_option( 'mwb_wrma_exchange_attach_enable', false );
		if ( 'yes' === $enable_attach ) {
			update_option( 'wps_rma_exchange_attachment', 'on' );
		}
		$attach_limit = get_option( 'mwb_wrma_exchange_attachment_limit', false );
		if ( ! empty( $attach_limit ) ) {
			update_option( 'wps_rma_exchange_attachment_limit', $attach_limit );
		}
		$sale_item = get_option( 'mwb_wrma_exchange_sale_enable', false );
		if ( 'yes' === $sale_item ) {
			update_option( 'wps_rma_exchange_on_sale', 'on' );
		}
		$deduct_coupon = get_option( 'mwb_wrma_exchange_deduct_coupon_amount_enable', false );
		if ( 'yes' === $deduct_coupon ) {
			update_option( 'wps_rma_exchange_deduct_coupon', 'on' );
		}
		$exchange_note_enable = get_option( 'mwb_wrma_exchange_note_enable', false );
		if ( 'yes' === $exchange_note_enable ) {
			update_option( 'wps_rma_exchange_note', 'on' );
		}
		$exchange_note = get_option( 'mwb_wrma_exchange_note_message', false );
		if ( ! empty( $exchange_note ) ) {
			update_option( 'wps_rma_exchange_note_text', $exchange_note );
		}
		$block_email = get_option( 'mwb_wrma_exchange_restrict_customer_mails', false );
		if ( 'yes' === $block_email ) {
			update_option( 'wps_rma_block_exchange_req_email', 'on' );
		}
		$auto_restock = get_option( 'mwb_wrma_exchange_request_auto_stock', false );
		if ( 'yes' === $block_email ) {
			update_option( 'wps_rma_auto_exchange_stock', 'on' );
		}
		$remove_cart_button = get_option( 'mwb_wrma_add_to_cart_enable', false );
		if ( 'yes' === $remove_cart_button ) {
			update_option( 'wps_rma_remove_add_to_cart', 'on' );
		}
		$exchange_button_text = get_option( 'mwb_wrma_exchange_button_text', false );
		if ( ! empty( $exchange_button_text ) ) {
			update_option( 'wps_rma_exchange_button_text', $exchange_button_text );
		}
		$exchange_desc = get_option( 'mwb_wrma_exchange_request_description', false );
		if ( 'yes' === $exchange_desc ) {
			update_option( 'wps_rma_exchange_description', 'on' );
		}
		$exchange_pre_reasons = get_option( 'mwb_wrma_exchange_predefined_reason', false );
		if ( ! empty( $exchange_pre_reasons ) ) {
			$exchange_pre_reasons = implode( ',', $exchange_pre_reasons );
			update_option( 'wps_rma_exchange_reasons', $exchange_pre_reasons );
		}
		$exchange_rule_enable = get_option( 'mwb_wrma_exchange_rules_editor_enable', false );
		if ( 'yes' === $exchange_rule_enable ) {
			update_option( 'wps_rma_exchange_rules', 'on' );
		}
		$exchange_rule = get_option( 'mwb_wrma_exchange_request_rules_editor', false );
		if ( ! empty( $exchange_rule ) ) {
			update_option( 'wps_rma_exchange_rules_editor', $exchange_rule );
		}
		$exchange_reason_placeholder = get_option( 'mwb_wrma_exchange_placeholder_text', false );
		if ( ! empty( $exchange_reason_placeholder ) ) {
			update_option( 'wps_rma_exchange_reason_placeholder', $exchange_reason_placeholder );
		}
		$exchange_shippin_desc = get_option( 'mwb_wrma_exchange_shipping_fee_desc', false );
		if ( ! empty( $exchange_shippin_desc ) ) {
			update_option( 'wps_rma_exchange_shipping_descr', $exchange_shippin_desc );
		}
		$variation_text = get_option( 'mwb_wrma_exchnage_with_same_product_text', false );
		if ( ! empty( $variation_text ) ) {
			update_option( 'wps_rma_exchange_same_product_text', $variation_text );
		}
		$exchange_wrapper_class = get_option( 'mwb_wrma_return_exchange_class', false );
		if ( ! empty( $exchange_wrapper_class ) ) {
			update_option( 'wps_wrma_exchange_form_wrapper_class', $exchange_wrapper_class );
		}
		$exchange_css = get_option( 'mwb_wrma_exchange_custom_css', false );
		if ( ! empty( $exchange_css ) ) {
			update_option( 'wps_rma_exchange_form_css', $exchange_css );
		}
		$hide_pages = get_option( 'mwb_wrma_exchange_button_view', false );
		if ( ! empty( $hide_pages ) ) {
			$button_hide = array();
			if ( ! in_array( 'order-page', $hide_pages ) ) {
				$button_hide[] = 'order-page';
			}
			if ( ! in_array( 'My account', $hide_pages ) ) {
				$button_hide[] = 'My account';
			}
			if ( ! in_array( 'thank-you-page', $hide_pages ) ) {
				$button_hide[] = 'Checkout';
			}
			update_option( 'wps_rma_exchange_button_pages', $button_hide );
		}
		$exchange_exclude_cate = get_option( 'mwb_wrma_exchange_ex_cats', false );
		if ( ! empty( $exchange_exclude_cate ) ) {
			$cat_array = array(
				'row_policy'           => 'wps_rma_exclude_via_categories',
				'row_functionality'    => 'exchange',
				'row_conditions2'      => 'wps_rma_equal_to',
				'incase_functionality' => 'incase',
				'row_ex_cate'          => $exchange_exclude_cate,
			);
			array_push( $policies_setting['wps_rma_setting'], $cat_array );
		}
		$exchange_days = get_option( 'mwb_wrma_exchange_days', false );
		if ( ! empty( $exchange_days ) ) {
			$days = array(
				'row_policy'           => 'wps_rma_maximum_days',
				'row_functionality'    => 'exchange',
				'row_conditions1'      => 'wps_rma_less_than',
				'row_value'            => $exchange_days,
				'incase_functionality' => 'incase',
			);
			array_push( $policies_setting['wps_rma_setting'], $days );
		}
		$exchange_status = get_option( 'mwb_wrma_exchange_order_status', false );
		if ( ! empty( $exchange_status ) ) {
			$statuss = array(
				'row_policy'           => 'wps_rma_order_status',
				'row_functionality'    => 'exchange',
				'row_conditions2'      => 'wps_rma_equal_to',
				'incase_functionality' => 'incase',
				'row_statuses'         => $exchange_status,
			);
			array_push( $policies_setting['wps_rma_setting'], $statuss );
		}
		$exchange_minimum = get_option( 'mwb_wrma_exchange_minimum_amount', false );
		if ( ! empty( $exchange_minimum ) ) {
			$min = array(
				'row_policy'           => 'wps_rma_min_order',
				'row_functionality'    => 'exchange',
				'row_conditions1'      => 'wps_rma_less_than',
				'row_value'            => $exchange_minimum,
				'incase_functionality' => 'incase',
			);
			array_push( $policies_setting['wps_rma_setting'], $min );
		}
		$enable_tax = get_option( 'mwb_wrma_exchange_tax_enable', false );
		if ( 'yes' === $enable_tax ) {
			$min = array(
				'row_policy'           => 'wps_rma_tax_handling',
				'row_functionality'    => 'exchange',
				'row_conditions2'      => 'wps_rma_equal_to',
				'row_tax'              => 'wps_rma_inlcude_tax',
				'incase_functionality' => 'incase',
			);
			array_push( $policies_setting['wps_rma_setting'], $min );
		}
		// Exchange Setting Migrate end.

		// Cancel Setting Migrate start.
		$enable_cancel = get_option( 'mwb_wrma_cancel_enable', false );
		if ( 'yes' === $enable_cancel ) {
			update_option( 'wps_rma_cancel_enable', 'on' );
		}
		$enable_product_cancel = get_option( 'mwb_wrma_cancel_order_product_enable', false );
		if ( 'yes' === $enable_product_cancel ) {
			update_option( 'wps_rma_cancel_product', 'on' );
		}
		$cancel_order_text = get_option( 'mwb_wrma_order_cancel_text', false );
		if ( ! empty( $cancel_order_text ) ) {
			update_option( 'wps_rma_cancel_button_text', $cancel_order_text );
		}
		$cancel_product_text = get_option( 'mwb_wrma_product_cancel_text', false );
		if ( ! empty( $cancel_product_text ) ) {
			update_option( 'wps_rma_cancel_prod_button_text', $cancel_product_text );
		}
		$hide_pages = get_option( 'mwb_wrma_cancel_button_view', false );
		if ( ! empty( $hide_pages ) ) {
			$button_hide = array();
			if ( ! in_array( 'order-page', $hide_pages ) ) {
				$button_hide[] = 'order-page';
			}
			if ( ! in_array( 'My account', $hide_pages ) ) {
				$button_hide[] = 'My account';
			}
			if ( ! in_array( 'thank-you-page', $hide_pages ) ) {
				$button_hide[] = 'Checkout';
			}
			update_option( 'wps_rma_cancel_button_pages', $button_hide );
		}

		if ( 'yes' === $enable_cancel ) {
			$days = array(
				'row_policy'           => 'wps_rma_maximum_days',
				'row_functionality'    => 'cancel',
				'row_conditions1'      => 'wps_rma_less_than',
				'row_value'            => 30,
				'incase_functionality' => 'incase',
			);
			array_push( $policies_setting['wps_rma_setting'], $days );
		}
		$cancel_status = get_option( 'mwb_wrma_cancel_order_status', false );
		if ( ! empty( $cancel_status ) ) {
			$statuss = array(
				'row_policy'           => 'wps_rma_order_status',
				'row_functionality'    => 'cancel',
				'row_conditions2'      => 'wps_rma_equal_to',
				'incase_functionality' => 'incase',
				'row_statuses'         => $exchange_status,
			);
			array_push( $policies_setting['wps_rma_setting'], $statuss );
		}
		$cancel_minimum = get_option( 'mwb_wrma_cancel_minimum_amount', false );
		if ( ! empty( $cancel_minimum ) ) {
			$min = array(
				'row_policy'           => 'wps_rma_min_order',
				'row_functionality'    => 'cancel',
				'row_conditions1'      => 'wps_rma_less_than',
				'row_value'            => $cancel_minimum,
				'incase_functionality' => 'incase',
			);
			array_push( $policies_setting['wps_rma_setting'], $min );
		}
		// Cancel Setting Migrate end.

		// Order Message Setting Migrate start.
		$block_email = get_option( 'mwb_wrma_order_message_emails', false );
		if ( 'yes' === $block_email ) {
			update_option( 'wps_rma_order_email', 'on' );
		}
		// Order Message Setting Migrate end.

		// Wallet Setting start.
		$enable_wallet = get_option( 'mwb_wrma_return_wallet_enable', false );
		if ( 'yes' === $enable_wallet ) {
			update_option( 'wps_rma_wallet_enable', 'on' );
		}
		$enable_plugin_wallet = get_option( 'mwb_wrma_enable_wallet_plugin_system', false );
		if ( 'yes' === $enable_plugin_wallet ) {
			update_option( 'wps_rma_wallet_plugin', 'on' );
		}
		$ref_method = get_option( 'mwb_wrma_select_refund_method_enable', false );
		if ( 'yes' === $ref_method ) {
			update_option( 'wps_rma_refund_method', 'on' );
		}
		$cancel_order_amu = get_option( 'mwb_wrma_return_wallet_cancelled', false );
		if ( 'yes' === $cancel_order_amu ) {
			update_option( 'wps_rma_cancel_order_wallet', 'on' );
		}
		$wallet_pre = get_option( 'mwb_wrma_return_coupon_prefeix', false );
		if ( ! empty( $wallet_pre ) ) {
			update_option( 'wps_rma_wallet_prefix', $wallet_pre );
		}
		// Wallet Setting end.

		// General Setting Migrate start.
		$single_ref_ex = get_option( 'mwb_wrma_return_exchange_enable', false );
		if ( 'yes' === $single_ref_ex ) {
			update_option( 'wps_rma_single_refund_exchange', 'on' );
		}
		$ref_ex_on_ex_app = get_option( 'mwb_wrma_exchange_approved_enable', false );
		if ( 'yes' === $ref_ex_on_ex_app ) {
			update_option( 'wps_rma_exchange_app_check', 'on' );
		}
		$show_sidebar = get_option( 'mwb_wrma_show_sidebar_on_form', false );
		if ( 'yes' === $show_sidebar ) {
			update_option( 'wps_rma_show_sidebar', 'on' );
		}
		$hide_button_for_cod = get_option( 'mwb_wrma_cod_button_view', false );
		if ( 'yes' === $hide_button_for_cod ) {
			update_option( 'wps_rma_hide_rec', 'on' );
		}
		$guest_phone = get_option( 'mwb_wrma_return_exchange_phone_enable', false );
		if ( 'yes' === $guest_phone ) {
			update_option( 'wps_rma_guest_phone', 'on' );
		}
		$order_status_days = get_option( 'mwb_wrma_func_start_date', false );
		if ( ! empty( $order_status_days ) ) {
			update_option( 'wps_rma_order_status_start', $order_status_days );
		}
		// General Setting Migrate end.

		// Exhcnage Email Setting Migrate start.
		// Exhcnage Request Subject And Content Updation.
		$subject = get_option( 'mwb_notification_exchange_subject', false );
		$content = get_option( 'mwb_notification_exchange_rcv', false );
		$content = str_replace( '[', '{', $content );
		$content = str_replace( ']', '}', $content );
		// Setting.
		$exchange_request_add = array(
			'enabled'            => 'yes',
			'subject'            => $subject,
			'heading'            => '',
			'additional_content' => $content,
			'email_type'         => 'html',
		);
		update_option( 'woocommerce_wps_rma_exchange_request_email_settings', $exchange_request_add );

		// Exhcnage Request Accept Subject And Content Updation.
		$subject = get_option( 'mwb_wrma_notification_exchange_approve_subject', false );
		$content = get_option( 'mwb_wrma_notification_exchange_approve', false );
		$content = str_replace( '[', '{', $content );
		$content = str_replace( ']', '}', $content );
		// Setting.
		$exchange_request_accept_add = array(
			'enabled'            => 'yes',
			'subject'            => $subject,
			'heading'            => '',
			'additional_content' => $content,
			'email_type'         => 'html',
		);
		update_option( 'woocommerce_wps_rma_exchange_request_accept_email_settings', $exchange_request_accept_add );

		// Exhcnage Request Cancel Subject And Content Updation.

		$subject = get_option( 'mwb_wrma_notification_exchange_cancel_subject', false );
		$content = get_option( 'mwb_wrma_notification_exchange_cancel', false );
		$content = str_replace( '[', '{', $content );
		$content = str_replace( ']', '}', $content );
		// Setting.
		$exchange_request_cancel_add = array(
			'enabled'            => 'yes',
			'subject'            => $subject,
			'heading'            => '',
			'additional_content' => $content,
			'email_type'         => 'html',
		);
		update_option( 'woocommerce_wps_rma_exchange_request_cancel_email_settings', $exchange_request_cancel_add );
		// Exchange Email Setting Migrate end.

		// Returnship EMAIL.
		$subject = get_option( 'mwb_wrma_return_slip_mail_subject', false );
		$content = get_option( 'mwb_wrma_return_ship_template', false );
		$content = str_replace( '[', '{', $content );
		$content = str_replace( ']', '}', $content );
		// Setting.
		$returnship_add = array(
			'enabled'            => 'yes',
			'subject'            => $subject,
			'heading'            => '',
			'additional_content' => $content,
			'email_type'         => 'html',
		);
		update_option( 'woocommerce_wps_rma_returnship_email_settings', $returnship_add );

		// License Code Migrate.
		$license_check = get_option( 'mwb_wrma_license_status' );
		$license_key = get_option( 'mwb_wrma_license_key' );

		if ( $license_check ) {
			update_option( 'wps_mwr_license_check', $license_check );
		}
		if ( $license_key ) {
			update_option( 'wps_mwr_license_key', $license_key );
		}
		update_option( 'policies_setting_option', $policies_setting );

		$global_shipping = get_option( 'mwb_wrma_shipping_global_data', '' );
		if ( ! empty( $global_shipping ) ) {
			update_option( 'wps_wrma_shipping_global_data', $global_shipping );
		}
	}
}
// Wallet Plugin System Org Migration code.
if ( ! function_exists( 'wps_migrate_user_amount_into_wallet_plugin' ) ) {
	/** Migrate the wallet amount */
	function wps_migrate_user_amount_into_wallet_plugin() {
		$enable              = get_option( 'wps_rma_wallet_plugin', 'no' );
		$wallet_enable       = get_option( 'wps_rma_wallet_enable', 'no' );
		$check_plugin_active = in_array(
			'wallet-system-for-woocommerce/wallet-system-for-woocommerce.php',
			// Active Plugins.
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		);
		if ( 'on' === $wallet_enable && 'on' === $enable && $check_plugin_active ) {
			$args          = array(
				'fields' => 'ids',
			);
			$all_users_ids = get_users( $args );
			if ( ! empty( $all_users_ids ) ) {
				foreach ( $all_users_ids as $key => $id ) {
					$walletcoupon = get_user_meta( $id, 'wps_wrma_refund_wallet_coupon', true );
					$the_coupon   = new WC_Coupon( $walletcoupon );
					$coupon_id    = $the_coupon->get_id();
					$the_coupon->set_amount( 0 );
					// Get Wallet Amount From RMA Wallet Amount.
					$amount = get_post_meta( $coupon_id, 'coupon_amount', true );
					if ( ! empty( $amount ) && $amount > 0 ) {
						// Get Wallet for WooCommerce's user's Wallet Amount.
						$wallet_amount = get_user_meta( $id, 'wps_wallet', true );
						if ( empty( $wallet_amount ) ) {
							$wallet_amount = 0;
						}
						update_user_meta( $id, 'wps_wallet', $wallet_amount + $amount );
						include_once WP_PLUGIN_DIR . 'wallet-system-for-woocommerce/includes/class-wallet-system-for-woocommerce.php';
						$wallet_payment_gateway              = new Wallet_System_For_Woocommerce();
						$transactiondata                     = array();
						$transactiondata['user_id']          = $id;
						$transactiondata['amount']           = $amount;
						$transactiondata['currency']         = get_woocommerce_currency();
						$transactiondata['transaction_type'] = __( 'RMA wallet Amount', 'woocommerce-rma-for-return-refund-and-exchange' );
						$transactiondata['payment_method']   = esc_html__( 'Migrated RMA Amount', 'woocommerce-rma-for-return-refund-and-exchange' );
						$transactiondata['transaction_id']   = '';
						$transactiondata['note']             = '';
						$trans_id                            = $wallet_payment_gateway->insert_transaction_data_in_table( $transactiondata );
						// Reset RMA wallet amount to zero bc it is transferred to Wallet for WooCommerce Plugin.
						update_post_meta( $coupon_id, 'coupon_amount', 0 );
					}
				}
				update_option( 'migration_successful', true );
			}
		}
	}
	// Mirgate the wallet amount.
	add_action( 'woocommerce_init', 'wps_migrate_user_amount_into_wallet_plugin' );
}
if ( ! function_exists( 'wps_rma_pro_wp_option_migrate' ) ) {
	/** Wp Option Data Migrate */
	function wps_rma_pro_wp_option_migrate() {
		$wps_wrma_ss_carrier_index = get_option( 'mwb_wrma_ss_carrier_index', 0 );
		$wps_wrma_carrier_index   = get_option( 'mwb_wrma_carrier_index', 0 );
		// option key migration.
		$wp_options = array(
			'mwb_wrma_shipping_global_data',
			'mwb_wrma_enable_return_ship_label',
			'mwb_wrma_enable_return_ship_station_label',
			'mwb_wrma_enable_ss_return_ship_station_label',
			'mwb_wrma_connected_ship_station_account',
			'mwb_wrma_validated_ship_station_api_key',
			'mwb_wrma_selected_ss_service_code' . $wps_wrma_ss_carrier_index,
			'mwb_wrma_ship_saved_carriers',
			'mwb_wrma_saved_carriers',
			'mwb_wrma_selected_service_code' . $wps_wrma_carrier_index,
			'mwb_wrma_ship_station_weight',
			'mwb_wrma_ship_station_dimension',
			'mwb_wrma_ship_station_name',
			'mwb_wrma_ship_station_comp_name',
			'mwb_wrma_ship_station_addr1',
			'mwb_wrma_ship_station_city',
			'mwb_wrma_ship_station_postcode',
			'mwb_wrma_ship_station_country',
			'mwb_wrma_ship_station_state',
			'mwb_wrma_ship_station_phone',
			'  mwb_wrma_validated_real_ship_station_api_key  ',
			'  mwb_wrma_validated_real_ship_station_secret_key  ',
			'mwb_wrma_selected_ss_carrier_id' . $wps_wrma_ss_carrier_index,
			'mwb_wrma_selected_ss_service_code' . $wps_wrma_ss_carrier_index,
			'mwb_wrma_selected_carrier_id',
			'mwb_wrma_selected_ss_carrier_id',
		);

		foreach ( $wp_options as $key => $value ) {
			$new_key   = str_replace( 'mwb_', 'wps_', $value );
			$new_value = get_option( $value );
			if ( ! empty( $new_value ) ) {
				update_option( $new_key, $new_value );
			}
		}

		$wp_options = array(
			'mwb_wrma_ss_carrier_index',
			'mwb_wrma_carrier_index',
		);

		foreach ( $wp_options as $key => $value ) {
			$new_key   = str_replace( 'mwb_', 'wps_', $value );
			$new_value = get_option( $value );
			if ( ! empty( $new_value ) ) {
				update_option( $new_key, $new_value );
			}
		}

	}
}
if ( ! function_exists( 'wps_rma_pro_shortcode_migrate' ) ) {
	/** UserMeta Data Migrate */
	function wps_rma_pro_shortcode_migrate() {
		$all_page_ids = get_posts(
			array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'fields'         => 'ids',
			)
		);
		foreach ( $all_page_ids as $id ) {
			$post = get_post( $id );
			$content = $post->post_content;
			$content = str_replace( 'mwb_wrma_customer_wallet', 'Wps_Rma_Customer_Wallet', $content );
			$content = str_replace( 'mwb_wrma_refund_ex_form', 'Wps_Rma_Guest_Form', $content );
			$my_post = array(
				'ID'           => $id,
				'post_content' => $content,
			);
			wp_update_post( $my_post );
		}

		$sidebar_content = get_option( 'widget_block', array() );
		$array           = array_map(
			function( $str ) {
				if ( $str['content'] ) {
					$content        = str_replace( 'mwb_wrma_customer_wallet', 'Wps_Rma_Customer_Wallet', $str['content'] );
					$str['content'] = $content;
				}
				return $str;
			},
			$sidebar_content
		);
		update_option( 'widget_block', $array );
	}
}


/**
 * Checking if plugin is already installed.
 *
 * @param string $slug string containing the plugin slug.
 * @return boolean
 */
function wps_rma_get_plugin_version( $slug ) {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$all_plugins = get_plugins();
	if ( ! empty( $all_plugins[ $slug ] ) ) {
		return $all_plugins[ $slug ]['Version'];
	} else {
		return false;
	}
}
/**
 * Install plugin.
 *
 * @param string $plugin_zip url for the plugin zip file at WordPress.
 * @return boolean
 */
function wps_rma_install_plugin( $plugin_zip ) {
	include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	wp_cache_flush();
	$upgrader  = new Plugin_Upgrader();
	$installed = $upgrader->install( $plugin_zip );
	return $installed;
}

