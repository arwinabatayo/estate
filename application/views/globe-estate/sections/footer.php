
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

		} else if($current_controller == 'payment' ){

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
	
	                if (resp.file_url) {
						pwin = window.open(resp.file_url,"_blank");
						// added focus for new window
						pwin.focus();
						pwin.print();
	                }     
	            }, 
	            error: function(){
	                alert('Some error occured or the system is busy. Please try again later');  
	            }
	        });
	    }


	    function getURLParameter(name) {
		    return decodeURI(
		        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
		    );
		}
		</script>
