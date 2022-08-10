<?php
/**
 * REST API Reports Stats Query
 * Handles requests to the '/reports/giftcards/issued/stats' endpoint.
 *
 * @package  WooCommerce Gift Cards
 * @since    1.8.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Automattic\WooCommerce\Admin\API\Reports\Query as ReportsQuery;

/**
 * WC_GC_Analytics_Issued_Stats_Query class.
 *
 * @version 1.8.0
 */
class WC_GC_Analytics_Issued_Stats_Query extends ReportsQuery {

	/**
	 * Valid fields for report.
	 *
	 * @return array
	 */
	protected function get_default_query_vars() {
		return array();
	}

	/**
	 * Get gift card data based on the current query vars.
	 *
	 * @return array
	 */
	public function get_data() {
		$args       = apply_filters( 'woocommerce_analytics_giftcards_issued_stats_query_args', $this->get_query_vars() );
		$data_store = WC_Data_Store::load( 'report-giftcards-issued-stats' );
		$results    = $data_store->get_data( $args );
		return apply_filters( 'woocommerce_analytics_giftcards_issued_stats_select_query', $results, $args );
	}
}
