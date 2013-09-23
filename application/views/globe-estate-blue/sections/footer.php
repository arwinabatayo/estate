

<div class="row-fluid footer">
	<div class="container">
		<?php include('pages/partials/footer_nav.php'); ?>
	</div>
</div>

<?php 
	//MODALS INCLUDE FILE
	if($page == 'landing' ){
		
		include('pages/partials/modal_landing.php');
		
	} else if($page == 'home'){ 
		
		include('pages/partials/modal_sku_config.php');
	}
	
	include('pages/partials/modal_commons.php');

?>   
    
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $assets_url?>site-blue/js/jquery.js"></script>    
<script src="<?php echo $assets_url?>site-blue/js/bootstrap.js"></script>


   
<!--<script src="<?php echo $assets_url?>site/js/defines.js" type="text/javascript"></script>-->
    
<script type="text/javascript">
	
    $(function () {
	
		<?php //Do not move. Must be initialize above.  ?>
		/*$(".jq-accordion").accordion({
			header: "h3",
			navigation: true, 
			heightStyle: "content",
			//event: false,
			icons: { header: "ui-icon-circle-plus", activeHeader: "ui-icon-circle-minus"}, 
		});*/
		
		//$('#emailConfirm').modal('show');	
		//$('#emailConfirm').modal( {show:true} );
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
		
		/*
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
			
		} else if($current_controller == 'payment' ){ 
			
			//---PAYMENT PAGE - shopping cart summary, Delivery Option, Confirm Order, Payment Method
			include('pages/partials/ftscript_payment.php'); 	
		
		} else if ($current_controller == 'order') {  
			
			//---ORDER PAGE
			include('pages/partials/ftscript_order.php'); 	
		
		} 
		
		//---COMMON SCRIPT
		include('pages/partials/ftscript_commons.php'); 
		* */
		?>
		



		var showPreloader = function(){
			$("#status").fadeIn(); $("#preLoader").delay(350).fadeIn("fast");
		}
		
		var closePreloader = function(){
			$("#status").fadeOut(); $("#preLoader").delay(350).fadeOut("fast");
		}

        $(window).load(function() { 
            $("#status").fadeOut(); $("#preLoader").delay(350).fadeOut("fast");
        });
        
		
	});
	

	
	
</script>
