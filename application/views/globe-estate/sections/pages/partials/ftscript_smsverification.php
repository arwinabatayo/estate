					$('#dialog_enter_mobile').dialog({
						autoOpen: true,modal:true,dialogClass: "no-close",
						buttons: [{
							text: "OK",
							click: function() {
								   $( this ).dialog( "close" );
								   $( '#dialog_verify_mobile' ).dialog( "open" );
							}
						}]
					});
							
					$('#dialog_verify_mobile').dialog({
						autoOpen: false,width:'auto',modal:true
					});
					
					$('#dialog_enter_captcha').dialog({
						autoOpen: true,width:'35%',modal:true
					});
										
					$('button#open_verify_mobile').click( function(e){
						e.preventDefault();
						$('#dialog_enter_mobile').dialog( "close" );
						$('#dialog_verify_mobile').dialog( "open" );
					});	
					
					$('form#sms-verification button').click( function(e){
						var s =	$('form#sms-verification div.status');
						var code =	$('input#verification_code').val();
							e.preventDefault();
							s.removeClass('alert-error');
							
							$.ajax({
								url: base_url+'home/check_verification_code',
								data: 'sms_verification_code='+code,
								type:'post',
								success: function(response){
									s.show();
									var resp = jQuery.parseJSON( response );
									s.addClass('alert-'+resp.status);
									s.html(resp.msg);
	
									//alert ( JSON.stringify(response) );
								   // return;
								    
									if(resp.status == 'success'){
										if (resp.order_type == 'reserve') {
											// close current dialog box
											$('#dialog_verify_mobile').dialog( "close" );

											if(!resp.is_globe_subscriber){
												// open reserve form for non globe subscriber
												$('#dialog_reserve_form').dialog( "open" );
												// return;
												// alert('You should be a globe subscriber to proceed.');
											} else {
												// open ty page, close after x secs and redirect to homepage
												$('#dialog_thankyou_reserve').dialog( "open" );
												setTimeout('$("#dialog_thankyou_reserve").dialog("close")', 5000);
											}
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

					$('button#btn_resend_vcode').click( function(e){

						var code =	$(this).siblings('input[name="code_id"]').val();

						e.preventDefault();
							$.ajax({
							    type: 'post',
							    data: 'input_code='+code,
								url: base_url+'captcha/validate',
							    success: function(response){
									var resp = jQuery.parseJSON( response );
									//alert ( JSON.stringify(response) )
									//alert ( resp.status );
									
									if(resp.status == 'success'){
										//alert(resp.msg);
										//window.location.reload();
										$('#dialog_enter_captcha').dialog( "close" );
										$('#dialog_verify_mobile').dialog( "open" );
									}else{
										alert(resp.msg);
										createCaptcha();
										$('input#code_id').val('');
									}
								}	
							});
					});
					
					
