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
			var lastStepGallery      = $( '#bundle-last-step-gallery' ),
				lastStepGalleryNav   = lastStepGallery.find( '.woocommerce-product-gallery-nav' ),
				lastStepGalleryItems = lastStepGallery.find( '.woocommerce-product-gallery-items' );

			$( '.variation-gallery-wrap .woocommerce-product-gallery.active' ).each(
				function () {
					var galleryItem    = $( this ).find( '.gallery-item' ).first(),
						galleryItemNav = $( this ).find( '.gallery-nav-item' ).first();
					galleryItem.appendTo( lastStepGalleryItems );
					galleryItemNav.appendTo( lastStepGalleryNav );

				}
			);
		},
		ajaxSuccess: function(response) {
			if (response['main_images'] && response['variation_id']) {
				this.appendVariationGallery( response['variation_id'], response['main_images'] );
			}
		},
		ajaxFail: function(response) {
			console.log( response )
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
					var oldStep = $( '.bundle-step.current-step' ),
						newStep = $( '.bundle-step[data-step=' + self.currentStep + ']' );
					if (self.currentStep === self.stepsNum) {
						self.updateLastStepGallery();
					}
					newStep.addClass( 'current-step' );
					oldStep.removeClass( 'current-step' );
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
