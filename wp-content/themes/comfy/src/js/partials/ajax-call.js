jQuery( document ).ready(
	function($) {
		window.ajaxCall = function (form_data) {
			return $.ajax(
				{
					url : form_data['ajax_url'] ? form_data['ajax_url'] : woocommerce_params.ajax_url, // Here goes our WordPress AJAX endpoint.
					type : 'post',
					data : form_data,
				}
			);
		};
	}
);
