<?php
/**
 * License Template.
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */

?>
<div class="wps-mwr-wrap">
<h2><?php esc_html_e( 'Your License', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></h2>
<div class="wps_mwr_license_text">
	<p>
	<?php
	esc_html_e( 'This is the License Activation Panel. After purchasing extension from wpswings you will get the purchase code of this extension. Please verify your purchase below so that you can use feature of this plugin.', 'woocommerce-rma-for-return-refund-and-exchange' );
	?>
	</p>
	<form id="wps_mwr_license_form"> 
		<table class="wps-mwr-form-table">
			<tr>
			<th scope="row"><label for="puchase-code"><?php esc_html_e( 'Purchase Code : ', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></label></th>
			<td>
				<input type="text" id="wps_mwr_license_key" name="purchase-code" required="" size="30" class="wps-mwr-purchase-code" value="" placeholder="<?php esc_html_e( 'Enter your code here...', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>">
				<div id="wps_license_ajax_loader"><img src="<?php echo 'images/spinner.gif'; ?>"></div>
			</td>
			</tr>
		</table>
		<p id="wps_mwr_license_activation_status"></p>
		<p class="submit">
		<button id="wps_mwr_license_activate" required="" class="button-primary woocommerce-save-button" name="wps_mwr_license_settings"><?php esc_html_e( 'Validate', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></button>
		</p>
	</form>
</div>
</div>
