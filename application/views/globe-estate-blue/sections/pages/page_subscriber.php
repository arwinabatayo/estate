			
         
              <div class="accordion row-fluid chooseplan clearfix" id="accordion2">  
             
				<?php
				    if($current_controller != 'home' && ($current_step < 5) ){
						include(ESTATE_THEME_BASEPATH.'/sections/sidebar_panel.php');
					}
				?>
                
                <div class="span9">
                	<?php if(!isset($_GET['subscriber_flag'])){ ?>
                    <div class="accordion2 account-content active" id="accordion3">
                        
	                        <h3><a href="#">Personal Information</a></h3>
	                        <div>
							   <div class="well textleft">
									<h4 style="font-size:24px;font-weight:normal">Quisque Laoreet Vulputate Dui</h4>
									<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>
							   </div>
							   
							 <form id="personal-info" onsubmit="return false">
								   
									<div>	
										<div class="fleft" style="padding-top:20px;">
							                Email : smoraga@live.com
							            </div>
							            <div style="float: right;">
							                <label>Social Network User ID</label>
							                <span><input type="text" style="width:260px;"/></span>
							                <br>
							                <span>
							                     <input name="sns_id" value="facebook" type="radio" checked="checked"> Facebook
							                     <input name="sns_id" value="twitter" type="radio"> Twitter
							                     <input name="sns_id" value="linkedin" type="radio"> LinkedIn
							                </span>
							            </div>
							        </div>
						            
						            <br class="clear">
						            
						            <div>
						                <label>Other Contact Number</label>
						                <br>
						                <div class="fleft">
						                    <label>Mobile Number</label>
						                    <span><input type="text" class="inputbox" style="width:260px;"/></span>
						                </div>
						                <div class="fright">
						                    <label>Landline Number</label>
						                    <span><input type="text" style="width:260px;"/></span>
						                </div>
						            </div>
						            <br class="clear">
						            <br />	
						            
						            <div>
						                <span class="fleft" style="margin-right: 30px;">
						                    <label>Area Code</label>
						                    <input type="text" style="width:100px;"/>
						                </span>
						                <span class="fleft" style="margin-right: 30px;">
						                    <label>Mobile Number</label>
						                    <input type="text" style="width:300px;"/>
						                </span>
						                <span class="fleft" >
						                    <label>Network Carrier</label>
						                    <select style="width:300px;">
												<option name="">Smart Postpoid</option>
												<option name="">Globe</option>
						                    </select>
						                </span>
									</div>
									<br class="clear">
									
								<br />	
							   <p class="textright"><button class="blue-btn">CONTINUE</button></p>
	                       
	                       
	                    </div>

                        
                    
                    </div>

                    <?php }else{ ?>

                    	<div class="accordion2 account-content" id="accordion3">
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="http://n-cubator.com/staging-estate/dev/newpsdhtml/aldrin/9.28.2013/06%20GET%20A%20NEW%20LINE%20(12-billing_info).html#collapse4">
                              Personal Information <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
                          <div id="collapse4" class="accordion-body in collapse" style="height: auto;">
                            <div class="accordion-inner personal-info">
								<!--New Content-->
								<p class="pad-space">Lorem ipsum&nbsp;dolor sit amet, consectuer adipiscing elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi. Duis ut matiis ligula.</p>
                            
								<!--<form action="" method="post">-->
									<div class="pad-space">
										<div class="span4">
											<p>First Name </p>
											<input type="text" name="fname" id="fname" class="span10 input-block-level">
										</div>
										
										<div class="span4">
											<p>Last Name </p>
											<input type="text" name="lname" id="lname" class="span10 input-block-level">
										</div>
										
										<div class="span4">
											<p>Middle Name </p>
											<input type="text" name="mname" id="mname" class="span10 input-block-level">
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<div class="pad-space">
										<div class="span4 radio-btn">
											<ul>
												<li>
													<div class="iradio_flat-blue"><input tabindex="13" type="radio" id="flat-radio-1" name="gender" style="position: absolute; opacity: 0;" value="male"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
													<label for="Business">Male</label>
												</li>
												<li>
													<div class="iradio_flat-blue"><input tabindex="14" type="radio" id="flat-radio-1" name="gender" style="position: absolute; opacity: 0;" value="female"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
													<label for="Personal">Female</label>
												</li>
											</ul>
										</div>
										
										<div class="span4">
											<label for="">Birthday *</label>
											<input type="text" class="datepicker input-block-level span10 hasDatepicker" id="dp1380512124937" name="bday">
										</div>
										
										<div class="span3">
											<label for="Civil Status">Civil Status *</label>
											<select name="civil_status" id="civil_status" class="civil span10" data-style="btn-primary">
												<option value="single">Single</option>
												<option value="married">Married</option>
												<option value="separated">Separated</option>
												<option value="widowed">Widowed</option>
											</select>
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<p class="pad-space"><strong>MOTHER’S FULL MAIDEN NAME</strong></p>
									
									<div class="pad-space">
										
										<div class="span4">
											<p>First Name *</p>
											<input type="text" name="mfname" id="mfname" class="span10 input-block-level">
										</div>
										
										<div class="span4">
											<p>Last Name *</p>
											<input type="text" name="mlname" id="mlname" class="span10 input-block-level">
										</div>
										
										<div class="span4">
											<p>Middle Name *</p>
											<input type="text" name="mmname" id="mmname" class="span10 input-block-level">
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<div class="pad-space">
										<div class="span4">
											<label for="citizenship Status">Citizenship</label>
											<select name="citizenship" id="" class="span10 citizenship" data-style="btn-primary">
												<option value="filipino">Filipino</option>
												<option value="japanese">Japanese</option>
											</select>
										</div>
										
										<div class="span4">
											<label for="Government ID Number">Government ID Number *</label>
											<input type="text" name="government_id" id="government_id" class="input-block-level">
											
											<div class="radio-btn">
												<ul>
													<li>
														<div class="iradio_flat-blue"><input tabindex="15" type="radio" id="flat-radio-1" name="government_id_type" style="position: absolute; opacity: 0;" value="tin"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
														<label for="Business">TIN</label>
													</li>
													<li>
														<div class="iradio_flat-blue"><input tabindex="16" type="radio" id="flat-radio-1" name="government_id_type" style="position: absolute; opacity: 0;" value="sss"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
														<label for="Personal">SSS</label>
													</li>
													<li>
														<div class="iradio_flat-blue"><input tabindex="17" type="radio" id="flat-radio-1" name="government_id_type" style="position: absolute; opacity: 0;" value="gsis"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background-color: rgb(255, 255, 255); border: 0px; opacity: 0; background-position: initial initial; background-repeat: initial initial;"></ins></div>
														<label for="Personal">GSIS</label>
													</li>
												</ul>
											</div>
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<div class="pad-space">
										<div class="span4">
											<label for="Email address">Email address</label>
											<p><strong>avargosino@gmail.com</strong></p>
										</div>
										
										<div class="span4">
											<label for="Phone">Phone</label>
											<p><strong>09079998877</strong></p>
										</div>
										
										<div class="span3">
											<label for="Network Carrier">Network Carrier</label>
											
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
											<input type="text" name="" id="" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="Building Name / Street">Building Name / Street  *</label>
											<input type="text" name="" id="" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="Subdivision / Barangay">Subdivision / Barangay *</label>
											<input type="text" name="" id="" class="input-block-level">
										</div>
									</div>
									
									<div class="pad-space">
										<div class="span4">
											<label for="Municipality / Town">Municipality / Town*</label>
											<input type="text" name="" id="" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="City / Province">City / Province *</label>
											<select name="id_select" class="city span12" data-style="btn-primary" style="display: none;">
												<option value="">Select</option>
												<option value="">City One</option>
												<option value="">City Two</option>
											</select><div class="btn-group bootstrap-select city span12"><button type="button" class="btn dropdown-toggle btn-primary" data-toggle="dropdown" data-id=""><div class="filter-option pull-left">Select</div>&nbsp;<div class="caret"></div></button><div class="dropdown-menu open"><ul class="dropdown-menu inner" role="menu"><li rel="0" class="selected"><a tabindex="0" class="" style=""><span class="text">Select</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li><li rel="1"><a tabindex="0" class="" style=""><span class="text">City One</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li><li rel="2"><a tabindex="0" class="" style=""><span class="text">City Two</span><i class="glyphicon glyphicon-ok icon-ok check-mark"></i></a></li></ul></div></div>
										</div>
										
										<div class="span4">
											<label for="Postal Code / Zip Code">Postal Code / Zip Code *</label>
											<input type="text" name="" id="" class="input-block-level">
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<p class="b-title pad-space"><strong>OTHER CONTACT NUMBER</strong></p>
									
									<div class="pad-space">
										<div class="span4">
											<label for="Mobile Number">Mobile Number *</label>
											<input type="text" name="" id="" class="input-block-level">
										</div>
										
										<div class="span4">
											<label for="Landline Number">Landline Number</label>
											<input type="text" name="" id="" class="input-block-level">
										</div>
									</div>
									
									<div class="clr"></div>
									
									<hr>
									
									<input type="submit" name="" value="Continue" id="btnSubmitBillingPersonalInfo" class="blue-btn">
                            </div>
                          </div>
                        </div>
                    </div>

                    <?php } ?>

                          
                </div>
            
            </div>
			

		
		
		
		
		
		
