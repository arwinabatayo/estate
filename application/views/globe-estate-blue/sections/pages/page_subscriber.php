			
         
              <div class="accordion row-fluid chooseplan clearfix" id="accordion2">  
             
				<?php
				    if($current_controller != 'home' && ($current_step < 5) ){
						include(ESTATE_THEME_BASEPATH.'/sections/sidebar_panel.php');
					}
				?>
        
                <div class="span9">
                 <div class="accordion2 account-content" id="accordion3">
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle collapsed bold" style="text-decoration:none;font-weight:bold">
                              PERSONAL INFORMATION
                            </a>
                          </div>

                           <div id="collapse4" class="accordion-body collapse" style="background:#ebebeb;height:auto">
								<div class="accordion-inner personal-info-09">
									<h2 class="pad-space"><?php echo $account_info->fullname ?></h2>
									
									<hr/>
									
									<p class="pad-space">Lorem ipsum dolor sit amet, consectuer adipiscing elit. Cras justo nulla, commodo nec mauris ut,  interdum adipiscing  nisi. Duis ut matiis ligula.</p><br />
									
									<form id="personal-info" onsubmit="return false">
										<div class="pad-space">
											<div class="span6">
												<label for="">Email address</label>
													<span><strong><?php echo $account_info->email ?></strong></span>
											</div>
											
											<div class="span6">
												<label for="Social Network Username ">Social Network Username </label>
												<span><input type="text" name="" class="span10" id=""/></span>
												
												<ul class="social-btn">
													<li>
														<span class="radio-btn"><input type="radio" name="sns_id" value="facebook" /></span>
														<label for="Facebook">Facebook</label>
													</li>
													<li>
														<span class="radio-btn"><input type="radio" name="sns_id" value="facebook"/></span>
														<label for="Twitter">Twitter</label>
													</li>
													<li>
														<span class="radio-btn"><input type="radio" name="sns_id" value="facebook" /></span>
														<label for="Linkedln">Linkedln</label>
													</li>
												</ul>
											</div>
											

											<select name="network_carrier" id="" class="span12 network-carrier" data-style="btn-primary">
												<option value="smart postpaid">Smart Postpaid</option>
												<option value="">Smart Postpaid II</option>
											</select>
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<div class="span6">
										<label for="Social Network Username">Social Network Username *</label>
										<input type="text" name="" class="span17" id="">
										
										<div class="radio-btn">
											<ul>
												<li>
													<div class="iradio_flat-blue"><input tabindex="15" type="radio" id="flat-radio-1" name="flat-radio" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
													<label for="Business">Facebook</label>
												</li>
												<li>
													<div class="iradio_flat-blue"><input tabindex="16" type="radio" id="flat-radio-1" name="flat-radio" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
													<label for="Personal">Twitter</label>
												</li>
												<li>
													<div class="iradio_flat-blue"><input tabindex="17" type="radio" id="flat-radio-1" name="flat-radio" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
													<label for="Personal">Linkedln</label>
												</li>
											</ul>
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<input type="submit" class="blue-btn" id="btnSubmitPersonalInfo" value="Continue">
								<!--</form>-->
                            </div>
                          </div>
                        </div>
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="http://n-cubator.com/staging-estate/dev/newpsdhtml/aldrin/9.28.2013/06%20GET%20A%20NEW%20LINE%20(12-billing_info).html#collapse5" id="billing-info-personal-btn">
                              Billing information <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
                          <div id="collapse5" class="accordion-body collapse" style="height: 0px;">
                            <div class="accordion-inner billing">
								<h4 class="pad-space">Suspendisse a dolor</h4>
							
									<p>Lorem ipsum&nbsp;dolor sit amet, consectuer adipiscing elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi. Duis ut matiis ligula.</p>
									
									<hr>
									
									<p class="b-title"><strong>Complete Home Address</strong></p>
									
									<div class="pad-space">
										<div class="span4">
											<label for="Room / Floor / House No.">Room / Floor / House No. *</label>
											<input type="text" name="house_no" id="house_no" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="Building Name / Street">Building Name / Street  *</label>
											<input type="text" name="street" id="street" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="Subdivision / Barangay">Subdivision / Barangay *</label>
											<input type="text" name="barangay" id="barangay" class="input-block-level">
										</div>
									</div>
									
									<div class="pad-space">
										<div class="span4">
											<label for="Municipality / Town">Municipality / Town*</label>
											<input type="text" name="municipality" id="municipality" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="City / Province">City / Province *</label>
											<select name="province" class="city span12" data-style="btn-primary" style="display: none;" id="province">
												<option value="">Select</option>
												<option value="">City One</option>
												<option value="">City Two</option>
											</select><div class="btn-group bootstrap-select city span12"><button type="button" class="btn dropdown-toggle btn-primary" data-toggle="dropdown" data-id=""><div class="filter-option pull-left">Select</div>&nbsp;<div class="caret"></div></button><div class="dropdown-menu open"><ul class="dropdown-menu inner" role="menu"><li rel="0" class="selected"><a tabindex="0" class="" style=""><span class="text">Select</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li><li rel="1"><a tabindex="0" class="" style=""><span class="text">City One</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li><li rel="2"><a tabindex="0" class="" style=""><span class="text">City Two</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li></ul></div></div>
										</div>
										
										<div class="span4">
											<label for="Postal Code / Zip Code">Postal Code / Zip Code *</label>
											<input type="text" name="postal_code" id="postal_code" class="input-block-level">
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<p class="b-title pad-space"><strong>OTHER CONTACT NUMBER</strong></p>
									
									<div class="pad-space">
										<div class="span4">
											<label for="Mobile Number">Mobile Number *</label>
											<input type="text" name="mobile_number" id="mobile_number" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="Landline Number">Landline Number</label>
											<input type="text" name="landline_number" id="landline_number" class="input-block-level">
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<input type="submit" name="" value="Continue" id="btnSubmitBillingPersonalInfo" class="blue-btn">
                            </div>
                          </div>
                        </div>
                    </div>

                          
                </div>
            
            </div>
			

		
		
		
		
		
		
