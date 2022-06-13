<?php
/**
 * The file that defines the core plugin api class
 *
 * A class definition that includes api's endpoints and functions used across the plugin
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/package/rest-api/version1
 */

/**
 * The core plugin  api class.
 *
 * This is used to define internationalization, api-specific hooks, and
 * endpoints for plugin.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/package/rest-api/version1
 * @author     wpswings <webmaster@wpswings.com>
 */
class Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Rest_Api {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin api.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the merthods, and set the hooks for the api and
	 *
	 * @since    1.0.0
	 * @param   string $plugin_name    Name of the plugin.
	 * @param   string $version        Version of the plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}


	/**
	 * Define endpoints for the plugin.
	 *
	 * Uses the Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Rest_Api class in order to create the endpoint
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function wps_mwr_add_endpoint() {
		register_rest_route(
			'rma',
			'exchange-request',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'wps_rma_exchange_request_callback' ),
				'permission_callback' => array( $this, 'wps_mwr_default_permission_check' ),
			)
		);
		register_rest_route(
			'rma',
			'exchange-request-accept',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'wps_rma_exchange_request_accept_callback' ),
				'permission_callback' => array( $this, 'wps_mwr_default_permission_check' ),
			)
		);
		register_rest_route(
			'rma',
			'exchange-request-cancel',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'wps_rma_exchange_request_cancel_callback' ),
				'permission_callback' => array( $this, 'wps_mwr_default_permission_check' ),
			)
		);
		register_rest_route(
			'rma',
			'cancel-request',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'wps_rma_cancel_request_callback' ),
				'permission_callback' => array( $this, 'wps_mwr_default_permission_check' ),
			)
		);
	}


	/**
	 * Begins validation process of api endpoint.
	 *
	 * @param   Array $request    All information related with the api request containing in this array.
	 * @return  Array   $result   return rest response to server from where the endpoint hits.
	 * @since    1.0.0
	 */
	public function wps_mwr_default_permission_check( $request ) {
		$request_params  = $request->get_params();
		$wps_secretkey   = isset( $request_params['secret_key'] ) ? $request_params['secret_key'] : '';
		$secret_key      = get_option( 'wps_rma_secret_key', true );
		$api_enable      = get_option( 'wps_rma_enable_api', true );
		$wps_secret_code = '';
		if ( 'on' === $api_enable ) {
			$wps_secret_code = ! empty( $secret_key ) ? $secret_key : '';
		}
		if ( '' === $wps_secretkey ) {
			return false;
		} elseif ( trim( $wps_secret_code ) === trim( $wps_secretkey ) ) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Begins execution of api endpoint.
	 *
	 * @param   Array $request    All information related with the api request containing in this array.
	 * @return  Array   $wps_mwr_response   return rest response to server from where the endpoint hits.
	 * @since    1.0.0
	 */
	public function wps_rma_exchange_request_callback( $request ) {

		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'package/rest-api/version1/class-rma-return-refund-exchange-for-woocommerce-pro-api-process.php';
		$wps_mwr_api_obj     = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Api_Process();
		$wps_mwr_resultsdata = $wps_mwr_api_obj->wps_rma_exchange_request_process( $request );
		if ( is_array( $wps_mwr_resultsdata ) && isset( $wps_mwr_resultsdata['status'] ) && 200 == $wps_mwr_resultsdata['status'] ) {
			unset( $wps_mwr_resultsdata['status'] );
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 200 );
		} else {
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 404 );
		}
		return $wps_mwr_response;
	}

	/**
	 * Begins execution of api endpoint.
	 *
	 * @param   Array $request    All information related with the api request containing in this array.
	 * @return  Array   $wps_mwr_response   return rest response to server from where the endpoint hits.
	 * @since    1.0.0
	 */
	public function wps_rma_exchange_request_accept_callback( $request ) {

		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'package/rest-api/version1/class-rma-return-refund-exchange-for-woocommerce-pro-api-process.php';
		$wps_mwr_api_obj = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Api_Process();
		$wps_mwr_resultsdata = $wps_mwr_api_obj->wps_rma_exchange_request_accept_process( $request );
		if ( is_array( $wps_mwr_resultsdata ) && isset( $wps_mwr_resultsdata['status'] ) && 200 == $wps_mwr_resultsdata['status'] ) {
			unset( $wps_mwr_resultsdata['status'] );
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 200 );
		} else {
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 404 );
		}
		return $wps_mwr_response;
	}

	/**
	 * Begins execution of api endpoint.
	 *
	 * @param   Array $request    All information related with the api request containing in this array.
	 * @return  Array   $wps_mwr_response   return rest response to server from where the endpoint hits.
	 * @since    1.0.0
	 */
	public function wps_rma_exchange_request_cancel_callback( $request ) {

		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'package/rest-api/version1/class-rma-return-refund-exchange-for-woocommerce-pro-api-process.php';
		$wps_mwr_api_obj = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Api_Process();
		$wps_mwr_resultsdata = $wps_mwr_api_obj->wps_rma_exchange_request_cancel_process( $request );
		if ( is_array( $wps_mwr_resultsdata ) && isset( $wps_mwr_resultsdata['status'] ) && 200 == $wps_mwr_resultsdata['status'] ) {
			unset( $wps_mwr_resultsdata['status'] );
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 200 );
		} else {
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 404 );
		}
		return $wps_mwr_response;
	}

		/**
		 * Begins execution of api endpoint.
		 *
		 * @param   Array $request    All information related with the api request containing in this array.
		 * @return  Array   $wps_mwr_response   return rest response to server from where the endpoint hits.
		 * @since    1.0.0
		 */
	public function wps_rma_cancel_request_callback( $request ) {

		require_once RMA_RETURN_REFUND_EXCHANGE_FOR_WOOCOMMERCE_PRO_DIR_PATH . 'package/rest-api/version1/class-rma-return-refund-exchange-for-woocommerce-pro-api-process.php';
		$wps_mwr_api_obj     = new Rma_Return_Refund_Exchange_For_Woocommerce_Pro_Api_Process();
		$wps_mwr_resultsdata = $wps_mwr_api_obj->wps_rma_cancel_request_process( $request );
		if ( is_array( $wps_mwr_resultsdata ) && isset( $wps_mwr_resultsdata['status'] ) && 200 == $wps_mwr_resultsdata['status'] ) {
			unset( $wps_mwr_resultsdata['status'] );
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 200 );
		} else {
			$wps_mwr_response = new WP_REST_Response( $wps_mwr_resultsdata, 404 );
		}
		return $wps_mwr_response;
	}
}
