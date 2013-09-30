	
	<!-- Modal -->
	<div id="order-thankyou" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body pop-content">
			<div class="o-i-icon"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_mail.png" width="150" height="150" alt=""/></div>
			
			<p class="pop-txtblue-large">Thank You</p>
			
			<p>An email has been sent to OM for your application approval.</p>

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
			
			<p>An email has been sent to OM for your application approval.</p>

			<p>Kindly check your email for the link back to this site.  Use the reference  number we sent to check the status of your application.</p><br /><br />
			
		</div>
	</div> 
