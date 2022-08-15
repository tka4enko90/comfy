(function ($) {
	$( document ).on(
		'ready',
		function () {
			$( '.aw-email-referral-form' ).attr( 'data-emails', 1 );
			var emailsInputs     = $( '.aw-email-referral-form .form-row' ),
				emailsLen        = emailsInputs.length,
				currentEmailsLen = 1;
			$( '.aw-referrals-share-or' ).on(
				'click',
				function () {
					if (currentEmailsLen < emailsLen) {
						$( '.aw-email-referral-form .form-row:nth-of-type(' + ++currentEmailsLen + ')' ).css( 'display', 'block' );
					} else {
						$( this ).css( 'display', 'none' );
					}
				}
			);
		}
	);
})( jQuery );
