         
              <div class="accordion row-fluid chooseplan clearfix" id="accordion2">  
             
				<?php
				    if($current_controller != 'home' && ($current_step < 5) ){
						include(ESTATE_THEME_BASEPATH.'/sections/sidebar_panel.php');
					}
				?>
                
                <div class="span9">
                    <div class="accordion2 account-content active" id="accordion3">
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse4">
                              ORDER TYPE <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
                          <div id="collapse4" class="accordion-body collapse" style="height: <?php echo ($_GET['ordertype'] == 'renew'|| isset($_GET['plantype'])) ? '0' : 'auto' ?>;">
                            <div class="accordion-inner">
								
								<?php 
								$subscriber_flag = ""; // jason 092913
                                if(isset($_GET['subscriber_flag'])){
                                    $subscriber_flag = "&subscriber_flag=" . $_GET['subscriber_flag'];
                                }
                                if( isset($_GET['ordertype']) && $_GET['ordertype'] == 'newline' ){
                                
                                    //GET NEWLINE
                                    //IMPLEMENTED: MANAGE - PLATINUM ACCOUNT
                                    //TODO: BUSINESS - 
                                    include('page_ordertype_newline.php'); 

								
								}else if( isset($_GET['ordertype']) && $_GET['ordertype'] == 'reset' ){
								
									include('page_ordertype_reset.php'); 
								
								}else{	
								
								?>
								
								<div class="row-fluid">
                                	<div class="ac-box-plan">
                                        <div class="span4 ac-boxes g-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/retain-current-plan.png" />
                                            <span>Renew Contract</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>
                                            <button class="blue-btn" onclick="window.location='<?php echo base_url() ?>plan?setOrderConfig=true&ordertype=renew'">Click here!</button>
                                        </div>
                                        <div class="span4 ac-boxes o-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/get-a-new-line.png" />
                                            <span>Get A New Line</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>  
                                            <button class="blue-btn" onclick="window.location='<?php echo base_url() ?>plan?setOrderConfig=true&ordertype=newline<?php echo $subscriber_flag; ?>'">Click here!</button>
                                        </div>
                                        <div class="span4 ac-boxes r-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/reset.png" />
                                            <span>Reset</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>                                    
                                            <button class="blue-btn" onclick="window.location='<?php echo base_url() ?>plan?setOrderConfig=true&ordertype=reset'">Click here!</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php } ?>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse5">SELECT PLAN <i class="tcoll collapse-toggle"></i></a>
                          </div>
                          <div id="collapse5" class="accordion-body in collapse" style="height: <?php echo ($_GET['ordertype'] == 'renew' || isset($_GET['plantype'])) ? 'auto' : '0' ?>; ">

									<?php 
										
										if( isset($_GET['plantype']) && $_GET['plantype'] == 'create' ){
											include('page_plan_create.php'); 
											
										}else if( isset($_GET['plantype']) && $_GET['plantype'] == 'package' ){
											include('page_plan_package.php'); 
										}else{
											//default
											include('page_plan_retain.php'); 
										}		
									 ?>

                          </div>
                        </div>
                    </div>
                    <div class="row-fluid link-bottom">
                        <a class="pull-left">Get A Prepaid Kit</a>
                        <div class="pull-right">
                        	<button class="blue-btn" onclick="window.location.href='<?php echo base_url() ?>addons'">Continue</button>
                        	<br class="clear" />
                        	<br />
                            <ul class="">
                                <li><a>Contact Us</a></li>
                                <li>|</li>
                                <li><a>Live Chat</a></li>
                            </ul> 
                        </div>

                    </div>                             
                </div>
            
            </div>






