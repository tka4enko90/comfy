(function ($) {

	//Header Scripts
	var speed = "500";
	$( 'li.depth-1 ul.sub-menu' ).slideUp();
	$( 'li.depth-1.active ul.sub-menu' ).slideDown();
	$( 'li.depth-1.menu-item-has-children' ).hover(
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
	subMenu.find( '.nav-item-with-image' ).hover(
		function () {
			var itemImg  = $( this ).attr( 'data-img' ),
				itemDesc = $( this ).attr( 'data-desc' ),
				imgWrap  = $( this ).parents( 'div.sub-menu-wrap' ).children( '.image-wrap' ),
				img      = imgWrap.children( 'img' ),
				imgDesc  = imgWrap.children( 'p' );
			imgDesc.html( itemDesc );
			img.attr( 'srcset', '' );
			img.attr( 'src', itemImg );
		}
	);

})( jQuery );
