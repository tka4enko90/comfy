(function ($) {
	var AjaxSearchForm = {
		settings: {
			searchForm: $( 'form#search-form' ),
			searchFormInput: $( 'input#search-form-input' ),
			toggleButton: $( 'header__widgets-link--cart, .shipping-change, .add-related-products-js' ),
			minSearchValLength: 3,
			searchResultList: $( '#search-results' ),
			timeoutToUpdate: 800,
			setIntervalTimeout: null
		},
		init: function () {
			this.searchInput();
		},
		ajaxFail:  function(response) {
			if (response['responseJSON']['data']['errors']) {
				console.log( response['responseJSON']['data']['errors'] );
			}
		},
		ajaxSuccess:  function(response) {
			if (response['data']['layout']) {
				AjaxSearchForm.settings.searchResultList.html( response['data']['layout'] ).addClass( 'active' );
				AjaxSearchForm.settings.searchResultList.addClass( 'active' );
			}
		},
		searchInput: function () {
			var self = this;
			self.settings.searchFormInput.on(
				'keyup',
				function (e) {
					// $(this).removeClass( 'active' ).children( 'article' ).remove();
					if (self.settings.setIntervalTimeout) {
						clearTimeout( self.settings.setIntervalTimeout );
					}
					if (e.currentTarget.value && e.currentTarget.value.length >= self.settings.minSearchValLength) {
						self.settings.setIntervalTimeout = setTimeout(
							function() {
								var formData = {
									search: e.currentTarget.value,
									action: 'search_site'
								};
								window.ajaxCall( formData ).success( self.ajaxSuccess ).fail( self.ajaxFail );
							},
							self.settings.timeoutToUpdate
						);
					} else {
						self.settings.searchResultList.removeClass( 'active' )
					}
				}
			);
		}
	};
	AjaxSearchForm.init();
})( jQuery );
