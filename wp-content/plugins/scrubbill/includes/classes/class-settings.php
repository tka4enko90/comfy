<?php
/**
 * Settings.
 * 
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class Settings
 *
 * @since 1.0
 */
class Settings {

	/**
	 * Unique ID for the settings page.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const SETTINGS_PAGE = 'scrubbill';

	/**
	 * The key for the API Token setting.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const API_TOKEN_KEY = 'scrubbill_api_token';

	/**
	 * Key for the label override setting.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const OVERRIDE_LABELS_KEY = 'scrubbill_override_address_labels';

	/**
	 * Key for the coupon exclusion setting.
	 *
	 * @var string
	 *
	 * @since 1.0.2
	 */
	const USE_CART_SUB_TOTAL = 'scrubbill_use_cart_sub_total';

	/**
	 * Key for the failover label setting.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const FAILOVER_LABEL_KEY = 'scrubbill_failover_label';

	/**
	 * Key for the failover rate setting.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const FAILOVER_RATE_KEY = 'scrubbill_failover_rate';

	/**
	 * Hooks
	 *
	 * @since 1.0
	 */
	public function hooks() {
		add_filter( 'woocommerce_get_sections_shipping', [ $this, 'add_settings_section' ] );
		add_filter( 'woocommerce_get_settings_shipping', [ $this, 'add_settings' ], 10, 2 );
		add_filter( 'woocommerce_admin_field_scrubbill_api_check', [ $this, 'check_api' ], 10 );
	}

	/**
	 * Add settings section to WooCommerce shipping options page.
	 *
	 * @param array $sections The existing settings.
	 *
	 * @since 1.0
	 */
	public function add_settings_section( $sections ) {
		$sections[ self::SETTINGS_PAGE ] = __( 'Scrubbill', 'scrubbill' );
		return $sections;
	}

	/**
	 * Add settings to the settings section.
	 *
	 * @param array  $settings        List of already configured settings.
	 * @param string $current_section The currently selected section.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function add_settings( $settings, $current_section ) {
		if ( self::SETTINGS_PAGE === $current_section ) {
			return [
				[
					'name'     => __( 'Scrubbill', 'scrubbill' ),
					'type'     => 'title',
					'desc'     => __( 'The following options are used to configure Scrubbill', 'scrubbill' ),
					'id'       => 'scrubbill',
				],
				[
					'name'     => __( 'Scrubbill API Token', 'scrubbill' ),
					'desc_tip' => __( 'Find the API token in your Scrubbill.com account', 'scrubbill' ),
					'id'       => self::API_TOKEN_KEY,
					'type'     => 'password',
					'desc'     => __( 'API token to connect to Scrubbill', 'scrubbill' ),
					'autoload' => false,
				],
				[
					'name'     => __( 'API Status', 'scrubbill' ),
					'type'     => 'scrubbill_api_check',
				],
				[
					'name'     => __( 'Update Shipping Labels', 'scrubbill' ),
					'id'       => self::OVERRIDE_LABELS_KEY,
					'type'     => 'checkbox',
					'desc'     => __( 'Overrides default WooCommerce labels to match Scrubbill address fields', 'scrubbill' ),
					'default'  => 'yes',
					'autoload' => false,
				],
				[
					'name'     => __( 'Use Cart Sub-Total', 'scrubbill' ),
					'id'       => self::USE_CART_SUB_TOTAL,
					'type'     => 'checkbox',
					'desc'     => __( 'Use cart Sub-Total instead of cart Total in rate calculation', 'scrubbill' ),
					'default'  => 'no',
					'autoload' => false,
				],
				[
					'name'     => __( 'Failover Shipping Label', 'scrubbill' ),
					'desc_tip' => __( 'The label to show on the checkout page next to the rate', 'scrubbill' ),
					'id'       => self::FAILOVER_LABEL_KEY,
					'type'     => 'text',
					'desc'     => __( 'Text label for the failover shipping rate', 'scrubbill' ),
					'autoload' => false,
				],
				[
					'name'     => __( 'Failover Shipping Rate', 'scrubbill' ),
					'desc_tip' => __( 'The rate to use if Scrubbill does not return a rate', 'scrubbill' ),
					'id'       => self::FAILOVER_RATE_KEY,
					'type'     => 'number',
					'desc'     => __( 'Rand value to charge for the failover shipping rate', 'scrubbill' ),
					'autoload' => false,
				],
				[
					'type'     => 'sectionend',
					'id'       => 'scrubbill',
				],
			];
		}

		return $settings;
	}

	/**
     * UI for displaying whether or not the API is connected.
     *
     * @since 1.0
     *
	 * @param array $args UI arguments.
	 */
	public function check_api( $args ) {
		$connected = __( 'Connection Failed - Please check token', 'scrubbill' );

		if ( ! empty( get_option( self::API_TOKEN_KEY ) ) ) {
			$api = Bootstrap::get_instance()->get_container( 'API' );

            // Make a test token call to check if we're connected.
            $rates = $api->request( 'token' );

			if ( false !== $rates ) {
				$connected = __( 'Connected', 'scrubbill' );
			}
        }
		?>
		<tr valign="top">
			<th scope="row" class="titledesc">
				<label><?php echo esc_html( $args['title'] ); ?></label>
			</th>
			<td>
                <?php echo esc_html( $connected ); ?>
			</td>
		</tr>
		<?php
	}
}
