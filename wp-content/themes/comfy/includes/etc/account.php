<?php

function account_forms_scripts() {
	$translation_array = array(
		'account_nonce_key' => wp_create_nonce( 'account-nonce-key' ),
	);
	wp_enqueue_script( 'account-forms', get_template_directory_uri() . '/dist/js/partials/ajax-account-forms.js', array( 'jquery' ), '', true );
	wp_localize_script( 'account-forms', 'cpm_object', $translation_array );
}
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( is_account_page() ) {
			account_forms_scripts();
		}
	}
);


function cmf_get_escaped_fields( $fields_names ) {
	$fields = array();
	foreach ( $fields_names as $field_name ) {
		$fields[ $field_name ] = esc_html( $_POST[ $field_name ] );
	}
	return $fields;
}

add_action(
	'wp_ajax_nopriv_ajax_login',
	function () {
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'account-nonce-key', 'security' );

		//Fields Validation
		$validation_obj = new Validation_Errors();
		$validate_rules = array(
			'username' => array(
				'required',
			),
			'password' => array(
				'required',
			),
		);
		$fields_names   = array( 'username', 'password' );
		$fields         = cmf_get_escaped_fields( $fields_names );
		if ( $validation_obj->validate_fields( $validate_rules, $fields ) ) {
			wp_send_json_error( array( 'errors' => $validation_obj->get_errors() ), 400 );
			wp_die();
		}

		$user_info['user_login']    = $fields['username'];
		$user_info['user_password'] = $fields['password'];
		$user_info['remember']      = true;

		$user_signon = wp_signon( $user_info, false );
		if ( is_wp_error( $user_signon ) ) {
			if ( isset( $user_signon->errors['invalid_username'] ) ) {
				$validation_obj->add_error( 'username', __( 'The username is not registered on this site.', 'comfy' ) );
			}
			if ( isset( $user_signon->errors['incorrect_password'] ) ) {
				$validation_obj->add_error( 'password', __( 'The password you entered is incorrect.', 'comfy' ) );
			}
			wp_send_json_error( array( 'errors' => $validation_obj->get_errors() ), 400 );
		} else {
			wp_send_json_success( __( 'Login successful, redirecting...', 'comfy' ) );
		}
		wp_die();
	}
);

add_action(
	'wp_ajax_nopriv_ajax_registration',
	function () {
		check_ajax_referer( 'account-nonce-key', 'security' );

		//Fields Validation
		$validation_obj = new Validation_Errors();
		$validate_rules = array(
			'first-name'   => array(
				'required',
			),
			'last-name'    => array(
				'required',
			),
			'email'        => array(
				'required',
				'email',
				'uniq_email',
			),
			'reg_password' => array(
				'required',
			),
		);
		$fields_names   = array( 'first-name', 'last-name', 'email', 'reg_password' );
		$fields         = cmf_get_escaped_fields( $fields_names );

		if ( $validation_obj->validate_fields( $validate_rules, $fields ) ) {
			wp_send_json_error( array( 'errors' => $validation_obj->get_errors() ), 400 );
			wp_die();
		}

		// Register New User
		$user_id = wp_create_user( $fields['email'], $fields['reg_password'], $fields['email'] );
		if ( ! is_wp_error( $user_id ) ) {
			$user = new WP_User( $user_id );
			$user->set_role( 'customer' );
			$user->first_name   = $fields['first-name'];
			$user->last_name    = $fields['last-name'];
			$user->display_name = $fields['first-name'] . ' ' . $fields['last-name'][0] . '.';
			wp_update_user( $user );

			//Log In New User
			$creds                  = array();
			$creds['user_login']    = $fields['email'];
			$creds['user_password'] = $fields['reg_password'];
			$creds['remember']      = false;
			$user                   = wp_signon( $creds, false );

			if ( ! is_wp_error( $user ) ) {
				wp_send_json_success( __( 'Registration Successful', 'comfy' ) );
				wp_die();
			}
		}

		wp_send_json_error( __( 'Something went wrong', 'comfy' ), 500 );
		wp_die();
	}
);

add_action(
	'wp_ajax_nopriv_ajax_lost_password',
	function () {
		check_ajax_referer( 'account-nonce-key', 'security' );

		//Fields Validation
		$validation_obj = new Validation_Errors();
		$validate_rules = array(
			'user_login' => array(
				'required',
			),
		);
		$fields_names   = array_keys( $validate_rules );
		$fields         = cmf_get_escaped_fields( $fields_names );
		if ( $validation_obj->validate_fields( $validate_rules, $fields ) ) {
			wp_send_json_error( array( 'errors' => $validation_obj->get_errors() ), 400 );
			wp_die();
		}

		if ( WC_Shortcode_My_Account::retrieve_password() ) {
			$success_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . 'lost-password/?reset-link-sent=true';
			wp_send_json_success( array( 'redirect_to' => $success_page_url ) );
			exit;
		} else {
			wp_send_json_error( array( 'errors' => array( 'user_login' => __( 'Invalid username or email.', 'comfy' ) ) ), 400 );
		}
		exit;
	}
);

// Registration page content
add_action(
	'parse_request',
	function ( $wp ) {
		if ( 'my-account/registration' === $wp->request ) {
			get_template_part( 'template-parts/registration-page' );
			exit;
		}
	}
);

// Min Password Strength
add_filter(
	'woocommerce_min_password_strength',
	function ( $strength ) {
		$min_strength = get_field( 'min_user_password_strength', 'options' );
		if ( isset( $min_strength ) ) {
			return intval( $min_strength );

		}
		// 3 => Strong (default) | 2 => Medium | 1 => Weak | 0 => Very Weak (anything).
		return 2;
	}
);

