(function ($) {

	//Reviews section title
	if ($( '#jdgm-rev-widg__rev-counter' ).length && $( '.jdgm-rev-widg[data-number-of-reviews]' ).length) {
		var revsWrap         = $( '#judgeme_product_reviews .jdgm-rev-widg' ),
			revsNum          = revsWrap.data( 'number-of-reviews' ),
			revsCounter      = revsWrap.find( '#jdgm-rev-widg__rev-counter' ),
			summaryRatingVal = revsWrap.data( 'average-rating' ),
			summaryRating    = revsWrap.find( '#jdgm-rev-widg__summary-rating-num' );

		revsCounter.text( revsNum + ' ' );
		summaryRating.text( summaryRatingVal + ' ' );
	}

})( jQuery );
