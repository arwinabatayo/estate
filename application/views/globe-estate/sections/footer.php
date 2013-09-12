    
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
									if(resp.status == 'success'){
										window.location = base_url+'plan?token='+resp.token;
									}
								}, 
								error: function(){
									s.html('Some error occured or the system is busy. Please try again later');	
								}
							});
								
					});
					
		    <?php } ?>
	
		<?php } else if($page == 'landing' ){ ?>
				
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
				$( "#plantype-plans" ).slideDown();
				$( this ).closest('div').slideUp();
				
			});
			
		
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
								
								//var resp = jQuery.parseJSON( response );
								
								//alert ( JSON.stringify(response) );
								alert ( response );
								return;
								
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

				// Combos And Boosters
				$(document).on('click', '.cartWidget a.btnDeleteCombos', function(){
						var rowid = $(this).attr('id');
						var prodName = $(this).attr('rel');
						
						var selectedPlanCashOut = $(".btnAddCombo").attr("data-cashout");
						var comboID = $(this).attr("data-id");
						var comboNAME = $(this).attr("data-name");
						var comboPV = $(this).attr("data-pv");
						var planPV = $(this).attr("data-planpv");
						
						if( !confirm('Are you sure you want to delete "'+prodName+'"?')) return;
						
						$.ajax({
							url: base_url+'cart/update_qty_of_cart',
							data: 'product_type=combos&product_id='+comboID+'&current_cashout='+selectedPlanCashOut+'&planpv='+planPV+'&combopv='+comboPV,
							type:'post',
							success: function(response){
								alert(response);
								var resp = jQuery.parseJSON( response );
			
								if(resp.status == 'success'){
									if(resp.qty == 0) {
										$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
										$('.cashoutLabel').html(resp.total);
									} else {
										$('#prod-qty-'+resp.rowid).html("<b>x"+resp.qty+"</b>");
										$('#prod-item-'+resp.rowid).show('slow');
									}
								}else{
									alert(resp.msg);
								}
							}, 
							error: function(){
								alert('Some error occured or the system is busy. Please try again later');	
							}
						});
						
				});
				
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


							var cartItem = '<div id="prod-item-'+resp.rowid+'" class="item" style="display:none">'+
							'<div class="fleft"><span class="productName block"><b>'+itemname+
							'</b></span></div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'">'+
							'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
						
							if(resp.status == 'success' && resp.rowid){
								$("#PlanCartWidget .item").remove();
								$("#PlanCartWidget").prepend(cartItem);
								$('#prod-item-'+resp.rowid).show('slow');

								var cashout = resp.gadget_cash_out; 
								if(cashout == 0) {
									// No CashOut
									$("#cashoutLabel").html("").show('slow');
								} else {
									$("#cashoutLabel").html("Php "+cashout).show('slow');
								}
								$("#pesovalLabel").attr('data-pv',plan_pv).html(plan_pv).show('slow');
								
								$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
									$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
								});
								$("#plan_name").html(itemname);
								$("#planid").attr('data-id',itemid);
								$("#planid").attr('data-cashout',cashout);
								$('#prod-item-'+resp.rowid).show('slow');
							}
							
							
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});
				});
				
				$("#goCombos").click(function(e) {
					e.preventDefault();
					//var selectedPlanId = $(".btnAddCombo").attr("data-id");
					var selectedPlanCashOut = $(".btnAddCombo").attr("data-cashout");
					//var planPV = $(".btnAddCombo").attr("data-pv");
					
					
					$( "#plantype-options" ).slideUp();
					$( "#plantype-combos" ).slideDown();


					$('a.btnAddCombo').click(function(e){
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
	 							alert(response);
// 								var updCashOut = resp['pvcashout'].upd_cashout;
// 								var updPlanPV = resp['pvcashout'].upd_planpv;

// 								$("#pesovalLabel").attr('data-pv',updPlanPV).html(updPlanPV).show('slow');
// 								$("#cashoutLabel").html("Php "+updCashOut).show('slow');
// 								$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
// 									$('#cashoutBox,#pesovalBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
// 								});

	 							var cartItem = '<div id="prod-item-'+resp.rowid+'" class="item" style="display:none">'+
								'<div class="fleft">'+
									'<span class="productName block">'+comboNAME+'</span>'+
									'<span class="productName block" id="prod-qty-'+resp.rowid+'" style="margin-left:15px;"  data-id="'+resp.product_id+'" data-name="'+resp.name+'" data-pv="'+resp.pv+'" data-cashout="" data-planpv="" >'+
										
									'</span>'+
								'</div>'+
								'<span class="icoDelete">'+
								'<a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'" >'+
								'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
							
								if(resp.status == 'success' && resp.rowid){
									if( resp.product_type == 'combos'){
										
										$("#CombosCartWidget").append(cartItem);
									} else {
									    basket.append(resp.name);
									}
									$('#prod-qty-'+resp.rowid).html("<b>x"+resp.qty+"</b>");
									$('#prod-item-'+resp.rowid).show('slow');
								}
	 						}, 
	 						error: function(){
	 							alert('Some error occured or the system is busy. Please try again later');	
	 						}
	 					});
						
					});
