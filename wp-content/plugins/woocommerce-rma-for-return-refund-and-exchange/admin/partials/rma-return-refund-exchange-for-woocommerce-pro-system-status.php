<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
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
// Template for showing information about system status.
global $mwr_wps_mwr_obj;
$mwr_default_status = $mwr_wps_mwr_obj->wps_mwr_plug_system_status();
$mwr_wordpress_details = is_array( $mwr_default_status['wp'] ) && ! empty( $mwr_default_status['wp'] ) ? $mwr_default_status['wp'] : array();
$mwr_php_details = is_array( $mwr_default_status['php'] ) && ! empty( $mwr_default_status['php'] ) ? $mwr_default_status['php'] : array();
?>
<div class="wps-mwr-table-wrap">
	<div class="wps-col-wrap">
		<div id="wps-mwr-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="wps-mwr-table mdc-data-table__table wps-table" id="wps-mwr-wp">
					<thead>
						<tr>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Variables', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Values', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $mwr_wordpress_details ) && ! empty( $mwr_wordpress_details ) ) { ?>
							<?php foreach ( $mwr_wordpress_details as $wp_key => $wp_value ) { ?>
								<?php if ( isset( $wp_key ) && 'wp_users' != $wp_key ) { ?>
									<tr class="mdc-data-table__row">
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_key ); ?></td>
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_value ); ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="wps-col-wrap">
		<div id="wps-mwr-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="wps-mwr-table mdc-data-table__table wps-table" id="wps-mwr-sys">
					<thead>
						<tr>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Variables', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Values', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $mwr_php_details ) && ! empty( $mwr_php_details ) ) { ?>
							<?php foreach ( $mwr_php_details as $php_key => $php_value ) { ?>
								<tr class="mdc-data-table__row">
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_key ); ?></td>
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_value ); ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
