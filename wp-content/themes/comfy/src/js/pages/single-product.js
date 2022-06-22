(function($) {
	const productPage = {
		isVariableProduct: function () {
			return $( '.product' ).hasClass( 'product-type-variable' );
		},
		initProductVariationPrice: function() {
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
		},
		initpPoductCarousel: function (variation_id) {
			var $currentGallery;

			if (variation_id) {
				$currentGallery = $( '.woocommerce-product-gallery--variation-' + variation_id ).find( '.woocommerce-product-gallery-items' );
			} else {
				$currentGallery = $( '.woocommerce-product-gallery' ).find( '.woocommerce-product-gallery-items' );
			}
			if ($currentGallery.length) {
				$currentGallery.each(
					function () {
						if ($( this ).hasClass( 'slick-initialized' )) {
							$( this ).slick( 'refresh' );
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
		},
		scrollToGallery: function () {
			var scrollTo = 0;

			if (window.matchMedia( "(max-width: 766px)" ).matches) {
				scrollTo = $( '.product_title' ).offset().top - $( '.site-header' ).height();
				$( 'html, body' ).animate(
					{
						scrollTop: scrollTo
					}
				)
			}

		},
		initGallery: function() {
			var self = this;
			$( window ).on(
				'wc_additional_variation_images_frontend_lightbox_done resize',
				function () {
					if (self.isVariableProduct()) {
						self.initpPoductCarousel( $( '[name="variation_id"]' ).val() );
					} else {
						self.initpPoductCarousel( false );
					}
					$( '.woocommerce-product-gallery__wrapper' ).css( 'opacity', '1' );
				}
			);

			$( '.variations_form' ).on(
				'woocommerce_variation_has_changed',
				function (e) {
					self.scrollToGallery();
				}
			);
		},
		initGalleryNav: function() {
			$.fn.isInViewport = function (offset) {
				if ($( this ).length) {
					var elementTop     = $( this ).offset().top,
						elementBottom  = elementTop + $( this ).outerHeight(),
						viewportTop    = $( window ).scrollTop(),
						viewportBottom = viewportTop + $( window ).height();

					return elementBottom > viewportTop && (elementTop + offset) < viewportBottom;
				}
			};
			$( 'body' ).on(
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

			$( window ).on(
				'resize scroll',
				function () {
					var galleryItem = $( 'div.gallery-item' );
					galleryItem.each(
						function () {
							if ($( this ).isInViewport( 360 )) {
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
		},
		initImageZoom: function() {
			$( 'body' ).on(
				'click',
				'.woocommerce-product-gallery__image a',
				function (e) {
					e.preventDefault();
					var img       = $( this ).children( 'img' ),
						imgHeight = img.height(),
						zoomedUrl = img.data( 'large_image' );

					$( this ).toggleClass( 'zoom-active' );
					if ($( this ).hasClass( 'zoom-active' )) {

						$( this ).css( 'height', imgHeight );
						img.attr( 'srcset', zoomedUrl );
						this.addEventListener(
							'mousemove',
							function (e,o) {
								var offs = $( this ).offset(),
									x    = e.pageX - offs.left,
									y    = e.pageY - offs.top;
								img.css( 'right', Math.round( (x / img.attr( 'width' )) * 100 ) + '%' );
								img.css( 'bottom', Math.round( (y / img.attr( 'height' )) * 100 ) + '%' );
							}
						);
					} else {
						img.attr( 'srcset', img.attr( 'src' ) );
						$( this ).css( 'height', 'auto' );
					}

				}
			).on(
				'mouseleave',
				'.woocommerce-product-gallery__image a.zoom-active',
				function () {
					var img = $( this ).children( 'img' );
					img.attr( 'srcset', img.attr( 'src' ) );
					$( this ).removeClass( 'zoom-active' );
					$( this ).css( 'height', 'auto' );
				}
			);
		},
		initQtyButtons: function() {
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

				}
			);
		},
		initSizeGuide: function() {
			var sizeGuideWrap = $( '#size-guide-wrap' ),
			body              = $( 'body' );

			$( '.size-guide-link' ).click(
				function () {
					sizeGuideWrap.addClass( 'active' );
					body.css( 'overflow', 'hidden' );
				}
			);
			body.on(
				'click',
				function (e) {
					if ($( e.target ).is( sizeGuideWrap ) || $( e.target ).is( '.close-guide' )) {
						sizeGuideWrap.removeClass( 'active' );
						body.removeAttr( "style" );
					}
				}
			);
		},
		init: function () {
			this.initGallery();
			this.initGalleryNav();
			this.initImageZoom();
			this.initQtyButtons();
			this.initProductVariationPrice();
			this.initSizeGuide();
		}
	};
	productPage.init();
})( jQuery );
