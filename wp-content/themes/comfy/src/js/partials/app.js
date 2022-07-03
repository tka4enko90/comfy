(function ($) {
	console.log( 'ok' );
	if ($( '#jdgm-rev-widg__rev-counter' ).length && $( '.jdgm-rev-widg[data-number-of-reviews]' ).length) {
		console.log( 'rev counter' );
	}
	var revsWrap    = $( '#judgeme_product_reviews .jdgm-rev-widg' ),
		revsNum     = revsWrap.data( 'number-of-reviews' ),
		revsCounter = revsWrap.find( '#jdgm-rev-widg__rev-counter' );
	revsCounter.text( revsNum + ' ' );
	if (revsWrap.length) {
		console.log( 'revsWrap' );
		console.log( 'revsNum: ' + revsNum );
	}
})( jQuery );
