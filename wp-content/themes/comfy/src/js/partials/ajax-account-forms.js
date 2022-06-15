jQuery( document ).ready(
	function($){
		var forms       = $( 'form#login-form, form#registration-form, form#lost-password' ),
			ajaxFail    = function(response) {
				if (response['responseJSON']['data']['errors']) {
					showErrors( response['responseJSON']['data']['errors'] );
					$( [document.documentElement, document.body] ).animate(
						{
							scrollTop: ($( '#' + Object.keys( response['responseJSON']['data']['errors'] )[0] ).offset().top - 200)
						},
						600
					);
				}
			},
			ajaxSuccess = function(response) {
				if (response.success === true) {
					if (response.data && response.data['redirect_to']) {
						location.replace( response.data['redirect_to'] )
					} else {
						location.reload();
					}
				}
			},
			clearErrors = function() {
				$( '.error-message' ).remove();
				$( '.form-field.error' ).removeClass( 'error' );
			},
			showErrors  = function(errors) {
				clearErrors();
				for (var key in errors) {
					var elWrap = $( "#" + key ).parents( '.form-field' );
					elWrap.addClass( 'error' );
					elWrap.append( '<span class="error-message">' + errors[key] + '</span>' );
				}
			};
		if (forms) {
			forms.submit(
				function (e) {
					e.preventDefault();
					var formFields = $( this ).serializeArray(),
						formData   = {};
					for (let i = 0; i < formFields.length; i++) {
						formData[formFields[i]['name']] = formFields[i]['value'];
					}
					formData['security'] = cpm_object.account_nonce_key;
					window.ajaxCall( formData ).success( ajaxSuccess ).fail( ajaxFail );
					return false;
				}
			);
			if ($( 'form#lost-password #user_login' )[0]) {
				$( '#user_login' ).on(
					'keyup',
					function () {
						$( 'button[type="submit"]' ).attr( 'disabled', false );
					}
				)
			}
		}
	}
);
