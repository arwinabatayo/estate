    <!-- Modal -->
    <!-- resend verification code -->
    <div id="resetVerification" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-body pop-content">
        <span class="pop-txtblue-large">Reset Verification Code</span>
        <p>You have exceeded the number of attempts allowed for entering your verification code. Type the characters you see and click Reset button to get a new verification code.</p>
        <div class="pop-resetcode">
			<span>Enter Characters You See</span><br/>
			<input class="pop-inputreset" id="code_id" name="code_id" type="text" autocomplete="false">
					<img src="<?php echo base_url() ?>_assets/estate/_captcha/default.png" alt="" id="captcha" />
            <br/>
            <a class="pull-right" href="javascript:void(0)" id="refresh_code">Refresh Code</a>
            <br/><br/>
        </div>
		<button class="blue-btn" id="btn_resend_vcode">OK</button>
      </div>
    </div>

    <!-- verifyNumber -->
    <div id="verifyNumber" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>        
      <div class="modal-body pop-content">
      	<img src="images/pop-entermodile.png" />
        <br/><br/>
        <span class="pop-txtblue-large">Verify Phone Number</span>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
        <div class="pop-verifycode">
			<span>SMS Verification Code</span><br/>
			<input id="verification_code" class="pop-inputvcode" type="text" val="">
            <span class="vcode-alert" style="display:none">
            	<i class="arrow"></i>
            	Please retype your SMS verification code.
            </span>
            <a class="pull-right">Resend Code</a>
        </div>
		<button class="blue-btn" id="resendVcode">Verify</button>
		<div style="display:none" class="status alert textcenter"></div>
      </div>
    </div> 
