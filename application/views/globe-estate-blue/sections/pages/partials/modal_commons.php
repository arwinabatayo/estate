<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade pop-modal in" id="my-application">
	<div class="modal-body pop-content">
		<div class="o-i-icon"><img width="151" height="150" alt="My Application" src="<?php echo $assets_path ?>site-blue/images/icons/icon_my_application.png"></div><br>
		
		<p class="pop-txtblue-large">My Application</p>
		
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing.<br> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero</p>
    	<form id="refnum-verification" name="refnum-verification" onsubmit="return false">
    		<label for="Reference Number">Reference Number</label>
    		<input type="text" id="reference_number" name="reference_number" />
    		
    		<a href="javascript: void(0);" id="lnk_forgot_refnum">Forgot your reference number?</a>
    		
    		<input type="submit" value="Submit" class="blue-btn">
            <a href="javascript: void(0);" id="open_resume_uncomp_transaction">Resume Uncompleted Transaction</a>
            <div style="display:none" class="status alert textcenter"></div>
        </form>
	</div>
</div>

<div class="modal hide fade pop-modal in" id="uncomplete-transaction" aria-hidden="true">
    <div class="modal-body pop-content">
        <div class="o-i-icon"><img width="151" height="150" alt="My Application" src="<?php echo $assets_path ?>site-blue/images/icons/icon_uncomplete_transaction.png"></div><br>
        
        <p class="pop-txtblue-large">Resume Uncompleted Transaction</p>
        
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        
        <form id="resume-uncomp-transaction" name="resume-uncomp-transaction" onsubmit="return false">   
            <label for="Email">Email</label>
            <input type="text" id="email" name="email" />
            <p>Example: name@yourmail.com</p>
            
            <hr>
            
            <label for="Enter Characters You See">Enter Characters You See</label>
            <input type="text" id="code_id" name="code_id" autocomplete="false" />
            <div>
                <!-- <div class="u-t-captcha"> -->
                    <img width="404" height="97" alt="" src="<?php echo base_url() ?>_assets/estate/_captcha/default.png" alt="" id="ut_captcha" >
                <!-- </div> -->
                <a class="pull-right" href="javascript:void(0)" id="refresh_code">Refresh code</a>
            </div>
            <div class="clr"></div>
            <div style="display:none" class="status alert textcenter"></div>
            <input type="submit" value="Submit" class="blue-btn">
        </form>
    </div>
</div>

<div id="forgot-reference" class="modal hide fade pop-modal" aria-hidden="true">
    <div class="modal-body pop-content">
        <button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>        
        
        <h2 class="pop-txtblue-large">Forgot reference number</h2>
        
        <p>Vivamus a justo hendrerit, viverra nibheget, scelerisque est. Phasellus sagittis commodo tellus, quis lobortis urna</p><br />
        
        <form name="forgot-refnum" id="forgot-refnum" onsubmit="return false;">
            <label for="Email"><strong>Email</strong></label>
            <input type="text" name="email" id="email" class="span4" />
            <small>Example:name@youremail.com</small><br /><br /><br />
            
            <label for="Enter Characters you see"><strong>Enter Characters you see</strong></label>
            <input type="text" name="code_id" id="code_id" class="span4" autocomplete="false" /><br />
            <div>
                <!-- <div class="u-t-captcha"> -->
                    <img width="404" height="97" alt="" src="<?php echo base_url() ?>_assets/estate/_captcha/default.png" alt="" id="fr_captcha" >
                <!-- </div> -->
                <a class="pull-right" href="javascript:void(0)" id="refresh_code">Refresh code</a>
            </div>
            <div style="display:none" class="status alert textcenter"></div>
            <input type="submit" name="" value="Submit" class="blue-btn"/>
        </form>
    </div>
</div> 

<div id="04-thank-you" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-body pop-content">
        <div class="o-i-icon"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_4_thank_you.png" width="150" height="150" alt="Reserve"/></div>
        
        <p class="pop-txtblue-large">Thank You</p>
        
        <p id="ty-msg">We will send you an email update once the device become available.</p>
        
        
        <div id="resend-link-info">
            <p class="pop-txt-resend">Didn’t receive the verification email? <a data-dismiss="modal" data-target="#emailConfirm" data-toggle="modal" href="javascript: void(0);" id="resend_saved_transaction_lnk">Resend link</a></p>
            <p class="pop-txtblu-small">Note: Kindly make sure to verify your email address. <br>Validity of this link is within 24 hours</p>
        </div>
        <hr/>
        <!-- <div class="modal-footer"> -->
          <button data-dismiss="modal" class="blue-btn">OK</button>
        <!-- </div> -->

    </div>
</div>  