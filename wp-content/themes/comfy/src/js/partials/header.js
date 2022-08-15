(function ($) {
	const mobileNavBreakpoint = 1039,
		slideAnimationSpeed   = 500,
		body                  = $( 'body' );

	// Mobile nav depth-1 slideToggle
	$( 'li.menu-item-has-children a.depth-0' ).on(
		'click',
		function (e) {
			if (window.innerWidth < mobileNavBreakpoint) {
				e.preventDefault();
				var parrentLi   = $( this ).parents( 'li.menu-item-has-children' ),
					subMenuWrap = parrentLi.children( 'div.sub-menu-wrap' );
				parrentLi.toggleClass( 'active' );
				if (parrentLi.hasClass( 'active' )) {
					subMenuWrap.slideDown( slideAnimationSpeed );
				} else {
					subMenuWrap.slideUp( slideAnimationSpeed );
				}
			}
		}
	);

	// Change Sub menu image on hover
	var subMenu = $( '.sub-menu-wrap' );
	subMenu.find( '.nav-item-with-image' ).on(
		'mouseenter',
		function () {
			if (window.innerWidth >= mobileNavBreakpoint) {
				var itemImg    = $( this ).data( 'img' ),
					itemDesc   = $( this ).data( 'desc' ) ? $( this ).data( 'desc' ) : '',
					imgWrap    = $( this ).parents( 'div.sub-menu-wrap' ).children( '.image-wrap' ),
					img        = imgWrap.children( 'img' ),
					imgDesc    = imgWrap.children( 'p' ),
					currentImg = imgWrap.find( 'img' ).attr( 'src' ),
					self       = $( this );

				setTimeout(
					function() {
						if (self.is( ":hover" )) {
							if ((itemImg.length || itemDesc.length) && currentImg !== itemImg) {
								img.attr( 'srcset', '' );
								imgWrap.fadeOut(
									'fast',
									function () {
										img.attr( 'src', itemImg );
										imgDesc.html( itemDesc )
									}
								).fadeIn( "fast" );
							}
						}
					},
					200
				);
			}
		}
	);

	//Clear sub menu wrap styles after resizing on desktop
	$( window ).on(
		'resize',
		function(){
			if ($( this ).width() >= mobileNavBreakpoint) {
				subMenu.removeAttr( "style" );
			}
		}
	);

	$( 'div.nav-toggle' ).on(
		'click',
		function () {
			$( this ).toggleClass( 'active' );
			$( 'div#primary-header-nav-container' ).toggleClass( 'active' );
			if ($( this ).hasClass( 'active' )) {
				body.css( 'width', body.width() );
				body.css( 'overflow', 'hidden' );
			} else {
				body.removeAttr( "style" );
			}
		}
	);

	//Search form toggle
	body.on(
		'click',
		function (e) {
			if ($( e.target ).is( '.search-wrap svg' )) {
				$( '.header-container' ).toggleClass( 'active' );
				const $input  = $( '#search-form-input' ),
					$inputVal = $input.val();

				$input.focus().val( '' ).val( $inputVal );

			} else if ($( e.target ).is( '.search-close-icon' ) || ! $( e.target ).parents( '.header-container' ).length) {
				$( '.header-container' ).removeClass( 'active' );
			}
		}
	);
	body.on(
		'click',
		'.search-view-all a, .header-search .header-search-icon',
		function (e) {
			e.preventDefault();
			$( this ).parents( '.header-search' ).find( 'form' ).submit();
		}
	);

})( jQuery );
