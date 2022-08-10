<?php
/**
 * API
 *
 * Handles requests to the Scrubbill API.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class API
 *
 * @since 1.0
 */
class API {

	/**
	 * API Endpoint.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const ENDPOINT = 'https://service.scrubbill.net/v1/a1f79b04a2d6184366d9f44d5d456c9453289125ef05502617540754b8b420e7';

	/**
	 * Send request to Scrubbill API.
	 *
	 * @param string $endpoint The API endpoint.
	 * @param array  $data The data to send with the request.
	 *
	 * @return array|false
	 */
	public function request( $endpoint, $data = [] ) {
		$request = [];

		$request['headers'] = [
			'Authorization' => get_option( Settings::API_TOKEN_KEY ),
		];

		if ( ! empty( $data ) ) {
			$request['body'] = wp_json_encode( $data );
		}

		$response = wp_safe_remote_post(
			sprintf( '%s/%s', self::ENDPOINT, $endpoint ),
			$request
		);

		if ( ! is_wp_error( $response ) && ! empty( $response['response']['code'] ) ) {
			switch ( $response['response']['code'] ) {
				case 200:
					return json_decode( $response['body'] );
				case 204:
					return 'invalid-address';
			}
		}

		return false;
	}
}
