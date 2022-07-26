(function($) {
	const quiz = {
		firstQuestionHash: '#first-question',
		initProgressBar: function(stepId) {
			var goToStepEl     = $( stepId ),
				currentStepNum = parseInt( goToStepEl.data( 'step' ) ),
				stepsAheadNum  = parseInt( goToStepEl.data( 'steps-ahead' ) ),
				percent        = (currentStepNum + stepsAheadNum) / 100,
				progress       = currentStepNum / percent;

			$( '.quiz-progress-bar-fill' ).delay( 30 ).queue(
				function (next) {
					$( this ).css( 'width', progress + '%' );
					next();
				}
			);
		},
		init: function () {
			if ( window.location.hash) {
				this.initProgressBar( window.location.hash );
			} else {
				window.location.hash = this.firstQuestionHash;
			}

			var self = this;
			window.addEventListener(
				'popstate',
				function(event) {
					self.initProgressBar( window.location.hash );
				},
				false
			);

		}
	};
	quiz.init();

})( jQuery );
