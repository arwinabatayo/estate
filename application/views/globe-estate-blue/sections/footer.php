

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
    
    if($current_controller == 'payment'){ 
		
		include('pages/partials/modal_payment.php');
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

<!-- #Robert 930 -->
<script type="text/javascript" src="<?php echo $assets_url ?>site-blue/js/ajaxfileupload.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){

		$('.radio-btn input').iCheck({
			checkboxClass: 'icheckbox_flat-red',
			radioClass: 'iradio_flat-blue'
		});
		
	});

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
		?>
			$('#accChooseYourPlan .accordion-body').height('auto');
			$('#accChooseYourPlan .accordion-toggle').removeClass('in collapse').addClass('collapsed');
		<?php 
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
	

	function downloadForm(_type)
	    {	
	    	var refnum = getURLParameter("refnum");
	    	
	        // call ajax for downloading
	        $.ajax({
	            url: base_url+'order/download_form',
	            data: { 'form_type' : _type, 'refnum' : refnum },
	            type: 'post',
	            success: function(response){
	                var resp = jQuery.parseJSON( response );
					
					if(_type != "receipt"){
		                if (resp.file_url) {
							pwin = window.open(resp.file_url,"_blank");
							// added focus for new window
							pwin.focus();
							pwin.print();
		                }
	            	}else{
	            		var order_item_str = "";
	            		for(var a=0; a < resp.order_item_details.length; a++){
	            			order_item_str += "<tr><td>" + resp.order_item_details[a].product + "</td><td>" + resp.order_item_details[a].description + "</td><td>" + resp.order_item_details[a].unit_price + "</td><td>" + resp.order_item_details[a].discount + "</td><td>" + resp.order_item_details[a].total + "</td></tr>";
	            		}

	            		


	            		

	            		$("#receipt div:eq(0)").html("<div><strong>Date: </strong>" + resp.order_details.date_ordered + "<strong>Order Number:</strong>" + resp.order_details.order_number + "</div><div><strong>Billing Information</strong></div><div><table><tr><td><strong>" + resp.account_details.fullname + "</strong><p>" + resp.billing_details.unit + " " + resp.billing_details.street + " " + resp.billing_details.subdivision + " " + resp.billing_details.barangay + "</p><p>" + resp.billing_details.municipality + " " + resp.billing_details.city + " " + resp.billing_details.postal + "</p><p><strong>Phone: </strong>" + resp.account_details.mobile_number + "</p><p><strong>Email: </strong>" + resp.account_details.email + "</p></td><td><p>Name: " + resp.account_details.fullname + "</p><p>Paid: </p><p>Email: " + resp.account_details.email + "</p><p>Account Number: " + resp.account_details.account_id + "</p></td></tr></table></div><div><table><tr><td>Product</td><td>Item Description</td><td>Unit Price</td><td>% Discount</td><td>Total</td></tr>" + order_item_str + "<tr><td rowspan=\"3\"><strong>Subtotal: </strong></td><td rowspan=\"2\">" + resp.order_details.subtotal + "</td></tr><tr><td rowspan=\"3\"><strong>Shipping and Handling Cost</strong></td><td rowspan=\"2\">" + resp.order_details.shipping_fee + "</td></tr></table></div><div><strong>Total: </strong>" + resp.order_details.total + "</div><div><button class=\"btn btn-primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover\" onclick=\"printeReceipt();\" role=\"button\" aria-disabled=\"false\"><span class=\"ui-button-text\">Print</span></button></div>");

	            		$("#receipt").modal("show");
	            	}     
	            }, 
	            error: function(){
	                alert('Some error occured or the system is busy. Please try again later');  
	            }
	        });
	    }

	    function printeReceipt(){
	    	var novoForm = window.open("about:blank", "wFormx", "width=800,height=600,location=no,menubar=no,status=no,titilebar=no,resizable=no,");
			//var w = novoForm.outerWidth;
			//var h = novoForm.outerHeight;
			novoForm.document.body.innerHTML = $("#receipt").html();
	    }


	    function getURLParameter(name) {
		    return decodeURI(
		        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
		    );
		}

	
</script>
