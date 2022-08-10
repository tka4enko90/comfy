<?php
/**
 * Checkout Fields.
 *
 * Custom fields for the checkout process.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class Checkout_Fields
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */
class Checkout_Fields {

	/**
	 * Postnet branch ID order custom field key.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const POSTNET_BRANCH_KEY = 'scrubbill_postnet_branch_id';

	/**
	 * Postnet branch key for storing the branch name.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const POSTNET_BRANCH_NAME_KEY = 'scrubbill_postnet_branch_name';

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */
	public function hooks() {
		add_action( 'woocommerce_review_order_after_shipping', [ $this, 'render_postnet_selector' ] );
		add_action( 'woocommerce_checkout_process', [ $this, 'validate_postnet_field' ] );
		add_action( 'woocommerce_checkout_update_order_meta', [ $this, 'save_postnet_field' ] );
		add_action( 'woocommerce_before_order_itemmeta', [ $this, 'show_postnet_branch' ], 10, 2 );
	}

	/**
	 * Render Postnet selector custom field.
	 *
	 * @since 1.0
	 */
	public function render_postnet_selector() {
		$shipping_method = WC()->session->get( 'chosen_shipping_methods' );

		// Only show this form when Postnet has been selected.
		if ( 'POSTNET' !== $shipping_method[0] ) {
			return;
		}
		?>
		<tr class="shipping-postnet">
			<th><?php esc_html_e( 'Postnet Branch', 'scrubbill' ); ?></th>
			<td>
				<script>
					(function($){
						$(document).ready(function(){
							$('#scrubbill_postnet_branch_id').selectWoo();
						});
					})(jQuery);
				</script>
				<?php
				woocommerce_form_field(
					self::POSTNET_BRANCH_KEY,
					[
						'type'     => 'select',
						'required' => true,
						'options'  => [ '' => __( 'Select a Postnet', 'scrubbill' ) ] + $this->get_postnet_branches(),
					]
				);
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Make sure the user enters a Postnet branch if they selected the Postnet shipping method.
     *
     * @since 1.0
	 */
	public function validate_postnet_field() {
		if ( empty( $_POST['shipping_method'][0] ) || 'POSTNET' !== $_POST['shipping_method'][0] ) {
			return;
		}

		if ( empty( $_POST[ self::POSTNET_BRANCH_KEY ] ) ) {
			wc_add_notice( __( 'Please select a Postnet branch.', 'scrubbill' ), 'error' );
		}
	}

	/**
	 * Save the postnet field that was selected.
	 *
	 * @since 1.0
	 *
	 * @param int $order_id The order ID.
	 */
	public function save_postnet_field( $order_id ) {
		if ( ! empty( $_POST[ self::POSTNET_BRANCH_KEY ] ) ) {
			$branch_id = sanitize_text_field( wp_unslash( $_POST[ self::POSTNET_BRANCH_KEY ] ) );
			update_post_meta( $order_id, self::POSTNET_BRANCH_KEY, $branch_id );

			$branches    = $this->get_postnet_branches();
			$branch_name = empty( $branches[ $branch_id ] ) ?: $branches[ $branch_id ];

			if ( ! empty( $branch_name ) ) {
				update_post_meta( $order_id, self::POSTNET_BRANCH_NAME_KEY, $branch_name );
			}
		}
	}

	/**
     * Display the Postnet branch that the user selected.
     *
     * @since 1.0
     *
	 * @param int    $item_id The ID of the item.
	 * @param object $item The item object.
	 */
	public function show_postnet_branch( $item_id, $item ) {
	    if ( ! is_object( $item ) || ! is_a( $item, 'WC_Order_Item_Shipping' ) ) {
	        return;
	    }

	    $branch_name = get_post_meta( get_the_ID(), self::POSTNET_BRANCH_NAME_KEY, true );

	    if ( ! empty( $branch_name ) ) {
		    ?>
            <div class="view">
                <?php esc_html_e( 'Postnet branch:', 'scrubbill' ); ?>
                <?php echo esc_html( $branch_name ); ?>
            </div>
            <?php
		}
	}

	/**
	 * Get Postnet branches.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	protected function get_postnet_branches() {
		return get_option( Scrubbill_Shipping_Method::POSTNET_BRANCHES_KEY );
	}
}
