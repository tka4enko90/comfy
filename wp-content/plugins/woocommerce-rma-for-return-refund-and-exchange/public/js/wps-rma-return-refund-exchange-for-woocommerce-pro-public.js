//code for datatable

jQuery(document).ready(function() {
    console.log('you entered');
});
jQuery(document).ready( function($){
	$ = jQuery;
	$( '.wps_rma_exchange_notification_checkbox' ).hide();
	$( '.wps_rma_exchange_notification_choose_product' ).hide();
	$( '.wps_rma_exchange_notification' ).hide();
	$( '.wps_rma_return_product_qty' ).removeAttr('disabled');
	// Show refund subject field if other option is selected.
	var wps_rma_return_request_subject = $( '#wps_rma_exchange_request_subject' ).val();
	if (wps_rma_return_request_subject == null || wps_rma_return_request_subject == '') {
		$( '#wps_rma_exchange_request_subject_text' ).show();
	} else {
		$( '#wps_rma_exchange_request_subject_text' ).hide();
	}
	// onchange Show refund subject field if other option is selected.
	$( '#wps_rma_exchange_request_subject' ).on( 'click', function(){
		var reason = $( this ).val();
		if (reason == null || reason == '') {
			$( '#wps_rma_exchange_request_subject_text' ).show();
		} else {
			$( '#wps_rma_exchange_request_subject_text' ).hide();
		}
	});
	// Add more file field on the refund request form.
	$( '.wps_rma_exchange_request_morefiles' ).on( 'click', function(){		
		var count = $(this).data('count');
		var max  = $(this).data('max');
		var html = '<div class="add_field_input_div"><input type="file" class="wps_wrma_exchange_request_files" name="wps_wrma_exchange_request_files[]"><span class="wps_rma_delete_field">X</span></div>';

		if(count < max ){
			$( '#wps_rma_exchange_request_files' ).append( html );
			$(document).find('.wps_rma_exchange_request_morefiles').data('count', count+1);
		}
	});
	// delete file field on the refund request form.
	$( document ).on( 'click', '.wps_rma_delete_field', function(){
		var count = $(document).find('.wps_rma_return_request_morefiles').data( 'count' );
		$(document).find('.wps_rma_return_request_morefiles').data( 'count', count - 1 );
		$(this).parent( '.add_field_input_div' ).remove();
	});
	// Add the cancel order link for order on the my-account
	$( '.wps_rma_cancel_order' ).each( function(){
		$( this ).attr( 'data-order_id', $( this ).attr( 'href' ).split( 'http://' )[1] );
		$( this ).attr( 'href', 'javascript:void(0);' ); 
	});
});
