<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package    woocommerce-rma-for-return-refund-and-exchange
 * @subpackage woocommerce-rma-for-return-refund-and-exchange/public/partials
 */

get_header( 'shop' );

/**
 * Woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
*/
// Woo Mail Content.
do_action( 'woocommerce_before_main_content' );

/**
 * Woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
update_option( 'wps_rma_session_start', true );
$wps_main_wrapper_class = get_option( 'wps_wrma_exchange_form_wrapper_class' );
$wps_exchange_css       = get_option( 'wps_rma_exchange_form_css' );
?>
<style>	<?php echo wp_kses_post( $wps_exchange_css ); ?></style>
<div class="<?php echo esc_html( $wps_child_wrapper_class ); ?>">
	<div id="wps_wrma_guest_request_form_wrapper">
		<h2>
		<?php
		$page_head = get_option( 'wps_wrma_return_exchange_page_heading_text', 'Refund/Exchange Request Form' );
		if ( '' == $page_head ) {
			$page_head = esc_html__( 'Refund/Exchange Request Form', 'woocommerce-rma-for-return-refund-and-exchange' );
		}
		$return_product_form = $page_head;
		// Refund/exchange request guest form heading.
		echo esc_html( apply_filters( 'wps_rma_return_product_form', $return_product_form ) );
		?>
		</h2>
		<?php
		if ( isset( WC()->session ) && WC()->session->get( 'wps_wrma_notification' ) && '' != WC()->session->get( 'wps_wrma_notification' ) ) {
			?>
			<ul class="woocommerce-error" id="login_session_alert">
					<li><strong><?php esc_html_e( 'ERROR', 'woocommerce-rma-for-return-refund-and-exchange' ); ?></strong>: <?php echo esc_html( WC()->session->get( 'wps_wrma_notification' ) ); ?></li>
			</ul>
			<?php
			WC()->session->__unset( 'wps_wrma_notification' );
		}
		?>
		<form class="login wps_rma_guest_form" method="post">
			<input type="hidden" name="get_nonce" value="<?php echo esc_html( wp_create_nonce( 'create_form_nonce' ) ); ?>">
			<p class="">
				<label for="username"><?php esc_html_e( 'Enter Order Id', 'woocommerce-rma-for-return-refund-and-exchange' ); ?><span class="required"> *</span></label>
				<input type="text" id="order_id" name="order_id" class="">
			</p>
			<?php
			$phone_enable = get_option( 'wps_rma_guest_phone' );
			if ( 'on' === $phone_enable ) {
				?>
				<p>
					<label for="phone_number"><?php esc_html_e( 'Enter Phone Number', 'woocommerce-rma-for-return-refund-and-exchange' ); ?><span class="required"> *</span></label>
					<input type="text" class="" name="order_phone" id="order_phone" value="">
				</p>
				<?php
			} else {
				?>
				<p>
					<label for="username"><?php esc_html_e( 'Enter Order Email', 'woocommerce-rma-for-return-refund-and-exchange' ); ?><span class="required"> *</span></label>
					<input type="text" class="" name="order_email" id="order_email" value="">
				</p>
				<?php
			}
			?>
			<p class="form-row">
				<input type="submit" value="<?php esc_html_e( 'Submit', 'woocommerce-rma-for-return-refund-and-exchange' ); ?>" name="wps_wrma_order_id_submit" class="woocommerce-Button button">
			</p>
		</form>
	</div>
</div>
<?php
// Main Content.
do_action( 'woocommerce_after_main_content' );


get_footer( 'shop' );
?>
