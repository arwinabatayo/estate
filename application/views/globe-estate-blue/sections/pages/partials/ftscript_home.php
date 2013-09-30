			<?php 
				/**
				 * 
				 * Robert Hughes
				 * 9.26.2013
				 */
				
			?>
			var selectedDevice = $("#multidevice").val();
			$('#multidevice').change(function() {
				var selectedDevice = $("#multidevice").val();
				window.location = "<?php echo base_url(); ?>sku-configuration?device=<?php echo $_GET['device']; ?>&type="+selectedDevice;
			});
			
			$("input[name=gadget_color]").click(function() {
				var imgattr = $(this).attr('data-img');
				var thisID = $(this).val();
				
				var selectedDevice = $("#multidevice").children(":selected").attr("data-id");
				$("#previewimg").attr('src',imgattr);
				
				$.ajax({
						url: base_url+'home/changeAttrCapacity',
						data: {device:selectedDevice,color:thisID},
						type:'post',
						success: function(response){
							$("#capacity ul").html();
							$("#capacity ul").html(response);
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});
				
			})
			
			
			//$('#dialog_reserve_form').modal('show');
			
			//SKU Configuration
			$('button#btn-add-device-continue').on('click', function(){
					var formData  = $('form#addGadget').serialize();	
					var _action = 'cart/addtocart';

					if ($('#is_reserve').val()) {
						_action = 'cart/reserveitem';
					}
					
					showPreloader();
					$.ajax({
						url: base_url + _action,
						data: formData,
						type:'post',
						success: function(response){
							
							var resp = jQuery.parseJSON( response );

							if(resp.status == 'success') {
								if ( resp.rowid || ($('#is_reserve').val() && !resp.rowid) )
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
				
		// reserve form for none globe
		$('#reserve-08 button').click(function(){
			var s =	$('form#reserve-form div.status');
		   	var formData = $('form#reserve-form').serialize();
		   	
		   	s.show();
		    s.html('Sending...Please wait...');

		   	// call reserve item action
		   	$.ajax({
		   		url  : 'cart/reserveitem',
		   		data : formData,
		   		type : 'post',
		   		success : function(response){
		   			resp = jQuery.parseJSON(response);
		   			if (resp.status == 'success') {
		   				s.hide();
		   				// show popup
		   				$('#reserve-08').modal('hide');
		   				$('#04-thank-you').modal( {show:true} );
		   				setTimeout('$("#04-thank-you").modal( {show:true} )', 5000);
		   				window.location.href = base_url+resp.nxt_page;
		   			} else {
		   				s.addClass('alert-'+resp.status);
						s.html(resp.msg);
		   			}
		   		},
		   		error : function(response){
		   			alert('Some error occured or the system is busy. Please try again later');
		   		} 
		   	});

		   // window.location.href = base_url+'home?showtymsg=true';
		});


		$('a#link_non_globe_reserve').click(function(){
			$('#enterMobile').modal('hide');
			$('#reserve-08').modal('show').css(
				{
					'margin-left': function () {
					return window.pageXOffset-($(this).width() / 2 );
				}
			});
			$('.consultation-radio input').iCheck({
				radioClass: 'iradio_flat-blue'
			});
		});

		// for new line - non globe subscriber jez
		$("#link_non_globe").click(function(){
			$('#enterMobile').modal('hide')
			$( '#selectBuyType' ).modal( {show:true} );

			$("#new_line_plan").click(function(){
				window.location = base_url+"plan?setOrderConfig=true&key=ordertype&val=newline&subscriber_flag=false"
			});

			$("#new_line_prepaid_kit").click(function(){
				window.location = base_url+"payment"
			});
			
		});
				
			

