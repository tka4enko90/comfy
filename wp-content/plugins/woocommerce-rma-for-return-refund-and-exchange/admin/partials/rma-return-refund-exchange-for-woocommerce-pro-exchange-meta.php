<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link  https://wpswings.com/
 * @since 1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */

/**
 * Show the exchange process related meta.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_int( $thepostid ) ) {
	$thepostid = $post->ID;
}
if ( ! is_object( $theorder ) ) {
	$theorder = wc_get_order( $thepostid );
}
$order_obj        = $theorder;
$order_id         = $order_obj->get_id();
$exchange_details = get_post_meta( $order_id, 'wps_wrma_exchange_product', true );
$wps_fee_cost     = get_post_meta( $order_id, 'ex_ship_amount', true );
$line_items       = $order_obj->get_items();
// Get Pending exchange request.
$get_order_currency = get_woocommerce_currency_symbol( $order_obj->get_currency() );
if ( isset( $exchange_details ) && ! empty( $exchange_details ) ) {
	foreach ( $exchange_details as $date => $exchange_detail ) {
		if ( isset( $exchange_details[ $date ]['subject'] ) ) {
				$approve_date = date_create( $date );
				$date_format  = get_option( 'date_format' );
				$approve_date = date_format( $approve_date, $date_format );
				$pending_date = '';
			if ( 'pending' === $exchange_detail['status'] ) {
				$pending_date = $date;
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

			if ( isset( $wps_fee_cost ) ) {
				$exchange_fees = $wps_fee_cost;
			} else {
				$exchange_fees = array();
			}
				$exchange_status  = $exchange_detail['status'];
				$exchange_reason  = $exchange_detail['reason'];
				$exchange_subject = $exchange_detail['subject'];

				esc_html_e( 'Following product exchange request is made on', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> <b><?php echo esc_html( $approve_date ); ?>.</b>

				<div>
					<div>
					<p><b><?php esc_html_e( 'Exchanged Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></b></p>
					<table class="wps-wrma__order-exchange-table wps_wrma_order_exchange">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Item', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Name', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Cost', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Qty', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if ( isset( $exchange_products ) && ! empty( $exchange_products ) ) {
							$selected_total_price = 0;
							foreach ( $exchange_products as $key => $exchanged_product ) {
								foreach ( $order_obj->get_items() as $item_id => $item ) {
									if ( $exchanged_product['item_id'] == $item_id ) {
										if ( $item->get_variation_id() ) {
											$product_id = $item->get_variation_id();
										} else {
											$product_id = $item->get_product_id();
										}
										$product = wc_get_product( $product_id );
										?>
										<tr>
											<td class="thumb">
												<?php echo '<div class="wc-order-item-thumbnail">' . wp_get_attachment_image( $product->get_image_id(), 'thumbnail' ) . '</div>'; ?>
											</td>
											<td>
												<?php
													echo esc_html( $product->get_name() );
												if ( ! empty( $product->get_sku() ) ) {
													echo '<div class="wc-order-item-sku"><strong>' . esc_html__( 'SKU:', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</strong> ' . esc_html( $product->get_sku() ) . '</div>';
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
												$item_meta = new WC_Order_Item_Product( $item, $product );
												wc_display_item_meta( $item_meta );
												?>
											</td>
											<td><?php echo wp_kses_post( wps_wrma_format_price( $exchanged_product['price'], $get_order_currency ) ); ?></td>
											<td><?php echo esc_html( $exchanged_product['qty'] ); ?></td>
											<td><?php echo wp_kses_post( wps_wrma_format_price( $exchanged_product['price'] * $exchanged_product['qty'], $get_order_currency ) ); ?></td>
										</tr>
										<?php
										$selected_total_price += $exchanged_product['price'] * $exchanged_product['qty'];
									}
								}
							}
						}
						?>
							<tr>
								<th colspan="4"><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php echo wp_kses_post( wps_wrma_format_price( $selected_total_price, $get_order_currency ) ); ?></th>
							</tr>
						</tbody>
					</table>	
				</div>
				<div class="wps_wrma_order_requested_wrap">
					<p><b><?php esc_html_e( 'Requested Product', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></b></p>
					<table class="wps-wrma__order-exchange-table wps_wrma_order_requested">
						<thead>
							<tr>
								<th><?php esc_html_e( 'Item', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Name', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Cost', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Qty', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php
						$wps_woo_tax_enable_setting       = get_option( 'woocommerce_calc_taxes' );
						$wps_woo_tax_display_shop_setting = get_option( 'woocommerce_tax_display_shop' );
						$wps_wrma_tax_test                = false;
						if ( isset( $exchange_to_products ) && ! empty( $exchange_to_products ) ) {
							$total_price = 0;
							foreach ( $exchange_to_products as $key => $exchange_to_product ) {
								$variation_attributes = array();

								// Variable Product.
								if ( isset( $exchange_to_product['variation_id'] ) ) {
									if ( $exchange_to_product['variation_id'] ) {
										$variation_product    = wc_get_product( $exchange_to_product['variation_id'] );
										$variation_attributes = $variation_product->get_variation_attributes();
										$variation_labels     = array();
										foreach ( $variation_attributes as $label => $value ) {
											if ( is_null( $value ) || '' == $value ) {
												$variation_labels[] = $label;
											}
										}

										if ( isset( $exchange_to_product['variations'] ) && ! empty( $exchange_to_product['variations'] ) ) {
											$variation_attributes = $exchange_to_product['variations'];
										}
										if ( 'yes' === $wps_woo_tax_enable_setting ) {
											$wps_wrma_tax_test = true;
											if ( isset( $exchange_to_product['price'] ) ) {
												$exchange_to_product_price = $exchange_to_product['price'];
											} else {
												$exchange_to_product_price = wc_get_price_including_tax( $variation_product );
											}
										} else {
											$exchange_to_product_price = $exchange_to_product['price'];
										}
									} $product = wc_get_product( $exchange_to_product['variation_id'] );
								} else {
									$product = wc_get_product( $exchange_to_product['id'] );

									if ( 'yes' === $wps_woo_tax_enable_setting ) {
										$wps_wrma_tax_test = true;
										if ( isset( $exchange_to_product['price'] ) ) {
											$exchange_to_product_price = $exchange_to_product['price'];
										} else {
											$exchange_to_product_price = wc_get_price_including_tax( $product );
										}
									} else {
										$exchange_to_product_price = $exchange_to_product['price'];
									}
								}
								// Grouped Product.
								if ( isset( $exchange_to_product['p_id'] ) ) {
									if ( $exchange_to_product['p_id'] ) {
										$grouped_product       = new WC_Product_Grouped( $exchange_to_product['p_id'] );
										$grouped_product_title = $grouped_product->get_title();
									}
								}

								$pro_price    = $exchange_to_product['qty'] * $exchange_to_product_price;
								$total_price += $pro_price;
								?>
								<tr>
									<td>
										<?php
										if ( isset( $exchange_to_product['p_id'] ) ) {
											echo wp_kses_post( $grouped_product->get_image() );
										} elseif ( isset( $variation_attributes ) && ! empty( $variation_attributes ) ) {
											echo wp_kses_post( $variation_product->get_image() );
										} else {
											echo wp_kses_post( $product->get_image() );
										}
										?>
										</span>
									</td>
									<td>
										<?php
										if ( isset( $exchange_to_product['p_id'] ) ) {
											echo esc_html( $grouped_product_title ) . ' -> ';
										}
											echo esc_html( $product->get_title() );
										if ( $product && $product->get_sku() ) {
											echo '<div class="wc-order-item-sku"><strong>' . esc_html__( 'SKU:', 'woocommerce-rma-for-return-refund-and-exchange' ) . '</strong> ' . esc_html( $product->get_sku() ) . '</div>';
										}
										if ( isset( $variation_attributes ) && ! empty( $variation_attributes ) ) {
											echo wp_kses_post( wc_get_formatted_variation( $variation_attributes ) );
										}
										?>
									</td>
									<td><?php echo wp_kses_post( wps_wrma_format_price( $exchange_to_product_price, $get_order_currency ) ); ?></td>
									<td><?php echo esc_html( $exchange_to_product['qty'] ); ?></td>
									<td><?php echo wp_kses_post( wps_wrma_format_price( $pro_price, $get_order_currency ) ); ?></td>
								</tr>
								<?php
							}
						}
						?>
							<tr>
								<th colspan="4"><?php esc_html_e( 'Total', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
								<th><?php echo wp_kses_post( wps_wrma_format_price( $total_price, $get_order_currency ) ); ?></th>
							</tr>
						</tbody>
					</table>	
				</div>
				<div class="wps_wrma_extra_reason wps_wrma_extra_reason_for_exchange">
				<?php
				if ( isset( $wps_fee_cost ) && ! empty( $wps_fee_cost ) ) {
					$flag = false;
					?>
						<p><?php esc_html_e( 'The fees amount is added to the Paid amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></p>
						<?php
						$readonly = '';
						if ( 'complete' === $exchange_status ) {
							$readonly = 'readonly="readonly"';
						}
						?>
						<div id="wps_wrma_exchange_add_fee">
							<?php
							foreach ( $wps_fee_cost as $name_key => $name_value ) {
								if ( ! empty( $name_value ) ) {
									$flag = true;
									?>
									<div class="wps_wrma_add_new_ex_fee1">
										<input type="text" name="wps_wrma_ex_ship_name" value="<?php echo esc_html( $name_key ); ?>" readonly>
										<input type="number" name="wps_wrma_add_new_ex_fee2[]" class="wps_wrma_add_new_ex_fee2" data-name="<?php echo esc_html( $name_key ); ?>" value="<?php echo esc_html( $name_value ); ?>" <?php echo esc_html( $readonly ); ?> required>
									</div>
									<?php
								}
							}
							if ( $flag ) {
								?>
							<input type="button" class="save_ship_ex_cost2" name="save_ship_ex_cost" data-orderid="<?php echo esc_html( $order_id ); ?>" data-date="<?php echo esc_html( $key ); ?>" value="<?php esc_html_e( 'Save', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>">
								<?php
							}
							?>
						</div>
						<?php
						if ( isset( $exchange_fees ) && ! empty( $exchange_fees ) ) {
							if ( is_array( $exchange_fees ) ) {
								foreach ( $exchange_fees as $fee ) {
									if ( ! empty( $fee ) ) {
										$total_price += $fee;
									}
								}
							}
						}
				}

				$wps_cpn_dis = $order_obj->get_discount_total();
				$wps_cpn_tax = $order_obj->get_discount_tax();
				$wps_dis_tot = $wps_cpn_dis + $wps_cpn_tax;
				$wps_dis_tot = 0;
				if ( $total_price - ( $selected_total_price + $wps_dis_tot ) > 0 ) {
					$amo = get_post_meta( $order_id, 'ex_left_amount', true );

					?>
						<p><strong><?php esc_html_e( 'Extra Amount Paid', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> : 
							<?php
							if ( 'complete' === $exchange_status ) {
								echo wp_kses_post( wps_wrma_format_price( $amo, $get_order_currency ) );
							} else {
								echo wp_kses_post( wps_wrma_format_price( $total_price - ( $selected_total_price + $wps_dis_tot ), $get_order_currency ) );
							}
							$up_price = $total_price - ( $selected_total_price + $wps_dis_tot );

							update_post_meta( $order_id, 'ex_left_amount', $up_price );
							?>
						</strong></p>
					<?php
				} else {
					if ( $wps_dis_tot > $total_price ) {
						$total_price = 0;
					} else {
						$total_price = $total_price - $wps_dis_tot;
					}
					?>
					<p class="ex_left_amount_para"><strong><i><?php esc_html_e( 'Left Amount After Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></i> : 
						<?php
						$up_price = get_post_meta( $order_id, 'ex_left_amount', true );

						if ( 'complete' === $exchange_status ) {
							echo wp_kses_post( wps_wrma_format_price( $up_price, $get_order_currency ) );
						} else {
							echo wp_kses_post( wps_wrma_format_price( $selected_total_price - $total_price, $get_order_currency ) );
						}
						$up_price = $selected_total_price - $total_price;

						update_post_meta( $order_id, 'ex_left_amount', $up_price );
						?>
						</strong>
							<input type="hidden" name="wps_wrma_left_amount_for_refund" class="wps_wrma_left_amount_for_refund" value="<?php echo esc_html( $selected_total_price - $total_price ); ?>">
						</p>
						<?php
				}
				?>
				<div class="wps_wrma_reason">	
					<p class="ex_left_amount_subject"><strong><?php esc_html_e( 'Subject', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> :</strong><i> <?php echo esc_html( $exchange_subject ); ?></i></p>
					<?php
					if ( isset( $exchange_reason ) && ! empty( $exchange_reason ) ) {
						echo '<p><b>' . esc_html__( 'Reason', 'woocommerce-rma-for-return-refund-and-exchange' ) . ': </b></p>';
						echo '<p>' . esc_html( $exchange_reason ) . '</p>';
					}
					?>
					<?php
					$bank_details = get_post_meta( $order_id, 'wps_rma_bank_details', true );
					if ( ! empty( $bank_details ) ) {
						?>
						<p><strong><?php esc_html_e( 'Bank Details', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> :</strong><i> <?php echo esc_html( $bank_details ); ?></i></p></p>
						<?php
					}
					$req_attachments = get_post_meta( $order_id, 'wps_wrma_exchange_attachment', true );

					if ( isset( $req_attachments ) && ! empty( $req_attachments ) ) {
						?>
					<p><b><?php esc_html_e( 'Attachment', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> :</b></p>
						<?php
						if ( is_array( $req_attachments ) ) {
							foreach ( $req_attachments as $da => $attachments ) {
								$count = 1;
								foreach ( $attachments['files'] as $attachment ) {
									if ( $attachment != $order_id . '-' ) {
										?>
									<a href="<?php echo esc_html( content_url() . '/attachment/' ); ?><?php echo esc_html( $attachment ); ?>" target="_blank"><?php esc_html_e( 'Attachment', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>-<?php echo esc_html( $count ); ?></a>
										<?php
										$count++;
									}
								}
								break;
							}
						}
					}
					if ( 'pending' === $exchange_status ) {
						$wps_wrma_enable_return_ship_label = get_option( 'wps_wrma_enable_return_ship_label', 'no' );
						if ( 'on' === $wps_wrma_enable_return_ship_label ) {
							?>
						<p><b><?php esc_html_e( 'Return Ship Label Attachment :', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></b></p> 
							<?php
							$wps_wrma_return_upload_button_exchange = esc_html__( 'Upload', 'woocommerce-rma-for-return-refund-and-exchange' );
							$return_label_name_exchange             = get_post_meta( $order_id, 'wps_return_label_attachment_exchange_name', true );
							if ( '' != $return_label_name_exchange ) {
								?>
							<span><b>Uploaded Attachment :</b></span>
							<a href="<?php echo esc_html( content_url() . '/return-label-attachments-exchange/' . $return_label_name_exchange ); ?>" target="_blank"><?php esc_html_e( 'Return Label Attachment', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></a><br><br>
								<?php
								$wps_wrma_return_upload_button_exchange = __( 'Change Attachment', 'woocommerce-rma-for-return-refund-and-exchange' );
							}
							$wps_wrma_enable_return_ship_station_label    = get_option( 'wps_wrma_enable_return_ship_station_label', true );
							$wps_wrma_enable_ss_return_ship_station_label = get_option( 'wps_wrma_enable_ss_return_ship_station_label', true );
							if ( 'on' === $wps_wrma_enable_return_ship_station_label || 'on' === $wps_wrma_enable_ss_return_ship_station_label ) {
								if ( ! empty( get_option( ' wps_wrma_saved_carriers ' ) ) || ! empty( get_option( ' wps_wrma_ship_saved_carriers ' ) ) ) :
									?>
								<div id="wps_wrma_return_ship_attchment_div">      
									<p class="description"><?php esc_html_e( 'Validate your Return label attachment here.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
									</p>
									<input type="hidden" name="return_type" value="exchange" />
									<?php $nonce = wp_create_nonce( 'save_button_nonce' ); ?>
									<input type="hidden" name="message-save_button_nonce" value="<?php echo esc_attr( $nonce ); ?>" />
									<input type="submit" name="wps_wrma_save_button" class="button save_order button-primary" value="<?php esc_html_e( 'Create Return Label', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>" >
								</div>
									<?php
							endif;
							} else {
								$attach_message = get_post_meta( $order_id, 'wps_wrma_exchange_attachment_error', true );
								if ( isset( $attach_message ) && ! empty( $attach_message ) ) {
									?>
							<p class="wps_wrma_retrn_attac_error">  <span class="wps_wrma_retrn_close">X</span> <?php echo esc_html( $attach_message ); ?></p> <?php } ?>
							<div id="wps_wrma_return_ship_attchment_div">      
								<p class="description"><?php esc_html_e( 'Upload your Return label attachment here.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></p>
								<input type="file" id="wps_return_label_attachment_exchange" name="wps_return_label_attachment_exchange" value="" size="25" />
								<input type="submit" name="save" class="button save_order button-primary" value="<?php echo esc_html( $wps_wrma_return_upload_button_exchange ); ?>" id='wps_wrma_save_button'> 
							</div>
								<?php
							}
						}
					}
					if ( 'pending' === $exchange_status ) {
						?>
						<p>
							<input type="button" class="button button-primary" value="<?php esc_html_e( 'Accept Request', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>"  id="wps_wrma_accept_exchange" data-orderid="<?php echo esc_html( $order_id ); ?>" data-date="<?php echo esc_html( $date ); ?>">
							<input type="button" class="button button-primary" value="<?php esc_html_e( 'Cancel Request', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>"  id="wps_wrma_cancel_exchange" data-orderid="<?php echo esc_html( $order_id ); ?>" data-date="<?php echo esc_html( $date ); ?>">
						</p>
							<?php
					}
					?>
						</div>
						<div class="wps_wrma_exchange_loader">
							<img src="<?php echo esc_html( site_url() . '/wp-admin/images/spinner-2x.gif' ); ?>">
						</div>
						</div>	
					</div>
					<p>
					<?php
					if ( 'complete' === $exchange_detail['status'] ) {
						$extra_amount = $total_price - $selected_total_price + $wps_dis_tot;
						$left_amount  = get_post_meta( $order_id, 'wps_wrma_left_amount', true );
						if ( isset( $left_amount ) && null != $left_amount && $left_amount > 0 && $extra_amount < 0 ) {

							?>
							<p><strong>
							<?php
							esc_html_e( 'Refundable Amount of this order is ', 'woocommerce-rma-for-return-refund-and-exchange' );
							echo wp_kses_post( wps_wrma_format_price( $left_amount, $get_order_currency ) );
							?>
							</strong><input type="button" class="button button-primary" name="wps_wrma_left_amount" id="wps_wrma_left_amount" data-orderid="<?php echo esc_html( $order_id ); ?>" Value="<?php esc_html_e( 'Refund Amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>" ></p>
							<input type="hidden" name="left_amount" id="left_amount" value="<?php echo esc_html( $left_amount ); ?>">
							<?php

						}
						$approve_date = date_create( $exchange_detail['approve'] );
						$date_format  = get_option( 'date_format' );
						$approve_date = date_format( $approve_date, $date_format );

						esc_html_e( 'Above product exchange request is approved on', 'woocommerce-rma-for-return-refund-and-exchange' );
						?>
						<b><?php echo esc_html( $approve_date ); ?>.</b>
						<?php

						$exhanged_order_id = get_post_meta( $order_id, 'new_order_id', true );

						?>
						</p><p><?php esc_html_e( 'A new order is generated for your exchange request.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
						<a href="<?php echo esc_html( home_url( "wp-admin/post.php?post=$exhanged_order_id&action=edit" ) ); ?>">Order #<?php echo esc_html( $exhanged_order_id ); ?></a>
						<?php
						$wps_wrma_manage_stock_for_exchange = get_post_meta( $order_id, 'wps_wrma_manage_stock_for_exchange', true );
						if ( '' == $wps_wrma_manage_stock_for_exchange ) {
							$wps_wrma_manage_stock_for_exchange = 'yes';
						}
						$get_auto_stock_exchange = get_option( 'wps_rma_auto_exchange_stock' );
						$manage_stock            = get_option( 'wps_rma_exchange_manage_stock' );
						if ( 'on' === $manage_stock && 'yes' === $wps_wrma_manage_stock_for_exchange ) {
							?>
							<div><?php esc_html_e( 'When Product Back in stock then for stock management-click on ', 'woocommerce-rma-for-return-refund-and-exchange' ); ?> <input type="button" class="button button-primary" name="wps_wrma_stock_back" id="wps_wrma_stock_back" data-type="wps_wrma_exchange" data-orderid="<?php echo esc_html( $order_id ); ?>" Value="<?php esc_html_e( 'Manage Stock', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>" ></div> 
							<?php
						}
					}
					if ( 'cancel' === $exchange_detail['status'] ) {
						$approve_date = date_create( $exchange_detail['cancel_date'] );
						$approve_date = date_format( $approve_date, 'F d, Y' );
						?>
						</p><p>
						<?php
						esc_html_e( 'Above product exchange request is cancelled on ', 'woocommerce-rma-for-return-refund-and-exchange' );
						?>
						<b><?php echo esc_html( $approve_date ); ?>.</b>
						<?php
					}
					?>
					</p>
					<hr/>
					<?php
		}
	}
} else {
	$page_id      = get_option( 'wps_rma_exchange_req_page', true );
	$exchange_url = get_permalink( $page_id );
	$exchange_url = add_query_arg( 'order_id', $order_obj->get_id(), $exchange_url );
	$exchange_url = wp_nonce_url( $exchange_url, 'wps_rma_nonce', 'wps_rma_nonce' );
	?>
<p><?php esc_html_e( 'No request from customer', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></p>
<a target="_blank" class="button button-primary" href="<?php echo esc_html( $exchange_url ); ?>"> <b><?php esc_html_e( 'Initiate Exchange Request', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></b></a>
	<?php
}
