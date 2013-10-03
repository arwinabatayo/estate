    <!-- Modal -->
    <!-- resend verification code -->
    <div id="resetVerification" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static" style="display:none">
      <div class="modal-body pop-content">
        <span class="pop-txtblue-large">Reset Verification Code</span>
        <p>You have exceeded the number of attempts allowed for entering your verification code.  To receive a new code, enter the characters  shown below, and click Reset.</p>
        <div class="pop-resetcode">
			<span>Enter Characters You See</span><br/>
			<input class="pop-inputreset" id="code_id" name="code_id" type="text" autocomplete="false">
					<img src="<?php echo base_url() ?>_assets/estate/_captcha/default.png" alt="" id="captcha" />
            <br/>
            <a class="pull-right btnRefresh_code" href="javascript:void(0)" rel="captcha">Refresh Code</a>
            <br/><br/>
        </div>
		<button class="blue-btn" id="btn_resend_vcode">OK</button>
		<div style="display:none" class="status alert textcenter"></div>
      </div>
    </div>
    
	<!-- Enter Mobile Number -->
    <div id="enterMobile" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
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
	<div id="selectBuyType" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
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
    <div id="verifyNumber" class="modal fade pop-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
	<button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>        
      <div class="modal-body pop-content">
      	<img src="<?php echo $assets_path ?>site-blue/images/pop-entermodile.png" />
        <br/><br/>
        <span class="pop-txtblue-large">Verify Phone Number</span>
        <p>We have sent an SMS containing a verification code to <strong>[mobile number]</strong>. This is to ensure security and verify ownership of the mobile number.<br /> Please enter the code in the space provided.</p>
        <div class="pop-verifycode">
			<span>SMS Verification Code</span><br/>
			<input id="verification_code" class="pop-inputvcode" type="text" val="">
            <span class="vcode-alert" style="display:none">
            	<i class="arrow"></i>
            	The code you entered is invalid. Please try again.
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
            
            <form id="reserve-form" name="reserve-form" onsubmit="return false">
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
                        <p><strong><input type="hidden" name="email" id="email" value="<?php echo $this->session->userdata('current_subscriber_email'); ?>" /><span id="email-cont"><?php echo $this->session->userdata('current_subscriber_email'); ?></span></strong></p>
                    </li>
                    <li class="span2">
                        <label for="Phone Number">Phone Number</label>
                        <p><strong><input type="hidden" name="phone" id="phone" value="<?php echo $this->session->userdata('current_subscriber_mobileno'); ?>" /><span id="phone-cont"><?php echo $this->session->userdata('current_subscriber_mobileno'); ?></span></strong></p>
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
            
            <!-- <a href="#" class="blue-btn modal-anchor" id="ty-btn-lbl" data-dismiss="modal">OK</a> -->

              <button class="blue-btn" data-dismiss="modal" id="ty-msg-btn">OK</button>

        </div>
    </div> 

    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade pop-modal in" id="settle-overdue">
        <div class="modal-body pop-content">
            <div class="o-i-icon"><img width="150" height="150" alt="Settle Your Overdue" src="<?php echo $assets_path ?>site-blue/images/icons/icon_settle_overdue.png"></div>
            
            <p class="pop-txtblue-large">Past Due</p>
            
            <p>To proceed with the order, please settle the overdue balance immediately.</p>
            
            <p class="s-o-text">
                <span>Overdue:</span>
                <div id="outstanding-balance">P0.00</div>
            </p>
            
            <hr>
            
            <a class="blue-btn" href="javascript: void(0);" id="settle-overdue-cc">Settle Due with Credit Card</a>
            <a class="blue-btn" href="javascript: void(0);" id="settle-overdue-gcash">Settle Due with GCash</a>
            <a class="blue-btn" href="javascript: void(0);" id="settle-account">I already settled my account</a>
            <?php
            // check if prepaid kit is enabled on db
            if ($prepaid_kit_overdue_enabled) { ?>
                <a class="pull-left" href="javascript: void(0);" id="get-prepaid-kit">Get a Prepaid Phone Kit&nbsp;</a>
            <?php } ?>
            <a class="pull-right" href="javascript: void(0);" id="settle-due-ways">Learn more ways to settle due</a>
            
            <div class="clr"></div>
        </div>
    </div>
    
    <div id="choose-payment" class="modal hide fade pop-modal">
        <div class="modal-body pop-content">
            <button type="button" class="close pop-close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="o-i-icon"><img src="<?php echo $assets_path ?>site-blue/images/icons/icon_choose_payment.png" width="150" height="150" alt="Settle Your Overdue"/></div>
            
            <p class="pop-txtblue-large">Payment Channel</p>
            
            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent</p>
            
            <form name="payment-channels-form" id="payment-channels-form" onsubmit="return false;">
                <div class="choose-payment-radio span3 consultation-radio pad-space">
                    <ul>
                        <li>
                            <input tabindex="13" type="radio" checked="checked" id="flat-radio-1" name="payment_channels" value="Globe Telecom Business Center" style="">
                            <label for="Globe Telecom Business Center">Globe Telecom Business Center</label>
                            
                            <div class="clr"></div>
                        </li>
                        <li>
                            <input type="radio" name="payment_channels" id="flat-radio-1" value="Bank" />
                            <label for="Bank">Bank</label>
                            
                            <div class="clr"></div>
                        </li>
                        <li>
                            <input type="radio" name="payment_channels" id="flat-radio-1" value="GCash" />
                            <label for="GCash">GCash</label>
                            
                            <div class="clr"></div>
                        </li>
                        <li>
                            <input type="radio" name="payment_channels" id="flat-radio-1" value="Online Banking" />
                            <label for="Online Banking">Online Banking</label>
                            
                            <div class="clr"></div>
                        </li>
                        <li>
                            <input type="radio" name="payment_channels" id="flat-radio-1" value="Bayad or Payment Center" />
                            <label for="Bayad or Payment Center">Bayad / Payment Center</label>
                            
                            <div class="clr"></div>
                        </li>
                    </ul>
                </div>
                
                <div class="clr"></div>
                
                <hr/>
                
                <p id="payment-medium-label" class="c-p-title">Globe Telecom Business Center</p>
                
                <label for="Payment Medium Name">Payment Medium Name</label>
                <input type="text" name="payment_medium_name" id="payment_medium_name" class="span3"/>

                <label for="Reference Number">Reference Number</label>
                <input type="text" name="reference_number" id="reference_number" class="span3"/>
                
                <label for="OR Number">OR Number</label>
                <input type="text" name="or_num" id="or_num" class="span3"/>
                
                <div class="clr"></div>
                
                <input type="submit" value="Submit" class="blue-btn"/>
            </form>
        </div>
    </div>
    
    
