
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
	
	$(function () {
		<?php //Do not move. Must be initialize above.  ?>
		$(".jq-accordion").accordion({
			header: "h3",
			navigation: true, 
			heightStyle: "content",
			//event: false,
			icons: { header: "ui-icon-circle-plus", activeHeader: "ui-icon-circle-minus"}, 
		});
		
		<?php 
		if($page == 'landing' ){
				
			//---LANDING PAGE
			include('pages/partials/ftscript_landing.php');
						
		} else if($page == 'home'){ 
			

			//---SKU-CONFIGURATION
			include('pages/partials/ftscript_home.php');
			
			///---SKU-CONFIGURATION > SMS VERIFICATION
			if($current_method == 'sms_verification'){ 
				
				include('pages/partials/ftscript_smsverification.php');
			
				if( $this->session->userdata('showcaptcha') ){
					echo '$(window).load( function(){ createCaptcha() });'."\n";
				}	
			 } 
		} 
		 
		if($current_controller == 'plan' ){ 
			
			//---PLAN PAGE
			include('pages/partials/ftscript_plan.php'); 
			
			//---PLAN PAGE > ULTIMA ADDTOCART(plan, combos & boosters) - ROBERT
			include('pages/partials/ftscript_plan_ultima.php'); 
		
		} else if($current_controller == 'addons' ){

			//---ADDONS PAGE
			include('pages/partials/ftscript_addons.php'); 	
		
		} else if($current_controller == 'subscriber' ){ 
			
			//---SUBSCRIBER INFO PAGE
			include('pages/partials/ftscript_subscriber.php'); 	
			
<<<<<<< HEAD
		} else if($current_controller == 'payment' ){ 
=======
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
				
				$("#combo-type").hide();


				$(this).parent().parent().parent().children("div.header").children("div.price-wrapper").children("h4").each(function(){
		        	if($(this).text() == "Package Plan"){
				        //$("#acc-order-type .option-wrapper").slideUp();

				        //$("#order-type-section").show('slow');

				        //$("#plantype-options").show();


				        $("a.btnAddPlan").parent().parent().hide();

				        $("#goCombos").parent().hide();
				        $("#goPackagePlanCombos").parent().show();

				        $("a.btnAddPackagePlan:eq(0)").parent().parent().hide();

				        $("#cashoutBox").show();

				        $( "#siderbar-panel" ).accordion( "option", "active", 2 );

				        // showing only package plan in sidebar panel
				        $( "#siderbar-panel h3.ui-state-active" ).parent().children().not("h3").children().not("div#package-plan-items").hide()
				        $("div#package-plan-items").show();


				        $("#goPackagePlanCombos").click(function(){
				        	window.location.href = base_url+"addons"
				        })
				    }

		        });


			});
			//toggle button
			$('.btn-show-plantype').click(function() {
				$( "#plantype-table" ).slideDown();
				$("#PackagePlanCartWidget").slideUp();
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
			$("a.btnAddPackagePlan").parent().parent().each(function(){
				$(this).click(function(i){
					var that = $(this);
					$.ajax({
						url: base_url+'plan/getpackageplancombos',
						data: {'plan_id' : parseInt($(this).children("div.my-plan-id").text()) },
						type:'post',
						success: function(response){

							var resp = jQuery.parseJSON( response );
							//console.log(resp)
							for(var ctr = 0; ctr < resp.length; ctr++){
								//console.log(resp[ctr]['combo_type']);
								var combo_type = resp[ctr]['category'].toLowerCase();
								
								$("#combo-type-" + combo_type + "-desc").text(resp[ctr]['description']);
								$("#combo-type-" + combo_type).css('display', 'block')

							}

							$("#combo-type").show();

							var plan_payment = that.find("a").text().split("Plan ")[1];

							

							$("#PackagePlanCartWidget").html("<br /><p><b>Plan:</b> " + plan_payment + "</p><p><b>Monthly Payment:</b> " + plan_payment + "</p><p><b>Text:</b> " + $("#combo-type-text-desc").text() + "</p><p><b>Call:</b> " + $("#combo-type-call-desc").text() + "</p><p><b>Surf:</b> " + $("#combo-type-surf-desc").text() + "</p><p><b>IDD:</b> " + $("#combo-type-idd-desc").text() + "</p>");
							$("#PackagePlanCartWidget").slideDown();

							
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});

					/*$.ajax({
						url: base_url+'plan/getpackageplangadgetcashout',
						data: {'plan_id' : parseInt($(this).children("div.my-plan-id").text()) },
						type:'post',
						success: function(response){

							var resp = jQuery.parseJSON( response );
							
							//$(".cashoutLabel").text(resp[0]['cashout_val'])

							

							
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});*/




					//add to cart functionality for additional and new line

					var itemid    = $(this).find("a").attr('data-id');
					var itemname    = $(this).find("a").attr('data-name');
					var plan_pv    = $(this).find("a").attr('data-pv');
					
					//alert(itemid + " " + itemname + " " + plan_pv);
					
					$.ajax({
						url: base_url+'cart/addtocart',
						data: 'product_type=package_plan&product_id='+itemid+'&plan='+itemid+'&device=1',
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

					// end of add to cart functionality
				});
			});

			//jez
			if($("#order-type-new-line-section").length != 0){
				$("input[name=new-line-non-globe-option]").each(function(){
					$(this).click(function(){
						
						showPreloader();

						
							if(parseInt($(this).val()) == 1){
								$("#order-type-new-line-section-footer").slideDown();
								$( "#plan-order-page" ).accordion( "option", "active", 0 );
							}else if(parseInt($(this).val()) == 2){
								$("#order-type-new-line-section-footer").slideUp();
								$( "#plan-order-page" ).accordion( "option", "active", 1 );
							}
						

						closePreloader();
					});
				});


				$("#new-line-continue").click(function(){
		    	
			    	//$( '#dialog_enter_mobile' ).dialog( "close" );
			    	$.ajax({
						url: base_url+'plan/sendEmail',
						data: {'email' : "xerenader@gmail.com" },
						type:'post',
						success: function(response){
							
							$( '#dialog_enter_mobile' ).dialog( "open" );
							//$( "#plan-order-page" ).accordion( "option", "active", 1 );
							//$( "#siderbar-panel" ).accordion( "option", "active", 2 );
						}, 
						error: function(){
							alert('Some error occured or the system is busy. Please try again later');	
						}
					});


			    	//$( "#plan-order-page" ).accordion( "option", "active", 1 );
			        //$( "#siderbar-panel" ).accordion( "option", "active", 2 );

			        //$("#plantype-options").show();
			        $("a.btnAddPackagePlan").parent().parent().show();
			    }); 

			}

			$('a#get-prepaid-kit').click(function(){
				// show bubble info where add to cart link is present
				$('#tooltip-prepaid-kit').dialog("open");
			});
		
		<?php } else if($current_controller == 'addons' ){ ?>
			  
			    $( "#siderbar-panel" ).accordion( "option", "active", <?php echo $accordionIndex ?> );
			
		<?php } else if($current_controller == 'subscriber' ){ ?>
			  
			  $( "#siderbar-panel" ).accordion( "option", "active", 3 );
			  
			  /*$( "#personal-info-page" ).accordion({
				  event: false
			  });*/
>>>>>>> b6f91d942c7c361d8306c61253bdd6a72157c014
			
			//---PAYMENT PAGE - shopping cart summary, Delivery Option, Confirm Order, Payment Method
			include('pages/partials/ftscript_payment.php'); 	
		
		} else if ($current_controller == 'order') {  
			
			//---ORDER PAGE
			include('pages/partials/ftscript_order.php'); 	
		
		} 
		
		//---COMMON SCRIPT
		include('pages/partials/ftscript_commons.php'); 
		

		?>
	
	});
	
		</script>
