			//SKU Configuration
			
			$('button#btn-add-device-continue').on('click', function(){
					var formData  = $('form#addGadget').serialize();	
					showPreloader();
					$.ajax({
						url: base_url+'cart/addtocart',
						data: formData,
						type:'post',
						success: function(response){
							
							var resp = jQuery.parseJSON( response );

							if(resp.status == 'success' && resp.rowid){
								$( '#emailConfirm' ).modal( {show:true} );
							}else{
								alert(resp.msg);
							}
							
							closePreloader();
							
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});
	
			});
			
			$('form#email-verification button').on('click', function(){
			
					var s =	$('form#email-verification div.status');
					var email =	$('form#email-verification input[name="email"]').val();

					s.show();
				    s.html('Sending...Please wait...');
				    
					$.ajax({
						url: base_url+'home/send_email_activation',
						data: 'email='+email,
						type:'post',
						success: function(response){
							var resp = jQuery.parseJSON( response );
			
							if(resp.status == 'success'){
								$('#e_lbl').html(email);
								$('#emailConfirm').modal( 'hide' );
								$('#emailThankConfirm').modal( {show:true} );
								s.html('').hide();
								
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
				
			

