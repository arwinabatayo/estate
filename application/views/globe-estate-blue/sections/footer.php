

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

	} else if($page == 'plan'){ 
		
		include('pages/partials/modal_plan.php');
		
	} else if($page == 'addons'){ 
		
		include('pages/partials/modal_addons.php');
	}
	
	
	if($current_method == 'sms_verification'){
		include('pages/partials/modal_sms-verification.php');
	}
	
	
	include('pages/partials/modal_commons.php');

?>   
    
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/jquery.js"></script>    
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/grid2.js"></script>
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/prettify.js"></script> 
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/jquery-ui-1.10.0.custom.min.js"></script>  
<script type="text/javascript" src="<?php echo $assets_url?>site-blue/js/jquery.icheck.min.js"></script>

<script type="text/javascript">
	
    $(function () {
	
		<?php 
		//---COMMON SCRIPT
		include('pages/partials/ftscript_commons.php'); 
		if($page == 'landing' ){
				
			//---LANDING PAGE
			include('pages/partials/ftscript_landing.php');
						
		} else if($page == 'home'){ 
			

			//---SKU-CONFIGURATION
			include('pages/partials/ftscript_home.php');
			
			///---SKU-CONFIGURATION > SMS VERIFICATION
			if($current_method == 'sms_verification'){ 
				
				include('pages/partials/ftscript_smsverification.php');
				
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
			
		} else if($current_controller == 'payment' ){ 
			
			//---PAYMENT PAGE - shopping cart summary, Delivery Option, Confirm Order, Payment Method
			include('pages/partials/ftscript_payment.php'); 	
		
		} else if ($current_controller == 'order') {  
			
			//---ORDER PAGE
			include('pages/partials/ftscript_order.php'); 	
		
		} 
		
		

		
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
