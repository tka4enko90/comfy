<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/public/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! is_user_logged_in() ) {
	$guest_user = true;
} else {
	$guest_user = false;
}
if ( isset( $_GET['wps_rma_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['wps_rma_nonce'] ) ), 'wps_rma_nonce' ) && isset( $_GET['order_id'] ) && ( $guest_user || current_user_can( 'wps-rma-exchange-request' ) ) ) {
	$order_id = sanitize_text_field( wp_unslash( $_GET['order_id'] ) );
} else {
	$order_id = '';
}

if ( ! empty( $order_id ) ) {
	$order_obj = wc_get_order( $order_id );
	if ( ! empty( $order_obj ) ) {
		$condition = wps_rma_show_buttons( 'exchange', $order_obj );
	} else {
		$condition = esc_html__( 'Please give the correct order id', 'woocommerce-rma-for-return-refund-and-exchange' );
	}
}
$rr_subject = '';
$rr_reason  = '';
if ( isset( $condition ) && 'yes' === $condition && isset( $order_id ) && ! empty( $order_id ) && ! empty( $order_obj ) ) {
	$order_customer_id = get_post_meta( $order_id, '_customer_user', true );
	if ( ! current_user_can( 'wps-rma-exchange-request' ) ) {
		if ( get_current_user_id() != $order_customer_id ) {
			$myaccount_page     = get_option( 'woocommerce_myaccount_page_id' );
			$myaccount_page_url = get_permalink( $myaccount_page );
			$condition          = wp_kses_post( "This order #$order_id is not associated to your account. <a href='$myaccount_page_url'>Click Here</a>" );
		}
	}
}
get_header( 'shop' );

if ( 'on' === get_option( 'wps_rma_show_sidebar' ) ) {
	// Woo Sidebar.
	do_action( 'woocommerce_before_main_content' );
}
if ( isset( $condition ) && 'yes' === $condition ) {
	// Get Exchange product.
	if ( null != WC()->session->get( 'exchange_requset' ) ) {
		$exchange_details = WC()->session->get( 'exchange_requset' );
	} else {
		$exchange_details = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
	}
	WC()->session->set( 'exchange_requset', $exchange_details );
	// Get pending exchange request.
	if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
		foreach ( $exchange_details as $date => $exchange_detail ) {
			if ( $exchange_detail['status'] && 'pending' === $exchange_detail['status'] ) {
				if ( isset( $exchange_detail['subject'] ) ) {
					$subject = $exchange_details[ $date ]['subject'];
				}
				if ( isset( $exchange_detail['reason'] ) ) {
					$reason = $exchange_details[ $date ]['reason'];
				}
				if ( isset( $exchange_detail['from'] ) ) {
					$exchange_products = $exchange_detail['from'];
				} else {
					$exchange_products = array();
				}
				if ( isset( $exchange_detail['to'] ) ) {
					$exchange_to_products = $exchange_detail['to'];
				} else {
					$exchange_to_products = array();
				}
			}
		}
	}
	// End.
	$show_purchase_note = $order_obj->has_status(
	// Get the order purchase note.
		apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) )
	);
	$show_customer_details       = is_user_logged_in() && $order_obj->get_user_id() === get_current_user_id();
	$wps_main_wrapper_class      = get_option( 'wps_wrma_exchange_form_wrapper_class' );
	$wps_exchange_css            = get_option( 'wps_rma_exchange_form_css' );
	$get_wps_rnx_global_shipping = get_option( 'wps_wrma_shipping_global_data', array() );
	$return_datas                = get_option( $order_id . 'wps_rma_refunded_pro_qty', array() );

	?>
	<style>	<?php echo wp_kses_post( $wps_exchange_css ); ?>	</style>
	<div class="wps-rma-form__wrapper <?php echo esc_html( $wps_main_wrapper_class ); ?>" id="wps_wrma_exchange_request_form_wrapper">
		<div id="wps_wrma_exchange_request_container" class="wps-rma-form__header">
			<h1 class="wps-rma-form__heading">
			<?php
				echo esc_html__( 'Order\'s Product Exchange Request Form', 'woocommerce-rma-for-return-refund-and-exchange' );
			?>
			</h1>
		</div>
		<ul id="wps-exchange-alert"></ul>
		<input type="hidden" id="wps_rma_exchange_request_order" value="<?php echo esc_html( $order_id ); ?>">
		<div class="wps_wrma_product_table_wrapper wps-rma-product__table-wrapper">
			<table class="wps_wrma_product_table wps-rma-product__table">
				<thead>
					<tr>
						<th class="product-check"><input type="checkbox" checked name="wps_rma_exchange_product_all" class="wps_rma_exchange_product_all"> <?php esc_html_e( 'Check All', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th class="product-qty"><?php esc_html_e( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th class="product-total"><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$get_order_currency = get_woocommerce_currency_symbol( $order_obj->get_currency() );
					$wps_rma_check_tax  = get_option( $order_id . 'check_tax', false );

					foreach ( $order_obj->get_items() as $item_id => $item ) {
						$item_quantity = $item->get_quantity();
						$refund_qty    = $order_obj->get_qty_refunded_for_item( $item_id );
						$item_qty      = $item->get_quantity() + $refund_qty;
						if ( $item_qty > 0 ) {
							if ( isset( $item['variation_id'] ) && $item['variation_id'] > 0 ) {
								$variation_id = $item['variation_id'];
								$product_id   = $item['product_id'];
							} else {
								$product_id = $item['product_id'];
							}
							$coupon_discount = get_option( 'wps_rma_exchange_deduct_coupon', 'no' );
							if ( 'on' === $coupon_discount ) {
								$tax_inc = $item->get_total() + $item->get_subtotal_tax();
								$tax_exc = $item->get_total() - $item->get_subtotal_tax();
							} else {
								$tax_inc = $item->get_subtotal() + $item->get_subtotal_tax();
								$tax_exc = $item->get_subtotal() - $item->get_subtotal_tax();
							}
							if ( empty( $wps_rma_check_tax ) ) {
								if ( 'on' === $coupon_discount ) {
									$wps_actual_price = $item->get_total();
								} else {
									$wps_actual_price = $item->get_subtotal();
								}
							} elseif ( 'wps_rma_inlcude_tax' === $wps_rma_check_tax ) {
								$wps_actual_price = $tax_inc;
							} elseif ( 'wps_rma_exclude_tax' === $wps_rma_check_tax ) {
								$wps_actual_price = $tax_exc;
							}
							$wps_actual_price = number_format( (float) $wps_actual_price, 2, '.', '' );
							$product =
							// Woo Order Item Product.
							apply_filters( 'woocommerce_order_item_product', $item->get_product(), $item );
							$thumbnail     = wp_get_attachment_image( $product->get_image_id(), 'thumbnail' );
							$productdata   = wc_get_product( $product_id );
							$purchase_note = get_post_meta( $product_id, '_purchase_note', true );
							$checked       = '';
							$qty           = 1;
							$product_types = wp_get_object_terms( $product_id, 'product_type' );
							if ( isset( $product_types[0] ) ) {
								$product_type = $product_types[0]->slug;
								if ( 'wgm_gift_card' === $product_type || 'gw_gift_card' === $product_type ) {
									$show          = false;
									$alert_message = esc_html__( 'Your Giftcard cannot be exchanged.', 'woocommerce-rma-for-return-refund-and-exchange' );
									update_post_meta( $order_id, 'wps_wrma_giftware_exchange_reason', $alert_message );
								}
							}
							?>
							<tr class="wps_rma_exchange_column" data-productid="<?php echo esc_html( $product_id ); ?>" data-variationid="<?php echo esc_html( $item['variation_id'] ); ?>" data-itemid="<?php echo esc_html( $item_id ); ?>">
								<td class="product-select">
									<?php
										$check_sale_item = get_option( 'wps_rma_exchange_on_sale', 'no' );

									?>
										<?php
										$exclude_prod = wps_rma_exclude_product( $product_id, 'exchange' );
										if ( ( 'on' !== $check_sale_item && wc_get_product( $product )->is_on_sale() ) || ! $exclude_prod ) {
											echo '<img class="disable-return" src="' . esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ) . '/public/images/return-disable.png">';
										} else {
											if ( null != WC()->session->get( 'exchange_requset' ) ) {
												$exchange_details = WC()->session->get( 'exchange_requset' );
											} else {
												$exchange_details = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
											}
											$checked = '';
											if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
												foreach ( $exchange_details as $key => $value ) {
													if ( isset( $value['from'] ) && ! empty( $value['from'] ) ) {
														foreach ( $value['from'] as $key => $value ) {
															if ( $value['item_id'] == $item_id ) {
																$checked = 'checked';
															}
														}
													}
												}
											}
											?>
											<input type="checkbox" class="wps_rma_exchange_product" <?php echo esc_html( $checked ); ?> data-item_id="<?php echo esc_html( $item_id ); ?>" value="<?php echo esc_html( $wps_actual_price / $item->get_quantity() ); ?>">
											<?php
										}
										?>
								</td>
								<td class="product-name">
									<div class="wps-rma-product__wrap">
										<?php
										$is_visible        = $product && $product->is_visible();
										$product_permalink =
										// Woo Order item Permalink.
										apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order_obj );

										$thumbnail = wp_get_attachment_image( $product->get_image_id(), 'thumbnail' );
										if ( isset( $thumbnail ) && ! empty( $thumbnail ) ) {
											echo wp_kses_post( $thumbnail );
										} else {
											?>
											<img alt="Placeholder" width="150" height="150" class="attachment-thumbnail size-thumbnail wp-post-image" src="<?php echo esc_html( plugins_url() ); ?>/woocommerce/assets/images/placeholder.png">
											<?php
										}
										?>
										<div class="wps_wrma_product_title wps-rma__product-title">
											<?php
											// Order Item Name.
											echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item['name'] ) : $item['name'], $item, $is_visible ) );
											// Order Item Quanity.
											echo wp_kses_post( apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item['qty'] ) . '</strong>', $item ) );
											?>
											<input type="hidden" class="quanty" value="<?php echo esc_html( $item['qty'] ); ?>">
											<?php
											// Order Item meta start.
											do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order_obj );
											if ( WC()->version < '3.0.0' ) {
												$order_obj->display_item_meta( $item );
												$order_obj->display_item_downloads( $item );
											} else {
												wc_display_item_meta( $item );
												wc_display_item_downloads( $item );
											}
											// // Order Item meta end.
											do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order_obj );
											?>
											<p>
												<b><?php esc_html_e( 'Price', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> : </b>
												<?php
													echo wp_kses_post( wps_wrma_format_price( ( $wps_actual_price / $item->get_quantity() ), $get_order_currency ) );
												?>
												<?php
												if ( 'wps_rma_inlcude_tax' === $wps_rma_check_tax ) {
													?>
													<small class="tax_label"><?php esc_html_e( '(incl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
													<?php
												} elseif ( 'wps_rma_exclude_tax' === $wps_rma_check_tax ) {
													?>
													<small class="tax_label"><?php esc_html_e( '(excl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
													<?php
												}
												?>
											</p>
										</div>
									</div>
								</td>
								<td class="product-quantity">
									<?php echo sprintf( '<input type="number" max="%s" min="1" value="%s" class="wps_rma_exchange_product_qty" name="wps_rma_exchange_product_qty">', esc_html( $item_qty ), esc_html( $qty ) ); ?>
								</td>
								<td class="product-total">
									<span id="wps_rma_total_product_total_ex">
									<?php
									echo wp_kses_post( wps_wrma_format_price( $wps_actual_price / $item->get_quantity(), $get_order_currency ) );
									?>
									</span>
									<?php
									if ( 'wps_rma_inlcude_tax' === $wps_rma_check_tax ) {
										?>
										<small class="tax_label"><?php esc_html_e( '(incl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
										<?php
									} elseif ( 'wps_rma_exclude_tax' === $wps_rma_check_tax ) {
										?>
										<small class="tax_label"><?php esc_html_e( '(excl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
										<?php
									}
									?>
									<input type="hidden" id="quanty" value="<?php echo esc_html( $item_qty ); ?>"> 
								</td>
							</tr>
							<?php
						}
					}
					?>
					<tr>
						<th scope="row" colspan="3"><?php esc_html_e( 'Total Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th class="wps_wrma_total_amount_wrap"><span id="wps_wrma_total_exchange_amount"><?php echo wp_kses_post( wps_wrma_format_price( 0, $get_order_currency ) ); ?></span>
					<?php
					if ( 'wps_rma_inlcude_tax' === $wps_rma_check_tax ) {
						?>
						<small class="tax_label"><?php esc_html_e( '(incl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
							<?php
					} elseif ( 'wps_rma_exclude_tax' === $wps_rma_check_tax ) {
						?>
							<small class="tax_label"><?php esc_html_e( '(excl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
							<?php
					}
					?>
						</th>
					</tr>
				</tbody>
			</table>
			<div class="wps_rma_exchange_notification_checkbox"><img src="<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ); ?>/public/images/loading.gif" width="40px"></div>
		</div>
		<div class="wps-rma-form__row">
			<p class="form-row form-row-wide wps_wrma_exchange_note">
				<?php
				// do someting after exchange table.
				do_action( 'wps_wrma_exchange_after_order_item_table' );
				?>
			</p>
			<p class="wps_rma_exchange_note">
				<i class="wps_rma_exchange_note_icon wps-rma__not-exchange-icon"><img src="<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ); ?>/public/images/return-disable.png" class="wps_rma_exchange_note_img" width="20px">
				</i>
				<span class="wps_rma_exchange_note_text">
					: <?php esc_html_e( 'It means product can\'t be exchanged.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
				</span>
				<span class="wps-wrma-display-block">
					<?php
					$giftware_error_message = get_post_meta( $order_id, 'wps_wrma_giftware_exchange_reason', true );
					if ( isset( $giftware_error_message ) && ! empty( $giftware_error_message ) ) {
						echo wp_kses_post( $giftware_error_message );
					}
					?>
				</span>
			</p>
			<?php
			$item_ids = array();
			foreach ( wc_get_order( $order_id )->get_items() as $item_id => $item ) {
				$item_ids[] = $item_id;
			}
			$show_charges = global_shipping_charges( $order_id, $item_ids );
			if ( $show_charges ) {
				?>
				<div class="ship_show_info">
					<?php
					$wps_wrma_exchange_shipping_fee_desc = empty( get_option( 'wps_rma_exchange_shipping_descr' ) ) ? esc_html__( 'This Extra Shipping Fee Will be Deducted from Total Amount When the Exchange Request is approved', 'woocommerce-rma-for-return-refund-and-exchange' ) : get_option( 'wps_rma_exchange_shipping_descr' );
					$get_wps_rnx_global_shipping         = get_option( 'wps_wrma_shipping_global_data', array() );
					if ( isset( $get_wps_rnx_global_shipping['enable'] ) && 'on' === $get_wps_rnx_global_shipping['enable'] ) {
						echo '<b><i>' . esc_html( $wps_wrma_exchange_shipping_fee_desc ) . '</i></b>';
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
							if ( ! empty( $name_value ) && ! empty( $wps_fee_cost[ $name_key ] ) ) {
								?>
								<tr>
								<?php
								echo '<td>' . esc_html( $name_value ) . '</td><td>' . wp_kses_post( wc_price( $wps_fee_cost[ $name_key ] ) ) . '</td>';
								?>
								</tr>
								<?php
							}
						}
					}
					?>
					</table>
				</div>
				<?php
			}
			?>
			<p id="wps_wrma_variation_list"></p>
			<?php
				$choose_product_button = apply_filters( 'wps_wrma_exchange_choose_product_button', esc_html__( 'CHOOSE PRODUCTS', 'woocommerce-rma-for-return-refund-and-exchange' ) );
			?>
			<p id="wps_wrma_variation_list"></p>
			<p class="form-row form-row-wide ">
				<a class="wps_wrma_exhange_shop" href="javascript:void(0);">
					<input type="button" class="button btn wps_wrma_exhange_shop" name="wps_wrma_exhange_shop"  id="wps_wrma_exhange_shop" value="<?php echo esc_html( $choose_product_button ); ?>" class="input-text">
					<span class="wps_rma_exchange_notification_choose_product "><img src="<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ); ?>/public/images/loading.gif" width="20px"></span>
				</a>
			</p>
			<?php
			$total_price = 0;
			if ( isset( $exchange_to_products ) && ! empty( $exchange_to_products ) ) {
				?>
			<div class="wps_wrma_exchanged_products_wrapper">
				<table class="shop_table order_details  wps_wrma_exchanged_products wps_wrma_product_table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							<th><?php esc_html_e( 'Quantity', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							<th><?php esc_html_e( 'Price', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							<th><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							<th><?php esc_html_e( 'Remove', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ( $exchange_to_products as $key => $exchange_to_product ) {
							$props                            = array();
							$variation_attributes             = array();
							$wps_woo_tax_enable_setting       = get_option( 'woocommerce_calc_taxes' );
							$wps_woo_tax_display_shop_setting = get_option( 'woocommerce_tax_display_shop' );
							$wps_wrma_tax_test                = false;
							if ( isset( $exchange_to_product['variation_id'] ) ) {
								if ( $exchange_to_product['variation_id'] ) {
									$variation_product    = wc_get_product( $exchange_to_product['variation_id'] );
									$variation_attributes = $variation_product->get_variation_attributes();
									$variation_attributes = isset( $exchange_to_product['variations'] ) ? $exchange_to_product['variations'] : $variation_product->get_variation_attributes();
									$variation_labels     = array();
									foreach ( $variation_attributes as $label => $value ) {
										if ( is_null( $value ) || '' == $value ) {
											$variation_labels[] = $label;
										}
									}
									if ( count( $variation_labels ) ) {
										$item_type =
										// Order Item type.
										apply_filters( 'woocommerce_admin_order_item_types', 'line_item' );
										$all_line_items = $order_obj->get_items( $item_type );
										$var_attr_info  = array();
										foreach ( $all_line_items as $ear_item ) {
											$variation_id = isset( $ear_item['item_meta']['_variation_id'] ) ? $ear_item['item_meta']['_variation_id'][0] : 0;
											if ( $variation_id && $variation_id == $exchange_to_product['variation_id'] ) {
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
									$wps_wrma_thumbnail = wp_get_attachment_image_src( $variation_product->get_image_id(), 'thumbnail' );
									$wps_wrma_thumbnail = $wps_wrma_thumbnail[0];

									$wps_wrma_exchange_to_product_price = $exchange_to_product['price'];

									$product = wc_get_product( $exchange_to_product['variation_id'] );

								}
							} else {
								$product = wc_get_product( $exchange_to_product['id'] );

								$wps_wrma_exchange_to_product_price = $exchange_to_product['price'];

								$wps_wrma_thumbnail = wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' );
								$wps_wrma_thumbnail = $wps_wrma_thumbnail[0];
							}
							if ( isset( $exchange_to_product['p_id'] ) ) {
								if ( $exchange_to_product['p_id'] ) {
									$grouped_product       = new WC_Product_Grouped( $exchange_to_product['p_id'] );
									$grouped_product_title = $grouped_product->get_title();
									$props                 = wc_get_product_attachment_props( get_post_thumbnail_id( $exchange_to_product['p_id'] ), $grouped_product );
								}
							}

							$pro_price    = $exchange_to_product['qty'] * $wps_wrma_exchange_to_product_price;
							$total_price += $pro_price;

							?>
							<tr>
								<td>
								<div class="wps-rma-product__wrap">
							<?php
							if ( isset( $wps_wrma_thumbnail ) && ! is_null( $wps_wrma_thumbnail ) ) {
								?>
								<div class="wps_wrma_prod_img wps-rma__prod-img"><img width="100" height="100" title="
								<?php
								if ( isset( $props['title'] ) && ! empty( $props['title'] ) ) {
									echo esc_html( $props['title'] ); }
								?>
								" alt="" class="attachment-thumbnail size-thumbnail wp-post-image" src="<?php echo esc_html( $wps_wrma_thumbnail ); ?>"></div>
								<?php
							} else {
								?>
								<div class="wps_wrma_prod_img wps-rma__prod-img"><img width="100" height="100" title="
								<?php
								if ( isset( $props['title'] ) && ! empty( $props['title'] ) ) {
									echo esc_html( $props['title'] ); }
								?>
								" alt="" class="attachment-thumbnail size-thumbnail wp-post-image" src="<?php echo esc_html( home_url( '/wp-content/plugins/woocommerce/assets/images/placeholder.png' ) ); ?>"></div>
								<?php
							}

							?>
							<div class="wps_wrma_product_title">
							<?php
							if ( isset( $exchange_to_product['p_id'] ) ) {
								echo wp_kses_post( $grouped_product_title ) . ' -> ';
							}
							echo wp_kses_post( $product->get_title() );
							if ( isset( $variation_attributes ) && ! empty( $variation_attributes ) ) {
								echo wp_kses_post( wc_get_formatted_variation( $variation_attributes ) );
							}
							?>
							</div></div></td>
							<td ><?php echo sprintf( '<input type="number" value="%s" class="wps_rma_exchange_to_product_qty" data-id="%d" name="wps_rma_exchange_product_qty">', esc_html( $exchange_to_product['qty'] ), esc_html( $exchange_to_product['id'] ) ); ?></td>
							<td >
							<?php
							$wps_woo_tax_enable_setting = get_option( 'woocommerce_calc_taxes' );
							echo wp_kses_post( wps_wrma_format_price( $wps_wrma_exchange_to_product_price, $get_order_currency ) );
							if ( 'yes' === $wps_woo_tax_enable_setting ) {
								?>
								<small class="tax_label"><?php esc_html_e( '(incl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
								<?php
							}
							?>
								</div></td>
							<td >
							<?php
							echo wp_kses_post( wps_wrma_format_price( $pro_price, $get_order_currency ) );
							if ( 'yes' === $wps_woo_tax_enable_setting ) {
								?>
								<small class="tax_label"><?php esc_html_e( '(incl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
								<?php
							}
							?>
							</td>
							<td data-key="<?php echo esc_html( $key ); ?>" class="wps_wrma_exchnaged_product_remove"><a class="remove" href="javascript:void(0)">×</a></td>
						</tr>
							<?php
						}
						?>
					</tbody>
					<tfoot class="exchange_product_table_footer">
						<th colspan="4"><?php esc_html_e( 'Total Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						<th colspan="3" id="wps_wrma_exchanged_total_show"> 
						<?php
						echo wp_kses_post( wps_wrma_format_price( $total_price, $get_order_currency ) );
						if ( 'wps_rma_inlcude_tax' === $wps_woo_tax_enable_setting ) {
							?>
							<small class="tax_label"><?php esc_html_e( '(incl. tax)', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></small>
							<?php
						}
						?>
						</th>
					</tfoot>
				</table>	
			</div>
				<?php
			}
			?>
			<div class="wps_wrma_note_rule_wrap wps-rma-refund-request__row">
				<div class="wps-rma-col wps_wrma_note_tag_col">
					<div class="wps_wrma_note_tag_wrapper">
						<input type="text" value="<?php echo esc_html( $total_price ); ?>" id="wps_wrma_exchanged_total" style="display:none;">
						<p class="form-row form-row form-row-wide" id="wps_wrma_exchange_extra_amount">
							<label>
								<b>
									<?php
										$reason_exchange_amount = '<i>' . esc_html__( 'Extra Amount Need to Pay', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</i>';
										// Extra amount text.
										echo wp_kses_post( apply_filters( 'wps_wrma_exchange_extra_amount', $reason_exchange_amount ) );
									?>
									: 
									<span class="wps_wrma_exchange_extra_amount">
										<?php echo wp_kses_post( wps_wrma_format_price( 0, $get_order_currency ) ); ?>
									</span>
								</b>
							</label>
						</p>
						<?php
						$wps_wrma_return_wallet_enable        = get_option( 'wps_rma_wallet_enable', false );
						$wps_wrma_select_refund_method_enable = get_option( 'wps_rma_refund_method', true );
						if ( isset( $wps_wrma_return_wallet_enable ) && 'on' === $wps_wrma_return_wallet_enable && is_user_logged_in() ) {
							if ( isset( $wps_wrma_select_refund_method_enable ) && 'on' === $wps_wrma_select_refund_method_enable ) {
								?>
							<div id="refund_amount_method">
								<label>
									<b>
										<?php esc_html_e( 'Select Amount Refund Method :', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
									</b>
								</label>
								<div>
									<input type="radio" class="wps_wrma_refund_method" name="wps_wrma_refund_method" value="wallet_method" ><span class="wps_wrma_refund_method_input_test" > <?php esc_html_e( 'Refund Into the Wallet', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></span>
								</div>
								<div class=wps_wrma_refund_method-wrap>
									<input type="radio" class="wps_wrma_refund_method" name="wps_wrma_refund_method" value="manual_method"><span class="wps_wrma_refund_method_input_test"> <?php esc_html_e( 'Refund Through Manual Method', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></span>
								</div>
							</div>
								<?php
							}
						}
						$re_bank = get_option( 'wps_rma_refund_manually_de', false );
						if ( 'on' === $re_bank ) {
							?>
							<div id="bank_details">
							<textarea name="" class="wps_rma_bank_details" rows=4 id="wps_rma_bank_details" maxlength="1000" placeholder="<?php esc_html_e( 'Please Enter the bank details for manual refund', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>"></textarea>
							</div>
							<?php
						}
						?>
						<p class="form-row form-row form-row-wide">
							<?php
							// Do someting before subject.
							do_action( 'wps_wrma_exchange_before_exchange_subject' );
							?>
						</p>
						<p class="form-row form-row-wide">
							<label>
								<b>
									<?php
										echo esc_html__( 'Subject of Exchange Request :', 'woocommerce-rma-for-return-refund-and-exchange' );
									?>
								</b>
							</label>
							<?php
							$predefined_exchange_reason = get_option( 'wps_rma_exchange_reasons', false );
							$predefined_exchange_reason = explode( ',', $predefined_exchange_reason );
							if ( isset( $predefined_exchange_reason ) && ! empty( $predefined_exchange_reason ) ) {
								?>
								<div class="wps_wrma_subject_dropdown wps-rma-subject__dropdown">
									<select name="wps_rma_exchange_request_subject" id="wps_rma_exchange_request_subject">
										<?php
										foreach ( $predefined_exchange_reason as $predefine_reason ) {
											if ( ! empty( $predefine_reason ) ) {
												$predefine_reason = trim( $predefine_reason );
												?>
											<option value="<?php echo esc_html( $predefine_reason ); ?>"><?php echo esc_html( $predefine_reason ); ?></option>
												<?php
											}
										}
										?>
										<option value=""><?php esc_html_e( 'Other', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
									</select>
								</div>
								<?php
							}
							?>
						</p>
						<p class="form-row form-row-wide">	
							<input type="text" name="wps_rma_exchange_request_subject" id="wps_rma_exchange_request_subject_text" class="wps_rma_exchange_request_subject" placeholder="<?php esc_html_e( 'Write your exchange reason', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>">
						</p>
						<?php
						$predefined_exchange_desc = get_option( 'wps_rma_exchange_description', false );
						if ( isset( $predefined_exchange_desc ) ) {
							if ( 'on' === $predefined_exchange_desc ) {
								?>
								<p>
									<label>
										<b>
										<?php
											$reason_exchange_request = esc_html__( 'Description for Refund Reason :', 'woocommerce-rma-for-return-refund-and-exchange' );
											// reason of exchange request.
											echo wp_kses_post( apply_filters( 'wps_wrma_exchange_request_reason', $reason_exchange_request ) );
										?>
										</b>
									</label>
									<?php
									$placeholder = get_option( 'wps_rma_exchange_reason_placeholder', 'Reason for Exchange Request' );
									if ( empty( $placeholder ) ) {
										$placeholder = esc_html__( 'Write your description for exchange', 'woocommerce-rma-for-return-refund-and-exchange' );
									}
									?>
									<textarea name="wps_wrma_exchange_request_reason" cols="40" style="height: 222px;" class="wps_wrma_exchange_request_reason form-control" placeholder="<?php echo esc_html( $placeholder ); ?>"></textarea>
								</p>

								<?php
							} else {
								?>
								<input type="hidden" name="wps_wrma_exchange_request_reason" class="wps_wrma_exchange_request_reason form-control" value="<?php esc_html_e( 'No Reason Enter', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>">
								<?php
							}
						} else {
							?>
							<input type="hidden" name="wps_wrma_exchange_request_reason" class="wps_wrma_exchange_request_reason form-control" value="<?php esc_html_e( 'No Reason Enter', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>">
							<?php
						}
						?>
						<form action="" method="post" id="wps_rma_exchnage_request_form" data-orderid="<?php echo esc_html( $order_id ); ?>" data-date="<?php echo esc_html( gmdate( 'd-m-Y' ) ); ?>" enctype="multipart/form-data">
							<?php
							$exchange_attachment = get_option( 'wps_rma_exchange_attachment', 'no' );
							$attach_limit        = get_option( 'wps_rma_exchange_attachment_limit', false );
							if ( empty( $attach_limit ) ) {
								$attach_limit = 5;
							}
							if ( isset( $exchange_attachment ) && ! empty( $exchange_attachment ) ) {
								if ( 'on' === $exchange_attachment ) {
									?>
									<p class="form-row form-row form-row-wide">
										<label><b><?php esc_html_e( 'Attach Files', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></b></label>
										<p>
											<span id="wps_rma_exchange_request_files">
												<input type="hidden" name="wps_wrma_return_request_order" value="<?php echo esc_html( $order_id ); ?>">
												<input type="hidden" name="action" value="wps_wrma_exchange_upload_files">
												<input type="file" name="wps_wrma_exchange_request_files[]" class="wps_rma_exchange_request_files">
											</span>
										</p>
										<div>
											<input type="button" value="<?php esc_html_e( 'Add More', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>" class="btn button wps_rma_exchange_request_morefiles" data-count="1" data-max="<?php echo esc_html( $attach_limit ); ?>">
										</div>
										<i><?php esc_html_e( 'Only .png, .jpeg extension file is supported.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></i>
									</p>
									<?php
								}
							}
							?>
							<p class="form-row form-row form-row-wide">
								<input type="submit" class="button btn wps_wrma_exchange_request_submit" name="wps_wrma_exchange_request_submit" value="<?php esc_html_e( 'Submit Request', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>" data-date="<?php echo esc_html( gmdate( 'd-m-Y' ) ); ?>"  class="input-text">
								<div class="wps_rma_exchange_notification"><img src="<?php echo esc_html( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_URL ); ?>/public/images/loading.gif" width="40px"></div>
							</p>
						</form>
						<br/>
						<p class="form-row form-row form-row-wide">
							<?php
							// do something after exchange submit button.
							do_action( 'wps_wrma_exchange_after_submit_button' );
							?>
						</p>
					</div>
				</div>
				<?php
				$exchange_rules_enable = get_option( 'wps_rma_exchange_rules', 'no' );
				$exchange_rules        = get_option( 'wps_rma_exchange_rules_editor', '' );
				if ( isset( $exchange_rules_enable ) && 'on' === $exchange_rules_enable && ! empty( $exchange_rules ) ) {
					?>
					<div class="wps-rma-col wps-wrma-txt-col wps_rma_flex">
						<div>
						<?php
						echo wp_kses_post( $exchange_rules );
						?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
			<div class="wps_rma_customer_detail">
			<?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $order_obj ) ); ?>
		</div>
	</div>
	<?php
} else {
	if ( isset( $condition ) ) {
		echo wp_kses_post( $condition );
	} else {
		echo esc_html__( 'Exchange Request Can\'t make on this order', 'woocommerce-rma-for-return-refund-and-exchange' );
	}
}
/**
 * Woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
if ( 'on' === get_option( 'wps_rma_show_sidebar' ) ) {
	// Woo Sidebar.
	do_action( 'woocommerce_after_main_content' );
}


get_footer( 'shop' );

?>
