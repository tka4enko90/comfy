(function($) {
	const productBundle = {
		stepsWrap: $( '.bundle-steps-wrap' ),
		currentStep: 0,
		stepsNum: NaN,
		loadedVariations: [],
		initBundleVariationsGallery: function () {
			var self = this;
			$( '.bundled_product' ).on(
				'woocommerce_variation_has_changed',
				function () {
					let variationId = $( this ).find( 'input.variation_id' ).attr( 'value' );
					if (variationId) {
						if (self.loadedVariations.includes( variationId )) {
							self.activateLoadedGallery( variationId );
						} else {
							self.loadedVariations.push( variationId );
							self.getVariationGallery( variationId );
						}
					}
				}
			);
		},
		getVariationGallery: function(variationId) {
			var request = {
				"ajax_url": '/?wc-ajax=wc_additional_variation_images_get_images',
				"variation_id": variationId,
				"security": wc_additional_variation_images_local.ajaxImageSwapNonce,
			};
			window.ajaxCall( request ).success( this.ajaxSuccess.bind( this ) ).fail( this.ajaxFail.bind( this ) );
		},
		appendVariationGallery: function(variationId, galleryLayout) {
			var variationGalleryWrap = this.getVariationGalleryWrap( variationId );
			variationGalleryWrap.append( galleryLayout );

			var loadedGallery = $( '.woocommerce-product-gallery--variation-' + variationId );
			if (loadedGallery[0]) {
				variationGalleryWrap.find( '.woocommerce-product-gallery.active' ).removeClass( 'active' );
				loadedGallery.addClass( 'active' );
				loadedGallery.css( 'opacity', 1 );
				this.activateLoadedGallery( variationId, variationGalleryWrap );
			}
		},
		getVariationGalleryWrap: function(variationId) {
			return $( 'input.variation_id[value=' + variationId + ']' ).parents( 'div.bundled_product' ).find( '.variation-gallery-wrap' );
		},
		activateLoadedGallery: function(variationId) {
			var loadedGallery        = $( '.woocommerce-product-gallery--variation-' + variationId ),
				variationGalleryWrap = this.getVariationGalleryWrap( variationId );
			if (loadedGallery[0]) {
				variationGalleryWrap.find( '.woocommerce-product-gallery.active' ).removeClass( 'active' );
				loadedGallery.addClass( 'active' );
				loadedGallery.css( 'opacity', 1 );
			}
		},
		updateLastStepGallery: function() {
			var lastStepGalleryNav   = $( '#bundle-last-step-gallery .woocommerce-product-gallery-nav' ).empty(),
				lastStepGalleryItems = $( '#bundle-last-step-gallery .woocommerce-product-gallery-items' ).empty();

			if (lastStepGalleryItems.hasClass( 'slick-initialized' )) {
				lastStepGalleryItems.slick( 'unslick' ).empty();
			}

			$( '.variation-gallery-wrap .woocommerce-product-gallery.active' ).each(
				function () {
					var galleryItem    = $( this ).find( '.woocommerce-product-gallery-items' ).hasClass( 'slick-initialized' ) ? $( this ).find( '.slick-slide[data-slick-index="0"] .gallery-item' ).first().clone() : $( this ).find( '.gallery-item' ).first().clone(),
						galleryItemNav = $( this ).find( '.gallery-nav-item' ).first().clone();
					lastStepGalleryItems.append( galleryItem );
					lastStepGalleryNav.append( galleryItemNav );
				}
			);

			lastStepGalleryItems.not( '.slick-initialized' ).slick(
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
		},
		updateLastStepItems: function() {
			$( '.variations_form' ).each(
				function () {
					var variationsData    = $( this ).data( 'product_variations' ),
					variationId           = parseInt( $( this ).find( 'input.variation_id' ).attr( 'value' ) ),
					currentVariationImage = {},
					productId             = $( this ).data( 'product_id' ),
					bundledItem           = $( '#bundle-item-' + productId );
					$( this ).find( '.attribute_options' ).each(
						function () {
							var attributeName       = $( this ).find( '.variable-items-wrapper' ).data( 'attribute_name' ),
								attributeValueLabel = $( this ).find( '.variable-item.selected' ).data( 'title' );
							bundledItem.find( '.' + attributeName ).text( attributeValueLabel )
						}
					);
					$( variationsData ).each(
						function () {
							if (variationId === this['variation_id']) {
								currentVariationImage = this.image;
								return;
							}
						}
					);
					bundledItem.find( 'img' ).attr( 'src', currentVariationImage.src ).attr( 'srcset', currentVariationImage.srcset );
				}
			);
		},
		updateLastStep: function() {
			this.updateLastStepItems();
			this.updateLastStepGallery();
		},
		ajaxSuccess: function(response) {
			if (response['main_images'] && response['variation_id']) {
				this.appendVariationGallery( response['variation_id'], response['main_images'] );
				$( window ).trigger( 'wc_additional_variation_images_frontend_lightbox_done' );
			}
		},
		ajaxFail: function(response) {
			console.log( response )
		},
		goToStep: function(stepNum) {
			var oldStep = $( '.bundle-step.current-step' ),
				newStep = $( '.bundle-step[data-step=' + stepNum + ']' );
			newStep.addClass( 'current-step' );
			oldStep.removeClass( 'current-step' );
		},
		initStepsBtns: function() {
			var self = this;
			$( '.bundle-step-button' ).on(
				'click',
				function (e) {
					e.preventDefault();
					if ($( this ).hasClass( 'prev-step-bundle' )) {
						self.currentStep--
					} else {
						self.currentStep++
					}
					if (self.currentStep === self.stepsNum) {
						self.updateLastStep();
					}
					self.goToStep( self.currentStep )
				}
			);
			$( '.bundle-item-change-link' ).on(
				'click',
				function (e) {
					e.preventDefault();
					self.currentStep = $( this ).data( 'step' );
					self.goToStep( self.currentStep );
					$( '.woocommerce-product-gallery-items.slick-initialized' ).slick( 'refresh' );
				}
			);
		},
		init: function () {
			this.stepsNum    = this.stepsWrap.data( 'steps' );
			this.currentStep = $( '.bundle-step.current-step' ).data( 'step' );

			this.initBundleVariationsGallery();
			this.initStepsBtns();
		}
	};
	productBundle.init();
})( jQuery );
