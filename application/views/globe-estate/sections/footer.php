
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

		} else if($current_controller == 'payment' ){

			//---PAYMENT PAGE - shopping cart summary, Delivery Option, Confirm Order, Payment Method
			include('pages/partials/ftscript_payment.php');

		} else if ($current_controller == 'order') {

			//---ORDER PAGE
			include('pages/partials/ftscript_order.php');

		}




		?>

	});

	// function for downloading print forms on status page -- gellie
	// TO MOVE in ftscripts_commons
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
					console.log(resp);
					if(_type != "receipt"){
		                if (resp.file_url) {
							pwin = window.open(resp.file_url,"_blank");
							// added focus for new window
							pwin.focus();
							pwin.print();
		                }
	            	}else{
	            		var order_item_str = "";
	            		for(var a=0; a < resp.new_order_item_details.length; a++){
							var discount = (resp.new_order_item_details[a].product_info.discount != null) ? resp.new_order_item_details[a].product_info.discount : 0;
	            			order_item_str += "<tr><td>" + resp.new_order_item_details[a].product_info.name + "</td><td>" + resp.new_order_item_details[a].product_info.product_type + "</td><td>" + resp.new_order_item_details[a].product_info.price_formatted + "</td><td>" + discount + "</td><td>" + resp.new_order_item_details[a].product_info.subtotal + "</td></tr>";
	            		}

	            		

	            		$("#receipt").html("<div><strong>Date: </strong>" + resp.order_details.date_ordered + "<strong>Order Number:</strong>" + resp.order_details.order_number + "</div><div><strong>Billing Information</strong></div><div><table><tr><td><strong>" + resp.account_details.fullname + "</strong><p>" + resp.billing_details.unit + " " + resp.billing_details.street + " " + resp.billing_details.subdivision + " " + resp.billing_details.barangay + "</p><p>" + resp.billing_details.municipality + " " + resp.billing_details.city + " " + resp.billing_details.postal + "</p><p><strong>Phone: </strong>" + resp.account_details.mobile_number + "</p><p><strong>Email: </strong>" + resp.account_details.email + "</p></td><td><p>Name: " + resp.account_details.fullname + "</p><p>Paid: </p><p>Email: " + resp.account_details.email + "</p><p>Account Number: " + resp.account_details.account_id + "</p></td></tr></table></div><div><table><tr><td>Product</td><td>Item Description</td><td>Unit Price</td><td>% Discount</td><td>Total</td></tr>" + order_item_str + "<tr><td rowspan=\"3\"><strong>Subtotal: </strong></td><td rowspan=\"2\">" + resp.order_details.subtotal + "</td></tr><tr><td rowspan=\"3\"><strong>Shipping and Handling Cost</strong></td><td rowspan=\"2\">" + resp.order_details.shipping_fee + "</td></tr></table></div><div><strong>Total: </strong>" + resp.order_details.total + "</div><div><button class=\"btn btn-primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover\" onclick=\"printeReceipt();\" role=\"button\" aria-disabled=\"false\"><span class=\"ui-button-text\">Print</span></button></div>");

	            		$("#receipt").dialog("open");
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
