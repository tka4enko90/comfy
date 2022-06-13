<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Hydroshop_Api_Management
	 * @subpackage Hydroshop_Api_Management/includes
	 * @author     WP Swings <wpswings.com>
	 */
	class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Api_Process {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   object $mwr_request  data of requesting headers and other information.
		 * @return  Array $wps_rma_rest_response    returns processed data and status of operations.
		 */
		public function wps_rma_exchange_request_process( $mwr_request ) {
			$data                  = $mwr_request->get_params();
			$order_id              = isset( $data['order_id'] ) ? absint( $data['order_id'] ) : 0;
			$products              = isset( $data['products'] ) ? $data['products'] : '';
			$reason                = isset( $data['reason'] ) ? $data['reason'] : '';
			$refund_method         = isset( $data['refund_method'] ) ? $data['refund_method'] : '';
			$wps_rma_rest_response = array();
			$order_obj             = wc_get_order( $order_id );
			if ( ! empty( $order_id ) && ! empty( $order_obj ) && ! empty( $reason ) && ! empty( $products ) ) {
				$check_exchange = wps_rma_show_buttons( 'exchange', $order_obj );
				if ( 'yes' === $check_exchange ) {
					$final_products  = array();
					$flag            = true;
					$qty_flag        = true;
					$variation_flag  = true;
					$from            = array();
					$to              = array();
					$item_detail     = array();
					$invalid_item    = true;
					$invalid_qty     = true;
					$item_flag       = true;
					$product_flag    = true;
					$variations_flag = true;
					foreach ( $order_obj->get_items() as $item_id => $item ) {
						$item_detail[ $item_id ] = $item->get_quantity();
					}
					$json_validate = wps_json_validate( $products );
					if ( $json_validate ) {
						foreach ( $order_obj->get_items() as $item_id => $item ) {
							foreach ( json_decode( $products ) as $key => $value ) {
								if ( 'from' === $key ) {
									foreach ( $value as $key1 => $value1 ) {
										if ( isset( $value1->item_id ) && isset( $value1->qty ) && array_key_exists( $value1->item_id, $item_detail ) ) {
											if ( $item_id == $value1->item_id ) {
												$item_exchange_already = get_post_meta( $order_id, 'wps_rma_request_made', true );
												if ( ! empty( $item_exchange_already ) && isset( $item_exchange_already[ $item_id ] ) && 'completed' === $item_exchange_already[ $item_id ] ) {
													$flag = false;
												} elseif ( absint( $value1->qty ) > $item->get_quantity() ) {
													$qty_flag = false;
													break;
												} else {
													$item_arr               = array();
													$item_arr['product_id'] = $item->get_product_id();
													$item_arr['item_id']    = $item_id;
													$item_arr['qty']        = $value1->qty;
													$tax                    = $item->get_total_tax();
													$wps_rma_check_tax      = get_option( $order_id . 'check_tax', false );
													if ( empty( $wps_rma_check_tax ) ) {
														$item_arr['price'] = $item->get_total();
													} elseif ( 'wps_rma_inlcude_tax' === $wps_rma_check_tax ) {
														$item_arr['price'] = $item->get_total() + $tax;
													} elseif ( 'wps_rma_exclude_tax' === $wps_rma_check_tax ) {
														$item_arr['price'] = $item->get_total() - $tax;
													}
													$from[] = $item_arr;
												}
											}
										} else {
											if ( ! isset( $value->item_id ) ) {
												$invalid_item = false;
											} elseif ( ! isset( $value->qty ) ) {
												$invalid_qty = false;
											} else {
												$item_flag = false;
											}
										}
									}
								}
							}
						}
						foreach ( json_decode( $products ) as $key => $value ) {
							if ( 'to' === $key ) {
								foreach ( $value as $key2 => $value2 ) {
									$item_arr  = array();
									$variation = array();
									if ( isset( $value2->product_id ) && ! empty( $value2->product_id ) ) {
										$item_arr['id'] = $value2->product_id;
										$product        = wc_get_product( $value2->product_id );
										if ( empty( $product ) ) {
											$product_flag = false;
										}
									}
									if ( isset( $value2->variation_id ) && ! empty( $value2->variation_id ) ) {
										$variation_product = wc_get_product( $value2->variation_id );
										if ( empty( $variation_product ) ) {
											$variation_flag = false;
										}
										if ( isset( $value2->variations ) && ! empty( $value2->variations ) ) {
											$ob_to_ar = json_decode( json_encode( $value2->variations ), true );
											foreach ( $ob_to_ar as $key3 => $value3 ) {
												$variation[ $key3 ] = $value3;
											}
											$item_arr['variations']   = $variation;
											$item_arr['variation_id'] = $value2->variation_id;
										} else {
											$variations_flag = false;
										}
									}
									$item_arr['qty']   = $value2->qty;
									$tax               = $item->get_total_tax();
									$wps_rma_check_tax = get_option( $order_id . 'check_tax', false );
									$product           = wc_get_product( $value2->product_id );
									if ( empty( $wps_rma_check_tax ) ) {
										$item_arr['price'] = $product->get_price();
									} elseif ( 'wps_rma_inlcude_tax' === $wps_rma_check_tax ) {
										$item_arr['price'] = wc_get_price_including_tax( $product );
									} elseif ( 'wps_rma_exclude_tax' === $wps_rma_check_tax ) {
										$item_arr['price'] = wc_get_price_excluding_tax( $product );
									}
									$to[] = $item_arr;
								}
							}
						}
					}
					if ( ! $flag ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Exchange Request Already has been made and accepted for the items you have given', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $qty_flag ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Quanity given for items is greater than the order\'s items quantity', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $variations_flag ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Please Enter the variations to continue the process.', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $product_flag ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Please enter the correct product id to continue the process', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $variation_flag ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Please enter the correct variation id to continue the process', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( empty( $from ) ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'There is wrong details given in the from products exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( empty( $to ) ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'There is wrong details given in the to products exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $json_validate ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Products are given by you doesn\'t a valid json format', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $item_flag ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'These item id does not belong to the order', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $invalid_item ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Please give the item ids which needs to be exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
					} elseif ( ! $invalid_qty ) {
						$wps_rma_rest_response['message'] = 'error';
						$wps_rma_rest_response['status']  = 404;
						$wps_rma_rest_response['data']    = esc_html__( 'Please give the item qty which needs to be exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
					} else {
						$date                              = gmdate( 'd-m-Y' );
						$final_products[ $date ]['status'] = 'pending';
						$final_products[ $date ]['from']   = $from;
						$final_products[ $date ]['to']     = $to;
						update_post_meta( $order_id, 'wps_rma_exchange_details', $final_products );
						$response                         = wps_wrma_submit_exchange_request_callback( $order_id, $reason, '', $refund_method );
						$wps_rma_rest_response['message'] = 'success';
						$wps_rma_rest_response['status']  = 200;
						$wps_rma_rest_response['data']    = esc_html__( 'Exchange Request send successfully', 'woocommerce-rma-for-return-refund-and-exchange' );
					}
				} else {
					$wps_rma_rest_response['status'] = 404;
					$wps_rma_rest_response['data']   = $check_exchange;
				}
			} elseif ( empty( $products ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the data for the products', 'woocommerce-rma-for-return-refund-and-exchange' );
			} elseif ( empty( $reason ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the reason for exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
			} elseif ( empty( $order_id ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			} elseif ( empty( $order_obj ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the correct order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			return $wps_rma_rest_response;
		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   object $mwr_request data of requesting headers and other information.
		 * @return  Array $wps_rma_rest_response returns processed data and status of operations.
		 */
		public function wps_rma_exchange_request_accept_process( $mwr_request ) {
			$data                  = $mwr_request->get_params();
			$order_id              = isset( $data['order_id'] ) ? absint( $data['order_id'] ) : 0;
			$flag                  = false;
			$flag_completed        = false;
			$wps_rma_rest_response = array();
			$order_obj             = wc_get_order( $order_id );
			if ( ! empty( $order_id ) && ! empty( $order_obj ) ) {
				$exchange_details = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
				if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
					foreach ( $exchange_details as $date => $exchange_detail ) {
						if ( 'pending' === $exchange_detail['status'] ) {
							$flag = true;
						} elseif ( 'complete' === $exchange_detail['status'] ) {
							$flag_completed = true;
						}
					}
				}
				if ( $flag ) {
					$wps_rma_resultsdata = wps_exchange_req_approve_callback( $order_id );
					if ( ! empty( $wps_rma_resultsdata ) ) {
						$wps_rma_rest_response['status'] = 200;
						$wps_rma_rest_response['data']   = esc_html__( 'Exchange Request Accepted Successfully', 'woocommerce-rma-for-return-refund-and-exchange' );
					} else {
						$wps_rma_rest_response['status'] = 404;
						$wps_rma_rest_response['data']   = esc_html__( 'Some problem occur while exchange request accepting', 'woocommerce-rma-for-return-refund-and-exchange' );
					}
				} elseif ( $flag_completed ) {
					$wps_rma_rest_response['status'] = 404;
					$wps_rma_rest_response['data']   = esc_html__( 'You have approved the exchange request already', 'woocommerce-rma-for-return-refund-and-exchange' );
				} else {
					$wps_rma_rest_response['status'] = 404;
					$wps_rma_rest_response['data']   = esc_html__( 'You can only perform the exchange request accept when the request has been made earlier', 'woocommerce-rma-for-return-refund-and-exchange' );
				}
			} elseif ( empty( $order_id ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			} elseif ( empty( $order_obj ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the correct order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			return $wps_rma_rest_response;
		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   object $mwr_request  data of requesting headers and other information.
		 * @return  Array $wps_rma_rest_response    returns processed data and status of operations.
		 */
		public function wps_rma_exchange_request_cancel_process( $mwr_request ) {
			$data                  = $mwr_request->get_params();
			$order_id              = isset( $data['order_id'] ) ? absint( $data['order_id'] ) : 0;
			$flag                  = false;
			$flag_cancel           = false;
			$wps_rma_rest_response = array();
			$order_obj             = wc_get_order( $order_id );
			if ( ! empty( $order_id ) && ! empty( $order_obj ) ) {
				$exchange_details = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
				if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
					foreach ( $exchange_details as $date => $exchange_detail ) {
						if ( 'pending' === $exchange_detail['status'] ) {
							$flag = true;
						} elseif ( 'cancel' === $exchange_detail['status'] ) {
							$flag_cancel = true;
						}
					}
				}
				if ( $flag ) {
					$wps_rma_resultsdata = wps_wrma_exchange_req_cancel_callback( $order_id );
					if ( ! empty( $wps_rma_resultsdata ) ) {
						$wps_rma_rest_response['status'] = 200;
						$wps_rma_rest_response['data']   = esc_html__( 'Exchange Request Cancel Successfully', 'woocommerce-rma-for-return-refund-and-exchange' );
					} else {
						$wps_rma_rest_response['status'] = 404;
						$wps_rma_rest_response['data']   = esc_html__( 'some problem occurred while exchange request canceling', 'woocommerce-rma-for-return-refund-and-exchange' );
					}
				} elseif ( $flag_cancel ) {
					$wps_rma_rest_response['status'] = 404;
					$wps_rma_rest_response['data']   = esc_html__( 'You have cancelled the exchange request already', 'woocommerce-rma-for-return-refund-and-exchange' );
				} else {
					$wps_rma_rest_response['status'] = 404;
					$wps_rma_rest_response['data']   = esc_html__( 'You can only perform the exchange request cancel when the request has been made earlier', 'woocommerce-rma-for-return-refund-and-exchange' );
				}
			} elseif ( empty( $order_id ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			} elseif ( empty( $order_obj ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the correct order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			return $wps_rma_rest_response;
		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   object $mwr_request  data of requesting headers and other information.
		 * @return  Array $wps_rma_rest_response    returns processed data and status of operations.
		 */
		public function wps_rma_cancel_request_process( $mwr_request ) {
			$data                  = $mwr_request->get_params();
			$order_id              = isset( $data['order_id'] ) ? absint( $data['order_id'] ) : 0;
			$products              = isset( $data['products'] ) ? $data['products'] : '';
			$qty_flag              = true;
			$item_arr              = array();
			$wps_rma_rest_response = array();
			$order_obj             = wc_get_order( $order_id );
			if ( ! empty( $order_id ) && ! empty( $order_obj ) ) {
				$check_cancel = wps_rma_show_buttons( 'cancel', $order_obj );
				if ( 'yes' === $check_cancel ) {
					if ( empty( $products ) ) {
						if ( 'cancelled' === $order_obj->get_status() ) {
							$wps_rma_rest_response['status'] = 200;
							$wps_rma_rest_response['data']   = esc_html__( 'This order is already cancelled', 'woocommerce-rma-for-return-refund-and-exchange' );
						} else {
							$response = wps_rma_cancel_customer_order_callback( $order_id );
							if ( ! empty( $response ) ) {
								$wps_rma_rest_response['status'] = 200;
								$wps_rma_rest_response['data']   = esc_html__( 'The order is cancelled', 'woocommerce-rma-for-return-refund-and-exchange' );
							} else {
								$wps_rma_rest_response['status'] = 404;
								$wps_rma_rest_response['data']   = esc_html__( 'Some problem occur while order cancelling', 'woocommerce-rma-for-return-refund-and-exchange' );
							}
						}
					} else {
						$json_validate = wps_json_validate( $products );
						if ( $json_validate ) {
							$products     = json_decode( $products );
							$item_detail  = array();
							$invalid_item = true;
							$invalid_qty  = true;
							$item_flag    = true;
							$qty_flag     = true;
							foreach ( $order_obj->get_items() as $item_id => $item ) {
								$item_detail[ $item_id ] = $item->get_quantity();
							}
							foreach ( $order_obj->get_items() as $item_id => $item ) {
								foreach ( $products as $key => $value ) {
									if ( isset( $value->item_id ) && isset( $value->qty ) && array_key_exists( $value->item_id, $item_detail ) ) {
										if ( $value->item_id === $item_id ) {
											if ( $value->qty > $item->get_quantity() ) {
												$qty_flag = false;
											}
											$item_arr[ $key ] = array( $item_id, $value->qty );
										}
									} else {
										if ( ! isset( $value->item_id ) ) {
											$invalid_item = false;
										} elseif ( ! isset( $value->qty ) ) {
											$invalid_qty = false;
										} else {
											$item_flag = false;
										}
									}
								}
							}
							if ( ! $invalid_item ) {
								$wps_rma_rest_response['status'] = 404;
								$wps_rma_rest_response['data']   = esc_html__( 'Please give the item ids which needs to be cancelled', 'woocommerce-rma-for-return-refund-and-exchange' );
							} elseif ( ! $invalid_qty ) {
								$wps_rma_rest_response['status'] = 404;
								$wps_rma_rest_response['data']   = esc_html__( 'please give the qty for the item.', 'woocommerce-rma-for-return-refund-and-exchange' );
							} elseif ( ! $item_flag ) {
								$wps_rma_rest_response['status'] = 404;
								$wps_rma_rest_response['data']   = esc_html__( 'These item id does not belongs to the order\'s item', 'woocommerce-rma-for-return-refund-and-exchange' );
							} elseif ( ! $qty_flag ) {
								$wps_rma_rest_response['status'] = 404;
								$wps_rma_rest_response['data']   = esc_html__( 'The item quantity must be less than order\'s item quantity', 'woocommerce-rma-for-return-refund-and-exchange' );
							} else {
								$response = wps_rma_cancel_customer_order_products_callback( $order_id, $item_arr );
								if ( ! empty( $response ) ) {
									$wps_rma_rest_response['status'] = 200;
									$wps_rma_rest_response['data']   = esc_html__( 'The order partially has been cancelled', 'woocommerce-rma-for-return-refund-and-exchange' );
								} else {
									$wps_rma_rest_response['status'] = 404;
									$wps_rma_rest_response['data']   = esc_html__( 'Some problem occur while order cancelling', 'woocommerce-rma-for-return-refund-and-exchange' );
								}
							}
						}
					}
				} else {
					$wps_rma_rest_response['status'] = 404;
					$wps_rma_rest_response['data']   = $check_cancel;
				}
			} elseif ( empty( $order_id ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			} elseif ( empty( $order_obj ) ) {
				$wps_rma_rest_response['status'] = 404;
				$wps_rma_rest_response['data']   = esc_html__( 'Please Provide the correct order id to perform the process', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			return $wps_rma_rest_response;
		}
	}
}
