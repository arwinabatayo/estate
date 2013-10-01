	     <div class="span9">
                    <div class="accordion2 account-content" id="accordion3">
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse4">
                              Company Information <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
                          <div id="collapse4" class="accordion-body collapse" style="height: 0; ">
                            <div class="accordion-inner company-information">
								<div class="row-fluid">
                                	<div class="pad-space">
										<!--Content-->
										<h2>Aenean a massa</h2>
										
										<p>Lorem ipsum dolor sit amet, consectetur adpiscing elit Cros justo nulla, commodo nec mauris ut, interdum adipiscing nisi. Duis ut mattis ligula. Suspendisse a dolor eu.</p><br />
										
										<form method="post" action="/estate_new/subscriber/saveCompanyPersonalInfo?info_type=company">
											<label for="Company Name">Company Name</label>
											<input type="text" name="name" id="name" class="input-block-level"/><br /><br />
										
											<p><strong>Registered Business Address</strong></p><br />
											
											<div class="span4">
												<label for="Unit Floor">Unit Floor</label>
												<input type="text" name="unit" id="unit" class="span11"/>
											</div>
											
											<div class="span4">
												<label for="Unit Floor">Building Name/Street No.</label>
												<input type="text" name="building_name" id="building_name" class="span11"/>
											</div>
											
											<div class="span4">
												<label for="Unit Floor">Street Name</label>
												<input type="text" name="street" id="street" class="span12"/>
											</div>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="">Barangay</label>
												<input type="text" name="barangay" id="barangay" class="span11"/>
											</div>
											
											<div class="span6">
												<label for="">Municipality/Town</label>
												<input type="text" name="municipality" id="municipality" class="span12"/>
											</div>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="City/Province">City/Province</label>
												<select name="city" id="city" class="city span11">
													<option value="">- SELECT -</option>
													<option value="">City I</option>
													<option value="">City II</option>
													<option value="">City III</option>
												</select>
											</div>
											
											<div class="span6">
												<label for="Postal Code/Zip Code">Postal Code/Zip Code</label>
												<input type="text" name="postal" id="postal" class="span12"/>
											</div>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="Industry">Industry</label>
												<select name="industry" id="industry"  class="industry span11">
													<option value="">- SELECT -</option>
													<option value="">Industry I</option>
													<option value="">Industry II</option>
													<option value="">Industry III</option>
												</select>
											</div>
											
											<div class="clr"></div><br />
											
											<p><strong>Authorized Corporate / Officer Signatory 1 (Signatory 2 is also required; same field required)</strong></p><br />
											
											<div class="span6">
												<label for="">Position in Company</label>
												<input type="text" name="position_1" id="position_1" class="span11"/>
											</div>
											
											<div class="span6">
												<label for="">Email Address</label>
												<input type="text" name="email_1" id="email_1"  class="span12"/>
											</div>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="Contact Number">Contact Number</label>
												<input type="text" name="contact_1" id="contact_1"  class="span11"/>
											</div>
											
											<div class="span6">
												<label for="Authorized Corporate / Officer">Authorized Corporate / Officer</label>
												<input type="text" name="authorized_1" id="authorized_1"  class="span12"/>
											</div>
											
											<div class="clr"></div><br />
											
											<p><strong>After-Sales Corporate Signatory 1 (Signatory 2 is also required; same field required)</strong></p><br />
											
											<div class="span6">
												<label for="Position in Company">Position in Company</label>
												<input type="text" name="position_2" id="position_2" class="span11"/>
											</div>
											
											<div class="span6">
												<label for="Position in Company">Email Address</label>
												<input type="text" name="email_2" id="email_2" class="span12"/>
											</div>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="Position in Company">Contact Number</label>
												<input type="text" name="contact_2" id="contact_2" class="span11"/>
											</div>
											
											<div class="clr"></div>
											
											<p><strong>VAT Tax Exemption</strong></p><br />
											
											<div class="span3">
												<label for="Tax">Tax</label>
												<ul class="radio-btn">
													<li>
														<input type="radio" name="vat" id="vat" value="1"/>
														Yes
													</li>
													<li>
														<input type="radio" name="vat" id="vat" value="0"/>
														No
													</li>
												</ul>
												
												<div class="clr"></div>
											</div>
											
											<div class="span6">
												<label for="Attach BIR Certificate/Sample Account No.">Attach BIR Certificate/Sample Account No.</label>
												
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input span5"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Attach</span><span class="fileupload-exists">Change</span><input type="file" class="" name="file_data"/></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
													</div>
												</div>
											</div>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="OCT">OCT</label>
												<ul class="radio-btn">
													<li class="fl">
														<input type="radio" name="oct" id="oct" value="1"/>
														<label for="Yes">Yes</label>
													</li>
													<li class="fl">
														<input type="radio" name="oct" id="oct" value="0"/>
														<label for="No">No</label>
													</li>
												</ul>
												
												<div class="clr"></div>
											</div>
											
											<div class="clr"></div>
											<input type="hidden" name="from_page" value="<?php echo $this->uri->uri_string() . '?billing=true'; ?>">
											<input type="submit" value="Continue" class="blue-btn"/>
										</form>
									</div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse5">
                              Billing Instructions <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
                          <div id="collapse5" class="accordion-body in collapse" style="height: auto; ">
                            <div class="accordion-inner bill-instructions last-border">
								<div class="row-fluid">
										<p><strong>Detailed Billing Statement</strong></p>
										
										<label for="How would you like to receive the billing statement?">How would you like to receive the billing statement?</label>
										
										<div class="span6 radio-btn">
											<input type="radio" name="detailed_billing_type" value="soft"/>
											<label for="Soft Copy, email to this address" style="margin-left:10px;">Soft Copy, email to this address</label>
										</div>
										
										<div class="clr"></div>
										
										<div id="soft_copy" style="margin-left:25px; display:block;">
											<label for="Email">Email</label>
											<input type="text" name="detailed_billing_email" id="detailed_billing_email"/>
										</div><br />
										
										<div class="clr"></div>
										
										<div class="span7 radio-btn">
											<input type="radio" name="detailed_billing_type" id="" value="hard" />
											<label for="Hard Copy, send to this preferred billing address" class="fl" style="margin-left:25px;">Hard Copy, send to this preferred billing address</label>
										
											<div class="clr"></div>
										</div>
										
											<div class="clr"></div>	
											
										<div class="hard-copy-details" id="hard_copy" style="display:none;">
											<div class="span4">
												<label for="First Name">First Name</label>
												<input type="text" name="fname" id="fname" class="span12"/>
											</div>
											
											<div class="span4">
												<label for="Last Name">Last Name</label>
												<input type="text" name="lname" id="lname" class="span12"/>
											</div>
											
											<div class="span4">
												<label for="Department">Department</label>
												<input type="text" name="department" id="department" class="span12"/>
											</div>
											
											<div class="clr"></div>
											
											<label for="Address">Address</label>
											<input type="text" name="address" id="address" class="input-block-level"/>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="Barangay">Barangay</label>
												<input type="text" name="barangay" id="barangay" class="span11"/>
											</div>
											
											<div class="span6">
												<label for="Barangay">Municipality/Town</label>
												<input type="text" name="municipality" id="municipality" class="span13"/>
											</div>
											
											<div class="clr"></div>
											
											<div class="span6">
												<label for="Barangay">City/Province</label>
												<input type="text" name="city" id="city" class="span11"/>
											</div>
											
											<div class="span6">
												<label for="Barangay">Postal Code/Zip Code</label>
												<input type="text" name="postal" id="postal" class="span13"/>
											</div>
										</div>
										
										<div class="clr"></div>
										
										<br /><br /><br /><p><strong>Bill Summary</strong></p>
										<label for="Would you like to receive a bill summary">Would you like to receive a bill summary</label>
										
										<ul class="radio-btn2">
											<li class="fl">
												<input type="radio" name="bill_summary_flag" id="" value="1"/>
												<label for="Yes">Yes</label>
											</li>
											<li class="fl">
												<input type="radio" name="bill_summary_flag" id="" value="0"/>
												<label for="Yes">No</label>
											</li>
										</ul>
										
										<div class="clr"></div><br /><br />
										
										<div id="choice-bill" style="display:none;">
											<label for="How you would like the bill summary">How you would like the bill summary</label>
											
											<div class="span5 radio-btn3" >
												<input type="radio" name="bill_summary_type" id="bill_summary_type" value="soft"/>
												<label for="Soft Copy, email to address">Soft Copy, email to address</label>
											</div>
											
											
											<div class="span7 radio-btn3">
												<input type="radio" name="bill_summary_type" id="bill_summary_type" value="0"/>
												<label for="Hard Copy, send to this preferred billing address">Hard Copy, send to this preferred billing address</label>
											</div>
											
											<div class="clr"></div><br />
											
											<div id="bill_softcopy" class="span16" style="display:block;">
												<label for="Email">Email</label>
												<input type="text" name="" id="" class="span5"/>
											</div>
											
											<div id="bill_hardcopy" style="display:none;">
												<div class="span4">
													<label for="First Name">First Name</label>
													<input type="text" name="bfname" id="bfname" class="span12"/>
												</div>
												
												<div class="span4">
													<label for="Last Name">Last Name</label>
													<input type="text" name="blname" id="blname" class="span12"/>
												</div>
												
												<div class="span4">
													<label for="Department">Department</label>
													<input type="text" name="bdepartment" id="bdepartment" class="span12"/>
												</div>
												
												<div class="clr"></div>
												
												<label for="Address">Address</label>
												<input type="text" name="baddress" id="baddress" class="input-block-level"/>
												
												<div class="clr"></div>
												
												<div class="span6">
													<label for="Barangay">Barangay</label>
													<input type="text" name="bbarangay" id="bbarangay" class="span11"/>
												</div>
												
												<div class="span6">
													<label for="Barangay">Municipality/Town</label>
													<input type="text" name="bmunicipality" id="bmunicipality" class="span13"/>
												</div>
												
												<div class="clr"></div>
												
												<div class="span6">
													<label for="Barangay">City/Province</label>
													<input type="text" name="bcity" id="bcity" class="span11"/>
												</div>
												
												<div class="span6">
													<label for="Barangay">Postal Code/Zip Code</label>
													<input type="text" name="bpostal" id="bpostal" class="span13"/>
												</div>
											</div>
										</div>
										
										<div class="clr"></div><br /><br />
										
										<button id="btnSubmitCompanyBillingInfo" class="blue-btn">
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="row-fluid link-bottom">
                        <a class="pull-left">Get A Prepaid Kit</a>
                        <ul class="pull-right">
                            <li><a>Contact Us</a></li>
                            <li>|</li>
                            <li><a>Live Chat</a></li>
                        </ul>
                    </div>                             
                </div>

	                    