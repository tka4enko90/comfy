jQuery(
    function ($) {
        var body = $('body');
        body.on(
            'click',
            '.woocommerce-product-gallery__image a',
            function (e) {
                e.preventDefault();
                $(this).toggleClass('zoom-active');
            }
        );
        body.on(
            'click',
            '.gallery-nav-item',
            function () {
                const scrollTo = $('.gallery-item-' + $(this).data('item'));
                $('.gallery-nav-item.active').removeClass('active');
                $(this).addClass('active');
                $([document.documentElement, document.body]).animate(
                    {
                        scrollTop: (scrollTo.offset().top - 120)
                    },
                    600
                );
            }
        );
        $.fn.isInViewport = function (offset) {
            if ($(this).length) {
                var elementTop = $(this).offset().top,
                    elementBottom = elementTop + $(this).outerHeight(),
                    viewportTop = $(window).scrollTop(),
                    viewportBottom = viewportTop + $(window).height();

                return elementBottom > viewportTop && (elementTop + offset) < viewportBottom;
            }
        };
        $(window).on(
            'resize scroll',
            function () {
                var galleryItem = $('div.gallery-item');
                galleryItem.each(
                    function () {
                        if ($(this).isInViewport(360)) {
                            const currentGalleryNavItem = $('.gallery-nav-item-' + $(this).data('item'));
                            if (!currentGalleryNavItem.hasClass('active')) {
                                $('.gallery-nav-item.active').removeClass('active');
                                currentGalleryNavItem.addClass('active');
                            }
                        }
                    }
                );
            }
        );

        $('.btn-qty').click(
            function () {
                let $this = $(this);
                let $qty = $this.closest('.quantity').find('.qty');
                let val = parseFloat($qty.val());
                let max = parseFloat($qty.attr('max'));
                let min = parseFloat($qty.attr('min'));
                let step = parseFloat($qty.attr('step'));
                let $button = $this.closest('.card-product').find('.add_to_cart_button');

                $(".actions .button[name='update_cart']").removeAttr('disabled');

                if ($this.is('.plus')) {
                    if (max && (max <= val)) {
                        $qty.val(max);
                        $button.attr('data-quantity', max);
                    } else {
                        $qty.val(val + step);
                        $button.attr('data-quantity', (val + step));
                    }
                } else {
                    if (min && (min >= val)) {
                        $qty.val(min);
                        $button.attr('data-quantity', min);
                    } else if (val > 1) {
                        $qty.val(val - step);
                        $button.attr('data-quantity', (val - step));
                    }
                }

            }
        );
        $('.size-guide').click(
            function () {
                $('#size-guide-wrap').addClass('active');
            }
        );

    }
);


(function($) {
	const productPage = {
		isVariableProduct: function () {
			return $('.product').hasClass('product-type-variable');
		},

		initpPoductCarousel: function (variation_id) {
			var $currentGallery;

			if (variation_id) {
				$currentGallery = $('.woocommerce-product-gallery--variation-' + variation_id).find('.woocommerce-product-gallery-items');
			} else {
				$currentGallery = $('.woocommerce-product-gallery').find('.woocommerce-product-gallery-items');
			}
			if ($currentGallery.length) {
				$currentGallery.each(
					function () {
						if ($(this).hasClass('slick-initialized')) {
							$(this).slick('refresh');
						}
						$(this).slick(
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

			if (window.matchMedia("(max-width: 766px)").matches) {
				scrollTo = $('.product_title').offset().top - $('.site-header').height();
			}
			$('html, body').animate(
				{
					scrollTop: scrollTo
				}
			)
		},
		init: function () {
			var self = this;
			$(window).on(
				'wc_additional_variation_images_frontend_lightbox_done resize',
				function () {
					if (self.isVariableProduct()) {
						self.initpPoductCarousel($('[name="variation_id"]').val());
					} else {
						self.initpPoductCarousel(false);
					}
					$('.woocommerce-product-gallery__wrapper').css('opacity', '1');
				}
			);


			$('.variations_form').on(
				'woocommerce_variation_has_changed',
				function (e) {
					self.scrollToGallery();
				}
			);
		}
	};

	productPage.init();
})( jQuery );
