(function ($) {

	//Header Scripts
	var speed = "500";
	$( 'li.depth-1 ul.sub-menu' ).slideUp();
	$( 'li.depth-1.active ul.sub-menu' ).slideDown();
	$( 'li.depth-1.menu-item-has-children' ).on(
		'click',
		function() {
			if ($( this ).hasClass( 'active' )) {
				return;
			}
			$( this ).parent( '.sub-menu' ).find( 'li.active' ).removeClass( 'active' ).find( 'ul.sub-menu' ).slideUp();
			$( this ).addClass( 'active' );
			$( this ).find( 'ul.sub-menu' ).slideDown( speed );
		}
	);

	// Change Sub menu image on hover
	var subMenu = $( '.sub-menu-wrap' );
	subMenu.find( '.nav-item-with-image' ).on(
		'mouseenter',
		function () {
			var itemImg    = $( this ).attr( 'data-img' ),
				itemDesc   = $( this ).attr( 'data-desc' ),
				imgWrap    = $( this ).parents( 'div.sub-menu-wrap' ).children( '.image-wrap' ),
				img        = imgWrap.children( 'img' ),
				imgDesc    = imgWrap.children( 'p' ),
				currentImg = imgWrap.find( 'img' ).attr( 'src' );
			if ((itemImg.length || itemDesc.length) && currentImg !== itemImg) {
				img.attr( 'srcset', '' );
				imgWrap.fadeOut(
					'fast',
					function(){
						img.attr( 'src', itemImg );
						imgDesc.html( itemDesc )
					}
				).fadeIn( "fast" );
			}
		}
	);

	$( 'div.nav-toggle' ).on(
		'click',
		function() {
			$( this ).toggleClass( 'active' );
			$( 'div#primary-header-nav-container' ).toggleClass( 'active' )
		}
	);
	$( 'body' ).on(
		'click',
		function(e) {
			if ($(e.target).is('#search-icon')) {
				$( '.search-wrap, .header-container' ).toggleClass( 'active' );
				$('#woocommerce-product-search-field-0').focus();
			}else if(!$(e.target).parents('.header-container').length) {
				$( '.search-wrap, .header-container' ).removeClass( 'active' );
			}
		}
	);
	$('body').on('click', '.search-view-all a', function(e){
		e.preventDefault()
		$(this).parents('.header-search').find('form').submit();
	});

	// Mobile nav depth-1 slideToggle
	$( 'li.menu-item-has-children a.depth-0' ).on(
		'click',
		function(e) {
			if (window.innerWidth <= 977) {
				e.preventDefault();
				var toggleSpeed = 500,
					parrentLi   = $( this ).parents( 'li.menu-item-has-children' ),
					test2       = parrentLi.children( 'div.sub-menu-wrap' );
				parrentLi.toggleClass( 'active' );
				if (parrentLi.hasClass( 'active' )) {
					test2.slideDown( toggleSpeed );
				} else {
					test2.slideUp( toggleSpeed );
				}

			}
		}
	);


})( jQuery );
