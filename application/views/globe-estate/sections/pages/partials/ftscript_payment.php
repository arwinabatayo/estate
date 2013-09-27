				    $('#personal-info-page  button.goNext').click(function() {
						var btnIndex = $('#personal-info-page  button.goNext').index(this);
						$( "#personal-info-page" ).accordion({active: btnIndex+1});
					});		
					
					
					var selectedDelivery = $('input[name=delivery_mode]:checked').val();
					var selectedShippingAddress = $('input[name=shipping_address]:checked').val();

					showHideDelivery(selectedDelivery);
					
					showHideShippingAddress(selectedShippingAddress);
					
					$('input[name=delivery_mode]').click(function() {
						var e = $(this).val();
						showHideDelivery(e);
					});
					
					
					$('input[name=shipping_address]').click(function() {
						var e = $(this).val();
						showHideShippingAddress(e);
					});
					
					
					function showHideDelivery(e){
						if( e == 'pickup'){
							$("#delivery_pickup").slideDown();
							$("#delivery_ship").slideUp();
						}else{

							$("#delivery_pickup").slideUp();
							$("#delivery_ship").slideDown();
						}
					}
					
					function showHideShippingAddress(e){
						if( e == 'new'){
							$("#shipping_address_new").slideDown();
							$('#shipping_address_field').slideUp();
						}else{
							$("#shipping_address_new").slideUp();
							$("#shipping_address_field").slideDown();
						}
					}

					// save new shipping address - mark
					$('form#new-shipping button').click(function(){
							var formData  = $('form#new-shipping').serialize();
							var btn = $(this);
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
					});	
					
					// Proceed to Payment Gateway - mark
					// Store Order Config: Delivery Mode, Shipping Address, Payment Option
					$('button#btnProceedToPayment').click(function(){
						var d  = $('input[name="delivery_mode"]:checked').val();
						var p  = $('input[name="payment_option"]:checked').val();
						var s  = $('input[name="shipping_address"]:checked').val();
						
							$.ajax({
								url: base_url+'order/save_payment_shipping_config',
								data: 'delivery_mode='+d+'&payment_option='+p+'&shipping_address='+s,
								type: 'post',
								success: function(response){

									var resp = jQuery.parseJSON( response );
									
									if(resp.status == 'success'){
									    window.location.href= base_url+'payment/gateway';
									}
								}, 
								error: function(){
									alert('Some error occured or the system is busy. Please try again later');	
								}
							});
						
					});
                                        
                                        $('#prefered_loc_search').click(function() {
                                            var location = $("#prefered_loc_val option:selected").text();
                                            $.post(base_url+'payment/search_store', {store_name: location}, function(data){
                                                $('.store_placeholder').html(data.temp);
                                             }, "json");
                                         });
                                         
                                         $('#store_search').click(function() {
                                            var keyword = $("#store_keyword").val();
                                            $.post(base_url+'payment/search_nearest_stores', {keyword: keyword}, function(data){
                                                $('.store_placeholder').html(data.temp);
                                             }, "json");
                                         });
