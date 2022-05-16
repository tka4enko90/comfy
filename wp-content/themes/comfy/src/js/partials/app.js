(function ($) {
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

})( jQuery );
