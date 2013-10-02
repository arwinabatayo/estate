/* ---------- SMS VERIFICATION SCRIPTS ---------- */

					<?php if($this->session->userdata('showcaptcha')){ ?>
							$('#resetVerification').modal('show');
							createCaptcha();
					<?php } else { ?>
							$('#enterMobile').modal('show');
					<?php } ?>
										
					$('button#open_verify_mobile').click( function(e){   
						e.preventDefault();
						$('#dialog_enter_mobile').dialog( "close" );
						$('#dialog_verify_mobile').dialog( "open" );
					});	
					
					$('#verifyNumber button').click( function(e){
						var s =	$('#verifyNumber div.status');
						
						var code =	$('input#verification_code').val();
							e.preventDefault();
							s.removeClass('alert-error');

							if( code.length == 0) {
								$('#verification_code').css('border', '2px solid #e2422d');
								$('.vcode-alert').fadeIn('fast');
								return;
							}
							
							s.show();
							s.html('Validating...Please wait...');

							$.ajax({
								url: base_url+'home/check_verification_code',
								data: 'sms_verification_code='+code,
								type:'post',
								success: function(response){
									s.show();
									var resp = jQuery.parseJSON( response );
									s.addClass('alert-'+resp.status);
									s.html(resp.msg);
								    
									if(resp.status == 'success'){
										if (resp.order_type == 'reserve') {
											// close current dialog box
											$('#verifyNumber').modal( "hide" );
											// open ty page, close after x secs and redirect to homepage
											$('#04-thank-you').modal( {show:true} );
											setTimeout('$("#04-thank-you").modal("hide"); window.location.href = base_url+resp.next_page;', 2000);
											resp.next_page = '';
										} else if (resp.overdue_flag) {
											// show overdue popup
											// alert("You need to settle your overdue balance before you can proceed");
											$('#verifyNumber').modal('hide');
											$('#settle-overdue').modal({show:true});
											$('#outstanding-balance').html('P'+resp.outstanding_balance);
										}
									}else{
										if(resp.tries < 3){
											return; // donot redirect yet
										}
									
									}

									if (resp.next_page != '') {window.location.href = base_url+resp.next_page;}
								}, 
								error: function(){
									s.html('Some error occured or the system is busy. Please try again later');	
								}
							});
								
					});

					$('button#btnEnterMobileNum').click( function(){
							var s =	$('#enterMobile div.status');
							var msisdn = $('input#msisdn').val();
		                    
		                    if( msisdn.length != 11){
								s.show();
								s.html('You must enter a valid Mobile Number');
								return;
							}
		                    
							//e.preventDefault();
							
							s.show();
						    s.html('Sending...Please wait...');

							$.ajax({
								url: base_url+'home/send_sms_verification',
								data: 'msisdn='+msisdn,
								type:'post',
								success: function(response){
									var resp = jQuery.parseJSON( response );
					
									if(resp.status == 'success'){
										s.hide();
										$( '#enterMobile' ).modal( "hide" );

										if (resp.non_globe_reserve) {
											// set value of email and mobile
											$('form#reserve-form #email').val(resp.email);
											$('#email-cont').html(resp.email);
											$('form#reserve-form #phone').val(resp.mobile_number);
											$('#phone-cont').html(resp.mobile_number);

											// open reserve form for non globe
											$('#reserve-08').modal('show').css(
												{
													'margin-left': function () {
													return window.pageXOffset-($(this).width() / 2 );
												}
											});
											$('.consultation-radio input').iCheck({
												radioClass: 'iradio_flat-blue'
											});
										} else {
											$( '#verifyNumber' ).modal( {show:true} );
										}
										
									}else{
										s.addClass('alert-'+resp.status);
										s.html(resp.msg);
									}
									
								}, 
								error: function(){
									alert('Some error occured or the system is busy. Please try again later');	
								}
							});
					
					});	
					
					$('button#btn_resend_vcode').click( function(e){

						//var code =	$(this).closest('input[name="code_id"]').val();
						var code =	$('input#code_id').val();
						var s =	$('#resetVerification div.status');
						
						s.show();
						s.html('Validating...Please wait...');
		
							$.ajax({
							    type: 'post',
							    data: 'input_code='+code,
								url: base_url+'captcha/validate',
							    success: function(response){
									var resp = jQuery.parseJSON( response );
									
									if(resp.status == 'success'){
										s.hide();
										$('#resetVerification').modal('hide');
										$('#verifyNumber').modal({show:true});
									}else{
										s.html(resp.msg);
										createCaptcha();
										$('input#code_id').val('');
									}
									
								}	
							});
							
					});

					$('#verification_code').focus(function(){
						$('#verification_code').css('border', '2px solid #bdc3c7');
						$('.vcode-alert').fadeOut('fast');
					});
					
/* ---------- OVERDUE BALANCE SCRIPTS ---------- */

					// TODO : get additional details what params are required here
					$('a#settle-overdue-cc').click(function(){
						// credit card page
						// alert('Credit card');
						window.location.href= base_url + 'payment-method';
					});

					$('a#settle-overdue-gcash').click(function(){
						// show gcash flow
						// alert('G-Cash');
						window.location.href= base_url+'payment-method';
					});

					$('a#settle-account').click(function(){
						// opens payment channel window
						$('#settle-overdue').modal("hide");
						$('#choose-payment').modal({show:true});
						// change payment channel HEADER label on click
						$('input:radio[name=payment_channels]').click(function(){
							$('#payment-medium-label').html($('input:radio[name=payment_channels]:checked').val());
						});
					});

					$('a#get-prepaid-kit').click(function(){
						// redirects to prepaid kit flow
						$.ajax({
							url: base_url+'cart/addprepaidtocart',
							success: function(response){

								var resp = jQuery.parseJSON( response );

								if (resp.status == 'success') {
							       window.location = resp.cart_url;
								} else {
									alert(resp.msg);
								}

							},
							error: function(){
								alert('Some error occured or the system is busy. Please try again later');
							}
						});
					});

					$('#settle-due-ways').click(function(){
						alert('Ways to settle account');
					});

					$('form#payment-channels-form').submit(function(){
						var formData = $('form#payment-channels-form').serialize();
						$.ajax({
							url : base_url + 'payment/settle_payment',
							data : formData,
							type : 'post',
							success : function(response) {
								resp = jQuery.parseJSON(response);

								if (resp.status == 'success') {
									// hide current modal
									$('#choose-payment').modal('hide');
									// show ty popup
									$('#04-thank-you').modal({show:true});
									$('#ty-msg').html(resp.msg);
									$('#ty-msg-btn').html('Continue');
								} else {
									alert(resp.msg);
								}
 							},
							error : function () {
								alert('Some error occured or the system is busy. Please try again later');
							}
						});
					});


