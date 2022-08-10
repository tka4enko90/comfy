<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
wp_enqueue_style( 'login-registration', get_template_directory_uri() . '/dist/css/pages/login-registration.css', array(), '', 'all' );

$page_image_id    = get_field( 'login_image_id', 'options' );
$registration_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'registration/';

do_action( 'woocommerce_before_customer_login_form' ); ?>

	<section class="log-reg-section">
		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="form-title"><?php esc_html_e( 'Account Login', 'woocommerce' ); ?></h2>
					<form id="login-form" class="ajax-account-form woocommerce-form woocommerce-form-login login" method="post">

						<?php do_action( 'woocommerce_login_form_start' ); ?>

						<p class="form-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="username"><?php esc_html_e( 'Email', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
							<input type="text" class=" form-control woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username"/>
						</p>
						<p class="form-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
							<input class="form-control woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
						</p>

						<?php do_action( 'woocommerce_login_form' ); ?>

						<input type="hidden" name="action" value="ajax_login">
						<p class="woocommerce-form-row form-row form-row-button">
							<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
								<?php esc_html_e( 'Log in', 'woocommerce' ); ?>
							</button>
						</p>
						<?php do_action( 'woocommerce_login_form_end' ); ?>
					</form>
					<p class="form-row link-text">
						<span class="woocommerce-LostPassword lost_password">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
						</span>
					</p>
					<?php
					if ( ! empty( $registration_url ) ) {
						?>
						<p class="form-row-bottom link-text"><?php echo __( 'Don’t have an account?', 'comfy' ); ?> <a href="<?php echo $registration_url; ?>"><?php echo __( 'Registration', 'comfy' ); ?></a></p>
						<?php
					}
					?>
				</div>
				<div class="col">
					<?php
					if ( ! empty( $page_image_id ) ) {
						echo wp_get_attachment_image( $page_image_id, 'cmf_content_with_image_1' );
					}
					?>
				</div>
			</div>
		</div>
	</section>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
