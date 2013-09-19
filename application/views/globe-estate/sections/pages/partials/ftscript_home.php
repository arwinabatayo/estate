			//SKU Configuration
			$('input.opt_color').click( function(){
				var color = $(this).val();
				$('#product_preview img').each( function(){
					$(this).hide();
				});
				$('#product_preview img.c_'+color).fadeIn();
			});
			
			$('#dialog_thankyou_email').dialog({
				buttons: [{
					text: "OK",
					click: function() {
						   $( this ).dialog( "close" );
					}
				}]
			});
			
			
			$('form#enter-mobile button').click( function(){
					var s =	$('form#enter-mobile div.status');
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
								$( '#dialog_enter_mobile' ).dialog( "close" );
								$( '#dialog_verify_mobile' ).dialog( "open" );
								
								
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
			
			$('form#email-verification button').on('click', function(){
			
					var s =	$('form#email-verification div.status');
					var email =	$('form#email-verification input[name="email"]').val();

					//e.preventDefault();
					
					s.show();
				    s.html('Sending...Please wait...');
				    
				    // may problem pa sa cache
				    //$(this).attr('disabled',true);

					$.ajax({
						url: base_url+'home/send_email_activation',
						data: 'email='+email,
						type:'post',
						success: function(response){
							var resp = jQuery.parseJSON( response );
			
							if(resp.status == 'success'){
								$('#e_lbl').html(email);
								$( '#dialog_enter_email' ).dialog( "close" );
								$( '#dialog_thankyou_email' ).dialog( "open" );
								s.html('').hide();
								//$(this).attr('disabled',false);
								
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
		
		$('button#open_enter_email').on('click', function(){
				var formData  = $('form#addGadget').serialize();
						
				$.ajax({
					url: base_url+'cart/addtocart',
					data: formData,
					type:'post',
					success: function(response){
						
						var resp = jQuery.parseJSON( response );
								//alert ( JSON.stringify(response) );
								//return;	
						if(resp.status == 'success' && resp.rowid){
							$( '#dialog_enter_email' ).dialog( "open" );
						}else{
							alert(resp.msg);
						}
						
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
		

		});

		// for new line - non globe subscriber jez
		$("#non-globe-new-line").click(function(){
			$("#dialog_new_line").dialog("open");

			$("#new-line-plan").click(function(){
				window.location = "/estate/plan?get_new_line=true"
			});

			$("#new-line-prepaid-kit").click(function(){
				var itemid    = $(this).find("a").attr('data-id');
				var itemname    = $(this).find("a").attr('data-name');
				var plan_pv    = $(this).find("a").attr('data-pv');

				$.ajax({
					url: base_url+'cart/addtocart',
					data: 'product_type=prepaid_kit&device=1',
					type:'post',
					success: function(response) {
						//alert(response);
						var resp = jQuery.parseJSON(response);


						var cartItem = '<div id="prod-item-'+resp.rowid+'" class="itemPlan" style="display:none">'+
						'<div class="fleft"><span class="productName block"><b>'+itemname+
						'</b></span></div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'">'+
						'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
					
						if(resp.status == 'success' && resp.rowid){
							$("#PlanCartWidget .itemPlan").remove();
							$("#PlanCartWidget").prepend(cartItem);
							$('#prod-item-'+resp.rowid).show('slow');

							
							$("#cashoutLabel").html(resp.total).show('slow');
							$("#pesovalLabel").attr('data-pv',resp.this_pv_value).html(resp.this_pv_value).show('slow');
							
							$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
								$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
							});
							$("#plan_name").html(itemname);
							$("#planid").attr('data-id',itemid);
							$("#planid").attr('data-cashout',resp.total);
							$('#prod-item-'+resp.rowid).show('slow');
						}
						
						
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
			})

			
		});
		
		//for none globe
		$('#dialog_reserve_form').dialog({
			autoOpen: false,
			buttons: [{
				text: "OK",
				click: function() {
					   $( this ).dialog( "close" );
					   window.location.href = base_url+'home?showtymsg=true';
				}
			}]
		});
