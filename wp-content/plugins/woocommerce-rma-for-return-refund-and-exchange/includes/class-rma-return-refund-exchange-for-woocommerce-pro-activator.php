<?php
/**
 * Fired during plugin activation
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/includes
 */
class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Activator {
	/**
	 * Activator.
	 *
	 * @param array() $network_wide .
	 */
	public static function rma_return_refund_exchange_for_woocommerce_pro_activate( $network_wide ) {
		global $wpdb;
		// Check if the plugin has been activated on the network.
		if ( is_multisite() && $network_wide ) {
			// Get all blogs in the network and activate plugins on each one.
			$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );

				// Create Pages.
				self::wps_rma_create_pages();

				restore_current_blog();
			}
		} else {
			// Create Pages.
			self::wps_rma_create_pages();

		}
	}

	/**
	 * Creates a translation of a post (to be used with WPML) && pages.
	 **/
	public static function wps_rma_create_pages() {
		$timestamp = get_option( 'wps_mwr_activated_timestamp', 'not_set' );

		if ( 'not_set' === $timestamp ) {

			$current_time = current_time( 'timestamp' );

			$thirty_days = strtotime( '+30 days', $current_time );

			update_option( 'wps_mwr_activated_timestamp', $thirty_days );
		}

		$wps_exchange_request_form = array(
			'post_author' => 1,
			'post_name'   => esc_html__( 'exchange-request-form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'post_title'  => esc_html__( 'Exchange Request Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'post_type'   => 'page',
			'post_status' => 'publish',

		);

		$page_id = wp_insert_post( $wps_exchange_request_form );

		if ( $page_id ) {
			update_option( 'wps_rma_exchange_req_page', $page_id );
			self::wps_wpml_translate_post( $page_id ); // Add translated page.
		}

		$wps_return_exchange_request_form = array(
			'post_author' => 1,
			'post_name'   => esc_html__( 'guest-request-form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'post_title'  => esc_html__( 'Guest Return/Exchange Request Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'post_type'   => 'page',
			'post_status' => 'publish',

		);

		$page_id = wp_insert_post( $wps_return_exchange_request_form );

		if ( $page_id ) {
			update_option( 'wps_rma_guest_form_page', $page_id );
			self::wps_wpml_translate_post( $page_id ); // Add translated page.
		}

		$wps_cancel_product_request_form = array(
			'post_author' => 1,
			'post_name'   => esc_html__( 'cancel-request-form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'post_title'  => esc_html__( 'Cancel Request Form', 'woocommerce-rma-for-return-refund-and-exchange' ),
			'post_type'   => 'page',
			'post_status' => 'publish',

		);

		$page_id = wp_insert_post( $wps_cancel_product_request_form );

		if ( $page_id ) {
			update_option( 'wps_rma_cancel_req_page', $page_id );
			self::wps_wpml_translate_post( $page_id ); // Add translated page.
		}
	}

	/**
	 * Creates a translation of a post (to be used with WPML)
	 *
	 * @param int $page_id The ID of the post to be translated.
	 **/
	public static function wps_wpml_translate_post( $page_id ) {
		if ( has_filter( 'wpml_object_id' ) ) {
			// If the translated page doesn't exist, now create it.
			do_action( 'wpml_admin_make_post_duplicates', $page_id );
		}
	}
}
