<?php /* Template Name: Registration Page */
$my_account_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );

if ( is_user_logged_in() ) {
	wp_safe_redirect( $my_account_url );
}

$page_image_id = get_field( 'registration_image_id', 'options' );


wp_enqueue_script( 'password-strength-meter' );
wp_enqueue_script( 'wc-password-strength-meter' );
account_forms_scripts();
wp_enqueue_style( 'login-registration', get_template_directory_uri() . '/dist/css/pages/login-registration.css', array(), '', 'all' );

get_header();
?>
	<main class="main">
		<div class="woocommerce">
			<div class="woocommerce-notices-wrapper"><?php wc_print_notices(); ?></div>
			<section class="log-reg-section">
				<div class="container">
					<div class="row">
						<div class="col">
							<h2 class="form-title"><?php _e( 'Create Account', 'comfy' ); ?></h2>
							<form id="registration-form" method="post" class="ajax-account-form woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

								<?php do_action( 'woocommerce_register_form_start' ); ?>

								<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label class="full-name">
										<span class="label"><?php esc_html_e( 'Full Name', 'comfy' ); ?>&nbsp;<span class="required">*</span></span>
										<span class="form-field">
											<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="first-name" id="first-name" autocomplete="given-name" placeholder="<?php _e( 'First Name', 'comfy' ); ?>"/>
										</span>
										<span class="form-field">
											<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="last-name" id="last-name" autocomplete="family-name" placeholder="<?php _e( 'Last Name', 'comfy' ); ?>"/>
										</span>
										</label>
								</div>
								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

									<p class="form-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
										<label for="username"><?php esc_html_e( 'Username', 'comfy' ); ?>&nbsp;<span class="required">*</span></label>
										<input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username"/>
									</p>

								<?php endif; ?>

								<p class="form-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="email"><?php esc_html_e( 'Email address', 'comfy' ); ?>&nbsp;<span class="required">*</span></label>
									<input type="email" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="email" id="email" autocomplete="email" placeholder="<?php _e( 'Email', 'comfy' ); ?>"/>
								</p>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

									<p class="form-field woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
										<label for="reg_password"><?php esc_html_e( 'Password', 'comfy' ); ?>&nbsp;<span class="required">*</span></label>
										<input type="password" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="reg_password" id="reg_password" autocomplete="new-password" placeholder="<?php _e( 'Password', 'comfy' ); ?>"/>
										<span id="password-strength" class="woocommerce-password-strength"></span>
									</p>

								<?php else : ?>

									<p><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'comfy' ); ?></p>

								<?php endif; ?>

								<?php do_action( 'woocommerce_register_form' ); ?>
								<input type="hidden" name="action" value="ajax_registration">
								<p class="woocommerce-form-row form-row form-row-button">
									<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" disabled value="<?php esc_attr_e( 'Register', 'comfy' ); ?>">
										<?php esc_html_e( 'Sing up', 'comfy' ); ?>
									</button>
								</p>

								<?php do_action( 'woocommerce_register_form_end' ); ?>

							</form>
							<p class="form-row-bottom link-text"><?php _e( 'Already have an account?', 'comfy' ); ?> <a href="<?php echo $my_account_url; ?>"><?php _e( 'Sign In', 'comfy' ); ?></a></p>
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
		</div>
	</main>
<?php
get_footer();
