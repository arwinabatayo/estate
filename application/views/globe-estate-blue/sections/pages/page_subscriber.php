			
         
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
														<input type="radio" name="sns_id" value="facebook" />
														<label for="Facebook">Facebook</label>
													</li>
													<li>
														<input type="radio" name="sns_id" value="facebook"/>
														<label for="Twitter">Twitter</label>
													</li>
													<li>
														<input type="radio" name="sns_id" value="facebook" />
														<label for="Linkedln">Linkedln</label>
													</li>
												</ul>
											</div>
											
											<div class="clr"></div>
										</div>
										
										<hr/>
										
										<p class="pad-space"><strong>OTHER CONTACT NUMBER</strong></p>
										
										<div class="pad-space">
											<div class="span6">
												<label for="Mobile Number">Mobile Number </label>
												<input type="text" name="" class="span10"  id=""/>
											</div>
											
											<div class="span6">
												<label for="Landline Number">Landline Number</label>
												<input type="text" name="" class="span10" id=""/>
											</div>
											
											<div class="clr"></div>
										</div>
										
										<hr/>
										<p class="textcenter">
										<button class="blue-btn" onclick="window.location='<?php echo base_url() ?>plan-summary'">Continue</button> 
										</p>
									</form>
									<br />
								</div> 
						</div>
                          
                </div>
            
            </div>
			

		
		
		
		
		
		
