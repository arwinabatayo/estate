		function closeModal(obj){
			var id = obj.parent().parent().attr("id");
			
			$("#" + id).modal('hide')
		}
		
		
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
			$("#"+seletorID).after('<span id="captchaPreloder" class="block" style="font-size:12px">Loading Captcha...Please wait...</span>');
			$.ajax({
			    dataType: 'json',
			    type:'POST',
				url: base_url+'captcha/get_captcha_img',
			    success: function(response){
					$("span#captchaPreloder").remove();
					$("#"+seletorID).attr('src',response.src);	
					
				},
				error: function(xhr, status, error){
						alert(xhr.responseText);
				}	
			});
			
		 }

/*
		$('a#refresh_code').click( function(e){
			e.preventDefault();
			var sel = $(this).siblings('img').attr('id');
			createCaptcha(sel) ;
		});	
*/
		
		$('.btnRefresh_code').each( function(){
			$(this).click( function(e){
				var sel = $(this).attr('rel');
				createCaptcha(sel) ;	
			});	
		});	
		

		// set dialog for opening refnum verification - gellie
		$('a#open_application_status').on('click', function(){
			$( '#my-application' ).modal({show:true});
		});

		// validate reference number - gellie
		$('form#refnum-verification').submit(function(){
	
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


		// forgot reference number link
		$('a#lnk_forgot_refnum').on('click', function(){
			$( '#my-application' ).modal( "hide" );
			$( '#forgot-reference' ).modal({show:true});

			// show captcha image
			createCaptcha('fr_captcha') ;
		});

		// validate email and captcha code - gellie
		$('form#forgot-refnum').submit(function(){
	
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
							$( '#forgot-reference' ).modal( "hide" );
							// open thank you dialog
							$( '#04-thank-you' ).modal({show:true});
							// show success message
							$('#ty-msg').html(resp.msg);
							// $('#ty-note').hide();
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
		

		// set dialog for resume uncomp transaction - gellie
		$('a#open_resume_uncomp_transaction').on('click', function(){
			$( '#my-application' ).modal( "hide" );
			$( '#uncomplete-transaction' ).modal({show:true});

			// show captcha image
			createCaptcha('ut_captcha') ;
		});
		
		// validate email and captcha code - gellie
		$('form#resume-uncomp-transaction').submit(function(){
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
							$( '#uncomplete-transaction' ).modal( "hide" );
							// open thank you dialog
							$( '#04-thank-you' ).modal({show:true});
							// show success message
							$('#ty-msg').html(resp.msg);
							// $('#ty-note').show();
							// $('#resend-link-info').show();
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
			$( '#04-thank-you' ).modal( "hide" );
			// reopen resume uncompleted transaction form
			$('a#open_resume_uncomp_transaction').click();
			// reset fields
			$("#email").val('');
			$("#code_id").val('');
			// remove status
			$('div.status').hide();
		});
