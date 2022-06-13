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
$mwr_genaral_settings =
// desc - filter for trial.
apply_filters( 'mwr_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="wps-mwr-gen-section-form">
	<div class="mwr-secion-wrap">
		<?php
		$mwr_general_html = $mwr_wps_mwr_obj->wps_mwr_plug_generate_html( $mwr_genaral_settings );
		echo esc_html( $mwr_general_html );
		wp_nonce_field( 'admin_save_data', 'wps_tabs_nonce' );
		?>
	</div>
</form>
