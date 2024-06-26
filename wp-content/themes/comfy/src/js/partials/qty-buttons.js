(function($) {
	$( 'body' ).on(
		'click',
		'.btn-qty',
		function () {
			let $this   = $( this );
			let $qty    = $this.closest( '.quantity' ).find( '.qty' );
			let val     = parseFloat( $qty.val() );
			let max     = parseFloat( $qty.attr( 'max' ) );
			let min     = parseFloat( $qty.attr( 'min' ) );
			let step    = parseFloat( $qty.attr( 'step' ) );
			let $button = $this.closest( '.card-product' ).find( '.add_to_cart_button' );

			$( ".actions .button[name='update_cart']" ).removeAttr( 'disabled' );

			if ($this.is( '.plus' )) {
				if (max && (max <= val)) {
					$qty.val( max );
					$button.attr( 'data-quantity', max );
				} else {
					$qty.val( val + step );
					$button.attr( 'data-quantity', (val + step) );
				}
			} else {
				if (min && (min >= val)) {
					$qty.val( min );
					$button.attr( 'data-quantity', min );
				} else if (val > 1) {
					$qty.val( val - step );
					$button.attr( 'data-quantity', (val - step) );
				}
			}
			$qty.trigger( "change" );
		}
	);
})( jQuery );
