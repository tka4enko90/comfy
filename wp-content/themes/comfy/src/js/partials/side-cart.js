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
			var body = $( 'body' );
			body.css( 'width', body.width() ).css( 'overflow', 'hidden' );
			this.cartWrap.addClass( 'active' );
		},
		hideCart: function() {
			this.cartWrap.removeClass( 'active' );
			$( 'body' ).removeAttr( "style" );
		},
		initQtyChange: function() {
			var self = this;
			$( 'body' ).on(
				'change paste keyup',
				'.woocommerce-mini-cart-item .qty', // Change to '.woocommerce-mini-cart-item .qty'
				function () {
					var cartItem            = $( this ).parents( '.woocommerce-mini-cart-item' ),
						cartItemID          = cartItem.find( 'input[name="product_id"]' ).val(),
						cartItemVariationID = cartItem.find( 'input[name="variation_id"]' ).val(),
						cartItemKey         = cartItem.find( 'input[name="product_key"]' ).val(),
						cartItemQty         = $( this ).val(),
						data                = {
							action: 'set_mini_cart_item_quantity',
							cart_item_key: cartItemKey,
							cart_item_qty: cartItemQty,
							product_id: cartItemID,
							variation_id: cartItemVariationID,
					};
					if (cartItemKey) {
						window.ajaxCall( data ).success( self.updateCart.bind( self ) ).fail( self.ajaxFail );
					}

				}
			);
		},
		updateCart: function(data) {
			if (data['fragments']) {
				$( document.body ).trigger( 'wc_fragment_refresh' );
			}
			this.showCart();
		},
		ajaxFail: function(data) {
			console.log( data );
			this.hideCart();
		},
		init: function () {
			var self = this;
			this.initQtyChange();
			this.initSideCartToggle();

			$( '.single_add_to_cart_button' ).on(
				'click',
				function (e) {
					e.preventDefault();
					var data = { action: 'add_product_to_cart'};
					if ($( this ).hasClass( 'bundle_add_to_cart_button' )) {

						var bundleFormFields = $( '.bundle_form' ).serializeArray(),
							bundleData       = {};

						for (let i = 0; i < bundleFormFields.length; i++) {
							bundleData[bundleFormFields[i]['name']] = bundleFormFields[i]['value'];
						}

						data['bundle_data'] = bundleData;
						data['product_id']  = $( this ).val();

					} else {
						var variableWrap         = $( this ).parent( '.woocommerce-variation-add-to-cart' );
							data['product_id']   = variableWrap.find( 'input[name="product_id"]' ).val();
							data['variation_id'] = variableWrap.find( 'input[name="variation_id"]' ).val();
							data['quantity']     = variableWrap.find( 'input[name="quantity"]' ).val();
					}
					window.ajaxCall( data ).success( self.updateCart.bind( self ) ).fail( self.ajaxFail.bind( self ) );
				}
			);
		}
	};
	sideCart.init();
})( jQuery );
