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
				
			// for new line - non globe subscriber jez
		$("#link_non_globe").click(function(){
			$('#enterMobile').modal('hide')
			$( '#selectBuyType' ).modal( {show:true} );

			$("#new_line_plan").click(function(){
				window.location = base_url+"plan?setOrderConfig=true&key=ordertype&val=newline&subscriber_flag=false"
			});

			$("#new_line_prepaid_kit").click(function(){
				window.location = base_url+"payment"
				/*var itemid    = $(this).find("a").attr('data-id');
				var itemname    = $(this).find("a").attr('data-name');
				var plan_pv    = $(this).find("a").attr('data-pv');

				$.ajax({
					url: base_url+'cart/addtocart',
					data: 'product_type=gadget&product_id=1',
					type:'post',
					success: function(response) {
						//alert(response);
						//window.location = "/estate/payment";
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
				});*/
			});
			
		});
				
			

