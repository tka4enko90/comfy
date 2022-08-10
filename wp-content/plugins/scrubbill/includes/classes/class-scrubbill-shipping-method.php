<?php
/**
 * Scrubbill Shipping Method.
 *
 * Custom shipping method for Scrubbill.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class Scrubbill_Shipping_Method
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */
class Scrubbill_Shipping_Method extends \WC_Shipping_Method {

	/**
	 * Key for storing Postnet branches.
	 *
	 * @since 1.0
	 */
	const POSTNET_BRANCHES_KEY = 'scrubbill_postnet_branches';

	/**
	 * Key for logging when Postnet branches were last updated.
	 *
	 * @since 1.0
	 */
	const POSTNET_LAST_UPDATED_KEY = 'scrubbill_postnet_last_updated';

	/**
	 * Constructor for your shipping class.
	 *
	 * @param integer $instance_id The ID of the instance.
	 *
	 * @since 1.0
	 */
	public function __construct( $instance_id = 0 ) {
		$this->id                 = 'scrubbill-rates'; // Important that the `id` here is not `scrubbill` otherwise the settings page conflicts.
		$this->instance_id        = absint( $instance_id );
		$this->method_title       = 'Scrubbill';
		$this->method_description = __( 'Offer rates from multiple shipping providers', 'scrubbiill' );
		$this->enabled            = 'yes';
		$this->title              = 'Scrubbill';
		$this->supports           = [ 'shipping-zones' ];
		$this->init();
	}

	/**
	 * Init settingss.
	 *
	 * @since 1.0
	 */
	public function init() {
		// Load the settings API.
		$this->init_form_fields();
		$this->init_settings();

		// Save settings in admin if you have any defined.
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * Calculate shipping rates from API request..
	 *
	 * @since 1.0
	 *
	 * @param array $package The order package details.
	 */
	public function calculate_shipping( $package = array() ) {
		$api  = Bootstrap::get_instance()->get_container( 'API' );
		$data = [];

		// Customer details.
		$data['first_name'] = WC()->customer->get_billing_first_name();
		$data['last_name']  = WC()->customer->get_billing_last_name();
		$data['company']    = WC()->customer->get_billing_company();

		// Address details.
		if ( ! empty( $package['destination'] ) ) {
			foreach ( $package['destination'] as $key => $value ) {
				$data[ $key ] = $value;
			}
		}

		// Contact details.
		$data['email'] = WC()->customer->get_billing_email();
		$data['phone'] = WC()->customer->get_billing_phone();

		// Add value.
		$use_cart_sub_total = get_option( Settings::USE_CART_SUB_TOTAL );

		if ( 'yes' === $use_cart_sub_total ) {
			$data['value'] = $this->format_float_to_string( WC()->cart->get_subtotal() );
		} else {
			$data['value'] = $this->format_float_to_string( WC()->cart->get_cart_contents_total() );
		}

		// Add weight.
		$data['weight'] = $this->format_float_to_string( WC()->cart->get_cart_contents_weight(), 4, false );

		// Items.
		$items = [];
		$cart  = WC()->cart->get_cart();

		if ( ! empty( $cart ) ) {
			foreach ( $cart as $product ) {
				$items[] = [
					'quantity' => $product['quantity'],
					'length'   => (string) $product['data']->get_length(),
					'width'    => (string) $product['data']->get_width(),
					'height'   => (string) $product['data']->get_height(),
					'weight'   => $this->format_float_to_string( $product['data']->get_weight(), 4, false ),
				];
			}
		}
		$data['cart'] = $items;

		// Get rates.
		$rates = $api->request( 'quote', $data );

		if ( is_array( $rates ) && ! empty( $rates ) ) {
			foreach ( $rates as $rate ) {
				$new_rate = [
					'id'       => $rate->type,
					'label'    => $rate->service,
					'cost'     => $rate->rate,
					'calc_tax' => 'per_item',
				];

				// Register the rate.
				$this->add_rate( $new_rate );

				// Check for Postnet branches.
				if ( 'POSTNET' === $rate->type ) {
					$this->update_postnet_branches( $api, $rate->updated_at );
				}
			}
		} elseif ( 'invalid-address' === $rates ) {
			// Show address warning if bad
			add_filter( 'woocommerce_no_shipping_available_html', function() {
				return __( 'Invalid address. Please make sure you enter a valid suburb and postal code combination', 'scrubbill' );
			} );
		} else {
			$failover_rate  = get_option( Settings::FAILOVER_RATE_KEY );
			$failover_label = get_option( Settings::FAILOVER_LABEL_KEY );

			if ( empty( $failover_label ) ) {
				$failover_label = __( 'Flat Rate', 'scrubbill' );
			}

			if ( ! empty( $failover_rate ) ) {
				$new_rate = [
					'id'       => 'default',
					'label'    => $failover_label,
					'cost'     => $failover_rate,
					'calc_tax' => 'per_item',
				];

				$this->add_rate( $new_rate );
			}
		}
	}

	/**
	 * Update Postnet branches if they've been updated on the remote server.
	 *
	 * @since 1.0
	 *
	 * @param API    $api API request object.
	 * @param string $api_last_updated The date when the remote API was last updated.
	 */
	public function update_postnet_branches( $api, $api_last_updated ) {
		$postnet_last_updated = get_option( self::POSTNET_LAST_UPDATED_KEY );

		if ( (string) $postnet_last_updated !== (string) $api_last_updated ) {
			$postnet_branches = $api->request( 'postnet' );

			if ( ! empty( $postnet_branches ) ) {
				$branches = [];

				foreach ( $postnet_branches as $branch ) {
					$branches[ $branch->id ] = $branch->storeName; // phpcs:ignore
				}
				update_option( self::POSTNET_BRANCHES_KEY, $branches );
				update_option( self::POSTNET_LAST_UPDATED_KEY, $api_last_updated );
			}
		}
	}

	/**
	 * Returns a string value of a float at 2 decimal points.
	 *
	 * @since 1.0.1
	 *
	 * @param float $value The float to format.
	 * @param int   $precision The amount of decimals to show.
	 * @param bool  $force_decimal Show decimals even if they are zero.
	 *
	 * @return string
	 */
	protected function format_float_to_string( $value, $precision = 2, $force_decimal = true ) {
		$value = (string) number_format( (float) $value, $precision, '.', '' );

		if ( '0' === $value ) {
			return $value;
		}

		if ( ! $force_decimal ) {
			while ( '0' === substr( $value, -1 ) ) {
				$value = substr( $value, 0, -1 );
			}
		}

		return rtrim( $value, '.' );
	}
}
