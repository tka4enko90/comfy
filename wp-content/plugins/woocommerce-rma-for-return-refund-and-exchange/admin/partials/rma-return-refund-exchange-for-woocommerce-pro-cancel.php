<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $mwr_wps_mwr_obj;
$mwr_cancel_settings =
// Cancel Setting register filter.
apply_filters( 'wps_rma_cancel_settings_array', array() );
$woo_email_url = admin_url() . 'admin.php?page=wc-settings&tab=email&section=wps_rma_cancel_request_email';
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="wps-mwr-gen-section-form">
	<div class="mwr-secion-wrap">
		<?php
		$mwr_cancel_html = $mwr_wps_mwr_obj->wps_mwr_plug_generate_html( $mwr_cancel_settings );
		echo esc_html( $mwr_cancel_html );
		wp_nonce_field( 'admin_save_data', 'wps_tabs_nonce' );
		?>
	</div>
</form>

<h6>
<?php
/* translators: %s: search term */
echo sprintf( esc_html__( 'To Configure Cancel Related Email %s.', 'woocommerce-rma-for-return-refund-and-exchange' ), '<a href="' . esc_html( $woo_email_url ) . '">Click Here</a>' );
?>
</h6>
