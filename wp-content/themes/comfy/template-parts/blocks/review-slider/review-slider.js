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
							}
						);
					}
				);
			}
		}
	);
})( jQuery );
