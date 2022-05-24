(function ($) {

	var footerNavs       = $( 'footer .widget_nav_menu' ),
		toggleSpeed      = 500,
		mobileBreakPoint = 480,
		navSlideInit     = function () {
			if ( window.innerWidth < mobileBreakPoint ) {
				$.each(
					footerNavs,
					function() {
						if ( ! $( this ).hasClass( 'active' )) {
							$( this ).children( 'div' ).slideUp( toggleSpeed );
						}
					}
				);
			} else {
				$.each(
					footerNavs,
					function() {

							$( this ).children( 'div' ).slideDown( toggleSpeed );

					}
				);
			}
		};

	footerNavs.first().addClass( 'active' );

	navSlideInit();
	$( window ).on( 'resize', navSlideInit );

	$( 'footer .widget-title' ).on(
		'click',
		function() {
			if ( window.innerWidth < mobileBreakPoint ) {
				var curNav = $( this ).parents( '.widget_nav_menu' );
				curNav.toggleClass( 'active' );
				if (curNav.hasClass( 'active' )) {
					curNav.children( 'div' ).slideDown( toggleSpeed );
				} else {
					curNav.children( 'div' ).slideUp( toggleSpeed );
				}
			}
		}
	);

})( jQuery );
