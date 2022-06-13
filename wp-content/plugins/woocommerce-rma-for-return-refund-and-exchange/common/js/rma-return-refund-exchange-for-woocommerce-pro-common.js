$ = jQuery;
function wps_rma_currency_seprator( price ) {
	var fixed_upto = 0;
	if ( mwr_common_param.price_decima_separator ) {
		fixed_upto = mwr_common_param.price_decima_separator;
	}
	price = price.toFixed( fixed_upto );
	price = price.replace('.',mwr_common_param.price_decimal_separator);
	console.log(  );
	return price;
}
// calculate refund total based on the selected product.
function wps_rma_refund_total() {
	var checkall = true;
	var count = 0;
	var total = 0;
	var return_data=[];
	var selected_product = {};
	
	var orderid = $("input[name='wps_rma_return_request_order']").val();

	$('.wps_rma_return_column').each(function(){
		if($(this).find('td:eq(0)').children('.wps_wrma_return_product').is(':checked')){
			var product_info = {};
			product_info['product_id'] = $(this).data('productid');
			product_info['variation_id'] = $(this).data('variationid');
			product_info['item_id'] = $(this).data('itemid');
			product_info['qty'] = $(this).find('td:eq(2)').children('.wps_rma_return_product_qty').val();
			product_info['price'] = parseFloat( $(this).find('td:eq(1)').children('.wps_rma_product_amount').val());
			total += parseFloat($(this).find('td:eq(1)').children('.wps_rma_product_amount').val());
			selected_product[count] = product_info;
			count++;
		}
	});

	return_data['selected_product'] = selected_product;
	return_data['amount'] = total;
	return return_data;
}
// Add more refund request conditions.
function wps_rma_return_alert_condition_addon() {
	var count = 0;
	var alerthtml = '';
	$('.wps_rma_return_column').each(function(){
		if( $(this).find('td:eq(0)').children('.wps_wrma_return_product').is(':checked')){
			count++;
		}
	});
	$('.wps_rma_return_column').each(function(){
		if($(this).find('td:eq(0)').children('.wps_wrma_return_product').is(':checked')){
			var product_qty = $(this).find('td:eq(2)').children('.wps_rma_return_product_qty').val();
			var product_q = $(this).find('td:eq(3)').children('#quanty').val();
			if(product_qty>product_q)
			{
				alerthtml += '<li>'+mwr_common_param.correct_quantity+'</li>';

			}
		}
	});
	if( count == 0 || alerthtml != '' ) {
		return alerthtml += '<li>'+ mwr_common_param.refund_product + '</li>';
	} else {
		return false;
	}
}
// get the refund method value.
function wps_rma_refund_method() {
	return $('input[name=wps_wrma_refund_method]:checked').val();;	
}
// auto refund request accept.
function wps_rma_refund_auto_accept( order_id ) {
	var orderid = order_id;
	var data = {
		action:'wps_rma_auto_return_req_approve',
		orderid:orderid,
		security_check	: mwr_common_param.wps_rma_nonce
	};
	$.ajax(
		{
			url: mwr_common_param.ajaxurl,
			type: 'POST',
			data: data,
			dataType :'json',
			success: function(response){
				window.setTimeout(function() {
					window.location.href = wrael_common_param.myaccount_url;
				}, 11000);

			}
		}
	);
}
$( document ).ready( function() {
	// refund total show on the refund request form.
	function refund_total_show() {
		var product_total = 0;
		var this_obj      = '';
		var checkall      = true;
		$('.wps_rma_return_column').each( function() {
			this_obj = this;
			if ($(this).find('td:eq(0)').children('.wps_wrma_return_product').is(':checked')){
				var product_price = $(this).find('td:eq(1)').children('.wps_rma_product_amount').val();
				var product_qty = $(this).find('td:eq(2)').children('.wps_rma_return_product_qty').val();
				product_total = product_total + ( product_price * product_qty );
				$('.wps_rma_return_notification_checkbox').show();
				$(this).find('td:eq(3)').children('.wps_wrma_formatted_price').html( wps_rma_currency_seprator( product_price * product_qty ) );
			} else {
				checkall = false;
			}
		});
		if( checkall ) {
			$('.wps_wrma_return_product_all').prop('checked', true );
		} else {
			$('.wps_wrma_return_product_all').prop('checked', false );
		}
		$(document).find('.wps_wrma_formatted_price').last().html( wps_rma_currency_seprator( product_total ) );
		$('.wps_rma_return_notification_checkbox').hide();

	}
	// show the refund total when refund request form load
	if ( window.location.href.indexOf('refund-request-form') > -1 ) {
		refund_total_show();
	}
	$( document ).on( 'change', '.wps_rma_return_product_qty', function(){
		refund_total_show();
	});
	$(document).on( 'click', '.wps_wrma_return_product', function(){
		refund_total_show();
	});
	//Check all on the refund request form
	$(document).on( 'click', '.wps_wrma_return_product_all', function(){
		if ( $(this).is(':checked') ) {
			$('.wps_wrma_return_product').each( function() {
				if( ! $(this).is(':checked') ) {
					$(this).prop('checked', true );
				}
			});
		} else {
			$('.wps_wrma_return_product').each( function() {
				if( $(this).is(':checked') ) {
					$(this).prop('checked', false );
				}
			});
		}
		refund_total_show();
	});
	// Regenerate coupon code.
	$(document).on( 'click', '#wps_rma_coupon_regenertor', function(){
		var id = $(this).data('id');
		$('.regenerate_coupon_code_image').css('display' , 'inline-block');
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',             
			data: { action : 'wps_rma_coupon_regenertor' , id : id , security_check	:	mwr_common_param.wps_rma_nonce },
			success: function(respond)   
			{
				var response = $.parseJSON( respond );
				var wallet_regenraton = '';
				wallet_regenraton = '<b>'+mwr_common_param.wallet_msg+':<br>'+response.coupon_code_text+': '+response.coupon_code+'<br>'+response.wallet_amount_text+': <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+response.currency_symbol+'</span>'+response.coupon_price+'</span> </b>';
				$('.wps_wrma_wallet').html(wallet_regenraton);
				$('.regenerate_coupon_code_image').css('display' , 'none');
			}
		});
	});

	$('#refund_amount_method').hide();
	var total = 0;	
	var extra_amount = 0;
	// function to calculate exchange total.
	function wps_rma_exchange_total()
	{
		alert
		var count =0;	
		var checkall = true;
		var total = 0;
		$('.wps_rma_exchange_column').each(function(){
			if($(this).find('td:eq(0)').children('.wps_rma_exchange_product').is(':checked')){
				var product_price = $(this).find('td:eq(0)').children('.wps_rma_exchange_product').val();
				var product_qty = $(this).find('td:eq(2)').children('.wps_rma_exchange_product_qty').val();
				var product_total = product_price * product_qty;
				$(this).find('td:eq(3)').children('.wps_rma_formatted_price').html(wps_rma_currency_seprator(product_total));
				total += product_total;
				$(this).find( '#wps_rma_total_product_total_ex' ).children( '.wps_wrma_formatted_price' ).html( wps_rma_currency_seprator( product_total ) );
			}
			else
			{
				checkall = false;
			}	
		});
		$( '#wps_wrma_total_exchange_amount' ).html( wps_rma_currency_seprator( total ) );
		
		if( checkall ) {
			$('.wps_rma_exchange_product_all').prop('checked', true );
		} else {
			$('.wps_rma_exchange_product_all').prop('checked', false );
		}	
		var selected_product = {};
		var count   = 0;
		var match   = '';
		var orderid = $('#wps_rma_exchange_request_order').val();
		$( '.wps_rma_exchange_column' ).each( function(){
			if($(this).find('td:eq(0)').children('.wps_rma_exchange_product').is(':checked')){
				var product_info = {};
				var variation_id = $(this).data('variationid');
				var product_id = $(this).data('productid');
				var item_id = $(this).data('itemid');
				var product_price = $(this).find('td:eq(0)').children('.wps_rma_exchange_product').val();
				var product_qty = $(this).find('td:eq(2)').children('.wps_rma_exchange_product_qty').val();
				product_info['product_id'] = product_id;
				product_info['variation_id'] = variation_id;
				product_info['item_id'] = item_id;
				product_info['price'] = product_price;
				product_info['qty'] = product_qty;
				selected_product[count] = product_info;
				count++;
			}
		});
		var data = {	
			action	:'wps_rma_exchange_products',
			products: selected_product,
			orderid : orderid,
			security_check	:	mwr_common_param.wps_rma_nonce	
		};
		var wps_check_coupon = 0;
		$('.wps_rma_exchange_notification_checkbox').show();
		
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',  
			data: data,
			async: false,
			dataType :'json',	
			success: function(response) 
			{
				count=response['count1'];
				match=response['match'];
				window.setTimeout(function() {
				$('.wps_rma_exchange_notification_checkbox').hide();
				}, 800);
				$('.wps_wrma_return_notification').html(response.msg);
				wps_check_coupon = 0;
			}
		});
		var exchanged_amount = $('#wps_wrma_exchanged_total').val();
		extra_amount = 0;
		if(exchanged_amount >= ( total + wps_check_coupon ) )
		{
			extra_amount = exchanged_amount - ( total + wps_check_coupon );
			$('#wps_wrma_exchange_extra_amount i').html(mwr_common_param.extra_amount_msg);
			$('#refund_amount_method').hide();
			$('.wps_wrma_refund_method').prop('checked', false );
		}
		else
		{
			if( wps_check_coupon > exchanged_amount )
			{
				exchanged_amount = 0;
			}
			else
			{
				exchanged_amount = exchanged_amount - wps_check_coupon;
			}
			extra_amount =  total  -  exchanged_amount;
			$('#wps_wrma_exchange_extra_amount i').html(mwr_common_param.left_amount_msg);
			$('.wps_wrma_refund_method').first().prop('checked', true );
			$('#refund_amount_method').show();
		}
		$('#wps_wrma_exchange_extra_amount .wps_wrma_formatted_price').html(wps_rma_currency_seprator(extra_amount));
		return total;
	}
	// show the exchange total when exchange request form load
	if ( window.location.href.indexOf('exchange-request-form') > -1 ) {
		wps_rma_exchange_total();
	}
	//Check all on the exchange request form
	$(document).on( 'click', '.wps_rma_exchange_product_all', function(){
		if ( $(this).is(':checked') ) {
			$('.wps_rma_exchange_product').each( function() {
				if( ! $(this).is(':checked') ) {
					$(this).prop('checked', true );
				}
			});
		} else {
			$('.wps_rma_exchange_product').each( function() {
				if( $(this).is(':checked') ) {
					$(this).prop('checked', false );
				}
			});
		}
		wps_rma_exchange_total();
	});
	$( document).on( 'click', '.wps_rma_exchange_product', function(){
		wps_rma_exchange_total();
	});

	//Update product qty
	$( document).on( 'change', '.wps_rma_exchange_product_qty', function(){
		wps_rma_exchange_total();
	});
	// peform functionalion when click on the choose product button on the exchange request form
	$(document ).on( 'click', '#wps_wrma_exhange_shop', function(e){
		var check = false;
		var selected_product = {};
		var count = 0;
		var orderid = $('#wps_rma_exchange_request_order').val();
		$('.wps_rma_exchange_column').each(function(){
			if($(this).find('td:eq(0)').children('.wps_rma_exchange_product').is(':checked')){
				check = true;
				var product_info = {};
				var variation_id = $(this).data('variationid');
				var product_id = $(this).data('productid');
				var item_id = $(this).data('itemid');
				var product_price = $(this).find('td:eq(0)').children('.wps_rma_exchange_product').val();
				var product_qty = $(this).find('td:eq(2)').children('.wps_rma_exchange_product_qty').val();
				product_info['product_id'] = product_id;
				product_info['variation_id'] = variation_id;
				product_info['item_id'] = item_id;
				product_info['price'] = product_price;
				product_info['qty'] = product_qty;
				selected_product[count] = product_info;
				count++;
			}
		});
		if (check == true) 
		{
			var data = {	
				action	:'wps_set_exchange_session',
				products: selected_product,
				orderid : orderid,
				security_check	:	mwr_common_param.wps_rma_nonce	
			}
			$('.wps_rma_exchange_notification_choose_product').show();
			$.ajax({
				url: mwr_common_param.ajaxurl, 
				type: 'POST',  
				data: data,
				dataType :'json',	
				success: function(response) 
				{
					if( mwr_common_param.wps_wrma_exchange_variation_enable )
						{	
						$('.wps_rma_exchange_notification_choose_product ').hide();
						$('#wps_wrma_variation_list').html('');
						$('#wps_wrma_variation_list').html('<h4><Strong>'+mwr_common_param.wps_wrma_exchnage_with_same_product_text+'<Strong></h4>');
						$('.wps_rma_exchange_column').each(function(){
						if($(this).find('td:eq(0)').children('.wps_rma_exchange_product').is(':checked')){
							var product_name = $(this).find('td:eq(1)').find('.wps_wrma_product_title a').html();
							var product_url = $(this).find('td:eq(1)').find('.wps_wrma_product_title a').attr('href');
							var clone = $(this).find('td:eq(1)').clone().appendTo('#wps_wrma_variation_list');
							product_name = product_name.split('-');
							product_name = product_name[0];
							product_url = product_url.split('?');
							product_url = product_url[0];
							clone.find('.wps_wrma_product_title a').html(product_name);
							clone.wrap('<a href="'+product_url+'"></a><br>');
							}
						});
					}
					else
					{
						$('.wps_rma_exchange_notification_choose_product').show();
						window.location.href = mwr_common_param.shop_url;
					}
			}
		});
		}
		if(check == false)
		{
			e.preventDefault();
			var alerthtml = '<li>'+mwr_common_param.select_product_msg_exchange+'</li>';
			$('#wps-exchange-alert').show();
			$('#wps-exchange-alert').html(alerthtml);
			$('#wps-exchange-alert').css('background-color', 'red');
			$('#wps-exchange-alert').addClass('woocommerce-error');
			$('#wps-exchange-alert').removeClass('woocommerce-message');
			$('html, body').animate({
				scrollTop: $('#wps_wrma_exchange_request_container').offset().top
			}, 800);
			return false;
		}	
	});
	// Add exchange product.
	$(document).on('click' , '.wps_wrma_ajax_add_to_exchange' , function(){
		var current = $(this);
		$(this).addClass('loading');
		var product_id = $(this).data('product_id');
		var product_sku = $(this).data('product_sku');
		var quantity = $(this).data('quantity');
		var price = $(this).data('price');
		var product_info = {};
		product_info['id'] = product_id;
		product_info['qty'] = quantity;
		product_info['sku'] = product_sku;
		product_info['price'] = price;
		
		var data = {	
			action	:'wps_wrma_add_to_exchange',
			products: product_info,
			security_check	:	mwr_common_param.wps_rma_nonce	
		}
		
		//Add Exchange Product
		
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',  
			data: data,
			dataType :'json',	
			success: function(response) 
			{
				current.removeClass('loading');
				current.addClass('added');
				current.parent().html('<a data-price="'+price+'" data-quantity="'+quantity+'" data-product_id="'+product_id+'" data-product_sku="'+product_sku+'" class="button wps_wrma_ajax_add_to_exchange" tabindex="0">'+mwr_common_param.exchange_text+'</a><a class="button wps_rma_redirect_ex_form" style="margin:3px" href="'+response.url+'">'+response.message+'</a>');
			}
		});
	});
	// add exchange product.
	$(document).on('click', '.wps_wrma_add_to_exchanged_detail' , function(){

		var current = $(this);
		$(this).addClass('loading');
		var product_id = $(this).data('product_id');
		
		var product_sku = $(this).data('product_sku');
		var quantity = $('.qty').val();
		var price = $(this).data('price');
		var variations = {};
		$('.variations select').each(function(){
			var name = $(this).data('attribute_name');
			var val = $(this).val();
			variations[name] = val;
		});
		
		var grouped = {};
		$('.group_table tr').each(function(){
			quantity = $(this).find('td:eq(0)').children().children('.qty').val();
			id = $(this).find('td:eq(0)').children().children('.qty').attr('name');
			id = id.match(/\d+/);
			id = id[0];
			grouped[id] = quantity;
			
		});
		
		var product_info = {};
		product_info['id'] = product_id;
		product_info['qty'] = quantity;
		product_info['sku'] = product_sku;
		product_info['price'] = price;
		product_info['variations'] = variations;
		product_info['grouped'] = grouped;
		var data = {	
			action	:'wps_wrma_add_to_exchange',
			products: product_info,
			security_check	:	mwr_common_param.wps_rma_nonce	
		}
		
		//Add Exchange Product
		
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',  
			data: data,
			dataType :'json',	
			success: function(response) 
			{

				current.removeClass('loading');
				current.addClass('added');
				current.parent().html('<button data-price="'+price+'" data-quantity="'+quantity+'" data-product_id="'+product_id+'" data-product_sku="'+product_sku+'" class="wps_wrma_add_to_exchanged_detail button alt added" tabindex="0">'+mwr_common_param.exchange_text+'</button><a class="button wps_rma_redirect_ex_form" style="margin:3px" href="'+response.url+'">'+response.message+'</a>');
			}
		});
	});
	// Add the exchange variable product.
	$(document).on( 'click', '.wps_wrma_add_to_exchanged_detail_variable', function(){
		var variation_id = $('[name="variation_id"]').val();
		if(variation_id == null || variation_id <= 0)
		{
			alert('Please choose variation');
			return false;
		}
		var current = $(this);
		$(this).addClass('loading');
		var product_id = $(this).data('product_id');
		var quantity = $('.qty').val();
		var variations = {};
		$('.variations select').each(function(){
			var name = $(this).data('attribute_name');
			var val = $(this).val();
			variations[name] = val;
		});
		
		var grouped = {};
		$('.group_table tr').each(function(){
			quantity = $(this).find('td:eq(0)').children().children().val();
			id = $(this).find('td:eq(0)').children().children().attr('name');
			id = id.match(/\d+/);
			id = id[0];
			grouped[id] = quantity;
			
		});
		
		var product_info = {};
		product_info['id'] = product_id;
		product_info['variation_id'] = variation_id;
		product_info['qty'] = quantity;
		product_info['variations'] = variations;
		product_info['grouped'] = grouped;
		var data = {	
			action	:'wps_wrma_add_to_exchange',
			products: product_info,
			security_check	:	mwr_common_param.wps_rma_nonce	
		}
		
		//Add Exchange Product
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',  
			data: data,
			dataType :'json',	
			success: function(response) 
			{
				current.removeClass('loading');
				current.addClass('added');
				current.parent().html('<button class="wps_wrma_add_to_exchanged_detail_variable button alt" data-product_id="'+product_id+'"> '+mwr_common_param.exchange_text+' </button><a class="button wps_rma_redirect_ex_form" style="margin:3px" href="'+response.url+'">'+response.message+'</a>');
			}
		});
	});
	// Remove exhcange product.
	$( document ).on( 'click', '.wps_wrma_exchnaged_product_remove' , function(){
		var current = $(this);
		var orderid = $('#wps_wrma_exchange_request_order').val();
		var id = $(this).data('key');
		var data = {	
			action	:'wps_wrma_exchnaged_product_remove',
			id: id,
			orderid : orderid,
			security_check	:	mwr_common_param.wps_rma_nonce	
		}
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',  
			data: data,
			dataType :'json',	
			success: function(response) 
			{
				current.parent().remove();
				var rowCount = $('.wps_wrma_exchanged_products >tbody >tr').length;
				if(rowCount <= 0)
				{
					$('.wps_wrma_exchanged_products').remove();
				}
				$('#wps_wrma_exchanged_total').val(response.total_price);
				$('#wps_wrma_exchanged_total_show .wps_wrma_formatted_price').html(response.total_price );
				wps_rma_exchange_total();
			}
		});
	});
	// submit exchange request form.
	$( document ).on( 'submit', '#wps_rma_exchnage_request_form', function(e){
		var wps_wrma_refund_method = $('input[name=wps_wrma_refund_method]:checked').val();
		e.preventDefault();
		var orderid = $('#wps_rma_exchange_request_order').val();
		var total = wps_rma_exchange_total();
		var alerthtml = '';
		var selected_product = {};
		var count = 0;
		var exchange_amount = $('#wps_wrma_exchanged_total').val();
		extra_amount = exchange_amount - total;
		
		var wps_wrma_selected = false;
		$('.wps_rma_exchange_column').each(function(){

			if($(this).find('td:eq(0)').children('.wps_rma_exchange_product').is(':checked'))
			{
				wps_wrma_selected = true;
			}	
		});
		
		if(wps_wrma_selected == false)
		{
			alerthtml += '<li>'+mwr_common_param.select_product_msg_exchange +'</li>';
		}
		else
		{
			if(exchange_amount  == 0)
			{
				alerthtml += '<li>'+mwr_common_param.before_submit_exchange +'</li>';
			}	
		}	
		
		var rr_subject = $('#wps_rma_exchange_request_subject').val();
		
		if(rr_subject == '' || rr_subject == null)
		{
			rr_subject = $('#wps_rma_exchange_request_subject_text').val();
			if(rr_subject == '' || rr_subject == null || ! rr_subject.match(/[[A-Za-z]/i ) )
			{
				alerthtml += '<li>'+mwr_common_param.exchange_subject_msg +'</li>';
			}	
		}
		$('.wps_rma_exchange_column').each(function(){
			if($(this).find('td:eq(0)').children('.wps_rma_exchange_product').is(':checked')){
				var product_enter_qty = $(this).find('td:eq(2)').children('.wps_rma_exchange_product_qty').val();
				var product_rem_qty = $(this).find('td:eq(3)').children('#quanty').val();
				product_enter_qty = parseInt(product_enter_qty);
				product_rem_qty = parseInt(product_rem_qty);
				if(product_enter_qty>product_rem_qty)
				{
					alerthtml += '<li>'+mwr_common_param.correct_quantity+'</li>';

				}
			}
		});
		var rr_reason = $('.wps_wrma_exchange_request_reason').val();
		
		if( typeof( rr_reason ) !== 'undefined' && ( rr_reason == '' || rr_reason == null || ! rr_reason.match(/[[A-Za-z]/i ) ) )
		{
			alerthtml += '<li>'+mwr_common_param.exchange_reason_msg+'</li>';
		}	
		
		if(alerthtml != '')
		{
			$('#wps-exchange-alert').show();
			$('#wps-exchange-alert').html(alerthtml);
			$('#wps-exchange-alert').addClass('woocommerce-error');
			$('#wps-exchange-alert').removeClass('woocommerce-message');
			$('#wps-exchange-alert').css('background-color', 'red');
			$('html, body').animate({
				scrollTop: $('#wps_wrma_exchange_request_container').offset().top
			}, 800);
			return false;
		}
		else
		{
			$('#wps-exchange-alert').hide();
			$('#wps-exchange-alert').html(alerthtml);
		}	
		
		$('.wps_rma_exchange_notification').show();
		var data = {	
			action	:'wps_wrma_submit_exchange_request',
			orderid: orderid,
			reason: rr_reason,
			subject: rr_subject,
			refund_method: wps_wrma_refund_method,
			bankdetails : $( '#wps_rma_bank_details' ).val(),
			security_check	:mwr_common_param.wps_rma_nonce	
		}
		//Upload attached files
		var formData = new FormData(this);
		formData.append( 'action', 'wps_wrma_exchange_upload_files');
		formData.append( 'orderid', orderid );
		formData.append( 'security_check', mwr_common_param.wps_rma_nonce );
		$('body').css('cursor', 'progress');
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',             
			data: formData, 
			contentType: false,       
			cache: false,             
			processData:false,       
			success: function(respond){
				$.ajax({
					url: mwr_common_param.ajaxurl, 
					type: 'POST',  
					data: data,
					dataType :'json',	
					success: function(response) 
					{
						// Start redirect page countdown on refund request form
						var timeleft = 10;
						var downloadTimer = setInterval(function(){
							if(timeleft >= 0){
								$('#countdownTimer').html( timeleft );
							}
							timeleft -= 1;
						}, 1000);
						$('.wps_rma_exchange_notification').hide();
						$('#wps-exchange-alert').html(response.msg + ' in ' + '<b><span id="countdownTimer"></span>' + ' seconds</b>');
						$('#wps-exchange-alert').removeClass('woocommerce-error');
						$('#wps-exchange-alert').addClass('woocommerce-message');
						$('#wps-exchange-alert').css('background-color', '#8FAE1B');
						$('#wps-exchange-alert').show();
						$('html, body').animate({
							scrollTop: $('#wps_wrma_exchange_request_container').offset().top
						}, 800);
						
						window.setTimeout(function() {
							window.location.href = mwr_common_param.myaccount_url;
						}, 11000);
					}
				});
			}
		});
	});
	// cancel the whole order.
	$(document).on( 'click', '.wps_rma_cancel_order' , function(){
		$( this ).prop('disabled',true);
		var order_id = $(this).attr('data-order_id');
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',
			data: {
				action : 'wps_rma_cancel_customer_order',
				order_id : order_id,
				security_check : mwr_common_param.wps_rma_nonce },
			success: function(respond){
				window.location.href = respond;
			}
		});
	});
	// checkbox on the cancel request form.
	$( document ).on('click', '.wps_wrma_cancel_product_all', function(){

		if (this.checked) {
            $('.wps_wrma_cancel_product').each(function() {
                this.checked=true;
            });
        } else {
            $('.wps_wrma_cancel_product').each(function() {
                this.checked=false;
            });
        }
	});
	// checkbox on the cancel request form.
	$( document ).on('click', '.wps_wrma_cancel_product', function(){
		
		if ($(this).is(':checked')) {
            var isAllChecked = 0;

            $('.wps_wrma_cancel_product').each(function() {
                if (!this.checked)
                {
                    isAllChecked = 1;
                }
            });

            if (isAllChecked == 0) {
                $('.wps_wrma_cancel_product_all').prop('checked', true);
            }     
        }
        else {
            $('.wps_wrma_cancel_product_all').prop('checked', false);
        }

	});
	//cancel order product on the cancel request form.
	$( document ).on( 'click', '.wps_rma_cancel_product_submit',function(){
		$('#wps-return-alert').hide();
		var wr_qty = false;
		var can_all = 0;
		var one_check = false;
		var alerthtml = '';
		$('.wps_wrma_cancel_product').each(function() {
			if ( this.checked ) {
				one_check = true;
				var parent = $(this).closest('.wps_wrma_cancel_column').find('.product-quantity').find('.wps_wrma_cancel_product_qty');

				var qty_val = parent.val();
				var qty_max = parent.attr('max');
				var qty_val = parseInt( qty_val );
				var qty_max = parseInt( qty_max );

				if( qty_val < qty_max ) {
					can_all = 1;
				} else if( qty_val > qty_max ) {
					wr_qty = true;
				}
			}
		});
		if( ! one_check ) {
			alerthtml = mwr_common_param.select_product_msg_cancel;
		}
		if( true == wr_qty ) {
			alerthtml = mwr_common_param.correct_quantity;
		}
		if(alerthtml != '') {
			$( '#wps-return-alert' ).html( alerthtml );
			$( '#wps-return-alert' ).addClass('woocommerce-error');
			$( '#wps-return-alert' ).removeClass('woocommerce-message');
			$( '#wps-return-alert' ).css('background-color', 'red');
			$( '#wps-return-alert' ).show();

			$('html, body').animate({
				scrollTop: $('#wps_wrma_return_request_container').offset().top
			}, 800);
			return false;
		}
		var order_id = $('.wps_wrma_cancel_product_all').val();
		
		if( can_all == 0 && $('.wps_wrma_cancel_product_all').is(':checked')){
			if(confirm( mwr_common_param.wps_wmrma_confirm_order ))
			{	
				$('.wps_rma_return_notification').show();
				$.ajax({
					url: mwr_common_param.ajaxurl, 
					type: 'POST',             
					data: { action : 'wps_rma_cancel_customer_order' , order_id : order_id , security_check	:	mwr_common_param.wps_rma_nonce },
					success: function(respond)   
					{
						$('.wps_rma_return_notification').show();
						window.location.href = respond;
					}
				});
			}
		}
		else{
			if(confirm( mwr_common_param.wps_wrma_confirm_products ))
			{
				$('.wps_rma_return_notification').show();
				var item_ids = [];
				var index = 0;
				var quantity = 0;
				var item_id = 0;
				$('.wps_wrma_cancel_product').each(function(){
					if($(this).is(':checked'))
					{
						quantity = $(this).closest('tr').find('.wps_wrma_cancel_product_qty').val();
						item_id  = $(this).val();
						item_ids.push([item_id, quantity]);
					}
				});
	
				$.ajax({
					url: mwr_common_param.ajaxurl, 
					type: 'POST',             
					data:{ 	action : 'wps_rma_cancel_customer_order_products' , 
							order_id : order_id ,
							item_ids : item_ids , 
							security_check	:	mwr_common_param.wps_rma_nonce 
						},
					success: function(respond)   
					{
						$('.wps_rma_return_notification').hide();
						window.location.href = respond;
					}
				});
				
			}
		}
	});
	$('.wps-return-ex-login-alert').hide();
	$('#login_session_alert').hide();
	// Guest form
	$( document ).on( 'submit', '.wps_rma_guest_form', function(e){
		var order_id = $('#order_id').val();
		var order_email = $('#order_email').val();
		var order_phone = $('#order_phone').val();
		$('#login_session_alert').hide();
		if (order_id == '' ){
			if ( order_email !== 'undefined' && order_email == '' ) {
				var msg = mwr_common_param.enter_login_details;
			}
			if( order_phone !== 'undefined' || order_email == '' ) {
				var msg = mwr_common_param.enter_login_details1;
			}
			$('.wps-return-ex-login-alert').show();
            $('.wps-return-ex-login-alert').html(msg);
            $('html, body').animate({
				scrollTop: $('.wps-return-ex-login-alert').offset().top
			}, 800);
			e.preventDefault();
			
		}
		else if( order_email !== 'undefined' && order_email == ''){
			$('.wps-return-ex-login-alert').show();
            $('.wps-return-ex-login-alert').html(mwr_common_param.enter_login_email);
            $('html, body').animate({
				scrollTop: $('.wps-return-ex-login-alert').offset().top
			}, 800);
			e.preventDefault();
		}
		else if ( order_email != 'undefined' && order_phone == '' ){
			$('.wps-return-ex-login-alert').show();
            $('.wps-return-ex-login-alert').html(mwr_common_param.enter_login_phone);
            $('html, body').animate({
				scrollTop: $('.wps-return-ex-login-alert').offset().top
			}, 800);
			e.preventDefault();
		}
		else if(order_id == '' ){
			$('.wps-return-ex-login-alert').show();
            $('.wps-return-ex-login-alert').html(mwr_common_param.enter_login_id);
            $('html, body').animate({
				scrollTop: $('.wps-return-ex-login-alert').offset().top
			}, 800);
			e.preventDefault();
		}
	});
	// check if product is available for exchange to show exchange button
	if ( mwr_common_param.exchange_session == 1 ) {
		$(document).on('change','.variations .value select',function(){
			var add_to_cart_btn_class = $( '.single_add_to_cart_button' ).attr('class');
			if(add_to_cart_btn_class.match('wc-variation-is-unavailable') == 'wc-variation-is-unavailable')	
			{
				$('.wps_wrma_add_to_exchanged_detail_variable').attr('disabled','disabled');
				$('.wps_wrma_add_to_exchanged_detail_variable').hide();
			}
			else
			{
				$('.wps_wrma_add_to_exchanged_detail_variable').removeAttr('disabled');
				$('.wps_wrma_add_to_exchanged_detail_variable').show()
			}

		});
		if ( mwr_common_param.wps_wrma_add_to_cart_enable != 'on' ) {
			$( '.single_add_to_cart_button' ).hide();
		}
	}

	// update the exchange to product qty from table
	$('.wps_rma_exchange_to_product_qty').on( 'change', function(){
		var qty = $(this).val();
		var id = $(this).data('id');
		$.ajax({
			url: mwr_common_param.ajaxurl, 
			type: 'POST',             
			data:{ 	action : 'wps_rma_update_exchange_to_prod', 
					id : id ,
					qty : qty , 
					security_check	:	mwr_common_param.wps_rma_nonce 
				},
			success: function(respond)   
			{
				window.location.reload();
			}
		});
	})
});
