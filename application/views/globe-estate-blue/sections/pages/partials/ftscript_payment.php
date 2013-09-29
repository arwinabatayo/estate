				    
					//delete cart item - mark
					$(document).on('click', '#cartSummaryTable a.btnDelete', function(){
							var rowid = $(this).attr('id');
							var prodName = $(this).attr('rel');
			
							if( !confirm('Are you sure you want to delete "'+prodName+'"?')) return;

							$.ajax({
								url: base_url+'cart/delete',
								data: 'keyid='+rowid+'&type',
								type:'post',
								success: function(response){
			
									var resp = jQuery.parseJSON( response );
			
									if(resp.status == 'success'){
										$('tr#prod-item-'+rowid).fadeOut('slow', function(){ $(this).remove() });
										$('#cashoutLabelSubtotal').html(resp.total);
										$('#cashoutLabel').html(resp.total);
									}else{
										alert(resp.msg);
									}
								},
								error: function(){
									alert('Some error occured or the system is busy. Please try again later');
								}
							});
			
					});
		
				    $('#personal-info-page  button.goNext').click(function() {
						var btnIndex = $('#personal-info-page  button.goNext').index(this);
						$( "#personal-info-page" ).accordion({active: btnIndex+1});
					});		
					
					
					// Delivery -- robert
					// Selecting Delivery Type
					
					var $radiosDeliveryType = $('input:radio[name=delivery_mode]');
				    if($radiosDeliveryType.is(':checked') === false) {
				        $radiosDeliveryType.filter('[value=delivery]').prop('checked', true);
				    }
					
					
					$("#deliveryorpickupBtn").click(function(e) {
						e.preventDefault();
						var deliveryType = $('input[name=delivery_mode]:checked').val();
						$.ajax({
							url: base_url+'order/save_payment_shipping_config',
							data: 'delivery_mode='+deliveryType,
							type: 'post',
							success: function(response){
								var resp = jQuery.parseJSON( response );
								if(resp.status == 'success'){
								    window.location.href= base_url+'shipping-address';
								}
							}, 
							error: function(){
								alert('Some error occured or the system is busy. Please try again later');	
							}
						});
					})
					
					// Delivery Billing Address -- robert
					
					var radiosShipAdd = $('input:radio[name=shipping_address]');
				    if(radiosShipAdd.is(':checked') === false) {
				        radiosShipAdd.filter('[value=billing]').prop('checked', true);
				        
				        $('#shipContent').hide();
				    }
				    
				    radiosShipAdd.click(function(e) {
						$(this).closest('ul').each(function() {
			    			$('li div.delContent').slideUp();
				    	});
				    	$(this).parent().next('div.delContent').slideDown();
				    });
				    
				    $('#shippingTypeBtn').click(function(e) {
				    	e.preventDefault();
				    	
				    	var shippingType = $('input[name=shipping_address]:checked').val();
				    	//alert(shippingType);
				    	window.location.href= base_url + 'pickup-store';
				    	/**
				    	$.ajax({
								url: base_url+'order/save_address',
								data: formData,
								type:'post',
								success: function(response){
									var resp = jQuery.parseJSON( response );
									//alert(JSON.stringify(resp));
									if(resp.status == 'success'){
										alert('New shipping address saved!');
										btn.attr('disabled',true);
										$( "#personal-info-page" ).accordion( "option", "active", 2 );
									}
								}, 
								error: function(){
									alert('Some error occured or the system is busy. Please try again later');	
								}
							});
				    	**/
				    })
				    
				    // Payment Method-- robert
					var radiosPayMethod = $('input:radio[name=payment_method]');
				    if(radiosPayMethod.is(':checked') === false) {
				        radiosPayMethod.filter('[value=atm]').prop('checked', true);
				    }
				    
				    $('#paymentMethodBtn').click(function(e) {
				    	e.preventDefault();
				    	var api = $('input[name=payment_method]:checked').attr('data-api');
				    	var paymentMethod = $('input[name=payment_method]:checked').val();
				    	$.ajax({
							url: base_url+'order/save_payment_shipping_config',
							data: 'payment_method='+paymentMethod,
							type: 'post',
							success: function(response){
								var resp = jQuery.parseJSON( response );
								if(resp.status == 'success'){
								    window.location.href= base_url + 'payment-checkout';
								}
							}, 
							error: function(){
								alert('Some error occured or the system is busy. Please try again later');	
							}
						});
				    })
				    
				    // Survey -- robert
				    $('.thank-order-check input').iCheck({
						checkboxClass: 'icheckbox_flat-blue',
						radioClass: 'iradio_flat-blue'
					});
					$('#surveyBtn').click(function(e) {
				    	e.preventDefault();
				    	//$('input[name=survey]:checked').each(function () {
					    //   var sValues = (this.checked ? $(this).val() : "");
					  	//});
				    	
				    	
				    	$(this).parent().parent().parent().fadeOut("slow", function(){
    						var toView = '<div class="span6 lgreybg" ><div class="row-fluid"><span class="flow-title pull-left offset1"><i class="flow-icon icon-apprvicon pull-left"></i><span>Thank you for taking time to<br />answer our Survey Questions</span></span><p class="flow-instruction pull-left">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p></div><div class="row-fluid"><p class="flow-instruction p-r-t-u-answer pull-left">We are about to post  what you\'ve purchased on your Facebook wall. Please confirm.</p><br /><div class="span6 flow-btns pull-left"><button class="blue-btn">Confirm</button></div><div class="span5 flow-btns pull-left"><button class="blue-btn">Cancel</button></div><div class="clr"></div></div></div>';
    						$(this).replaceWith(toView).fadeIn("slow");
    					});
				    })
				    
				    
				    //Pickup Stores-mark
					$('.radio-btn input').iCheck({
						checkboxClass: 'icheckbox_flat-red',
						radioClass: 'iradio_flat-blue'
					});
					
					$('#receipt-popup').modal({dynamic:true});
					
					$('.accordion').on('show hide', function (n) {
						$(n.target).siblings('.accordion-heading').find('.accordion-toggle i').toggleClass('icon-arrow-up icon-arrow-down');
						$(n.target).siblings('.accordion-heading').toggleClass('a-h-white a-h-whiteno');
					});
				    
				    
				    
				    
				    
				    
