	
		function setOrderConfig(k,v){
			var out;
					$.ajax({
						url: base_url+'cart/set_order_config',
						data: 'key='+k+'&val='+v,
						type:'post',
						success: function(response){
							out = response;
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});
			return out;
		}
		
		// function that sets captcha img src 
        function createCaptcha( seletorID ){
			var seletorID = seletorID ? seletorID : 'captcha';
			$.ajax({
			    dataType: 'json',
				url: base_url+'captcha/get_captcha_img',
			    success: function(response){
					$("#"+seletorID).attr('src',response.src);	
				},
				error: function(xhr, status, error){
						alert(xhr.responseText);
				}	
			});
		 }

		$('a#refresh_code').click( function(e){
			e.preventDefault();
			var sel = $(this).siblings('img').attr('id');
			createCaptcha(sel) ;
		});	
		
		$('a#get-prepaid-kit').click(function(){
			// show bubble info where add to cart link is present
			$('#tooltip-prepaid-kit').dialog("open");
		});
		
		//accessories & addons addtocart - mark
		$('form.addtoCart img').click(function(){
			
				var thisID = $(this).parent('form').attr('id');
				var itemname  = $(this).find('input[name=product-name]').val();
				var itemprice = $(this).find('input[name=product-price]').val();
				var itemid    = $(this).find('input[name=product-id]').val();
				var formData  = $('form#'+thisID).serialize();
				var basket    = $('#AddonCartWidget');
				var basketAccessory    = $('#AccessoryCartWidget');
	
				$.ajax({
					url: base_url+'cart/addtocart',
					data: formData,
					type:'post',
					success: function(response){
						
						var resp = jQuery.parseJSON( response );
						
						var cartItem = '<div id="prod-item-'+resp.rowid+'" class="item" style="display:none"><div class="fleft"><span class="productName block">'+resp.name+'</span><span class="price block arial italic">'+resp.price_formatted+'</span></div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'"><i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
						
						if(resp.status == 'success' && resp.rowid){
					
							if( resp.product_type == 'accessories'){
								basketAccessory.append(cartItem);
							}else{
							    basket.append(cartItem);
							}
							
							$('#prod-item-'+resp.rowid).show('slow');
							$('#cashoutLabel').html(resp.total);
							$('#cashoutBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
								$('#cashoutBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
							});
							
							
						}else{
							alert(resp.msg);
						}
						
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
					
		});
				
		//delete cart item - mark
		$(document).on('click', '.cartWidget a.btnDelete, #cartSummaryTable a.btnDelete', function(){
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
							$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
							$('.cashoutLabel').html(resp.total);
						}else{
							alert(resp.msg);
						}
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
				
		});

		// validate reference number - gellie
		$('form#refnum-verification button').on('click', function(){
	
				var s = $('form#refnum-verification div.status');
				var refnum = $('input#reference_number').val();
				// reset error class
				s.removeClass('alert-error');
				//e.preventDefault();
				
				s.show();
				s.html('Sending...Please wait...');
				
				// may problem pa sa cache
				//$(this).attr('disabled',true);

				$.ajax({
					url: base_url+'home/validate_reference_number',
					data: 'refnum='+refnum,
					type:'post',
					success: function(response){
						var resp = jQuery.parseJSON( response );
						
						if(resp.status == 'success'){
							$('#e_lbl').html(refnum);
							s.html(resp.msg);
							// redirect to status page
							window.location = resp.status_page_url;
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

		// set dialog for resume uncomp transaction - gellie
		$('a#open_resume_uncomp_transaction').on('click', function(){
			$( '#dialog_application_status' ).dialog( "close" );
			$( '#dialog_resume_uncomp_transaction' ).dialog( "open" );

			// show captcha image
			createCaptcha('ut_captcha') ;
		});
		
		// validate email and captcha code - gellie
		$('form#resume-uncomp-transaction button').on('click', function(){
	
				var s =	$('form#resume-uncomp-transaction div.status');
				// TODO : add validation for email
				var email = $('#resume-uncomp-transaction input#email').val();
				var code_id = $('#resume-uncomp-transaction input#code_id').val();


				// reset error class
				s.removeClass('alert-error');
				//e.preventDefault();
				
				s.show();
			    s.html('Sending...Please wait...');
			    
			    // may problem pa sa cache
			    //$(this).attr('disabled',true);

				$.ajax({
					url: base_url+'home/verify_email_captcha',
					data: 'email='+email+'&code='+code_id+'&flow_type=saved_transaction',
					type:'post',
					success: function(response){
						var resp = jQuery.parseJSON( response );
						
						if(resp.status == 'success') {
							// close current dialog box
							$( '#dialog_resume_uncomp_transaction' ).dialog( "close" );
							// open thank you dialog
							$( '#dialog_saved_transaction_success' ).dialog( "open" );
							// show success message
							$('#msg-success').html(resp.msg);
							$('#ty-note').show();
							$('#resend-link-info').show();
						} else {
							s.addClass('alert-'+resp.status);
							s.html(resp.msg);
						}
						
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');	
					}
				});
		});	

		// resend link
		$('a#resend_saved_transaction_lnk').on('click', function(){
			// close thank you dialog
			$( '#dialog_saved_transaction_success' ).dialog( "close" );
			// reopen resume uncompleted transaction form
			$('a#open_resume_uncomp_transaction').click();
			// reset fields
			$("input").val('');
			// remove status
			$('div.status').hide();
		});

		// forgot reference number link
		$('a#lnk_forgot_refnum').on('click', function(){
			$( '#dialog_application_status' ).dialog( "close" );
			$( '#dialog_forgot_refnum' ).dialog( "open" );

			// show captcha image
			createCaptcha('fr_captcha') ;
		});

		// validate email and captcha code - gellie
		$('form#forgot-refnum button').on('click', function(){
	
				var s = $('form#forgot-refnum div.status');
				// TODO : add validation for email
				var email = $('#forgot-refnum input#email').val();
				var code_id = $('#forgot-refnum input#code_id').val();


				// reset error class
				s.removeClass('alert-error');
				//e.preventDefault();
				
				s.show();
				s.html('Sending...Please wait...');
				
				// may problem pa sa cache
				//$(this).attr('disabled',true);

				$.ajax({
					url: base_url+'home/verify_email_captcha',
					data: 'email='+email+'&code='+code_id+'&flow_type=forgot_refnum',
					type:'post',
					success: function(response){
						var resp = jQuery.parseJSON( response );
						
						if(resp.status == 'success') {
							// close current dialog box
							$( '#dialog_forgot_refnum' ).dialog( "close" );
							// open thank you dialog
							$( '#dialog_saved_transaction_success' ).dialog( "open" );
							// show success message
							$('#msg-success').html(resp.msg);
							$('#ty-note').hide();
							$('#resend-link-info').hide();
						} else {
							s.addClass('alert-'+resp.status);
							s.html(resp.msg);
						}
						
					}, 
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');  
					}
				});
		});
		
	
		// function for downloading print forms on status page -- gellie
		function downloadForm(_type)
	    {	
	        // call ajax for downloading
	        $.ajax({
	            url: base_url+'order/download_form',
	            data: 'form_type='+_type,
	            type: 'post',
	            success: function(response){
	                var resp = jQuery.parseJSON( response );
	
	                if (resp.file_url) {
						pwin = window.open(resp.file_url,"_blank");
						// added focus for new window
						pwin.focus();
						pwin.print();
	                }     
	            }, 
	            error: function(){
	                alert('Some error occured or the system is busy. Please try again later');  
	            }
	        });
	    }

