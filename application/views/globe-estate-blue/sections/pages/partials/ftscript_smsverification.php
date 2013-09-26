

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
										if( resp.is_globe_subscriber == 'false' && resp.order_type == 'reserve'){
											$('#dialog_reserve_form').dialog( "open" );
											return;
										}
									}else{
										if(resp.tries < 3){
											return; // donot redirect yet
										}
									
									}

									window.location.href = base_url+resp.next_page;
								}, 
								error: function(){
									s.html('Some error occured or the system is busy. Please try again later');	
								}
							});
								
					});
					 
					$('#verification_code').focus(function(){
							$('#verification_code').css('border', '2px solid #bdc3c7');
							$('.vcode-alert').fadeOut('fast');
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
										$( '#verifyNumber' ).modal( "show" );
										
										
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

						e.preventDefault();
							$.ajax({
							    type: 'post',
							    data: 'input_code='+code,
								url: base_url+'captcha/validate',
							    success: function(response){
									var resp = jQuery.parseJSON( response );
									
									if(resp.status == 'success'){
										s.hide();
										$('#resetVerification').modal('close');
										$('#verifyNumber').modal('show');
									}else{
										s.html(resp.msg);
										createCaptcha();
										$('input#code_id').val('');
									}
								}	
							});
					});
					
					
