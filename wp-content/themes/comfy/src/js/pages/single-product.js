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
				$( '.gallery-nav-item.active' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				$( [document.documentElement, document.body] ).animate(
					{
						scrollTop: (scrollTo.offset().top - 120)
					},
					600
				);
			}
		);
		$.fn.isInViewport = function(offset) {
			if ($( this ).length) {
				var elementTop     = $( this ).offset().top,
					elementBottom  = elementTop + $( this ).outerHeight(),
					viewportTop    = $( window ).scrollTop(),
					viewportBottom = viewportTop + $( window ).height();

				return elementBottom > viewportTop && (elementTop + offset) < viewportBottom;
			}
		};
		$( window ).on(
			'resize scroll',
			function() {
				var galleryItem = $( 'div.gallery-item' );
				galleryItem.each(
					function () {
						if ($( this ).isInViewport( 360 )) {
							console.log( $( this ).data( 'item' ) );
							const currentGalleryNavItem = $( '.gallery-nav-item-' + $( this ).data( 'item' ) );
							if ( ! currentGalleryNavItem.hasClass( 'active' )) {
								$( '.gallery-nav-item.active' ).removeClass( 'active' );
								currentGalleryNavItem.addClass( 'active' );
							}
						}
					}
				);
			}
		);

		$( '.btn-qty' ).click(
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
		$( '.size-guide' ).click(
			function () {

			}
		);

		function initpPoductCarousel() {
			var productCarousel = $( '.woocommerce-product-gallery-items' );
			if (productCarousel.length) {
				productCarousel.each(
					function () {
						if ($( this ).hasClass( 'slick-initialized' )) {
							return;
						}
						$( this ).slick(
							{
								infinite: true,
								dots: true,
								arrows: false,
								slidesToShow: 1,
								slidesToScroll: 1,
								speed: 1000,
								mobileFirst: true,
								responsive: [
									{
										breakpoint: 480,
										settings: "unslick"
								}
								]
							}
						);
					}
				);
			}
		}
		$( document ).on(
			'found_variation',
			'form.cart',
			function () {
				initpPoductCarousel();
			}
		);

	}
);
