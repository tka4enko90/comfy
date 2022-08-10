<?php
/**
 * Shipping
 *
 * Register shipping methods for Scrubbill.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class Shipping
 *
 * @since 1.0
 */
class Shipping {

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */
	public function hooks() {
		// Load our custom shipping class.
		add_action( 'woocommerce_shipping_init', function() {
			include 'class-scrubbill-shipping-method.php';
		} );

		add_filter( 'woocommerce_shipping_methods', [ $this, 'add_shipping_method' ] );
	}

	/**
	 * Add our custom shipping method for Scrubbill.
	 *
	 * @since 1.0
	 *
	 * @param array $methods The existing shipping methods.
	 *
	 * @return array
	 */
	public function add_shipping_method( $methods ) {
		$methods['scrubbill-rates'] = 'Scrubbill\Plugin\Scrubbill\Scrubbill_Shipping_Method';
		return $methods;
	}
}
