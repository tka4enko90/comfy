(function ($) {
	$( document ).on(
		'ready',
		function () {
			var testimonialsCarousel = $( '.review-slider' );
			if (testimonialsCarousel.length) {
				testimonialsCarousel.each(
					function () {
						$( this ).slick(
							{
								dots: false,
								arrows: true,
								infinite: true,
								speed: 1000,
								slidesToShow: 1,
								slidesToScroll: 1,
								prevArrow:"<button type='button' class='slick-prev pull-left'><svg width=\"20\" height=\"18\" viewBox=\"0 0 20 18\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
									"<path d=\"M1.00156 9L18.1016 9\" stroke=\"#283455\" stroke-width=\"1.2381\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
									"<path d=\"M11.2746 0.999999L19 9L11.2746 17\" stroke=\"#283455\" stroke-width=\"1.2381\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
									"</svg></button>",
								nextArrow:"<button type='button' class='slick-next pull-right'><svg width=\"20\" height=\"18\" viewBox=\"0 0 20 18\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
									"<path d=\"M1.00156 9L18.1016 9\" stroke=\"#283455\" stroke-width=\"1.2381\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
									"<path d=\"M11.2746 0.999999L19 9L11.2746 17\" stroke=\"#283455\" stroke-width=\"1.2381\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
									"</svg></button>"
							}
						);
					}
				);
			}
		}
	);
})( jQuery );
