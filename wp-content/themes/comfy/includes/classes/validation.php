<?php
class Validation_Errors {
	private $errors = array();

	public function add_error( $field_name, $message ) {
		$this->errors[ $field_name ] = $message;
	}
	public function get_errors() {
		return $this->errors;
	}
	public function has_errors() {
		return ( count( $this->errors ) > 0 ) ? true : false;
	}

	public function validate_fields( $validate_rules, $fields, $rules_for_all_fields = array() ) {
		foreach ( $fields as $field_name => $field_value ) {
			if ( isset( $validate_rules[ $field_name ] ) ) {
				// Add Required Rules
				foreach ( $rules_for_all_fields as $required_rule ) {
					$validate_rules[ $field_name ][] = $required_rule;
				}
				// Check Fields
				foreach ( $validate_rules[ $field_name ] as $validate_rule ) {
					switch ( $validate_rule ) {
						case 'required':
							if ( ! strlen( $field_value ) ) {
								$this->add_error( $field_name, __( 'Field is required', 'comfy' ) );
							}
							break;
						case 'email':
							if ( ! filter_var( $field_value, FILTER_VALIDATE_EMAIL ) ) {
								$this->add_error( $field_name, __( 'Invalid email format', 'comfy' ) );
							}
							break;
						case 'uniq_email':
							if ( email_exists( $field_value ) ) {
								$this->add_error( $field_name, __( 'Sorry, that email address is already used!', 'comfy' ) );
							}
							break;
						case 'phone':
							if ( '' !== $field_value && ! WC_Validation::is_phone( $field_value ) ) {
								$this->add_error( $field_name, __( 'Not valid phone number.', 'comfy' ) );
							}
							break;
						case 'username':
							if ( ! validate_username( $field_value ) ) {
								$this->add_error( $field_name, __( 'Not valid username!', 'comfy' ) );
							}
							break;
						case 'uniq_username':
							if ( username_exists( $field_value ) ) {
								$this->add_error( $field_name, __( 'Sorry, that username already exists!', 'comfy' ) );
							}
							break;
						case 'password':
							$uppercase = preg_match( '@[A-Z]@', $fields['password'] );
							$lowercase = preg_match( '@[a-z]@', $fields['password'] );
							$number    = preg_match( '@[0-9]@', $fields['password'] );
							if ( ! $uppercase || ! $lowercase || ! $number || strlen( $fields['password'] ) < 8 ) {
								$this->add_error( $field_name, __( 'Password should be at least 8 characters in length and should include at least one upper case letter and one number.', 'comfy' ) );
							}
							break;
						case 'html_injection':
							if ( esc_html( $fields[ $field_name ] ) !== $fields[ $field_name ] ) {
								$this->add_error( $field_name, __( 'Not valid value', 'comfy' ) );
							}
							break;
						case 'positive_integer':
							$val = intval( $fields[ $field_name ] );
							if ( ! is_integer( $val ) || $val <= 0 ) {
								$this->add_error( $field_name, __( 'Not valid value', 'comfy' ) );
							}
							break;
						default:
							break;
					}
				}
			}
		}
		return $this->has_errors();
	}
}
