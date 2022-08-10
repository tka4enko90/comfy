<?php
/**
 * WC_Rest_API
 *
 * Extend the WC Rest API.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class WC_Rest_API
 *
 * @since 1.0
 */
class WC_Rest_API {

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */
	public function hooks() {
		add_filter( 'woocommerce_rest_orders_prepare_object_query', [ $this, 'add_date_modified_parameter' ], 10, 2 );
	}

	/**
	 * Adds the ability to query orders from the WooCommerce REST API by last modified date.
	 *
	 * @param array            $args Query arguments.
	 * @param \WP_REST_Request $request The REST request object.
	 *
	 * @since  1.0
	 * @return array
	 */
	public function add_date_modified_parameter( $args, $request ) {
		$modified_after = $request->get_param( 'modified_after' );

		if ( empty( $modified_after ) ) {
			return $args;
		}

		$args['date_query'][0]['column'] = 'post_modified';
		$args['date_query'][0]['after']  = $modified_after;

		return $args;
	}
}
