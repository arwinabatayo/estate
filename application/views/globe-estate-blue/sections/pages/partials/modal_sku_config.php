    
    
    <!-- Modal -->
    <div id="emailConfirm" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="emailConfirmLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-body pop-content">
			<img src="<?php echo $assets_url ?>images/pop-email.png" /><br/><br/>
	            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br/>
		         <form id="email-verification" onsubmit="return false">
		            <span class="pop-txtblue-large">Enter Your Email</span>
		            <input type="text" id="email" name="email" class="pop-email-input" />
		            <p>Example: name@yourmail.com</p>
		            <button class="blue-btn">Continue</button>
		            <div style="display:none" class="status alert textcenter"></div>
	            </form>
        </div>
    </div>
    
    <div id="emailThankConfirm" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="emailThankConfirmLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-body pop-content">
			<img src="<?php echo $assets_url ?>images/pop-email-thankyou.png" /><br/><br/>
	        <span class="pop-txtblue-large">Thank You</span>
            <p class="pop-txtgrey-large">We have sent an email to <strong id="e_lbl">avargosino@yahoo.com</strong>.<br/>click on the link  found in your email to get verified.</p>
			<p class="pop-txt-resend">Didn’t receive the verification email? <a data-toggle="modal" data-target="#emailConfirm" data-dismiss="modal">Resend link</a></p>
            <p class="pop-txtblu-small">Note: Kindly make sure to verify your email address. <br/>Validity of this link is within 24 hours</p>
            <div class="modal-footer">
			  <button class="blue-btn" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>



	<div id="dialog_reserve_form"  tabindex="-1" class="modal hide fade pop-modal" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
			<div class="modal-body pop-content">
				<br />
				<span class="pop-txtblue-large">Please fillout the form</span>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
				 
				 <br />
				<h4 class="normal">Your Name</h4>
				 
				  <div>
						<div class="span4">
		                    <label>First Name</label>
		                    <span><input class="inputbox" style="" type="text"></span>
		                </div>
		                
						<div class="span4">
		                    <label>Last Name</label>
		                    <span><input class="inputbox" style=";" type="text"></span>
		                </div>
		                
						<div class="span4">
		                    <label>Middle Name</label>
		                    <span><input class="inputbox" style="" type="text"></span>
		                </div>
	              </div> 
	              <br />
				  <div>
						<div class="span3">
		                    <label>Email</label>
		                    <span>avargosino@yahoo.com</span>
		                </div>
		                
						<div class="span3">
		                    <label>Phone</label>
		                    <span>0915-2211334</span>
		                </div>
		                
						<div class="span3">
		                    <label>Middle Name</label>
		                    <span><input class="inputbox" style="" type="text"></span>
		                </div>
		                
						<div class="span3">
			                <label>Social Network User ID</label>
			                <span><input type="text" /></span>
			                <br>
			                <span>
			                     <input name="sns_id" value="facebook" type="radio" checked="checked"> Facebook
			                     <input name="sns_id" value="twitter" type="radio"> Twitter
			                     <input name="sns_id" value="linkedin" type="radio"> LinkedIn
			                </span>
		                </div>
		                
	              </div> 
	                
			</div>
		</div>
