<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace rma_return_refund_exchange_for_woocommerce_pro_public.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/public
 */
class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwr_public_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'public/css/wps-rma-return-refund-exchange-for-woocommerce-pro-public.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwr_public_enqueue_scripts() {
		wp_register_script( $this->plugin_name, RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL . 'public/js/wps-rma-return-refund-exchange-for-woocommerce-pro-public.min.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'mwr_public_param',
			array(
				'ajaxurl'       => admin_url( 'admin-ajax.php' ),
				'wps_rma_nonce' => wp_create_nonce( 'wps_rma_ajax_seurity' ),
			)
		);
		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Show checkbox on the refund form <thead>.
	 *
	 * @param [type] $order_id .
	 */
	public function wps_rma_add_extra_column_refund_form( $order_id ) {
		?>
		<th class="product-check"><input type="checkbox" name="wps_wrma_return_product_all" class="wps_wrma_return_product_all" data-order_id="<?php echo esc_html( $order_id ); ?>"> <?php esc_html_e( 'Check All', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
		<?php
	}

	/**
	 * Show the checkbox field.
	 *
	 * @param [type] $item_id .
	 * @param [type] $product_id .
	 * @return void
	 */
	public function wps_rma_add_extra_column_field_value( $item_id, $product_id ) {
		$check_sale_item = get_option( 'wps_rma_refund_on_sale', 'no' );
		$exclude_prod    = wps_rma_exclude_product( $product_id, 'refund' );
		?>
		<td class="product-select">
			<?php
			if ( ( 'on' !== $check_sale_item && wc_get_product( $product_id )->is_on_sale() ) || ! $exclude_prod ) {
				echo '<img class="disable-return" src="' . esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . '/public/images/return-disable.png">';
			} else {
				?>
				<input type="checkbox" class="wps_wrma_return_product" data-item_id="<?php echo esc_html( $item_id ); ?>">
				<?php
			}
			?>
		</td>
		<?php
	}

	/**
	 * Show refund method on the refund request form.
	 *
	 * @param [type] $order_id .
	 */
	public function wps_rma_after_table( $order_id ) {
		?>
		<p class="wps_wrma_exchange_note">
			<i><img src="<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ); ?>/public/images/return-disable.png" class="wps_rma_refund_note_img" width="20px"> : <?php esc_html_e( 'It means product can\'t be refunded.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> <br>
			<?php
			$giftware_error_message = get_post_meta( $order_id, 'wps_wrma_giftware_exchange_reason', true );
			if ( isset( $giftware_error_message ) && ! empty( $giftware_error_message ) ) {
				echo wp_kses_post( $giftware_error_message );
			}
			?>
			</i>
		</p>
		<div class="wps_wrma_refund_method_div">
		<?php
		$wps_wrma_return_wallet_enable        = get_option( 'wps_rma_wallet_enable', 'no' );
		$wps_wrma_select_refund_method_enable = get_option( 'wps_rma_refund_method', 'no' );
		if ( isset( $wps_wrma_return_wallet_enable ) && 'on' === $wps_wrma_return_wallet_enable ) {
			if ( isset( $wps_wrma_select_refund_method_enable ) && 'on' === $wps_wrma_select_refund_method_enable ) {
				?>
				<br><label>
				<b>
					<?php esc_html_e( 'Select Amount Refund Method :', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
				</b>
			</label>
				<div>
					<input type="radio" id="wps_wrma_refund_method" name="wps_wrma_refund_method" value="wallet_method" checked><span class="wps_wrma_refund_method_input_test"> <?php esc_html_e( 'Refund Into the Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></span>
				</div>
				<div class=wps_wrma_refund_method-wrap>
					<input type="radio" name="wps_wrma_refund_method" value="manual_method"><span class="wps_wrma_refund_method_input_test"> <?php esc_html_e( 'Refund Through Manual Method', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></span>
				</div>
				<?php
			}
		}
		?>
		</div>
		<?php
		$item_ids = array();
		foreach ( wc_get_order( $order_id )->get_items() as $item_id => $item ) {
			$item_ids[] = $item_id;
		}
		$show_charges = global_shipping_charges( $order_id, $item_ids );
		if ( $show_charges ) {
			?>
			<br/>
			<div class="ship_show_info">
				<?php
				$wps_rma_refund_shipping_fee_desc = empty( get_option( 'wps_rma_refund_shipping_descr' ) ) ? esc_html__( 'This Extra Shipping Fee Will be Deducted from Total Amount When the Refund Request is approved', 'woocommerce-rma-for-return-refund-and-exchange' ) : get_option( 'wps_rma_refund_shipping_descr' );
				$get_wps_rnx_global_shipping      = get_option( 'wps_wrma_shipping_global_data', array() );
				if ( isset( $get_wps_rnx_global_shipping['enable'] ) && 'on' === $get_wps_rnx_global_shipping['enable'] ) {
					echo '<b><i>' . esc_html( $wps_rma_refund_shipping_fee_desc ) . '</i></b>';
				}
				?>
			</div>
			<div class="ship_show">
				<table>
					<tr>
						<th><?php esc_html_e( 'Shipping Charges', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th><?php esc_html_e( 'Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
					</tr>
				<?php
				$wps_fee_name = $get_wps_rnx_global_shipping['fee_name'];
				$wps_fee_cost = $get_wps_rnx_global_shipping['fee_cost'];
				if ( is_array( $wps_fee_name ) && ! empty( $wps_fee_name ) ) {
					foreach ( $wps_fee_name as $name_key => $name_value ) {
						?>
						<tr>
						<?php
						if ( ! empty( $name_value ) && ! empty( $wps_fee_cost[ $name_key ] ) ) {
							echo '<td>' . esc_html( $name_value ) . '</td><td>' . wp_kses_post( wc_price( $wps_fee_cost[ $name_key ] ) ) . '</td>';
						}
						?>
						</tr>
						<?php
					}
				}
				?>
				</table>
			</div>
			<?php
		}
	}

	/**
	 * Show sidebar.
	 */
	public function wps_rma_refund_form_sidebar() {
		if ( 'on' === get_option( 'wps_rma_show_sidebar' ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * If check product is for the refund.
	 *
	 * @param int $product_id .
	 * @return bool $flag
	 */
	public function wps_rma_revoke_product_refund( $product_id ) {
		$check_sale_item = get_option( 'wps_rma_refund_on_sale', 'no' );
		if ( 'on' !== $check_sale_item && wc_get_product( $product_id )->is_on_sale() ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Show the exchange and cancel button on order page.
	 *
	 * @param array  $actions .
	 * @param object $order .
	 * @return $actions
	 */
	public function wps_rma_exchange_cancel_button( $actions, $order ) {
		$conditions1 = wps_rma_show_buttons( 'exchange', $order );
		$conditions2 = wps_rma_show_buttons( 'cancel', $order );

		// Show Exchange Button.
		$exchange_will_made =
		// change refund will made.
		apply_filters( 'wps_rma_refund_will_made', true, $order->get_id() );
		$wps_rma_exchange_request_form_page_id = get_option( 'wps_rma_exchange_req_page', true );
		if ( $exchange_will_made && 'yes' === $conditions1 ) {
			$exchange_button_text = get_option( 'wps_rma_exchange_button_text', false );
			$exchange_button_view = get_option( 'wps_rma_exchange_button_pages', false );
			if ( isset( $exchange_button_text ) && ! empty( $exchange_button_text ) ) {
				$exchange_button_text = $exchange_button_text;
			} else {
				$exchange_button_text = esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			$page_id      = $wps_rma_exchange_request_form_page_id;
			$exchange_url = get_permalink( $page_id );
			$exchange_url = add_query_arg( 'order_id', $order->get_id(), $exchange_url );
			$exchange_url = wp_nonce_url( $exchange_url, 'wps_rma_nonce', 'wps_rma_nonce' );
			if ( empty( $exchange_button_view ) ) {
				$exchange_button_view = array( 'none' );
			}
			$show_on_pages = true;
			if ( ! empty( $exchange_button_view ) && in_array( 'order-page', $exchange_button_view, true ) ) {
				$show_on_pages = false;
			}
			if ( $show_on_pages ) {
				$actions['exchange']['url']  = $exchange_url;
				$actions['exchange']['name'] = $exchange_button_text;
			}
		}
		if ( 'yes' === $conditions2 ) {
			$prod_cancel                         = get_option( 'wps_rma_cancel_product', 'no' );
			$wps_rma_cancel_request_form_page_id = get_option( 'wps_rma_cancel_req_page', true );
			$cancel_button_text                  = get_option( 'wps_rma_cancel_button_text', false );
			$cancel_prod_button_text             = get_option( 'wps_rma_cancel_prod_button_text', false );
			$cancel_button_view                  = get_option( 'wps_rma_cancel_button_pages', false );
			if ( isset( $cancel_prod_button_text ) && ! empty( $cancel_prod_button_text ) ) {
				$cancel_prod_button_text = $cancel_prod_button_text;
			} else {
				$cancel_prod_button_text = esc_html__( 'Cancel Product', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			if ( isset( $cancel_button_text ) && ! empty( $cancel_button_text ) ) {
				$cancel_button_text = $cancel_button_text;
			} else {
				$cancel_button_text = esc_html__( 'Cancel Order', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			$page_id    = $wps_rma_cancel_request_form_page_id;
			$cancel_url = get_permalink( $page_id );
			$cancel_url = add_query_arg( 'order_id', $order->get_id(), $cancel_url );
			$cancel_url = wp_nonce_url( $cancel_url, 'wps_rma_nonce', 'wps_rma_nonce' );
			if ( empty( $cancel_button_view ) ) {
				$cancel_button_view = array( 'none' );
			}
			$show_on_pages = true;
			if ( ! empty( $cancel_button_view ) && in_array( 'order-page', $cancel_button_view, true ) ) {
				$show_on_pages = false;
			}

			if ( $show_on_pages ) {
				if ( 'on' === $prod_cancel ) {
					$actions['cancel']['name'] = $cancel_prod_button_text;
					$actions['cancel']['url']  = $cancel_url;
				} else {
					$actions['wps_rma_cancel_order']['name'] = $cancel_button_text;
					$actions['wps_rma_cancel_order']['url']  = $order->get_id();
				}
			}
		}
		return $actions;
	}

	/**
	 * Show the exchange details
	 *
	 * @param object $order .
	 */
	public function wps_rma_exchange_button_and_details( $order ) {
		// Exchange process related info.
		$exchange_enable = get_option( 'wps_rma_exchange_enable', 'no' );
		if ( 'on' === $exchange_enable ) {
			$exchanged_details  = get_post_meta( $order->get_id(), 'wps_wrma_exchange_product', true );
			$get_order_currency = get_woocommerce_currency_symbol( $order->get_currency() );
			if ( isset( $exchanged_details ) && ! empty( $exchanged_details ) ) {
				foreach ( $exchanged_details as $key => $exchanged_detail ) {
					if ( isset( $exchanged_detail['from'] ) && isset( $exchanged_detail['to'] ) && isset( $exchanged_detail['orderid'] ) ) {
						$selected_total_price = 0;
						$date                 = date_create( $key );
						$date_format          = get_option( 'date_format' );
						$date                 = date_format( $date, $date_format );
						?>
						<p><?php esc_html_e( 'Following product exchange request is made on', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> <b><?php echo esc_html( $date ); ?>.</b></p>
						<?php
						$exchanged_products    = $exchanged_detail['from'];
						$exchanged_to_products = $exchanged_detail['to'];
						if ( isset( $exchanged_detail['fee'] ) ) {
							$exchanged_fees = $exchanged_detail['fee'];
						} else {
							$exchanged_fees = array();
						}
						?>
						<h2><?php esc_html_e( 'Exchange Requested Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></h2>
						<table class="shop_table order_details">
							<thead>
								<tr>
									<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
									<th class="product-total"><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ( $order->get_items() as $item_id => $item ) {
								foreach ( $exchanged_products as $key => $exchanged_product ) {
									if ( $exchanged_product['item_id'] == $item_id ) {
										$pro_price             = $exchanged_product['qty'] * $exchanged_product['price'];
										$selected_total_price += $pro_price;
										?>
										<tr>
											<td class="product-name">
											<?php
											$product =
											// Woo Order Item Product.
											apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
											$is_visible        = $product && $product->is_visible();
											$product_permalink =
											// Woo Order item Permalink.
											apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

											echo wp_kses_post( $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item['name'] ) : $item['name'] );
											echo wp_kses_post( '<strong class="product-quantity">' . sprintf( '&times; %s', $exchanged_product['qty'] ) . '</strong>' );
											// Order Item meta start.
											do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order );
											if ( WC()->version < '3.0.0' ) {
												$order->display_item_meta( $item );
												$order->display_item_downloads( $item );
											} else {
												wc_display_item_meta( $item );
												wc_display_item_downloads( $item );
											}
											// Order Item meta end.
											do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order );
											?>
											</td>
											<td class="product-total"><?php echo wp_kses_post( wps_wrma_format_price( $pro_price, $get_order_currency ) ); ?></td>
										</tr>
										<?php
									}
								}
							}
							?>
									<tr>
										<th><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
										<th><?php echo wp_kses_post( wps_wrma_format_price( $selected_total_price, $get_order_currency ) ); ?></th>
									</tr>
								</tbody>
							</table>
							<h2><?php esc_html_e( 'Exchanged Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></h2>
							<table class="shop_table order_details">
								<thead>
									<tr>
										<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
										<th class="product-total"><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								$total_price = 0;
								foreach ( $exchanged_to_products as $key => $exchanged_product ) {
									$variation_attributes = array();
									if ( isset( $exchanged_product['variation_id'] ) ) {
										if ( $exchanged_product['variation_id'] ) {
											$variation_product    = new WC_Product_Variation( $exchanged_product['variation_id'] );
											$variation_attributes = isset( $exchanged_product['variations'] ) ? $exchanged_product['variations'] : $variation_product->get_variation_attributes();
											$variation_labels     = array();
											foreach ( $variation_attributes as $label => $value ) {
												if ( is_null( $value ) || '' == $value ) {
													$variation_labels[] = $label;
												}
											}
											if ( count( $variation_labels ) ) {
												$item_type =
												// order Item type.
												apply_filters( 'woocommerce_admin_order_item_types', 'line_item' );
												$all_line_items = $order->get_items( $item_type );
												$var_attr_info  = array();
												foreach ( $all_line_items as $ear_item ) {
													$variation_id = isset( $ear_item['item_meta']['_variation_id'] ) ? $ear_item['item_meta']['_variation_id'][0] : 0;
													if ( $variation_id && $variation_id == $exchanged_product['variation_id'] ) {
														$item_meta = isset( $ear_item['item_meta'] ) ? $ear_item['item_meta'] : array();
														foreach ( $item_meta as $meta_key => $meta_info ) {
															$meta_name = 'attribute_' . sanitize_title( $meta_key );
															if ( in_array( $meta_name, $variation_labels ) ) {
																$variation_attributes[ $meta_name ] = isset( $term->name ) ? $term->name : $meta_info[0];
															}
														}
													}
												}
											}
										}
									}
									if ( isset( $exchanged_product['p_id'] ) ) {
										if ( $exchanged_product['p_id'] ) {
											$grouped_product       = new WC_Product_Grouped( $exchanged_product['p_id'] );
											$grouped_product_title = $grouped_product->get_title();
										}
									}
									$pro_price    = $exchanged_product['qty'] * $exchanged_product['price'];
									$total_price += $pro_price;
									$product      = new WC_Product( $exchanged_product['id'] );
									?>
									<tr>
										<td>
										<?php
										if ( isset( $exchanged_product['p_id'] ) ) {
											echo wp_kses_post( $grouped_product_title . ' -> ' );
										}
										echo wp_kses_post( $product->get_title() );
										echo '<b> × ' . esc_html( $exchanged_product['qty'] ) . '</b>';
										if ( isset( $variation_attributes ) && ! empty( $variation_attributes ) ) {
											echo wp_kses_post( wc_get_formatted_variation( $variation_attributes, $get_order_currency ) );
										}
										?>
										</td>
										<td><?php echo wp_kses_post( wps_wrma_format_price( $pro_price, $get_order_currency ) ); ?></td>
									</tr>
									<?php
								}
								if ( isset( $exchanged_fees ) ) {
									if ( is_array( $exchanged_fees ) ) {
										?>
										<tr>
											<th colspan="2"><?php esc_html_e( 'Extra Cost', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
										</tr>
										<?php
										foreach ( $exchanged_fees as $fee ) {
											?>
											<tr>
												<th><?php echo wp_kses_post( $fee['text'] ); ?></th>
												<td><?php echo wp_kses_post( wps_wrma_format_price( $fee['val'], $get_order_currency ) ); ?></td>
											</tr>
											<?php
											$total_price += $fee['val'];
										}
									}
								}
								?>
								<tr>
									<th><?php esc_html_e( 'Total Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
									<th><?php echo wp_kses_post( wps_wrma_format_price( $total_price, $get_order_currency ) ); ?></th>
								</tr>
							</tbody>
						</table>
						<table class="shop_table order_details">
							<?php
							if ( $total_price - $selected_total_price > 0 ) {
								?>
								<tr>
									<th class="product-name"><?php esc_html_e( 'Pay Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
									<th class="product-total"><?php echo wp_kses_post( wps_wrma_format_price( $total_price - $selected_total_price, $get_order_currency ) ); ?></th>
								</tr>
								<?php
							} else {
								?>
								<tr>
									<th class="product-name"><?php esc_html_e( 'Refundable Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
									<th class="product-total"><?php echo wp_kses_post( wps_wrma_format_price( $selected_total_price - $total_price, $get_order_currency ) ); ?></th>
								</tr>
							<?php } ?>
						</table>	
						<p>
						<?php
						if ( 'complete' === $exchanged_detail['status'] ) {
							$approve_date = date_create( $exchanged_detail['approve'] );
							$date_format  = get_option( 'date_format' );
							$approve_date = date_format( $approve_date, $date_format );

							esc_html_e( 'Above product exchange request is approved on', 'woocommerce-rma-for-return-refund-and-exchange' );
							?>
							<b><?php echo esc_html( $approve_date ); ?>.</b>
							<?php
						}
						if ( 'cancel' === $exchanged_detail['status'] ) {
							$approve_date = date_create( $exchanged_detail['cancel_date'] );
							$approve_date = date_format( $approve_date, 'F d, Y' );

							esc_html_e( 'Above product exchange request is cancelled on', 'woocommerce-rma-for-return-refund-and-exchange' );
							?>
							<b><?php echo esc_html( $approve_date ); ?>.</b>
							<?php
						}
						?>
					</p>
						<?php
					}
				}
			}
		}
		// Exchange process related end.

		$conditions1 = wps_rma_show_buttons( 'exchange', $order );
		$conditions2 = wps_rma_show_buttons( 'cancel', $order );

		$refund_will_made =
		// Exchange will made.
		apply_filters( 'wps_rma_refund_will_made', true, $order->get_id() );

		$wps_rma_exchange_request_form_page_id = get_option( 'wps_rma_exchange_req_page', true );
		if ( $refund_will_made && 'yes' === $conditions1 ) {
			$exchange_button_text = get_option( 'wps_rma_exchange_button_text', false );
			$exchange_button_view = get_option( 'wps_rma_exchange_button_pages', false );
			if ( isset( $exchange_button_text ) && ! empty( $exchange_button_text ) ) {
				$exchange_button_text = $exchange_button_text;
			} else {
				$exchange_button_text = esc_html__( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			$page_id      = $wps_rma_exchange_request_form_page_id;
			$exchange_url = get_permalink( $page_id );
			$exchange_url = add_query_arg( 'order_id', $order->get_id(), $exchange_url );
			$exchange_url = wp_nonce_url( $exchange_url, 'wps_rma_nonce', 'wps_rma_nonce' );
			if ( empty( $exchange_button_view ) ) {
				$exchange_button_view = array( 'none' );
			}
			if ( ! in_array( get_the_title(), $exchange_button_view, true ) ) {
				?>
				<form action="<?php echo esc_html( $exchange_url ); ?>" method="post">
					<input type="hidden" value="<?php echo esc_html( $order->get_id() ); ?>" name="order_id">
					<p><input type="submit" class="btn button" value="<?php echo esc_html( $exchange_button_text ); ?>" name="ced_new_return_request"></p>
				</form>
				<?php
			}
		}
		if ( 'yes' === $conditions2 ) {
			$wps_rma_cancel_request_form_page_id = get_option( 'wps_rma_cancel_req_page', true );
			$cancel_button_text                  = get_option( 'wps_rma_cancel_button_text', false );
			$cancel_button_view                  = get_option( 'wps_rma_cancel_button_pages', false );
			$cancel_prod_button_text             = get_option( 'wps_rma_cancel_prod_button_text', false );
			if ( isset( $cancel_button_text ) && ! empty( $cancel_button_text ) ) {
				$cancel_button_text = $cancel_button_text;
			} else {
				$cancel_button_text = esc_html__( 'Cancel Order', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			if ( isset( $cancel_prod_button_text ) && ! empty( $cancel_prod_button_text ) ) {
				$cancel_prod_button_text = $cancel_prod_button_text;
			} else {
				$cancel_prod_button_text = esc_html__( 'Cancel Product', 'woocommerce-rma-for-return-refund-and-exchange' );
			}
			if ( empty( $cancel_button_view ) ) {
				$cancel_button_view = array( 'none' );
			}
			$prod_cancel = get_option( 'wps_rma_cancel_product', 'no' );
			if ( ! in_array( get_the_title(), $cancel_button_view, true ) ) {
				if ( 'on' === $prod_cancel ) {
					$page_id    = $wps_rma_cancel_request_form_page_id;
					$cancel_url = get_permalink( $page_id );
					$cancel_url = add_query_arg( 'order_id', $order->get_id(), $cancel_url );
					$cancel_url = wp_nonce_url( $cancel_url, 'wps_rma_nonce', 'wps_rma_nonce' );
					?>
						<form action="<?php echo esc_html( $cancel_url ); ?>" method="post">
							<input type="hidden" value="<?php echo esc_html( $order->get_id() ); ?>" name="order_id">
							<p><input type="submit" class="btn button" value="<?php echo esc_html( $cancel_prod_button_text ); ?>" name="wps_rma_new_return_request"></p>
						</form>
					<?php

				} else {
					$actions['cancel']['name'] = $cancel_button_text;
					$actions['cancel']['url']  = $order->get_id();
					?>
					<p><a href='' class="woocommerce-button button wps_rma_cancel_order" data-order_id="<?php echo esc_html( $order->get_id() ); ?>"><?php echo esc_html( $cancel_button_text ); ?></a></p>
					<?php
				}
			}
		}
	}

	/**
	 *  Include the templates.
	 *
	 * @param string $template .
	 * @return $template
	 */
	public function wps_rma_template_include( $template ) {
		$exchange_page_id = get_option( 'wps_rma_exchange_req_page' );
		$cancel_page_id   = get_option( 'wps_rma_cancel_req_page' );
		$guest_page_id    = get_option( 'wps_rma_guest_form_page' );

		if ( has_filter( 'wpml_object_id' ) ) {
			$ro_ex  = apply_filters( 'wpml_object_id', $exchange_page_id, 'page', false, ICL_LANGUAGE_CODE );
			$ro_can = apply_filters( 'wpml_object_id', $cancel_page_id, 'page', false, ICL_LANGUAGE_CODE );
			$ro_g   = apply_filters( 'wpml_object_id', $guest_page_id, 'page', false, ICL_LANGUAGE_CODE );
		}
		if ( ( is_page( $exchange_page_id ) && '' != $exchange_page_id ) || ( isset( $ro_ex ) && is_page( $ro_ex ) ) ) {
			$get_id = get_option( 'wps_rma_exchange_page' );
			if ( function_exists( 'vc_lean_map' ) && ! empty( $get_id ) ) {
				if ( isset( $_GET['wps_rma_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['wps_rma_nonce'] ) ), 'wps_rma_nonce' ) && isset( $_GET['order_id'] ) ) {
					$url           = get_permalink( $get_id );
					$order_id      = sanitize_text_field( wp_unslash( $_GET['order_id'] ) );
					$wps_rma_nonce = sanitize_text_field( wp_unslash( $_GET['wps_rma_nonce'] ) );
					$args          = array(
						'order_id'      => $order_id,
						'wps_rma_nonce' => $wps_rma_nonce,
					);
					$url           = add_query_arg( $args, $url );
					wp_safe_redirect( $url );
				}
			}
			$new_template = esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH ) . 'public/partials/wps-exchange-request-form.php';
			$template     = $new_template;
			WC()->session->__unset( 'wps_wrma_exchange' );
			WC()->session->__unset( 'wps_wrma_exchange_variable_product' );
		}
		if ( ( is_page( $cancel_page_id ) && '' != $cancel_page_id ) || ( isset( $ro_can ) && is_page( $ro_can ) ) ) {
			$get_id = get_option( 'wps_rma_cancel_page' );
			if ( function_exists( 'vc_lean_map' ) && ! empty( $get_id ) ) {
				if ( isset( $_GET['wps_rma_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['wps_rma_nonce'] ) ), 'wps_rma_nonce' ) && isset( $_GET['order_id'] ) ) {
					$url           = get_permalink( $get_id );
					$order_id      = sanitize_text_field( wp_unslash( $_GET['order_id'] ) );
					$wps_rma_nonce = sanitize_text_field( wp_unslash( $_GET['wps_rma_nonce'] ) );
					$args          = array(
						'order_id'      => $order_id,
						'wps_rma_nonce' => $wps_rma_nonce,
					);
					$url           = add_query_arg( $args, $url );
					wp_safe_redirect( $url );
				}
			}
			$new_template = esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH ) . 'public/partials/wps-cancel-request-form.php';
			$template     = $new_template;
		}
		if ( ( is_page( $guest_page_id ) && '' != $guest_page_id ) || ( isset( $ro_g ) && is_page( $ro_g ) ) ) {
			$new_template = esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH ) . 'public/partials/wps-guest-form.php';
			$template     = $new_template;
		}
		return $template;
	}

	/**
	 * This function is to add pay button.
	 *
	 * @param int $order_id .
	 */
	public function wps_wrma_exchange_pay_button( $order_id ) {
		$order       = wc_get_order( $order_id );
		$payment_url = $order->get_checkout_payment_url();
		if ( $order->needs_payment() ) {
			?>
			<a class="button pay" href="<?php echo esc_html( $payment_url ); ?>"><?php esc_html_e( 'Pay', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></a>
			<?php
		}
	}

	/**
	 * Delete cancel button for this status .
	 *
	 * @param [type] $actions .
	 * @param [type] $order .
	 * @return $actions
	 */
	public function wps_rma_remove_cancel_button( $actions, $order ) {
		if ( $order->get_status() === 'exchange-approve' ) {
			unset( $actions['cancel'] );
		}
		return $actions;
	}

	/** Show the product note */
	public function wps_rma_show_note_on_product() {
		global $post, $product;
		$product_id      = $product->get_id();
		$return_enable   = get_option( 'wps_rma_refund_enable', 'no' );
		$exchange_enable = get_option( 'wps_rma_exchange_enable', 'no' );

		// Return Product.
		if ( isset( $return_enable ) && ! empty( $return_enable ) ) {
			if ( 'on' === $return_enable ) {
				$show1      = false;
				$sale_item1 = get_option( 'wps_rma_refund_on_sale', 'no' );
				$check1     = wps_rma_exclude_product( $product_id, 'refund' );
				if ( ! $check1 ) {
					$show1 = true;
				}
				if ( 'on' !== $sale_item1 ) {
					if ( $product->is_on_sale() ) {
						$show1 = true;
					}
				}
				if ( $show1 ) {
					$wps_wrma_return_note_enable  = get_option( 'wps_rma_refund_note', false );
					$wps_wrma_return_note_message = get_option( 'wps_rma_refund_note_text', false );
					if ( isset( $wps_wrma_return_note_enable ) && ! empty( $wps_wrma_return_note_enable ) ) {
						if ( 'on' === $wps_wrma_return_note_enable ) {
							?>
							<b><?php echo esc_html( $wps_wrma_return_note_message ); ?></b>
							<?php
						}
					}
				}
			}
		}

		// Exchange Product.
		if ( isset( $exchange_enable ) && ! empty( $exchange_enable ) ) {
			if ( 'on' === $exchange_enable ) {
				$show2      = false;
				$sale_item2 = get_option( 'wps_rma_exchange_on_sale', 'no' );
				$check2     = wps_rma_exclude_product( $product_id, 'exchange' );
				if ( ! $check2 ) {
					$show2 = true;
				}
				if ( 'on' !== $sale_item2 ) {
					if ( $product->is_on_sale() ) {
						$show2 = true;
					}
				}
				if ( $show2 ) {
					$wps_wrma_return_note_enable  = get_option( 'wps_rma_exchange_note', false );
					$wps_wrma_return_note_message = get_option( 'wps_rma_exchange_note_text', false );
					if ( isset( $wps_wrma_return_note_enable ) && ! empty( $wps_wrma_return_note_enable ) ) {
						if ( 'on' === $wps_wrma_return_note_enable ) {
							?>
							<br><b><?php echo esc_html( $wps_wrma_return_note_message ); ?></b>
							<?php
						}
					}
				}
			}
		}
	}

	/**
	 * Change the quanity on the refund request form
	 *
	 * @param string $html .
	 * @param string $qty .
	 * @return $html
	 */
	public function wps_rma_change_quanity( $html, $qty ) {
		$html = sprintf( '<input type="number" max="%s" min="1" value="%s" class="wps_rma_return_product_qty" name="wps_rma_return_product_qty">', $qty, 1 );
		return $html;
	}

	/** This function set a woocommerce customer session for guest user. */
	public function wps_rma_session_start() {
		if ( is_user_logged_in() || is_admin() ) {
			return;
		}
		if ( get_option( 'wps_rma_session_start', false ) ) {
			if ( isset( WC()->session ) ) {
				if ( ! WC()->session->has_session() ) {
					WC()->session->set_customer_session_cookie( true );
				}
			}
		}
	}

	/** Add Shortocde */
	public function wps_rma_add_shortcode() {
		$wallet_enable        = get_option( 'wps_rma_wallet_enable', 'no' );
		$wallet_plugin_enable = get_option( 'wps_rma_wallet_plugin', 'no' );
		if ( 'on' !== $wallet_plugin_enable && 'on' === $wallet_enable ) {
			add_shortcode( 'Wps_Rma_Customer_Wallet', array( $this, 'wps_rma_woocommerce_after_my_account1' ) );
		}
		add_shortcode( 'Wps_Rma_Guest_Form', array( $this, 'wps_rma_guest_form' ) );
	}

	/**
	 * Displays Customer Wallet on My Account (Dashboard Page)
	 */
	public function wps_rma_woocommerce_after_my_account() {
		$html        = '';
		$customer_id = get_current_user_id();
		if ( $customer_id > 0 ) {
			$walletcoupon = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
			if ( ! empty( $walletcoupon ) && isset( $walletcoupon ) ) {
				$the_coupon = new WC_Coupon( $walletcoupon );
				$coupon_id  = $the_coupon->get_id();
				if ( isset( $coupon_id ) && wps_rma_wallet_feature_enable() ) {
					$amount = get_post_meta( $coupon_id, 'coupon_amount', true );
					?>
					<p class='button wps_wrma_wallet' style='text-align:center;'><b><?php esc_html_e( 'My Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>: </br><?php esc_html_e( 'Coupon Code', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>:<?php echo esc_html( $walletcoupon ); ?><br><?php esc_html_e( 'Wallet Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>:  <?php echo wp_kses_post( wc_price( $amount ) ); ?></b></p><p class='regenerate_coupon_code'><a class='button' data-id="<?php echo esc_html( $coupon_id ); ?>" href='javascript:void(0)' id='wps_rma_coupon_regenertor'><?php esc_html_e( 'Regenerate Coupon Code', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></a><img class='regenerate_coupon_code_image' src="<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . 'admin/image/loading.gif'; ?>" width='20px' style='display:none;'></p>
					<?php
				}
			}
		}
	}
	/**
	 * Add walllet.
	 */
	public function wps_rma_woocommerce_after_my_account1() {
		$html        = '';
		$customer_id = get_current_user_id();
		if ( $customer_id > 0 ) {
			$walletcoupon = get_user_meta( $customer_id, 'wps_wrma_refund_wallet_coupon', true );
			if ( ! empty( $walletcoupon ) && isset( $walletcoupon ) ) {
				$the_coupon = new WC_Coupon( $walletcoupon );
				$coupon_id  = $the_coupon->get_id();
				if ( isset( $coupon_id ) && wps_rma_wallet_feature_enable() ) {
					$amount = get_post_meta( $coupon_id, 'coupon_amount', true );
					$html  .= "<p class='button wps_wrma_wallet' style='text-align:center;'><b>" . esc_html__( 'My Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </br>' . esc_html__( 'Coupon Code', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': ' . esc_html( $walletcoupon ) . '<br>' . esc_html__( 'Wallet Amount', 'woocommerce-rma-for-return-refund-and-exchange' ) . ':  ' . wc_price( esc_html( $amount ) ) . "</b></p><p class='regenerate_coupon_code'><a class='button' data-id=" . esc_html( $coupon_id ) . " href='javascript:void(0)' id='wps_rma_coupon_regenertor'>" . esc_html__( 'Regenerate Coupon Code', 'woocommerce-rma-for-return-refund-and-exchange' ) . "</a><img class='regenerate_coupon_code_image' src = " . esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . "admin/image/loading.gif width='20px' style='display:none;'></p>";
				}
			}
		}
		return $html;
	}


	/** Guest Form HTML  */
	public function wps_rma_guest_form() {
		$html         = '';
		$phone_enable = get_option( 'wps_rma_guest_phone' );
		if ( isset( WC()->session ) && WC()->session->get( 'wps_wrma_notification' ) && '' != WC()->session->get( 'wps_wrma_notification' ) ) {
			$html .= '<ul class="woocommerce-error" id="login_session_alert">
					<li><strong>' . esc_html__( 'ERROR', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</strong>: ' . WC()->session->get( 'wps_wrma_notification' ) . '</li>
			</ul>';
			WC()->session->__unset( 'wps_wrma_notification' );
		}
		$html .= '<form class="login wps_rma_guest_form" method="post">
				<input type="hidden" name="get_nonce" value="' . esc_html( wp_create_nonce( 'create_form_nonce' ) ) . '">
				<p>
					<label for="username">' . esc_html__( 'Enter Order Id', 'woocommerce-rma-for-return-refund-and-exchange' ) . '<span class="required"> *</span></label>
					<input type="text" id="order_id" name="order_id" >
				</p>';
		if ( 'on' === $phone_enable ) {
			$html .= '<p>
					<label for="phone_number">' . esc_html__( 'Enter Phone Number', 'woocommerce-rma-for-return-refund-and-exchange' ) . '<span class="required"> *</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="order_phone" id="order_phone" value="">
				</p>';
		} else {
			$html .= '<p>
					<label for="username">' . esc_html__( 'Enter Order Email', 'woocommerce-rma-for-return-refund-and-exchange' ) . '<span class="required"> *</span></label>
					<input type="text"  name="order_email" id="order_email" value="">
				</p>';
		}
		$html .= '<p class="form-row">
				<input type="submit" value="' . esc_html__( 'Submit', 'woocommerce-rma-for-return-refund-and-exchange' ) . '" name="wps_wrma_order_id_submit" class="woocommerce-Button button">
			</p>
		</form>';
		return $html;
	}
}
