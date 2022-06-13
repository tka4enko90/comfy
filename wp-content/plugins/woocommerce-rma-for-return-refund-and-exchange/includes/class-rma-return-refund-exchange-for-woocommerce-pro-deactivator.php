<?php
/**
 * Fired during plugin deactivation
 *
 * @link  https://wpswings.com/
 * @since 1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/includes
 */
class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Deactivator {

	/**
	 * Deactivator.
	 *
	 * @param array() $network_wide .
	 */
	public static function rma_return_refund_exchange_for_woocommerce_pro_deactivate( $network_wide ) {
		global $wpdb;
		// Check if we are on a Multisite or not.
		if ( is_multisite() ) {
			// Retrieve all site IDs from all networks (WordPress >= 4.6 provides easy to use functions for that).
			if ( function_exists( 'get_sites' ) ) {
				$site_ids = get_sites( array( 'fields' => 'ids' ) );
			} else {
				$site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			}

			// Uninstall the plugin for all these sites.
			foreach ( $site_ids as $site_id ) {
				switch_to_blog( $site_id );
				self::wps_rma_delete_pages();
				self::wps_rma_reset_license();
				restore_current_blog();
			}
		} else {
			self::wps_rma_delete_pages();
			self::wps_rma_reset_license();
		}

	}

	/**
	 * Function to deletepages.
	 */
	public static function wps_rma_delete_pages() {

		// Delete pages.
		$page_id = get_option( 'wps_rma_exchange_req_page' );
		self::wps_delete_wpml_translate_post( $page_id );
		wp_delete_post( $page_id );
		$page_id = get_option( 'wps_rma_guest_form_page' );
		self::wps_delete_wpml_translate_post( $page_id );
		wp_delete_post( $page_id );
		$page_id = get_option( 'wps_rma_cancel_req_page' );
		self::wps_delete_wpml_translate_post( $page_id );
		wp_delete_post( $page_id );
	}

	/**
	 * Function to reset the license.
	 */
	public static function wps_rma_reset_license() {
		if ( get_option( 'mwr_radio_reset_license', false ) ) {
			$server_name = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
			$license_key = get_option( 'wps_mwr_license_key', false );
			$api_params  = array(
				'slm_action' => 'slm_deactivate',
				'secret_key' => RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_SPECIAL_SECRET_KEY,
				'license_key' => $license_key,
				'registered_domain' => is_multisite() ? site_url() : $server_name,
				'item_reference' => urlencode( RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_ITEM_REFERENCE ),
				'product_reference' => 'WPSPK-67570',
			);
			$query = esc_url_raw( add_query_arg( $api_params, RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_LICENSE_SERVER_URL ) );
			$response = wp_remote_get(
				$query,
				array(
					'timeout' => 20,
					'sslverify' => false,
				)
			);

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( isset( $license_data->result ) && 'success' === $license_data->result ) {
				delete_option( 'wps_mwr_license_check' );
				delete_option( 'wps_mwr_license_key' );
			}
		}
	}
	/**
	 * Function to delete translated pages.
	 *
	 * @param int $page_id The ID of the post to be deleted.
	 */
	public static function wps_delete_wpml_translate_post( $page_id ) {
		if ( has_filter( 'wpml_object_id' ) && function_exists( 'wpml_get_active_languages' ) ) {
			$langs = wpml_get_active_languages();
			foreach ( $langs as $lang ) {
				if ( apply_filters( 'wpml_object_id', $page_id, 'page', false, $lang['code'] ) ) {
					$pageid = apply_filters( 'wpml_object_id', $page_id, 'page', false, $lang['code'] );
					wp_delete_post( $pageid );

				}
			}
		}
	}

}
