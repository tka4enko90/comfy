<?php
/**
 * Returnship Label Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */

?>
<h4>
	<input type="button" class="show_returnship_label wps-rma-admin__button" value="ReturnShip Label" />
	<input class="show_shipintegration wps-rma-admin__button" type="button" value="Ship Integration" />
	<?php
	// Extend the integration button.
	do_action( 'wps_rma_extend_more_integration_button' );
	?>
</h4>
<div class="wps_table wps_rma_shipping_label_setting">
	<form enctype="multipart/form-data" action="" id="mainform" method="post">
		<h4 id="wrma_mail_setting" class="wps_wrma_basic_setting wps_wrma_slide_active"><?php esc_html_e( 'Return Ship Setting', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></h4>
		<div id="wrma_mail_setting_wrapper">
			<table class="form-table wps_wrma_notification_section">
				<tr valign="top">
					<th class="titledesc wps-form-group__label">
						<label for="wps_wrma_enable_return_ship_label"><?php esc_html_e( 'Enable Shiping Label', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
					</th>
					<td>
						<div class="wps-form-group">
							<div class="wps-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
											<div class="mdc-switch__thumb-underlay">
												<div class="mdc-switch__thumb"></div>
												<input name="wps_wrma_enable_return_ship_label" type="checkbox" id="wps_wrma_enable_return_ship_label" value="on" class="mdc-switch__native-control wrael-radio-switch-class" role="switch" aria-checked="
												"
												<?php
												$wps_wrma_enable_return_ship_label = get_option( 'wps_wrma_enable_return_ship_label', 'no' );
												if ( 'on' === $wps_wrma_enable_return_ship_label ) {
													?>
													checked="checked"
													<?php
												}
												?>
												>
											</div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc wps-form-group__label">
						<label for="wps_wrma_enable_return_ship_station_label"><?php esc_html_e( 'Enable ShipEngine Shiping Label', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
					</th>
					<td>
						<div class="wps-form-group">
							<div class="wps-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
											<div class="mdc-switch__thumb-underlay">
												<div class="mdc-switch__thumb"></div>
												<input name="wps_wrma_enable_return_ship_station_label" type="checkbox" id="wps_wrma_enable_return_ship_station_label" value="on" class="mdc-switch__native-control wrael-radio-switch-class" role="switch" aria-checked="
												"
												<?php
												$wps_wrma_enable_return_ship_station_label = get_option( 'wps_wrma_enable_return_ship_station_label', 'no' );
												if ( 'on' === $wps_wrma_enable_return_ship_station_label ) {
													?>
													checked="checked"
													<?php
												}
												?>
												>
											</div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc wps-form-group__label">
						<label for="wps_wrma_enable_ss_return_ship_station_label"><?php esc_html_e( 'Enable ShipStation Shiping Label', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
					</th>
					<td>
						<div class="wps-form-group">
							<div class="wps-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
											<div class="mdc-switch__thumb-underlay">
												<div class="mdc-switch__thumb"></div>
												<input name="wps_wrma_enable_ss_return_ship_station_label" type="checkbox" id="wps_wrma_enable_return_ship_station_label" value="on" class="mdc-switch__native-control wrael-radio-switch-class" role="switch" aria-checked="
												"
												<?php
												$wps_wrma_enable_ss_return_ship_station_label = get_option( 'wps_wrma_enable_ss_return_ship_station_label', 'no' );
												if ( 'on' === $wps_wrma_enable_ss_return_ship_station_label ) {
													?>
													checked="checked"
													<?php
												}
												?>
												>
											</div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<h6>
		<?php
			$woo_email_url = admin_url() . 'admin.php?page=wc-settings&tab=email&section=wps_rma_returnship_email';
			/* translators: %s: search term */
			echo sprintf( esc_html__( 'To Configure Returnship Related Email %s.', 'woocommerce-rma-for-return-refund-and-exchange' ), '<a href="' . esc_html( $woo_email_url ) . '">Click Here</a>' );
		?>
		</h6>
		<p class="submit">
			<input type="submit" value="<?php esc_html_e( 'Save Settings', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>" class="wps-rma-save-button wps-rma-admin__button" name="wps_wrma_noti_save_return_slip">
		</p>
	</form>
</div>
<div class='wps_table wps_rma_shipping_setting'>
	<form enctype='multipart/form-data' action='' id='' method='post'>
		<!-- wrapper div -->
		<div class='wps_wrma_accordion'>
			<div class="wps_wrma_accord_sec_wrap">
				<h4 id="wrma_shipstation_heading" class="wps_wrma_basic_setting wps_wrma_slide_active">
					<?php esc_html_e( 'ShipEngine Configuration', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
				</h4>
				<div class='wps_wrma_validate_form_wrapper'>
					<!-- loader -->
					<div class="wps_wrma_return_loader">
						<img src="<?php echo esc_html( home_url() ); ?>/wp-admin/images/spinner-2x.gif">
					</div>
					<?php

						$wps_wrma_connected_account = get_option( ' wps_wrma_connected_ship_station_account ', '' );
						$wps_wrma_api_key = get_option( ' wps_wrma_validated_ship_station_api_key ', '' );
						$carrier_object = get_option( ' carrier_object ', '' );
						$wps_wrma_validated_html = sprintf( '%s %s', 'Connected Account : ', $wps_wrma_connected_account );
						$wps_wrma_hide_form = '';
					if ( ! empty( $wps_wrma_connected_account ) || ! empty( $wps_wrma_api_key ) ) {

						$wps_wrma_hide_form = 'wps_wrma_show_connected';
						?>

							<!-- Connected form start -->
							<div class="wps_wrma_ship_station_validated-wrap">
								<div class="wps_wrma_ship_station_validated">
									<p class="wps_wrma_ship_station_account_html " >

									<?php echo wp_kses_post( $wps_wrma_validated_html ); ?>
									</p>
									<div class="wps_wrma_logout_wrap">
										<a href='javascript:void(0)' class='wps_wrma_logout' ><?php esc_html_e( 'Log Out', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
										</a>
									</div>
								</div> 
							</div>
							<!-- Connected form ends -->

							<?php
							/* List carriers starts */

							$wps_wrma_refund_class = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Admin( 'rma-return-refund-exchange-for-woocommerce-pro', '5.0.0' );
							$wps_wrma_refund_class->wps_wrma_list_carriers_html();

							/* List carriers ends */
					}
					?>
					<!-- Validation form start -->
					<div class="wps_wrma_ship_station <?php echo esc_html( $wps_wrma_hide_form ); ?> ">

						<!-- input form -->
						<label for='wps_wrma_validate_id' ><?php esc_html_e( ' Enter Your API Key', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>

						<input type='text' id='wps_wrma_validate_id' class="wps_wrma_validate_field" placeholder='Enter Your API Key' >

						<span class='wps_wrma_notify_error'></span>

						<p class='submit'>
							<a href='javascript:void(0)' class='wps_wrma_validate_api_key wps-rma-admin__button' ><?php esc_html_e( 'Validate Account', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
							</a>
						</p>
					</div>
					<!-- Validation form ends -->
				</div>
			</div>
		</div>
		<!-- wrapper div -->
		<div class='wps_wrma_accordion'>
			<div class="wps_wrma_accord_sec_wrap">
				<h4 id="wrma_shipstation_main_heading" class="wps_wrma_basic_setting wps_wrma_slide_active">
					<?php esc_html_e( 'Shipstation Configuration', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
				</h4>
				<div class='wps_wrma_ship_validate_form_wrapper'>
					<!-- loader -->
					<div class="wps_wrma_returnship_loader">
						<img src="<?php echo esc_html( home_url() ); ?>/wp-admin/images/spinner-2x.gif">
					</div>
					<?php
						$wps_wrma_connected_account = get_option( ' wps_wrma_validated_real_ship_station_api_key ', '' );
						$wps_wrma_api_key = get_option( ' wps_wrma_validated_real_ship_station_api_key ', '' );
						$wps_wrma_secret_key = get_option( ' wps_wrma_validated_real_ship_station_secret_key ', '' );
						$carrier_object = get_option( ' carrier_object ', '' );
						$wps_wrma_validated_html = sprintf( '%s %s', 'Connected Account : ', $wps_wrma_connected_account );
						$wps_wrma_hide_ship_form = '';
					if ( ! empty( $wps_wrma_secret_key ) || ! empty( $wps_wrma_api_key ) ) {

						$wps_wrma_hide_ship_form = 'wps_wrma_show_connected';
						?>

							<!-- Connected form start -->
							<div class="wps_wrma_ship_station_validated-wrap">
								<div class="wps_wrma_ship_station_validated">
									<p class="wps_wrma_ship_station_account_html " >

									<?php echo esc_html( $wps_wrma_validated_html ); ?>
									</p>
									<div class="wps_wrma_logout_wrap">
										<a href='javascript:void(0)' class='wps_wrma_shipstation_logout' ><?php esc_html_e( 'Log Out', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
										</a>
									</div>
								</div> 
							</div>
							<!-- Connected form ends -->

							<?php

							/* List carriers starts */

							$wps_wrma_refund_class = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Admin( 'rma-return-refund-exchange-for-woocommerce-pro', '5.0.0' );
							$wps_wrma_refund_class->wps_wrma_list_shipstation_carriers_html();

							/* List carriers ends */
					}
					?>

					<!-- Validation form start -->
					<div class="wps_wrma_ship_station <?php echo esc_html( $wps_wrma_hide_ship_form ); ?> ">
						<div class="wps-wrma-validation__wrap">
							<!-- input form -->
							<label for='wps_wrma_validate_api_id' ><?php esc_html_e( ' Enter Your API Key ', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
							<input type='text' id='wps_wrma_validate_ship_api_id' class="wps_wrma_validate_api_id_field" placeholder='Enter your Shipstation Api key' >
						</div>
						<br>
						<div class="wps-wrma-validation__wrap">
							<label for='wps_wrma_validate_secret_id' ><?php esc_html_e( ' Enter Your Secret Key ', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
							<input type='text' id='wps_wrma_validate_secret_id' class="wps_wrma_validate_secret_id_field" placeholder='Enter your Shipstation Secret key' >	
						</div>
						<span class='wps_wrma_notify_error'></span>

						<p class='submit'>
							<a href='javascript:void(0)' class='wps_wrma_ship_validate_api_key wps-rma-admin__button' ><?php esc_html_e( 'Validate Account', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
							</a>
						</p>
					</div>
					<!-- Validation form ends -->
				</div>
			</div>
		</div>
		<div class="wps_wrma_accordion">
			<div class="wps_wrma_accord_sec_wrap">
				<h4 id="wps_wrma_shipstation_details_heading" class="wps_wrma_basic_setting wps_wrma_slide_active">
					<?php esc_html_e( 'Ship Integration Details', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
				</h4>
				<div class="wps_wrma_shipstation_details_wrapper">
					<table>
						<tbody>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_name"><?php esc_html_e( 'Name', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_name = get_option( 'wps_wrma_ship_station_name', false );
									?>
									<input type="text" placeholder=""class="input-text" value="<?php echo esc_html( $wps_wrma_ship_station_name ); ?>" id="wps_wrma_ship_station_name" name="wps_wrma_ship_station_name">
								</td>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_comp_name"><?php esc_html_e( 'Company Name', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_comp_name = get_option( 'wps_wrma_ship_station_comp_name', false );
									?>
									<input type="text" placeholder=""class="input-text" value="<?php echo esc_html( $wps_wrma_ship_station_comp_name ); ?>" id="wps_wrma_ship_station_comp_name" name="wps_wrma_ship_station_comp_name">
								</td>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_addr1"><?php esc_html_e( 'Address', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_addr1 = get_option( 'wps_wrma_ship_station_addr1', false );
									?>
									<input type="text" placeholder=""class="input-text" value="<?php echo esc_html( $wps_wrma_ship_station_addr1 ); ?>" id="wps_wrma_ship_station_addr1" name="wps_wrma_ship_station_addr1">
								</td>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_city"><?php esc_html_e( 'City', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_city = get_option( 'wps_wrma_ship_station_city', false );
									?>
									<input type="text" placeholder=""class="input-text" value="<?php echo esc_html( $wps_wrma_ship_station_city ); ?>"  id="wps_wrma_ship_station_city" name="wps_wrma_ship_station_city">
								</td>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_postcode"><?php esc_html_e( 'Postcode/ZIP', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_postcode = get_option( 'wps_wrma_ship_station_postcode', false );
									?>
									<input type="tel" placeholder=""class="input-text" value="<?php echo esc_html( $wps_wrma_ship_station_postcode ); ?>" id="wps_wrma_ship_station_postcode" name="wps_wrma_ship_station_postcode">
								</td>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_country"><?php esc_html_e( 'Country', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_country = get_option( 'wps_wrma_ship_station_country', true );
									global $woocommerce;
									$countries_obj = new WC_Countries();
									$countries     = $countries_obj->__get( 'countries' );
									$count_arr     = array( 'US', 'CA', 'AU', 'GB' );
									?>
									<select id="wps_wrma_ship_station_country" name="wps_wrma_ship_station_country"> 
									<?php
									foreach ( $countries as $ckey => $cvalue ) {
										if ( in_array( $ckey, $count_arr ) ) {
											$select = 0;
											if ( $wps_country == $ckey ) {
												$select = 1;
											}
											?>
											<option value="<?php echo esc_html( $ckey ); ?>" <?php echo esc_html( selected( 1, $select ) ); ?>><?php echo esc_html( $cvalue ); ?></option>
											<?php
										}
									}
									?>
									</select>
								</td>
							</tr>
							<tr valign="top" class="wps_wrma_ship_station_state">
								<?php
								$states    = WC()->countries->get_states();
								$wps_state = get_option( 'wps_wrma_ship_station_state', '' );
								if ( ! empty( $wps_country ) && isset( $wps_state ) && ! empty( $wps_state ) ) {
									?>
									<th class="titledesc" scope="row">
										<label for="wps_wrma_ship_station_state"><?php esc_html_e( 'State', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
									</th>
									<td class="forminp forminp-text">
										<select id="wps_wrma_ship_station_state" name="wps_wrma_ship_station_state"> 
										<?php
										foreach ( $states as $s_key => $s_value ) {
											if ( $wps_country == $s_key ) {
												if ( ! empty( $s_value ) && ! empty( $wps_state ) ) {
													foreach ( $s_value as $s_key1 => $s_value1 ) {
														$select = 0;
														if ( $wps_state == $s_key1 ) {
															$select = 1;
														}
														?>
														<option value="<?php echo esc_html( $s_key1 ); ?>" <?php echo esc_html( selected( 1, $select ) ); ?>><?php echo esc_html( $s_value1 ); ?></option>
														<?php
													}
												}
											}
										}
										?>
										</select>
								</td>
							<?php	} ?>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_phone"><?php esc_html_e( 'Phone', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_phone = get_option( 'wps_wrma_ship_station_phone', false );
									?>
									<input type="tel" placeholder=""class="input-text" value="<?php echo esc_html( $wps_wrma_ship_station_phone ); ?>"  id="wps_wrma_ship_station_phone" name="wps_wrma_ship_station_phone">
								</td>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_weight"><?php esc_html_e( 'Weight Unit', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_weight = get_option( 'wps_wrma_ship_station_weight', 'kilogram' );
									?>
									<select id="wps_wrma_ship_station_weight" name="wps_wrma_ship_station_weight">
										<option value="ounce" <?php echo ( 'ounce' === $wps_wrma_ship_station_weight ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Ounce', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
										<option value="pound" <?php echo ( 'pound' === $wps_wrma_ship_station_weight ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Pound', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
										<option value="gram" <?php echo ( 'gram' === $wps_wrma_ship_station_weight ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Gram', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
										<option value="kilogram" <?php echo ( 'kilogram' === $wps_wrma_ship_station_weight ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Kilogram', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<th class="titledesc" scope="row">
									<label for="wps_wrma_ship_station_dimension"><?php esc_html_e( 'Dimensions Unit', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label>
								</th>
								<td class="forminp forminp-text">
									<?php
									$wps_wrma_ship_station_dimension = get_option( 'wps_wrma_ship_station_dimension', 'centimeter' );

									?>
									<select id="wps_wrma_ship_station_dimension" name="wps_wrma_ship_station_dimension">
										<option value="inch" <?php echo ( 'inch' === $wps_wrma_ship_station_dimension ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Inch', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
										<option value="centimeter" <?php echo ( 'centimeter' === $wps_wrma_ship_station_dimension ) ? 'selected' : ''; ?> ><?php esc_html_e( 'Centimeter', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></option>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<p class="submit">
			<button class="wps_wrma_save_shipstation wps-wrma-save-button wps-rma-admin__button" name="wps_wrma_save_shipstation" ><?php esc_html_e( 'Save Settings', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>
			</button>
		</p>
	</form>
</div>
<?php
// Extend the integration field.
do_action( 'wps_rma_extend_more_integration_content' );
