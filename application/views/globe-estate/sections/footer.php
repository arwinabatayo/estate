
    <footer>
		<div id="footer-box" class="row">
			<br />
			<div id="footer-menu" class="span10 divcenter">
				<?php include('pages/partials/footer_nav.php'); ?>
			</div>
		</div>
    </footer>
   
    
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $assets_url?>site/js/jquery-1.9.0.min.js" type="text/javascript"></script>
<script src="<?php echo $assets_url?>site/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $assets_url?>site/js/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $assets_url?>site/js/google-code-prettify/prettify.js" type="text/javascript"></script>
<script src="<?php echo $assets_url?>site/js/acc-wizard.min.js" type="text/javascript"></script>
<script src="<?php echo $assets_url?>site/js/defines.js" type="text/javascript"></script>

<script type="text/javascript">
	
	//alert('<?php echo $current_controller ?>');
	
	$(function () {

		$(".jq-accordion").accordion({
			header: "h3",
			navigation: true, 
			heightStyle: "content",
			//event: false,
			icons: { header: "ui-icon-circle-plus", activeHeader: "ui-icon-circle-minus"}, 
		});
		
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
		
		<?php if($page == 'home'){ ?>
		
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
					var email =	$('input#email').val();

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
				
	    <?php if($current_method == 'sms_verification'){ ?>
		    
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
					
					<?php if( $this->session->userdata('showcaptcha') ){ ?>
			        
			         function createCaptcha(){
							$.ajax({
							    dataType: 'json',
								url: base_url+'captcha/get_captcha_img',
							    success: function(response){
									//var resp = jQuery.parseJSON( response );
									//alert (  response.src );

									$("#captcha").attr('src',response.src);
									
								},
								error: function(xhr, status, error){
										alert(xhr.responseText);
								}	
							});
					 }
					 
					
					$('a#refresh_code').click( function(e){
						e.preventDefault();
						createCaptcha() ;
					});	
					
					$(window).load( function(){ createCaptcha() });
					
					<?php } ?>
					
					$('button#btn_resend_vcode').click( function(e){
						 var code =	$('input#code_id').val();
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
					
					
					
		    <?php } ?>
	
		<?php } else if($page == 'landing' ){ ?>
				
				$('#dialog_thankyou_reserve').dialog({
					autoOpen: true,
					buttons: [{
						text: "OK",
						click: function() {
							   $( this ).dialog( "close" );
						}
					}]
				});
								
				$('form#addGadget button').click(function(){
						var itemid    = $(this).find('input[name=product-id]').val();
						var formData  = $('form#addGadget').serialize();
						$.ajax({
							url: base_url+'cart/addtocart',
							data: formData,
							type:'post',
							success: function(response){
								
								var resp = jQuery.parseJSON( response );
								
								if(resp.status == 'success' && resp.rowid){
									window.location = '<?php echo base_url() ?>sku-configuration';
								}
								
							}, 
							error: function(){
								alert('Some error occured or the system is busy. Please try again later');	
							}
						});
				});
		
		<?php } else if($current_controller == 'plan' ){ ?>
		
			//ORDER TYPE
		    $('#acc-order-type  button').click(function() { 
	            //showPreloader();
		        //create ajax call here - add to cart order type
		        /*$( "#plan-order-page" ).accordion( "option", "active", 1 );
		        $( "#siderbar-panel" ).accordion( "option", "active", 2 );*/

		        $("#acc-order-type .option-wrapper").hide('slow');

		        $("#order-type-section").show('slow');

		    });

		    //click continue button in get additional line
		    $("#additional-line-continue").click(function(){
		    	$( '#dialog_enter_mobile' ).dialog( "open" );
		    	//$( '#dialog_enter_mobile' ).dialog( "close" );

		    	$( "#plan-order-page" ).accordion( "option", "active", 1 );
		        $( "#siderbar-panel" ).accordion( "option", "active", 2 );
		    }); 
		    
		    //PLAN TYPE
		    $( "#plantype-options" ).hide();
			$( "#plantype-combos" ).hide(); // Robert
		    
		    $('#plantype-table  button').click(function() {
				var title = $(this).attr('rel');
				
				var id = $(this).attr('id'); // Robert
				if(id == 3) {// Robert
					$( "#siderbar-panel" ).accordion( "option", "active", 2 );// Robert
				}// Robert
				
				var btnIndex = $('#plantype-table  button').index(this);
	
				showPreloader();
				
				setTimeout(function(){ //simulate ajax request
					$( "#plantype-table" ).slideUp();
					
					if(btnIndex > 0){
						$( "#plantype-options h4" ).html(title);
						$( ".ui-accordion h3:eq(2) a" ).html(title);
						$( "#plantype-options" ).slideDown();
					}else{
						$( "#retain-plan" ).slideDown();
						$( ".ui-accordion h3:eq(2) a" ).html('Retain Current Plan - 3799');
					}
					closePreloader();
				},500)
				
			});
			//toggle button
			$('.btn-show-plantype').click(function() {
				$( "#plantype-table" ).slideDown();
				$( this ).closest('div').slideUp();
				
			});
			$('.btn-show-plans').click(function() {
				$( "#plantype-options" ).slideDown();
				$( this ).closest('div').slideUp();
				
			});
			$('.btn-show-plancombos').click(function() {
				$( "#plantype-combos" ).slideDown();
				$( this ).closest('div').slideUp();
				
			});
			// jez
			$("a.btnAddPlan").parent().parent().each(function(){
				$(this).click(function(){
					$.ajax({
						url: base_url+'plan/getpackageplancombos',
						data: {'plan_id' : parseInt($(this).children("div.my-plan-id").text()) },
						type:'post',
						success: function(response){

							var resp = jQuery.parseJSON( response );
							console.log(resp);

							for(var ctr = 0; ctr < resp.length; ctr++){
								//console.log(resp[ctr]['combo_type']);
								var combo_type = resp[ctr]['combo_type'].toLowerCase();
								
								$("#combo-type-" + combo_type + "-desc").text(resp[ctr]['combo_desc']);
								$("#combo-type-" + combo_type).css('display', 'block')

							}

							$("#combo-type").show();

							
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});

					$.ajax({
						url: base_url+'plan/getpackageplangadgetcashout',
						data: {'plan_id' : parseInt($(this).children("div.my-plan-id").text()) },
						type:'post',
						success: function(response){

							var resp = jQuery.parseJSON( response );
							
							$(".cashoutLabel").text(resp[0]['cashout_val'])

							

							
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});
			
				});
			})



		
		<?php } else if($current_controller == 'addons' ){ ?>
			  
			    $( "#siderbar-panel" ).accordion( "option", "active", <?php echo $accordionIndex ?> );
			
		<?php } else if($current_controller == 'subscriber' ){ ?>
			  
			  $( "#siderbar-panel" ).accordion( "option", "active", 3 );
			  
			  /*$( "#personal-info-page" ).accordion({
				  event: false
			  });*/
			
			  $('form#personal-info button').click(function() {
					if ( $("input[name='sns_id']:checked").val() == 'facebook' ) {
				       $( '#confim_onbehalf' ).dialog( "open" );
				    }else{
						
						$( "#personal-info-page" ).accordion( "option", "active", 1 );
					}
			  });
				
				$('#confim_onbehalf').dialog({
					autoOpen: false,
					dialogClass: "no-close",
					buttons: {
						"Yes" : function() {
							   $( this ).dialog( "close" );
							  $( "#personal-info-page" ).accordion({
								  active: 1
								  });
						},
						"No" : function() {
							   $( this ).dialog( "close" );
							  $( "#personal-info-page" ).accordion({
								  active: 1
							  });
						}
					}
				});
		<?php } else if($current_controller == 'payment' ){ ?>
					//$( "#personal-info-page" ).accordion({active: 1});
					
				    $('#personal-info-page  button.goNext').click(function() {
						var btnIndex = $('#personal-info-page  button').index(this);
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
							$("#delivery_ship").slideUp();
							$("#delivery_pickup").slideDown();
						}else{
							$("#delivery_ship").slideDown();
							$("#delivery_pickup").slideUp();
							$("#delivery_ship").slideDown();
						}else{
							$("#delivery_pickup").slideDown();
							$("#delivery_ship").slideUp();
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
			
		<?php }  ?>
		
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
				
		
				//$('.cartWidget a.btnDelete, #cartSummaryTable a.btnDelete').on('click', function(){
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

				// delete/deduct combo qty -- robert
				$(document).on('click', '.cartWidget a.btnDeleteCombos, .cartWidget a.btnDeleteBoosters', function(){
						var rowid = $(this).attr('id');
						var prodName = $(this).attr('rel');
						
						var selectedPlanCashOut = $(".btnAddCombo").attr("data-cashout");
						var comboID = $(this).attr("data-id");
						var comboNAME = $(this).attr("data-name");
						var comboPV = $(this).attr("data-pv");
						var planPV = $(this).attr("data-planpv");
						var amount = $(this).attr("data-amount");
						var product_type = $(this).attr("data-product-type");
						
						if( !confirm('Are you sure you want to delete "'+prodName+'"?')) return;
						
						$.ajax({
							url: base_url+'cart/update_qty_of_cart',
							data: 'keyid='+rowid+'&product_type='+product_type+'&product_id='+comboID+'&current_cashout='+selectedPlanCashOut+'&planpv='+planPV+'&combopv='+comboPV,
							type:'post',
							success: function(response){
								var resp = jQuery.parseJSON( response );
								if(product_type == "boosters") {
									if(resp.qty <= 0) {
										$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
										$('#prod-item-'+rowid).remove();
										
									}
								} else {
									if(resp.combos_qty <= 0) {
										$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
										$('#prod-item-'+rowid).remove();
										
									} else {
										$('#prod-qty-'+resp.rowid).html("<b>x"+resp.combos_qty+"</b>");
										$('#prod-item-'+resp.rowid).show('slow');
									}
								}

								$("#cashoutLabel").html(resp.total).show('slow');
								$("#pesovalLabel").attr('data-pv',resp.total_remaining_pv).html(resp.total_remaining_pv).show('slow');
								
								$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
									$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
								});
							}, 
							error: function(){
								alert('Some error occured or the system is busy. Please try again later');	
							}
						});
				});

				// add plan --robert
				$('a.btnAddPlan').click(function(e){
					e.preventDefault();
					
					var itemid    = $(this).attr('data-id');
					var itemname    = $(this).attr('data-name');
					var plan_pv    = $(this).attr('data-pv');
					
					
					$.ajax({
						url: base_url+'cart/addtocart',
						data: 'product_type=plan&product_id='+itemid+'&plan='+itemid+'&device=7',
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
				});

				// go next for combos --robert
				$("#goCombos").click(function(e) {
					e.preventDefault();
					//var selectedPlanId = $(".btnAddCombo").attr("data-id");
					var selectedPlanCashOut = $(".btnAddCombo").attr("data-cashout");
					//var planPV = $(".btnAddCombo").attr("data-pv");
					
					$( "#plantype-options" ).slideUp();
					$( "#plantype-combos" ).slideDown();

					$('a.btnAddCombo').click(function(e) {
						e.preventDefault();
						var comboID = $(this).attr("data-id");
						var comboNAME = $(this).attr("data-name");
						var comboPV = $(this).attr("data-pv");
						var planPV = $(this).attr("data-planpv");

						$.ajax({
	 						url: base_url+'cart/addtocart',
	 						data: 'product_type=combos&product_id='+comboID+'&current_cashout='+selectedPlanCashOut+'&planpv='+planPV+'&combopv='+comboPV,
	 						type:'post',
	 						success: function(response){
	 							var resp = jQuery.parseJSON( response );
	 							
								if(resp.status == 'success' && resp.rowid){
									if( resp.product_type == 'combos'){
										$("#CombosCartWidget #prod-item-"+resp.rowid).remove();
										$("#CombosCartWidget").append('<div id="prod-item-'+resp.rowid+'" class="item" style="display:none">'+
												'<div class="fleft">'+
												'<span class="productName block">'+comboNAME+'</span>'+
												'<span class="productName block" id="prod-qty-'+resp.rowid+'" style="margin-left:15px;"  data-id="'+resp.product_id+'" data-name="'+resp.name+'" data-pv="'+resp.this_pv_value+'" data-cashout="" data-planpv="" >'+
													
												'</span>'+
											'</div>'+
											'<span class="icoDelete">'+
											'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp.product_id+'" data-name="'+resp.name+'" data-pv="'+resp.this_pv_value+'" data-cashout="" data-planpv=""  id="'+resp.rowid+'" rel="'+resp.name+'">'+
											'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n');
									} else {
									    basket.append(resp.name);
									}

									$("#cashoutLabel").html(resp.total).show('slow');
									$("#pesovalLabel").attr('data-pv',resp.total_remaining_pv).html(resp.total_remaining_pv).show('slow');
									
									$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
										$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
									});
									$('#prod-qty-'+resp.rowid).html("<b>x"+resp.combo_qty+"</b>");
									$('#prod-item-'+resp.rowid).show('slow');
								} else if(resp.status == 'coexist') {
									var confirmCoexist = confirm("You are already subscribed to "+resp.product_name+". Do you wish to continue?");

									if(confirmCoexist == true) {
										
										$.ajax({
											url: base_url+'cart/addtocart',
											data: 'tag=replace_cart_item&product_type=combos&product_id='+comboID+'&current_cashout='+selectedPlanCashOut+'&planpv='+planPV+'&combopv='+comboPV+'&remove_keyid='+resp.rowid+'&remove_product_id='+resp.product_id,
											type:'post',
											success: function(response) {
												
												var resp2 = jQuery.parseJSON( response );
												var cartItem = '<div id="prod-item-'+resp2.rowid+'" class="item" style="display:none">'+
												'<div class="fleft">'+
													'<span class="productName block">'+comboNAME+'</span>'+
													'<span class="productName block" id="prod-qty-'+resp2.rowid+'" style="margin-left:15px;"  data-id="'+resp2.product_id+'" data-name="'+resp2.name+'" data-pv="'+resp2.pv+'" data-cashout="" data-planpv="" >'+
														
													'</span>'+
												'</div>'+
												'<span class="icoDelete">'+
												'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp2.product_id+'" data-name="'+resp2.name+'" data-pv="'+resp2.pv+'" data-cashout="" data-planpv=""  id="'+resp2.rowid+'" rel="'+resp2.name+'">'+
												'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
											
												if(resp2.status == 'success' && resp2.rowid){
													$('#prod-item-'+resp.rowid).remove();
													if( resp2.product_type == 'combos'){
														$("#CombosCartWidget").append(cartItem);
													} else {
													    basket.append(resp2.name);
													}

													$("#cashoutLabel").html(resp2.total).show('slow');
													$("#pesovalLabel").attr('data-pv',resp2.total_remaining_pv).html(resp2.total_remaining_pv).show('slow');
													
													$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
														$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
													});
													$('#prod-qty-'+resp2.rowid).html("<b>x"+resp2.qty+"</b>");
													$('#prod-item-'+resp2.rowid).show('slow');
													
												}

											}, 
											error: function(){
												alert('Some error occured or the system is busy. Please try again later');	
											}
										});
									}
								}
	 						}, 
	 						error: function(){
	 							alert('Some error occured or the system is busy. Please try again later');	
	 						}
	 					});
					});
				});

				// go next for boosters --robert
				$("#goBoosters").click(function(e) {
					e.preventDefault();
					var selectedPlanCashOut = $(".btnAddBooster").attr("data-cashout");
					
					$( "#plantype-combos" ).slideUp();
					$( "#plantype-boosters" ).slideDown();

					$('a.btnAddBooster').click(function(e) {
						e.preventDefault();
						
						var id = $(this).attr("data-id");
						var name = $(this).attr("data-name");
						var amount = $(this).attr("data-amount");

						$.ajax({
	 						url: base_url+'cart/addtocart',
	 						data: 'product_type=boosters&product_id='+id+'&current_cashout='+selectedPlanCashOut+'&amount='+amount,
	 						type:'post',
	 						success: function(response){
	 							var resp = jQuery.parseJSON( response );
	 							
								if(resp.status == 'success' && resp.rowid) {
									$("#BoostersCartWidget #prod-item-"+resp.rowid).remove();
									$("#BoostersCartWidget").append('<div id="prod-item-'+resp.rowid+'" class="item" style="display:none">'+
											'<div class="fleft">'+
											'<span class="productName block" style="max-width:199px;">'+resp.name+'</span>'+
											'</span>'+
										'</div>'+
										'<span class="icoDelete">'+
										'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp.product_id+'" data-name="'+resp.name+'" data-pv="'+resp.this_pv_value+'" data-cashout="" data-planpv=""  id="'+resp.rowid+'" rel="'+resp.name+'">'+
										'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n');
									
									$("#cashoutLabel").html(resp.total).show('slow');
									$("#pesovalLabel").attr('data-pv',resp.total_remaining_pv).html(resp.total_remaining_pv).show('slow');
									
									$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
										$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
									});
									$('#prod-qty-'+resp.rowid).html("<b>x"+resp.combo_qty+"</b>");
									$('#prod-item-'+resp.rowid).show('slow');
								} else if(resp.status == 'coexist') {
									var confirmCoexist = confirm("You are already subscribed to "+resp.product_name+". Do you wish to continue?");
									if(confirmCoexist == true) {
										$.ajax({
											url: base_url+'cart/addtocart',
											data: 'tag=replace_cart_item&product_type=boosters&product_id='+id+'&remove_keyid='+resp.rowid+'&remove_product_id='+resp.product_id,
											type:'post',
											success: function(response) {
												
												var resp2 = jQuery.parseJSON( response );
												
												var cartItem = '<div id="prod-item-'+resp2.rowid+'" class="item" style="display:none">'+
												'<div class="fleft">'+
													'<span class="productName block" style="max-width:199px;">'+name+'</span>'+
													'</span>'+
												'</div>'+
												'<span class="icoDelete">'+
												'<a href="javascript:void(0)" class="btnDeleteCombos" data-id="'+resp2.product_id+'" data-name="'+resp2.name+'" data-pv="'+resp2.pv+'" data-cashout="" data-planpv=""  id="'+resp2.rowid+'" rel="'+resp2.name+'">'+
												'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
											
												if(resp2.status == 'success' && resp2.rowid){
													$('#prod-item-'+resp.rowid).remove();
													$("#BoostersCartWidget").append(cartItem);
													
													$("#cashoutLabel").html(resp2.total).show('slow');
													$("#pesovalLabel").attr('data-pv',resp2.total_remaining_pv).html(resp2.total_remaining_pv).show('slow');
													
													$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
														$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
													});
													$('#prod-qty-'+resp2.rowid).html("<b>x"+resp2.qty+"</b>");
													$('#prod-item-'+resp2.rowid).show('slow');
												}

											}, 
											error: function(){
												alert('Some error occured or the system is busy. Please try again later');	
											}
										});
									}
								}
	 						}, 
	 						error: function(){
	 							alert('Some error occured or the system is busy. Please try again later');	
	 						}
	 					});
						
					});
				});
				// set dialog for resume uncomp transaction - gellie
				$('a#open_resume_uncomp_transaction').on('click', function(){
					$( '#dialog_application_status' ).dialog( "close" );
					$( '#dialog_resume_uncomp_transaction' ).dialog( "open" );
				});
				
				// validate reference number - gellie
				$('form#resume-uncomp-transaction button').on('click', function(){
			
						var s =	$('form#resume-uncomp-transaction div.status');
						var email = $('input#email').val();
						var cap = $('input#captcha-input').val();
			
						var s =	$('form#refnum-verification div.status');
						var refnum = $('input#reference_number').val();
						// reset error class
						s.removeClass('alert-error');
						//e.preventDefault();
						
						s.show();
					    s.html('Sending...Please wait...');
					    
					    // may problem pa sa cache
					    //$(this).attr('disabled',true);

						$.ajax({
							url: base_url+'home/send_saved_transaction',
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
	});
</script>
