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

	$( 'div.nav-toggle' ).on(
		'click',
		function() {
			$( this ).toggleClass( 'active' );
			$( 'div#primary-header-nav-container' ).toggleClass( 'active' );
		}
	);
	$( '#search-icon' ).on(
		'click',
		function() {
			$( '.search-wrap' ).toggleClass( 'active' );
		}
	);

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

	// Ajax Search
	var searchForm         = $( 'form.woocommerce-product-search' ),
		searchResultList   = searchForm.append( '<ul id="search-results"></ul>' ).children( 'ul#search-results' ),
		searchFormInput    = $( 'input#woocommerce-product-search-field-0' ),
		minSearchValLength = 3,
		ajaxFail           = function(response) {
			if (response['responseJSON']['data']['errors']) {
				console.log( response['responseJSON']['data']['errors'] );
			}
		},
		ajaxSuccess        = function(response) {
			if (response.success === true && response['data']['products']) {
				var resultLayout = '';
				for ( var i = 0; i < response['data']['products'].length; i++) {
					var product = response['data']['products'][i];

					resultLayout += '<li>';
					resultLayout += '<a href="' + product['url'] + '">';

					resultLayout += (product['thumb']) ? '<img src="' + product['thumb'] + '" width="54px" height="54px" alt="Product Image">' : '';
					resultLayout += '<p>' + product['title'] + '</p>';

					resultLayout += '</a>';
					resultLayout += '</li>';
				}
				searchResultList.append( resultLayout ).addClass( 'active' );
			}
		};
	searchFormInput.attr( 'autocomplete', 'off' );
	searchFormInput.on(
		'keyup',
		function (e) {
			searchResultList.removeClass( 'active' ).children( 'li' ).remove();
			if (e.currentTarget.value.length >= minSearchValLength ) {
				var formData = {
					search: e.currentTarget.value,
					action: 'search_site'
				};
			} else {
				searchResultList.removeClass( 'active' );
			}
			window.ajaxCall( formData ).success( ajaxSuccess ).fail( ajaxFail );
		}
	);

})( jQuery );
