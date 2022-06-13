<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://wpswings.com/
 * @since 1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $mwr_wps_mwr_obj;
$callname_lic         = Rma_Return_Refund_Exchange_For_Woocommerce_Pro::check_lcns_validity();
$callname_lic_initial = Rma_Return_Refund_Exchange_For_Woocommerce_Pro::$lic_ini_callback_function;
$day_count            = Rma_Return_Refund_Exchange_For_Woocommerce_Pro::$callname_lic_initial();
if ( ! get_option( 'wps_mwr_license_check', 0 ) ) {
	if ( $day_count > 0 ) {
		$day_count_warning = floor( $day_count );
		/* translators: %s: search term */
		$day_string = sprintf( _n( '%s day', '%s days', $day_count_warning, 'woocommerce-rma-for-return-refund-and-exchange' ), number_format_i18n( $day_count_warning ) );
		$day_string = '<span id="wps-mwr-day-count" >' . $day_string . '</span>';
		?>
		<div class="thirty-days-notice wps-header-container wps-bg-white wps-r-8">
			<h1 class="update-message notice">
				<p>
					<strong><a href="?page=woo_refund_and_exchange_lite_menu&wrael_tab=rma-return-refund-exchange-for-woocommerce-pro-license">
					<?php
					/* translators: %s: search term */
					esc_html_e( 'Activate', 'woocommerce-rma-for-return-refund-and-exchange' );
					?>
				</a>
				<?php
					/* translators: %s: search term */
					printf( esc_html__( ' the license key before %s or you may risk losing data and the plugin will also become dysfunctional.', 'woocommerce-rma-for-return-refund-and-exchange' ), wp_kses_post( $day_string ) );
				?>
					</strong>
				</p>
			</h1>
		</div>
		<?php
	} else {
		?>
		<div class="thirty-days-notice wps-header-container wps-bg-white wps-r-8">
			<h1 class="wps-header-title">
				<p>
					<strong><?php esc_html_e( ' Your trial period is over please activate license to use the features.', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></strong>
				</p>
			</h1>
		</div>
		<?php
	}
}
