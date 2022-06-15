<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'login-registration', get_template_directory_uri() . '/dist/css/pages/login-registration.css', array(), '', 'all' );

do_action( 'woocommerce_before_lost_password_form' );
?>
<section class="lost-password-section log-reg-section">
	<div class="container">
		<h2 class="form-title"><?php echo __( 'Reset Password', 'comfy' ); ?></h2>
		<form id="lost-password" method="post" class="ajax-account-form woocommerce-form woocommerce-ResetPassword lost_reset_password">

            <p class="form-msg"><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'We will send you an email to reset your password.', 'comfy' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>


			<div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
				<div class="form-field">
					<label for="user_login"><?php esc_html_e( 'Email', 'comfy' ); ?></label>
					<input class="form-control woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php echo __( 'Email', 'comfy' ); ?>"/>
				</div>
			</div>


			<div class="clear"></div>

			<?php do_action( 'woocommerce_lostpassword_form' ); ?>
			<p class="woocommerce-form-row form-row form-row-reset">
				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Submit', 'comfy' ); ?>">
					<?php esc_html_e( 'Submit', 'comfy' ); ?>
				</button>
			</p>

			<input type="hidden" name="action" value="ajax_lost_password">
		</form>
		<p class="form-row-bottom link-text"><?php echo __( 'Remember your password?', 'comfy' ); ?> <a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"><?php echo __( ' Back to login', 'comfy' ); ?></a></p>
	</div>
</section>
<?php
do_action( 'woocommerce_after_lost_password_form' );
