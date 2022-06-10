(function ($) {
	const slideSpeed = 600;
	$( document ).on(
		'ready',
		function () {
			$( '.faq-item-title' ).on(
				'click',
				function() {
					if ( ! $( this ).hasClass( 'active' )) {
						$( '.faq-item-title.active' ).removeClass( 'active' ).parent( '.faq-item' ).find( '.faq-item-content' ).slideToggle( slideSpeed );
					}
					$( this ).toggleClass( 'active' ).parent( '.faq-item' ).find( '.faq-item-content' ).slideToggle( slideSpeed );
				}
			);
		}
	);
})( jQuery );
