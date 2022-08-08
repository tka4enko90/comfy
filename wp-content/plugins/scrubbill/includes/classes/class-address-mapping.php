<?php
/**
 * Address_Mapping
 * 
 * Adds the necessary Address Mapping required for ScrubBill. 
 * 
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class Address_Mapping
 *
 * @since 1.0
 */
class Address_Mapping {

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */
	public function hooks() {
		$override_labels = get_option( Settings::OVERRIDE_LABELS_KEY );

		// Explicitly check for `no` as we default to yes (i.e. false or not set should be `yes`).
		if ( 'no' !== $override_labels ) {
			add_filter( 'woocommerce_default_address_fields', [ $this, 'set_address_fields' ], 99 );
			add_filter( 'woocommerce_checkout_fields', [ $this, 'set_placeholder_fields' ], 99 );
		}
	}

	/**
	 * Set Address Fields
	 *
	 * @param array $address_fields WooCommerce default address fields
	 *
	 * @since  1.0
	 * @return array
	 */
	public function set_address_fields( $address_fields ) {
		if ( ! empty( $address_fields['address_1'] ) ) {
			$address_fields['address_1']['placeholder'] = esc_html__( 'Address line 1', 'scrubbill' );
			$address_fields['address_1']['label'] = esc_html__( 'Street Address', 'scrubbill' );
		}

		if ( ! empty( $address_fields['address_2'] ) ) {
			$address_fields['address_2']['placeholder'] = esc_html__( 'Address line 2 (optional)', 'scrubbill' );
			$address_fields['address_2']['label'] = esc_html__( '', 'scrubbill' );
		}

		if ( ! empty( $address_fields['city'] ) ) {
			$address_fields['city']['placeholder'] = esc_html__( 'Suburb - matching postal code below', 'scrubbill' );
			$address_fields['city']['label'] = esc_html__( 'Suburb', 'scrubbill' );
		}

		if ( ! empty( $address_fields['postcode'] ) ) {
			$address_fields['postcode']['placeholder'] = esc_html__( 'Postal Code', 'scrubbill' );
			$address_fields['postcode']['label'] = esc_html__( 'Postal Code', 'scrubbill' );
		}

		return $address_fields;
	}

	/**
	 * Set Placeholder Fields
	 *
	 * @param array $address_fields WooCommerce default address fields
	 *
	 * @since  1.0
	 * @return array
	 */
	public function set_placeholder_fields( $address_fields ) {
		if ( ! empty( $address_fields['billing']['billing_phone'] ) ) {
			$address_fields['billing']['billing_phone']['placeholder'] = esc_html__( 'Cell Phone', 'scrubbill' );
			$address_fields['billing']['billing_phone']['label'] = esc_html__( 'Cell Phone', 'scrubbill' );
			$address_fields['billing']['billing_phone']['type'] = 'text';
		}

		return $address_fields;
	}
}
