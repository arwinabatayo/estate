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
        <?php
            $non_globe_id = "link_non_globe"; 
            if ($is_reserve) {
                $non_globe_id = "link_non_globe_reserve";
            }
        ?>
        <a class="pop-txtblue-link clearfix" id="<?php echo $non_globe_id; ?>">For Non -Globe postpaid subscribers, click here</a>
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
    
    <div id="reserve-08" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>  
        <div class="modal-body pop-content">
            <p class="pop-txtblue-large">Reserve</p>
            
            <hr/>
            
            <p>Please fill out the form</p>
            <p>Lorem ipsum dolor sit amet, consectuer adipiscing elit. Cras justo nulla,  commodo nec mauris ut,  interdum adipiscing  nisi..</p>
            
            <p>YOUR NAME</p>
            
            <form id="reserve-form" name="reserve-form" method="post">
                <ul>
                    <li class="span3">
                        <label for="First Name">First Name <span class="req-val">*</span></label>
                        <input type="text" name="first_name" id="first_name" />
                    </li>
                    <li class="span3">
                        <label for="Last Name">Last Name <span class="req-val">*</span></label>
                        <input type="text" name="last_name" id="last_name"/>
                    </li>
                    <li class="span3">
                        <label for="Middle Name">Middle Name <span class="req-val">*</span></label>
                        <input type="text" name="middle_name" id="middle_name"/>
                    </li>
                    <li class="span3">
                        <label for="Email address">Email address</label>
                        <p><strong><input type="hidden" name="email" id="email" value="<?php echo $this->session->userdata('current_subscriber_email'); ?>" /><?php echo $this->session->userdata('current_subscriber_email'); ?></strong></p>
                    </li>
                    <li class="span2">
                        <label for="Phone Number">Phone Number</label>
                        <p><strong><input type="hidden" name="phone" id="phone" value="<?php echo $this->session->userdata('current_subscriber_mobileno'); ?>" /><?php echo $this->session->userdata('current_subscriber_mobileno'); ?></strong></p>
                    </li>
                </ul>
                
                <div class="span4 consultation-radio">
                    <label for="Phone Number">Social Network ID <span class="req-val">*</span></label>
                    <input type="text" name="sn_uid" id="sn_uid" class="span3"/>
                    
                    <ul>
                        <li>
                            <input type="radio" name="sns_id" id="flat-radio-1" value="facebook" checked="checked" />
                            <label for="Facebook">Facebook</label>
                        </li>
                        <li>
                            <input type="radio" name="sns_id" id="flat-radio-1" value="twitter" />
                            <label for="Facebook">Twitter</label>
                        </li>
                        <li>
                            <input type="radio" name="sns_id" id="flat-radio-1" value="linkedin" />
                            <label for="Facebook">LinkedIn</label>
                        </li>
                        <input type="hidden" name="from_reserve_form" id="from_reserve_form" value="1" />
                    </ul>
                </div>
                <button class="blue-btn" id="btnSendReservation">Submit</button>
                <div style="display:none" class="status alert textcenter"></div>
            </form>
            
            <div class="clr"></div>
        </div>
    </div>

    <div id="04-thank-you" class="modal hide fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-body pop-content">
            <div class="o-i-icon"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_4_thank_you.png" width="150" height="150" alt="Reserve"/></div>
            
            <p class="pop-txtblue-large">Thank You</p>
            
            <p id="ty-msg">We will send you an email update once the device become available.</p>
            
            <hr/>
            
            <a href="#" class="blue-btn modal-anchor" id="ty-btn-lbl">OK</a>
        </div>
    </div>    
    
    
    
