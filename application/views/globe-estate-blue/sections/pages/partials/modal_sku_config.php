    
    
    <!-- Modal -->
    <div id="emailConfirm" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="emailConfirmLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static" style="display:none">
        <button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>
        <div class="modal-body pop-content">
			<img src="<?php echo $assets_url ?>images/pop-email.png" /><br/><br/>
	            <p>Please provide a valid email address to receive information and important announcements about your order.  We will then be verifying if your given email address is active.</p><br/>
		         <form id="email-verification" onsubmit="return false">
		            <span class="pop-txtblue-large">Enter Your Email</span>
		            <input type="text" id="email" name="email" class="pop-email-input" />
		            <p>Example: name@yourmail.com</p>
		            <button class="blue-btn">Continue</button>
		            <div style="display:none" class="status alert textcenter"></div>
	            </form>
        </div>
    </div>
    
    <div id="emailThankConfirm" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="emailThankConfirmLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static" style="display:none">
        <button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>
        <div class="modal-body pop-content">
			<img src="<?php echo $assets_url ?>images/pop-email-thankyou.png" /><br/><br/>
	        <span class="pop-txtblue-large">Thank You</span>
            <p class="pop-txtgrey-large">We have sent an email to <strong id="e_lbl">avargosino@yahoo.com</strong>.<br />  Please click on the link found in your email to verify your account.</p>
			<p class="pop-txt-resend">Didn't receive the verification email? <a data-toggle="modal" data-target="#emailConfirm" data-dismiss="modal">Resend link</a></p>
            <p class="pop-txtblu-small">Note: Kindly make sure to verify your email address. <br/>The link will expire after 24 hours.</p>
            <div class="modal-footer">
			  <button class="blue-btn" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
