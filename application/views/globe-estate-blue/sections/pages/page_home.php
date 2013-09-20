

			    <?php include('partials/sku_configuration.php'); ?>

			   
			   
			    <?php
			    
			    
			     /*if($current_method == 'sms_verification'){ ?>
			    
                
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
	            </div>	*/ ?>
	            
			



