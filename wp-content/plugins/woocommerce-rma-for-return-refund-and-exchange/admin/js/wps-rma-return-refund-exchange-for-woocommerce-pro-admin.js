//code for datatable

jQuery(document).ready(function() {

    console.log('you entered');
    jQuery('#mwr-datatable').DataTable({
        stateSave: true,
        dom: '<"wps-dt-buttons"fB>tr<"bottom"lip>',
        "ordering": true, // enable ordering
   
        
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        language: {
            "lengthMenu": 'Rows per page _MENU_',

            paginate: { next: '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.99984 0L0.589844 1.41L5.16984 6L0.589844 10.59L1.99984 12L7.99984 6L1.99984 0Z" fill="#8E908F"/></svg>', previous: '<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.00016 12L7.41016 10.59L2.83016 6L7.41016 1.41L6.00016 -1.23266e-07L0.000156927 6L6.00016 12Z" fill="#8E908F"/></svg>' }
        },
    });
});
$ = jQuery;
// Show the correct rma policies setting depending upon the selected setting.
function show_correct_field_pro( append_html ) {
    $.each( $('.wps_rma_settings'), function() {
        if( $( this ).val() == '' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
            
        } else if( $( this ).val() == 'wps_rma_maximum_days' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if ( $( this ).val() == 'wps_rma_order_status' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if ( $( this ).val() == 'wps_rma_tax_handling' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if( $( this ).val() == 'wps_rma_min_order' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if( $( this ).val() == 'wps_rma_exclude_via_categories' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if( $( this ).val() == 'wps_rma_exclude_via_products' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().show();
        }
    });
    append_html = replaceAll1( append_html, 'wps_rma_ex_prod1', 'wps_rma_ex_prod' );
    append_html = replaceAll1( append_html, 'wps_rma_ex_cate1', 'wps_rma_ex_cate' ); 
    return append_html;
}
// escape unwanted thing from string
function escapeRegExp1(string){
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}
// call function when add more setting in rma policies
function wps_rma_do_something() {
    $('.wps_rma_ex_prod').select2();
    $('.wps_rma_ex_cate').select2();
    show_correct_field_pro( '' );
}      
// Define function to find and replace specified term with replacement string
function replaceAll1(str, term, replacement) {
  return str.replace(new RegExp(escapeRegExp1(term), 'g'), replacement);
}

// add shipping fee for refund process.
$( document ).on( 'click', '.save_ship_ex_cost', function(){
  var added_ex_fee={};
  var orderid = $(this).data('orderid');
  $('.wps_wrma_add_new_ex_fee').each(function(){
    var ex_fee_val = $(this).val();
    if ( ex_fee_val || 0 != ex_fee_val ) {
      var ex_fee_name = $(this).data('name');
      added_ex_fee[ex_fee_name] = ex_fee_val;
    }
  });
  var data = {
      action:'wps_exchange_add_new_fee',
      fees: added_ex_fee,
      orderid : orderid,
      type : 'refund',
      security_check	:	mwr_admin_param.wps_rma_nonce	
  };
  $.ajax({
    url: mwr_admin_param.ajaxurl, 
    type: 'POST',  
    data: data,
    dataType :'json',	
    success: function(response) 
    {
      location.reload();
    }
  });
  
});
// add shipping fee for exchange process.
$( document ).on( 'click', '.save_ship_ex_cost2', function(){
  var added_ex_fee={};
  var orderid = $(this).data('orderid');
  $('.wps_wrma_add_new_ex_fee2').each(function(){
    var ex_fee_val = $(this).val();
    if ( null !== ex_fee_val || ex_fee_val || 0 != ex_fee_val ) {
      var ex_fee_name = $(this).data('name');
      added_ex_fee[ex_fee_name] = ex_fee_val;
    }
  });
  var data = {
      action:'wps_exchange_add_new_fee',
      fees: added_ex_fee,
      orderid : orderid,
      type: 'exchange',
      security_check	:	mwr_admin_param.wps_rma_nonce	
  };
  $.ajax({
    url: mwr_admin_param.ajaxurl, 
    type: 'POST',  
    data: data,
    dataType :'json',	
    success: function(response) 
    {
     location.reload();
    }
  });
});
$(document).ready(function() {
  $('.wps_rma_ex_cate').select2();
  $('.wps_rma_ex_prod').select2();
  // Show the correct rma policies setting depending upon the selected setting.
  function show_correct_field_pro1() {
    $.each( $('.wps_rma_settings'), function() {
      if( $( this ).val() == '' ) {
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        
      } else if( $( this ).val() == 'wps_rma_maximum_days' ) {
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
      } else if ( $( this ).val() == 'wps_rma_order_status' ) {
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
      } else if ( $( this ).val() == 'wps_rma_tax_handling' ) {
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
      } else if( $( this ).val() == 'wps_rma_min_order' ) {
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
      } else if( $( this ).val() == 'wps_rma_exclude_via_categories' ) {
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
      } else if( $( this ).val() == 'wps_rma_exclude_via_products' ) {
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).show();
        $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().show();
      }
    });
  }
  setTimeout(function(){ show_correct_field_pro1(); }, 500 );
  // onShow the correct rma policies setting depending upon the selected setting.
  $(document).on( 'change', '.wps_rma_settings, .wps_rma_on_functionality', function() {
    $.each( $('.wps_rma_settings'), function() {
        if( $( this ).val() == '' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if( $( this ).val() == 'wps_rma_maximum_days' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if ( $( this ).val() == 'wps_rma_order_status' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if ( $( this ).val() == 'wps_rma_tax_handling' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        }  else if( $( this ).val() == 'wps_rma_min_order' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if( $( this ).val() == 'wps_rma_exclude_via_categories' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().hide();
        } else if( $( this ).val() == 'wps_rma_exclude_via_products' ) {
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_tax_handling' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_order_statues' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_max_number_days' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions1' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions2' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_conditions_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_settings_label' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_cate' ).next().hide();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).show();
            $( this ).parent( '.add_more_rma_policies' ).children( '.wps_rma_ex_prod' ).next().show();
        }
        show_correct_field_pro1();
    });
  });
  // Add the customer wallet from user page.
  $(document).on( 'click', '.wps_rma_add_customer_wallet' , function(){
		var id = $(this).data('id');
		$('#regenerate_coupon_code_image-'+id).css('display' , 'inline-block');
		$.ajax({
			url: mwr_admin_param.ajaxurl, 
			type: 'POST',             
			data: { action : 'wps_rma_generate_user_wallet_code' , id : id , security_check	:	mwr_admin_param.wps_rma_nonce },
			success: function(respond)   
			{
				var l = respond+'<br><b>( '+ mwr_admin_param.wps_rma_currency_symbol +'0.00 )</b>';
				$('#regenerate_coupon_code_image-'+id).css('display' , 'none');
				$('div#user'+id).html(l);
			}
		});
	} );
  $( '.wps_wrma_exchange_loader' ).hide();
  // Accept the exchange request.
  $( document ).on('click', '#wps_wrma_accept_exchange', function(){
		$('.wps_wrma_exchange_loader').show();
		var orderid = $(this).data('orderid');
		var date = $(this).data('date');
		var data = {
				action:'wps_exchange_req_approve',
				orderid:orderid,
				date:date,
				security_check	:	mwr_admin_param.wps_rma_nonce	
		};
		$.ajax({
			url: mwr_admin_param.ajaxurl, 
			type: 'POST',  
			data: data,
			dataType :'json',	
			success: function(response) 
			{
				$('.wps_wrma_exchange_loader').hide();
				location.reload();
			}
		});
	});
  // Cancel the exchange request.
	$( document ).on( 'click', '#wps_wrma_cancel_exchange', function(){
		$('.wps_wrma_exchange_loader').show();
		var orderid = $(this).data('orderid');
		var date = $(this).data('date');
		var data = {
				action:'wps_exchange_req_cancel',
				orderid:orderid,
				date:date,
				security_check	:	mwr_admin_param.wps_rma_nonce	
			   };
		$.ajax({
			url: mwr_admin_param.ajaxurl, 
			type: 'POST',  
			data: data,
			dataType :'json',	
			success: function(response) 
			{
				$('.wps_wrma_exchange_loader').hide();
				location.reload();
			}
		});
	});
  // Refund left amount after exchange process.
  $( document ).on( 'click', '#wps_wrma_left_amount', function(){
		$(this).attr('disabled','disabled');
		$('#wps_wrma_return_package').hide();
		$('.wps_wrma_return_loader').show();
		var orderid = $(this).data('orderid');
		var refund_amount = $('.ex_left_amount_para .wps_wrma_formatted_price').html();

		var result=false;
		var data = {
			action:'wps_exchange_req_approve_refund',
			orderid:orderid,
			amount:refund_amount,
			security_check	:mwr_admin_param.wps_rma_nonce	
		};
		$('.ex_left_amount_para').children('p').eq(3).html("<strong style='color:red'>New Order Created Successfully.</strong> ");
		$.ajax({
			url: mwr_admin_param.ajaxurl, 
			type: 'POST',  
			data: data,
			dataType :'json',	
			success: function(response) 
			{
				$(this).removeAttr('disabled');
				if(response.result)
				{
					$('#post').prepend('<div class="updated notice notice-success is-dismissible" id="message"><p>Amount is added to Customer wallet.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'); 
					$('html, body').animate({
						scrollTop: $('body').offset().top
					}, 2000, 'linear', function(){
						window.setTimeout(function() {
							window.location.reload();
						}, 1000);
					});
				}
				else
				{
					$('.wps_wrma_return_loader').hide();

					$('html, body').animate({
						scrollTop: $('#order_shipping_line_items').offset().top
					}, 1000);

          $( 'div.wc-order-refund-items' ).slideDown();
          $( 'div.wc-order-data-row-toggle' ).not( 'div.wc-order-refund-items' ).slideUp();
          $( 'div.wc-order-totals-items' ).slideUp();
					
					var refund_amount = $('.ex_left_amount_para .wps_wrma_formatted_price').html();
					var refund_reason = $('.ex_left_amount_subject i').html();

					$('#refund_amount').val(refund_amount);
					$('#refund_reason').val(refund_reason);
					var total = accounting.unformat( refund_amount, woocommerce_admin.mon_decimal_point );

					$( 'button .wc-order-refund-amount .amount' ).text( accounting.formatMoney( total, {
						symbol:    woocommerce_admin_meta_boxes.currency_format_symbol,
						decimal:   woocommerce_admin_meta_boxes.currency_format_decimal_sep,
						thousand:  woocommerce_admin_meta_boxes.currency_format_thousand_sep,
						precision: woocommerce_admin_meta_boxes.currency_format_num_decimals,
						format:    woocommerce_admin_meta_boxes.currency_format
					} ) );
				}
			}
		});
	});
  // Manage stock of the exchange product.
  $(document).on('click','#wps_wrma_stock_back',function(){
    $(this).attr('disabled','disabled');
    var order_id = $(this).data('orderid');
    var type = $(this).data('type');
    var data = { 
      action   : 'wps_wrma_manage_stock' ,
      order_id : order_id ,
      type     : type,
      security_check : mwr_admin_param.wps_rma_nonce
      };
    $.ajax({
    url: mwr_admin_param.ajaxurl, 
    type: 'POST',             
    data: data,
    dataType :'json',
    success: function(response)   
    {
      $(this).removeAttr('disabled');
      if(response.result)
      {
        $('#post').prepend('<div class="updated notice notice-success is-dismissible" id="message"><p>'+response.msg+'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'); 
        $('html, body').animate({
              scrollTop: $('body').offset().top
          }, 2000, 'linear', function(){
            window.setTimeout(function() {
              window.location.reload();
            }, 1000);
          });
      }
      else
      {
        $('#post').prepend('<div id="messege" class="notice notice-error is-dismissible" id="message"><p>'+response.msg+'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'); 
        $('html, body').animate({
              scrollTop: $('body').offset().top
          }, 2000, 'linear', function(){
          });
      }
    }
  });
  });

  // Shipping fee setting related code start
  $('#wps_wrma_ship_products').select2();
  if ( $( '#wps_enable_ship_setting' ).is( ':checked' ) ) {
		$('#add_fee').show();
	}else{
		$('#add_fee').hide();
	}
	$('#wps_enable_ship_setting').on( 'change' , function(){
		if ( $( '#wps_enable_ship_setting' ).is( ':checked' ) ) {
			$('#add_fee').show();
		}else{
			$('#add_fee').hide();
		}
	});
  $('#wps_ship_pro_cb').on( 'change' , function(){
    if ( $( '#wps_ship_pro_cb' ).is( ':checked' ) ) {
      $('.select_product_for_ship').show();
    }else{
      $('.select_product_for_ship').hide();
    }
  });
  $(document).on('click','.wps_wrma_global_ship_fee_rem',function(){

    $(this).closest('tr').remove();
  });
  if ( $( '#wps_ship_pro_cb' ).is( ':checked' ) ) {
    $('.select_product_for_ship').show();
  }else{
    $('.select_product_for_ship').hide();
  }
  $(document).on('click','#add_fee_button',function(){
    var fee_html='';
    fee_html += '<tr class="add_fee_tr" valign="top">';
    fee_html += '<td class="forminp"><fieldset>';
    fee_html += '<div><input type="text" id="add_ship_fee_name" name="add_ship_fee_name[]" placeholder="Fee Name"></div></fieldset></td>';
    fee_html += '<td><fieldset><div><input type="text" id="add_ship_fee_cost" name="add_ship_fee_cost[]" placeholder="Fee Cost"></div></fieldset></td><td><fieldset><div><input type="button" class="button wps_wrma_global_ship_fee_rem" value="Remove"></div></fieldset></td></tr>';
    $(fee_html).insertBefore($(this).closest('tr'));
  });
  // Shipping fee setting related code end

  // Integration tab setting code start
  $( '.wps_rma_shipping_label_setting' ).show();
  $( '.wps_rma_shipping_setting' ).hide();
	$( '.show_returnship_label' ).addClass('shipClass');
	$('.wps_wrma_return_loader').hide();
	$('.wps_wrma_returnship_loader').hide();
  $( document ).on( 'click', '.show_returnship_label', function() {
    $( '.wps_rma_shipping_label_setting' ).show();
	$( '.show_returnship_label' ).addClass('shipClass');
	$( '.show_shipintegration' ).removeClass('shipClass');
    $( '.wps_rma_shipping_setting' ).hide();
  });
  $( document ).on( 'click', '.show_shipintegration', function() {
      $( '.wps_rma_shipping_setting' ).show();
	  $( '.show_shipintegration' ).addClass('shipClass');
	  $( '.show_returnship_label' ).removeClass('shipClass');
      $( '.wps_rma_shipping_label_setting' ).hide();
  });
  $(document).on('change','select#wps_wrma_ship_station_country',function(){
      
    var selectedCountry = $('#wps_wrma_ship_station_country option:selected').val();
    var data = {
        action:'wps_wrma_select_state',
        country : selectedCountry,
        security_check	:	mwr_admin_param.wps_rma_nonce	
      };
    $.ajax({
      
      url: mwr_admin_param.ajaxurl, 
      type: 'POST',  
      data: data ,
      success: function( response ) 
      {
        $('.wps_wrma_ship_station_state').html(response);
      }
    });
  });
  /* API LOGIN AND VALIDATION FOR SHIPENGINE*/
  $(document).on('click','.wps_wrma_validate_api_key',function(){
    $('.wps_wrma_return_loader').show();
    var api_key = $('#wps_wrma_validate_id').val();
    var error_cont = $(this).parent().parent().find('.wps_wrma_notify_error');
    var data = {
        action:'wps_wrma_validate_api_key',
        api_key: api_key,
        security_check	:	mwr_admin_param.wps_rma_nonce	
      };
  
    $.ajax({
      
      url: mwr_admin_param.ajaxurl, 
      type: 'POST',  
      data: data,
      dataType:'json',	
      success: function( response )
      {
        
        $('.wps_wrma_return_loader').hide();
        error_cont.html( response );
        if( response == 'success' ) {
          location.reload();
        }
      }
    });
  });
  // ShipEngine logout.
  $(document).on('click','.wps_wrma_logout',function(){
    $('.wps_wrma_return_loader').show();
    var data = {
        action:'wps_wrma_logout',
        security_check	:	mwr_admin_param.wps_rma_nonce	
      };
    $.ajax({
      
      url: mwr_admin_param.ajaxurl, 
      type: 'POST',  
      data: data,
      dataType :'json',	
      success: function( response )
      {
        $('.wps_wrma_return_loader').hide();
        location.reload();
      }
    });
  });
  /* API LOGIN AND VALIDATION FOR SHIPSTATION*/
  $(document).on('click','.wps_wrma_ship_validate_api_key',function(){
    $('.wps_wrma_returnship_loader').show();
    var ship_api_key = $('#wps_wrma_validate_ship_api_id').val();
    var ship_secret_key = $('#wps_wrma_validate_secret_id').val();
    var data = {
        action:'wps_wrma_validate_shipstation_api_key',
        ship_api_key : ship_api_key,
        ship_secret_key : ship_secret_key,
        security_check	: mwr_admin_param.wps_rma_nonce	
      };
      var error_cont = $(this).parent().parent().find('.wps_wrma_notify_error');
    $.ajax({
      
      url: mwr_admin_param.ajaxurl, 
      type: 'POST',  
      data: data,
      dataType :'json',	
      success: function( response )
      {
        $('.wps_wrma_returnship_loader').hide();
        error_cont.html( response );
        if( response == 'success' ) {
          location.reload();
        }
      }
    });
  });
  // ShipStation logout.
  $(document).on('click','.wps_wrma_shipstation_logout',function(){
    $('.wps_wrma_returnship_loader').show();
    var data = {
        action:'wps_wrma_shipstation_logout',
        security_check	:	mwr_admin_param.wps_rma_nonce	
      };
    $.ajax({
      
      url: mwr_admin_param.ajaxurl, 
      type: 'POST',  
      data: data,
      dataType :'json',	
      success: function( response ) 
      {
        location.reload();
        $('.wps_wrma_returnship_loader').hide();
        
      }
    });
  });
  // Integration tab setting code end
  
  // Activate the rma org plugin.
  $( document ).on( 'click', '.wps_rma_activate_lite', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    if( href ) {
      $.ajax({
        url: mwr_admin_param.ajaxurl, 
        type: 'POST',
        data : {
          security_check: mwr_admin_param.wps_rma_nonce, 
          action: 'wps_rma_lite_activate',
          href: href,
        },
        success: function( response ) {
          window.location.reload();
        }
      });
    }
  });

  // change the coupon amount on the user profile edit page.
  $(document).on('click' , '#wps_wrma_change_customer_wallet_amount' , function(){
    $('.regenerate_coupon_code_image').css('display' , 'inline-block');
    var user_id = $(this).data('id');
    var coupon_code = $(this).data('couponcode');
    var amount = $('#wps_rma_customer_wallet_price').val();
    $.ajax({
      url: mwr_admin_param.ajaxurl, 
      type: 'POST',
      data: {
        action : 'wps_rma_change_customer_wallet_amount', 
        coupon_code : coupon_code ,
        amount : amount,
        security_check: mwr_admin_param.wps_rma_nonce,
      },
      success: function(respond)   
      {
        $('.regenerate_coupon_code_image').css('display' , 'none');
      }
    });
  });
  // License Code
  $( '#wps_license_ajax_loader').hide();
  $('form#wps_mwr_license_form').on('submit', function(e) {
    e.preventDefault();
    var license_key = $('#wps_mwr_license_key').val();
    $( '#wps_license_ajax_loader').show();
    $.ajax({
      type: 'POST',
      dataType: 'JSON',
      url: mwr_admin_param.ajaxurl,
      data: {
        action: 'wps_mwr_validate_license_key',
        purchase_code: license_key,
        security_check : mwr_admin_param.wps_rma_nonce,
      },

      success: function(data) {
        
        $( '#wps_license_ajax_loader').hide();

        if (data.status == true) {
          $('#wps_mwr_license_activation_status').css('color', '#42b72a');

          $('#wps_mwr_license_activation_status').html(data.msg);

          location = mwr_admin_param.mwr_admin_param_location;
        } else {
          $('#wps_mwr_license_activation_status').css('color', '#ff3333');

          $('#wps_mwr_license_activation_status').html(data.msg);

          $('#wps_mwr_license_key').val('');
        }
      },
    });
  });
});
