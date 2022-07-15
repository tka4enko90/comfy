(function($) {
	const sideCart = {
		cartWrap: $( '#side-cart-wrap' ),
		initSideCartToggle: function() {
			var self = this;

			$( '.cart-link.secondary-header-nav-el' ).click(
				function (e) {
					e.preventDefault();
					self.showCart();
				}
			);

			$( 'body' ).on(
				'click',
				function (e) {
					if ($( e.target ).is( self.cartWrap ) || $( e.target ).is( '.close-cart' )) {
						self.hideCart();
					}
				}
			);

		},
		showCart: function() {
			this.cartWrap.addClass( 'active' );
			//$( 'body' ).css( 'width', body.width() ).css( 'overflow', 'hidden' );
		},
		hideCart: function() {
			this.cartWrap.removeClass( 'active' );
			$( 'body' ).removeAttr( "style" );
		},
		// addProductToCart( e ) {
		// 	e.preventDefault();
		// 	//alert( 'ok' )
		//
		// },
		updateCart: function(data) {
			this.showCart();
			$('.side-cart-content').html(data['fragments']['div.widget_shopping_cart_content']);
			console.log(data['fragments']['div.widget_shopping_cart_content']);
			alert( 'sucsess' );
		},
		ajaxFail: function(data) {
			console.log(data);
			alert( 'fail' );
		},
		init: function () {
			var self = this;
			//this.cartWrap = $( '#side-cart-wrap' );
			this.initSideCartToggle();

			$( '.single_add_to_cart_button' ).on(
				'click',
				function (e) {
					e.preventDefault();
					var variableWrap = $( this ).parent( '.woocommerce-variation-add-to-cart' ),
						productID    = variableWrap.find( 'input[name="product_id"]' ).val(),
						variationID  = variableWrap.find( 'input[name="variation_id"]' ).val(),
						quantity     = variableWrap.find( 'input[name="quantity"]' ).val();

					var data = {
						action: 'add_variable_product_to_cart',
						product_id: productID,
						variation_id: variationID,
						quantity: quantity,
					};
					window.ajaxCall( data ).success( self.updateCart.bind(self) ).fail( self.ajaxFail );

					//self.addProductToCart( e );
				}
			);
		}
	};
	sideCart.init();
})( jQuery );
