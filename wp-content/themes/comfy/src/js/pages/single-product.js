jQuery(
	function($) {
		var body = $( 'body' );

		$( document ).on(
			'found_variation',
			'form.cart',
			function (event, variation) {
				console.log( variation );
				if (variation.price_html) {
					$( '.summary > p.price' ).html( variation.price_html );
				}
				$( '.woocommerce-variation-price' ).hide();
			}
		);
		$( document ).on(
			'hide_variation',
			'form.cart',
			function (event, variation) {
				$( '.summary > p.price' ).html( cmfProduct.price_html );
			}
		);

		body.on(
			'click',
			'.woocommerce-product-gallery__image a',
			function (e) {
				e.preventDefault();
				$( this ).toggleClass( 'zoom-active' );
			}
		);
		body.on(
			'click',
			'.gallery-nav-item',
			function () {
				const scrollTo = $( '.gallery-item-' + $( this ).data( 'item' ) );
				scrollTo.addClass( 'Test-123' );
				$( [document.documentElement, document.body] ).animate(
					{
						scrollTop: (scrollTo.offset().top - 120)//($( '#' + Object.keys( 'gallery-item-' + $( this ).data( 'item' ) )).offset().top - 200)
					},
					600
				);
			}
		);

		body.on(
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

				if ( $this.is( '.plus' ) ) {
					if ( max && ( max <= val ) ) {
						$qty.val( max );
						$button.attr( 'data-quantity', max );
					} else {
						$qty.val( val + step );
						$button.attr( 'data-quantity', (val + step) );
					}
				} else {
					if ( min && ( min >= val ) ) {
						$qty.val( min );
						$button.attr( 'data-quantity', min );
					} else if ( val > 1 ) {
						$qty.val( val - step );
						$button.attr( 'data-quantity', (val - step) );
					}
				}

			}
		);

	}
);
