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
		<div style="display:none" class="status alert textcenter"></div>
      </div>
    </div>
    
	<!-- Enter Mobile Number -->
    <div id="enterMobile" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>        
      <div class="modal-body pop-content">
      	<img src="<?php echo $assets_path ?>site-blue/images/pop-entermodile.png" />
        <br/><br/>
        <span class="pop-txtblue-large">Enter your Phone Number</span>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
        <div class="pop-inputmobile">
			<span>Mobile Number</span><br/>
			<input id="msisdn" name="msisdn" type="text" class="span3 active" data-provide="typeahead" placeholder="">
        </div>
		<button class="blue-btn" id="btnEnterMobileNum">Submit</button>
		<div style="display:none" class="status alert textcenter"></div>
        <br/><br/>
        <a class="pop-txtblue-link clearfix" id="link_non_globe">For Non -Globe postpaid subscribers, click here</a>
        <br/><br/>
      </div>
    </div> 
	
	<!-- Prepaid kit - non-globe -->
	<div id="selectBuyType" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>        
      <div class="modal-body pop-content">
      	<img src="<?php echo $assets_path ?>site-blue/images/pop-entermodile.png" />
        <br/><br/>
        <span class="pop-txtblue-large">How would you like to get this phone</span>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>

		<button class="blue-btn" id="new_line_plan">Get this with a Plan</button>
		<button class="blue-btn" id="new_line_prepaid_kit">Get Prepaid Kit</button>
		<div style="display:none" class="status alert textcenter"></div>
        <br/><br/>
        
        <br/><br/>
      </div>
    </div> 
    
    <!-- verifyNumber -->
    <div id="verifyNumber" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>        
      <div class="modal-body pop-content">
      	<img src="<?php echo $assets_path ?>site-blue/images/pop-entermodile.png" />
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
            <a class="pull-right" data-toggle="modal" data-target="#enterMobile" data-dismiss="modal">Resend Code</a>
        </div>
		<button class="blue-btn" id="resendVcode">Verify</button>
		<div style="display:none" class="status alert textcenter"></div>
      </div>
    </div> 
    
      <div id="reserveForm"  tabindex="-1" class="modal hide fade pop-modal" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-body pop-content">
        <br />
        <div>
            <h4 class="normal">Please fillout the form</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
             
             <br />
            <h4 class="normal">Your Name</h4>
              <form name="reserve-form" id="reserve-form">
                <div class="row-fluid">
                  <div class="span4">
                      <label>First Name</label>
                      <span><input class="inputbox" style="" type="text" name="first_name" id="first_name" /></span>
                  </div>
                          
                  <div class="span4">
                      <label>Last Name</label>
                      <span><input class="inputbox" style="" type="text" name="last_name" id="last_name" /></span>
                  </div>
                          
                  <div class="span4">
                      <label>Middle Name</label>
                      <span><input class="inputbox" style="" type="text" name="middle_name" id="middle_name" /></span>
                  </div>
                </div> 
                <br />
                        <?php // use session values for email and number ?>
                  <div class="row-fluid">
                  <div class="span3">
                      <label>Email</label>
                      <span><input type="hidden" name="email" id="email" value="<?php echo $this->session->userdata('current_subscriber_email'); ?>" /><?php echo $this->session->userdata('current_subscriber_email'); ?></span>
                  </div>
                          
                  <div class="span3">
                      <label>Phone</label>
                      <span><input type="hidden" name="phone" id="phone" value="<?php echo $this->session->userdata('current_subscriber_mobileno'); ?>" /><?php echo $this->session->userdata('current_subscriber_mobileno'); ?></span> <?php // why is this hardcoded on the requirement? ?>
                  </div>
                          
                  <div class="span3">
                      <label>Network Carrier</label>
                      <span><select id="network_carrier" name="network_carrier">
                        <option value="Smart">Smart</option>
                        <option value="Sun Cellular">Sun Cellular</option>
                        <option value="Others">Others</option>
                      </select></span>
                  </div>
                          
                  <div class="span3">
                        <label>Social Network User ID</label>
                        <span><input type="text" name="sn_uid" id="sn_uid" /></span>
                        <br>
                        <span>
                             <input name="sns_id" value="facebook" type="radio" checked="checked"> Facebook
                             <input name="sns_id" value="twitter" type="radio"> Twitter
                             <input name="sns_id" value="linkedin" type="radio"> LinkedIn
                        </span>
                      </div>                        
                    </div>
                    <input type="hidden" name="from_reserve_form" id="from_reserve_form" value="1" />
                    <div style="display:none" class="status alert textcenter"></div>
                </form> 
          </div>    
      </div>
    </div>
    
    
    
