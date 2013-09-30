	
	<!-- Modal -->
	<div id="order-thankyou" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body pop-content">
			<div class="o-i-icon"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_mail.png" width="150" height="150" alt=""/></div>
			
			<p class="pop-txtblue-large">Thank You</p>
			
			<p>An email has been sent to Order Manager for your application approval.</p>

			<p>Kindly check your email for the link back to this site.  Use the reference  number we sent to check the status of your application.</p><br /><br />
			
			<?php if(!isset($_GET['subscriber_flag'])){ ?>
				<p class="textcenter"><button class="blue-btn" onclick="window.location.href='<?php echo base_url() ?>'">Continue</button></p>
			<?php }else{ ?>
				<p class="textcenter"><button class="blue-btn" onclick="closeModal(this);">Continue</button></p>
			<?php } ?>
		</div>
	</div>

	<div id="business-10" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true" id="close-business-10">×</button>
		<div class="modal-body pop-content">
			<div class="o-i-icon"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_mail.png" width="150" height="150" alt=""/></div>
			
			<p class="pop-txtblue-large">Thank You</p>
			
			<p>An email has been sent to Order Manager for your application approval.</p>

			<p>Kindly check your email for the link back to this site.  Use the reference  number we sent to check the status of your application.</p><br /><br />
			
		</div>
	</div> 

	<div class="popover fade top in" style="top: 851px; left: 480.975px; display: block;"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content">
	</div></div>

	<div class="hide" id="get-prepaid-content">
		<h3><img width="62" height="62" alt="" src="<?php echo $assets_path ?>site-blue/images/order_type/icon_prepaid.jpg">&nbsp; <?php echo $gadget_data['gadget_name'] . " / " . $gadget_data['gadget_specs']['capacity'] . " GB"; ?></h3>
		
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
		
		<hr>
		
		<p>Price:<?php echo $gadget_data['gadget_price']; ?></span></p>
		<a href="javascript: void(0);" onclick="addPrepaid();" id="add-prepaid">Add to Cart</a>
	</div>

	<script type="text/javascript">
		function addPrepaid () 
		{
            $.ajax({
				url: base_url+'cart/addprepaidtocart',
				success: function(response){

					var resp = jQuery.parseJSON( response );

					if (resp.status == 'success') {
				       window.location = resp.cart_url;
					} else {
						alert(resp.msg);
					}

				},
				error: function(){
					alert('Some error occured or the system is busy. Please try again later');
				}
			});
		}
	</script>
