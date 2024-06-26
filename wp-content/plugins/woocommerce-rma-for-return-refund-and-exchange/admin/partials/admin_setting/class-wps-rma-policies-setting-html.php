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
 * The admin-specific functionality of the plugin.
 *
 * Extend the setting in the RMA POLICIES TAB.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */
class Wps_Rma_Policies_Setting_Html {

	/**
	 * Extend the functionality.
	 *
	 * @param string $value .
	 */
	public function wps_rma_setting_extend_show_column1_set( $value ) {
		?>
		<option value="exchange" <?php selected( 'exchange', $value ); ?>><?php esc_html_e( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<option value="cancel" <?php selected( 'cancel', $value ); ?>><?php esc_html_e( 'Cancel', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<?php
	}

	/**
	 * Extend the functionality.
	 */
	public function wps_rma_setting_extend_column1_set() {
		?>
		<option value="exchange" ><?php esc_html_e( 'Exchange', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<option value="cancel" ><?php esc_html_e( 'Cancel', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<?php
	}

	/**
	 * Extend the row policy.
	 */
	public function wps_rma_setting_extend_column3_set() {
		?>
		<option value="wps_rma_min_order" ><?php esc_html_e( 'Minimum Order', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<option value="wps_rma_exclude_via_categories" ><?php esc_html_e( 'Exclude Categories', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<option value="wps_rma_exclude_via_products" ><?php esc_html_e( 'Exclude Products', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<?php
	}

	/**
	 *  Extend the row policy.
	 *
	 * @param string $value .
	 */
	public function wps_rma_setting_extend_show_column3_set( $value ) {
		?>
		<option value="wps_rma_min_order" <?php selected( 'wps_rma_min_order', $value ); ?>><?php esc_html_e( 'Minimum Order', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<option value="wps_rma_exclude_via_categories" <?php selected( 'wps_rma_exclude_via_categories', $value ); ?>><?php esc_html_e( 'Exclude Categories', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<option value="wps_rma_exclude_via_products" <?php selected( 'wps_rma_exclude_via_products', $value ); ?>><?php esc_html_e( 'Exclude Products', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
		<?php
	}

	/**
	 *  Extend the settings.
	 *
	 * @param string $value .
	 * @param string $count .
	 */
	public function wps_rma_setting_extend_show_column5_set( $value, $count ) {
		$all_cat   = get_terms( 'product_cat', array( 'hide_empty' => 0 ) );
		$cat_name = array();
		if ( $all_cat ) {
			foreach ( $all_cat as $cat ) {
				$cat_name[ $cat->term_id ] = $cat->name;
			}
		}
		$all_products_ids = get_posts(
			array(
				'post_type'   => 'product',
				'numberposts' => -1,
				'post_status' => 'publish',
				'fields'      => 'ids',
			)
		);
		?>
		<select name="wps_rma_setting[<?php echo esc_html( $count ); ?>][row_ex_cate][]" class="wps_rma_ex_cate" multiple>   
			<?php
			foreach ( $cat_name as $key => $cat_name ) {
				?>
			<option value="<?php echo esc_html( $key ); ?>"
					<?php
					if ( isset( $value['row_ex_cate'] ) && ! empty( $value['row_ex_cate'] ) ) {
						echo in_array( $key, $value['row_ex_cate'] ) ? 'selected' : '';
					}
					?>
				>
					<?php echo esc_html( $cat_name ); ?>
				</option>
					<?php
			}
			?>
		</select>
		<select name="wps_rma_setting[<?php echo esc_html( $count ); ?>][row_ex_prod][]" class="wps_rma_ex_prod" multiple>   
			<?php
			foreach ( $all_products_ids as $key => $product_id ) {
				$product = wc_get_product( $product_id );
				?>
				<option value="<?php echo esc_html( $product_id ); ?>"
					<?php
					if ( isset( $value['row_ex_prod'] ) && ! empty( $value['row_ex_prod'] ) ) {
						echo in_array( $product_id, $value['row_ex_prod'] ) ? 'selected' : '';
					}
					?>
					>
					<?php echo wp_kses_post( '(' . $product_id . ') ' . $product->get_title() ); ?>
				</option>
			<?php } ?>
		</select>

		<?php
	}

	/**
	 *  Extend the settings.
	 */
	public function wps_rma_setting_extend_column5_set() {
		$all_cat  = get_terms( 'product_cat', array( 'hide_empty' => 0 ) );
		$cat_name = array();
		if ( $all_cat ) {
			foreach ( $all_cat as $cat ) {
				$cat_name[ $cat->term_id ] = $cat->name;
			}
		}
		$all_products_ids = get_posts(
			array(
				'post_type'   => 'product',
				'numberposts' => -1,
				'post_status' => 'publish',
				'fields'      => 'ids',
			)
		);
		?>
		<select name="wps_rma_setting[1][row_ex_cate][]" class="wps_rma_ex_cate1" multiple>   
		<?php
		foreach ( $cat_name as $key => $cat_name ) {
			echo '<option value="' . esc_html( $key ) . '">' . esc_html( $cat_name ) . '</option>';
		}
		?>
		</select>
		<select name="wps_rma_setting[1][row_ex_prod][]" class="wps_rma_ex_prod1" multiple>   
		<?php
		foreach ( $all_products_ids as $key => $product_id ) {
			$product = wc_get_product( $product_id );
			?>
			<option value="<?php echo esc_html( $product_id ); ?>"
			>
				<?php echo wp_kses_post( '(' . $product_id . ') ' . $product->get_title() ); ?>
			</option>
			<?php } ?>
		</select>
		<?php
	}

	/**
	 * Register the global shipping html.
	 *
	 * @param [type] $order_id .
	 * @return void
	 */
	public function wps_rma_global_shipping_fee_set( $order_id ) {
		$return_datas = get_post_meta( $order_id, 'wps_rma_return_product', true );
		$readonly     = '';
		if ( isset( $return_datas ) && ! empty( $return_datas ) ) {
			foreach ( $return_datas as $key => $return_data ) {
				if ( 'complete' === $return_data['status'] ) {
					$readonly = 'readonly="readonly"';
				}
			}
		}
		$wps_fee_cost = get_post_meta( $order_id, 'ex_ship_amount1', true );
		if ( isset( $wps_fee_cost ) && ! empty( $wps_fee_cost ) ) {
			$flag = false;
			?>
			<p><?php esc_html_e( 'This Fees amount is deducted from Refund amount', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></p>
			<div id="wps_wrma_add_fee">
				<?php
				foreach ( $wps_fee_cost as $name_key => $name_value ) {
					if ( ! empty( $name_value ) ) {
						$flag = true;
						?>
						<div class="wps_wrma_add_new_ex_fee_div">
						<input type="text" name="wps_wrma_ship_name" class="wps_wrma_add_new_ex_fee_name" value="<?php echo esc_html( $name_key ); ?>" readonly>
						<input type="number" class="wps_wrma_add_new_ex_fee" name="wps_wrma_new_ship_cost[]" data-name="<?php echo esc_html( $name_key ); ?>" value="<?php echo esc_html( $name_value ); ?>" <?php echo esc_html( $readonly ); ?>>
						</div>
						<?php
					}
				}
				if ( $flag ) {
					?>
				<input type="button" class="save_ship_ex_cost" name="save_ship_cost" data-orderid="<?php echo esc_html( $order_id ); ?>" data-date="<?php echo esc_html( $order_id ); ?>" value="<?php esc_html_e( 'Save', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>">
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