// 					alert($("#planid").attr("value"));
// 					$.ajax({
// 						url: base_url+'cart/addtocart',
// 						data: 'product_type=plan&product_id='+itemid,
// 						type:'post',
// 						success: function(response){
							
// 							var resp = jQuery.parseJSON( response );
							
// 							if(resp.status == 'success' && resp.id){

// 								if( resp.product_type == 'plan'){
// 									$("#plan_name").html(resp.name);
// 								}else{
// 								    basket.append(resp.name);
// 								}
								
// 								$('#prod-item-'+resp.id).show('slow');
// 							}
// 						}, 
// 						error: function(){
// 							alert('Some error occured or the system is busy. Please try again later');	
// 						}
// 					});
				});
// 				$("a.btnAddCombo").click(function(e){
// 					e.preventDefault();

// 					var comboid = $(this).attr('data-id');
// // 					var comboname = $(this).attr('data-name'); 

// 					$.ajax({
// 						url: base_url+'cart/addtocart',
// 						data: 'product_type=combos&product_id='+comboid,
// 						type:'post',
// 						success: function(response){
						
// 							var resp = jQuery.parseJSON( response );
							
// 							var cartItem = '<div id="prod-item-'+resp.rowid+'" class="item" style="display:none">'+
// 								'<div class="fleft"><span class="productName block">'+resp.name+
// 								'</span><span class="price block arial italic">'+resp.rowid+
// 								'</span></div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'">'+
// 								'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
							
// 							if(resp.status == 'success' && resp.rowid){

// 								if( resp.product_type == 'combos'){
// 									$("#CombosCartWidget").append(cartItem);
// 								}else{
// 								    basket.append(resp.name);
// 								}
							
// 								$('#prod-item-'+resp.rowid).show('slow');
// 							}
// 						}, 
// 						error: function(){
// 							alert('Some error occured or the system is busy. Please try again later');	
// 						}
// 					});
					
// // 					var cartItem = '<div id="prod-item-'+comboid+'" class="item" style="display:none">'+
// // 						'<div class="fleft"><span class="productName block">'+comboname+
// // 						'</span><span class="price block arial italic">'+comboid+
// // 						'</span></div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+comboid+'">'+
// // 						'<i class="icon-remove"></i></a> </span><br class="clear" /></div>\n';
						
					
// 				});

				
				$("#goBoosters").click(function(e) {
					e.preventDefault();
					var selectedPlanId = $("#planid").attr("value");
// 					var selectedPlanId = $("#planid").attr("value");
					$( "#plantype-combos" ).slideUp();
					$( "#plantype-boosters" ).slideDown();
					
// 					alert($("#planid").attr("value"));
// 					$.ajax({
// 						url: base_url+'cart/addtocart',
// 						data: 'product_type=plan&product_id='+itemid,
// 						type:'post',
// 						success: function(response){
							
// 							var resp = jQuery.parseJSON( response );
							
// 							if(resp.status == 'success' && resp.id){

// 								if( resp.product_type == 'plan'){
// 									$("#plan_name").html(resp.name);
// 								}else{
// 								    basket.append(resp.name);
// 								}
								
// 								$('#prod-item-'+resp.id).show('slow');
// 							}
// 						}, 
// 						error: function(){
// 							alert('Some error occured or the system is busy. Please try again later');	
// 						}
// 					});
				});
	});
</script>
