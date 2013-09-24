
			
			    <?php 
			    
			    include('partials/sku_configuration.php'); ?>
			   
			    <?php if($current_method == 'sms_verification'){ ?>
			    
                
						<?php if( $this->session->userdata('showcaptcha') ){ ?>
			                <div id="dialog_enter_captcha" title="Reset Verification Code">
								<div>
									<p>You have exceeded the number of attempts allowed for entering your verification code.  Type the characters you see and click Reset button to get a new verification code.</p>
									<label style="font-size:90%">Enter characters you see:</label>
									<p><img src="<?php echo base_url() ?>_assets/estate/_captcha/default.png" alt="" id="captcha" />&nbsp; <a href="javascript:void(0)" id="refresh_code" style="font-size:11px;">Refresh Captcha</a></p>
				                    
				                    <input class="fleft" id="code_id" name="code_id" type="text" autocomplete="false" />&nbsp;<button id="btn_resend_vcode" class="btn btn-primary">RESET</button>
	                    		</div>
			                </div>  
			                
						<?php } else { ?>
           
		                
		                <div class="globe-dialog" id="dialog_enter_mobile" title="Enter Your Mobile Number">
							<div class="span5 textleft noLeftMargin">
								<p><i class="icon-mobile-phone icon-4x fleft"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
								<p class="label label-info">&nbsp;For Non-Globe postpaid subscribers,&nbsp;&nbsp;<a href="#" style="color:#FFF" id="non-globe-new-line">Click Here</a>&nbsp;</p>
								
		                    </div>
		                    
							<div class="span4">
							<form id="enter-mobile" class="form-inline" onsubmit="return false">
								<fieldset>
								<div class="control-group ">
								<label class="control-label">Mobile Number</label>
									<div class="controls">
										<input type="text" required id="msisdn" name="msisdn" class="-medium">
										<button class="btn btn-primary">Submit</button>
									</div>
								</div>
								<p class="note">Examples: 09151178863</p>
								</fieldset>
								<div style="display:none" class="status alert textcenter"></div>
							</form>
		                    </div>
		                </div>


		                <div class="globe-dialog" id="dialog_new_line" title="How would you like to get this phone?">
							<div class="span5 textleft noLeftMargin">
								<p>SMS successfully sent to you mobile number! - incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
								
								<button class="btn btn-primary" id="new-line-plan">Get this with a Plan</button>
								<button class="btn btn-primary" id="new-line-prepaid-kit">Get a Prepaid Kit</button>
		                    </div>
		                </div>


			            <br />
			            <?php } ?>
			            
		                <div id="dialog_verify_mobile" title="Verify Mobile Number">
							<div class="span5 textleft noLeftMargin">
								<p><i class="icon-mobile-phone icon-4x fleft"></i>SMS successfully sent to you mobile number! - incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
					
		                    </div>
		                    
							<div class="span4">
							<form id="sms-verification" class="form-inline" onsubmit="return false">
								<fieldset>
								<div class="control-group ">
								<label class="control-label">SMS Verification Code </label>
									<div class="controls">
										<input type="text" id="verification_code" name="verification_code" class="-medium">
										<button class="btn btn-primary">Verify</button>
									</div>
								</div>
								<p><a href="javascript:void(0)" class="open-dialog" rel="dialog_enter_mobile">Resend Code</a></p>
								<div style="display:none" class="status alert textcenter"></div>
								</fieldset>
							</form>
								
		                    </div>
		                </div>    
						

	            
			    
			    <?php } else { ?>
			    
                <div class="globe-dialog" id="dialog_enter_email" title="Enter Your Email">
					
					<div class="span4 textleft noLeftMargin">
						<p><i class="icon-envelope icon-3x fleft"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.<br /> 					<span class="span4 textright">

						</p>
                    </div>
					<div class="span4">
						
					<form id="email-verification" class="form-inline" onsubmit="return false">
						<fieldset>
						<div class="control-group ">
						<label class="control-label">Email</label>
							<div class="controls">
								<input type="text" id="email" name="email" class="-medium">
								<button class="btn btn-primary">Submit</button>
							</div>
						</div>
						<div style="display:none" class="status alert textcenter"></div>
						</fieldset>
					</form>
                    </div>
                </div>
	            <br />
	            
	            <div class="globe-dialog" id="dialog_thankyou_email" title="Thank You!">
					<p>We have sent an email to <span id="e_lbl" class="bold"></span>. Click on the link found in your email to get verified.</p>
					<span class="span4 textleft noLeftMargin" style="color:#888">
						<p class="note">NOTE: Kindly make sure to verify your email address. Validity of this link is within 24hrs.</p>
					</span>
					<span class="span4 textright">
						<strong>Didn't receive the verification email?</strong> &nbsp;&nbsp;
						<button  class="ui-button-primary open-dialog" id="resend_link" rel="dialog_enter_email">Resend Link</button>
					</span>
	            </div>	
	            

			    <?php }  ?>
			
			
	            <div class="globe-dialog" id="dialog_reserve_form" title="Reserve">
					<div>
						<h4 class="normal">Please fillout the form</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
						 
						 <br />
						<h4 class="normal">Your Name</h4>
						 
						  <div class="row-fluid">
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
						  <div class="row-fluid">
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
	            
	            <?php // settle overdue balance popup ?>
				<div class="globe-dialog" id="dialog_settle_overdue" title="Settle Your Overdue">
					<span class="span4 textleft noLeftMargin">
						To proceed with the order, please settle the overdue balance immediately.
					</span>
					<span class="span4 textcenter">
						<h3 style="color: red;">Php 14, 500.00</h3>
						<span style="display: block; height: 30px; font-size: 11px;">Overdue Balance</span>

						<div>
							<button  class="ui-button-primary open-dialog" id="settle-overdue-cc">Settle Due with Credit Card</button><br/><br/>
							<button  class="ui-button-primary open-dialog" id="settle-overdue-gcash">Settle Due with G-Cash</button><br/><br/>
							<a href="javascript: void(0);" id="account-settled">I already settled my account</a>
						</div>
						<br/>
						<?php 
						// check if prepaid kit is enabled
						$prepaid_kit_enabled = $this->config->item('prepaid_kit_enabled');
						if ($prepaid_kit_enabled) { ?>
							<a href="javascript: void(0);" id="get-prepaid-kit">Get a Prepaid Phone Kit</a>
						<?php } ?>
						<a href="javascript: void(0);" id="ways-to-settle-due">Learn more ways to settle due</a>
					</span>
				</div>

				<?php // payment channels dialog ?>
				<div class="globe-dialog" id="dialog_payment_channels" title="Payment Channel">
					<div>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
						<br />
						<div class="row-fluid">
							<div class="span3">
			                    <input type="radio" name="payment_channel" checked="checked" value="Globe Telecom Business Center" /> Globe Telecom Business Center
			                </div>
			                <div class="span2">
			                    <input type="radio" name="payment_channel" value="Bank" /> Bank
			                </div>
							<div class="span2">
			                    <input type="radio" name="payment_channel" value="GCash" /> GCash
			                </div>
			                <div class="span2">
			                    <input type="radio" name="payment_channel" value="Online Banking" /> Online Banking
			                </div>
			                <div class="span3">
			                    <input type="radio" name="payment_channel" value="Bayad/Payment Center" /> Bayad/Payment Center
			                </div>
		              	</div>
		              	<br/>
		              	<h4>Globe Telecom Business Center</h4>
			            <form name="form-settle-overdue" id="form-settle-overdue" onsubmit="return false;"> 	
			              	<div class="row-fluid">
								<fieldset>
									<div class="control-group ">
										<div class="span4">
						                    <label class="control-label">Reference Number </label><input type="text" name="ref_num" id="ref_num" />
						                </div>
						                <div class="span3">
						                     <label class="control-label">OR Number </label><input type="text" name="or_num" id="or_num" />
						                </div>
						                <button class="btn btn-primary">Submit</button>
					            	</div>
				                <fieldset>
			              	</div>
			            </form>
	              	</div>
				</div>

				<?php // settle overdue balance ty popup ?>
				<div class="globe-dialog" id="dialog_settle_overdue_ty" title="Thank You.">
					<span class="span4 textcenter">
						We will get back to you in <strong id="hours">5</strong> hours or <strong id="days">6</strong> days once we confirmed your payment.
					</span>
				</div>
