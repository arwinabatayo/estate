         
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

                                if( isset($_GET['ordertype']) && $_GET['ordertype'] == 'newline' || !empty($subscriber_flag)){
                                
                                    //GET NEWLINE
                                    //IMPLEMENTED: MANAGE - PLATINUM ACCOUNT
                                    //TODO: BUSINESS - 
                                    include('page_ordertype_newline.php'); 

								
								}else if( isset($_GET['ordertype']) && $_GET['ordertype'] == 'reset' ){
								
									include('page_ordertype_reset.php'); 
								
								}else{	
								
								?>
								
                                <?php if(empty($subscriber_flag)){ ?>
								<div class="row-fluid">
                                	<div class="ac-box-plan">
                                        <div class="span4 ac-boxes g-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/retain-current-plan.png" />
                                            <span>Renew Contract</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>
                                            <?php if($user_category==4||$user_category==5&&!$ENTIN_switch||$user_category==2&&!$SMBRE_switch){ // Lawrence 10-02-2013?>                                            
                                            <button class="blue-btn" id="biz_renew_button">Click here!</button>
                                            <?php }else{?>
                                            <button class="blue-btn" onclick="window.location='<?php echo base_url() ?>plan?setOrderConfig=true&ordertype=renew'">Click here!</button>
 											<?php }?>
                                        </div>
                                        <div class="span4 ac-boxes o-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/get-a-new-line.png" />
                                            <span>Get additional Line</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>  
                                            <button class="blue-btn" onclick="window.location='<?php echo base_url() ?>plan?setOrderConfig=true&ordertype=newline<?=!$biz_line_flag?'&plantype=create':''?>'">Click here!</button>
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
                                
                                <?php } ?>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse5" id="select-plan-order-type">SELECT PLAN <i class="tcoll collapse-toggle"></i></a>
                          </div>
                          <div id="collapse5" class="accordion-body in collapse" style="height: <?php echo ($_GET['ordertype'] == 'renew' || isset($_GET['plantype'])) ? 'auto' : '0' ?>; ">

									<?php 
									
										$changeBtnId = 'retain';
										$display = "display:none;";
										if( isset($_GET['plantype']) && $_GET['plantype'] == 'create' ) {
											if(isset($_GET['bundles'])) {
												switch ($_GET['bundles']) {
													case "combos": include('page_plan_create_combos.php'); 
																$changeBtnId="combos";
																$gobackBtnId ="backPlans";
																$display = "";
																$goto = "&plantype=".$_GET['plantype'].$subscriber_flag;
													break;
													case "boosters": include('page_plan_create_boosters.php'); 
																$changeBtnId="boosters"; 
																$gobackBtnId ="backCombos";
																$display = "";
																$goto = "&plantype=".$_GET['plantype']."&bundles=combos".$subscriber_flag;
													break;
												}
											} else {
												include('page_plan_create.php');
												$changeBtnId = $_GET['plantype'];
											}
										}else if( isset($_GET['plantype']) && $_GET['plantype'] == 'package' ){
											
											include('page_plan_package.php');
											$changeBtnId = $_GET['plantype'];
											
										}else if( isset($_GET['plantype']) && $_GET['plantype'] == 'retain' ){

											include('page_plan_retain.php'); 
											
										}else{
											//default - CHOOSE YOUR PLAN
											include('page_plan_choose.php'); 
										}	

									 ?>

                          </div>
                        </div>
                    </div>
                    <div class="row-fluid link-bottom">
                        <a data-placement="top" id="get-prepaid" class="pull-left" data-original-title="" title="">Get A Prepaid Kit</a>
                        <div class="pull-right">
                        	<!-- Updated by Robert 92913 -->
                        	<!-- button class="blue-btn" onclick="window.location.href='<?php echo base_url() ?>addons'" id="<?php echo $changeBtnId; ?>">Continue</button-->
                            <input type="hidden" id="subs_flag" value="<?php echo $subscriber_flag; ?>">
                        	<button class="blue-btn" id="<?php echo $gobackBtnId; ?>" data-goto="<?php echo $goto; ?>" style="<?php echo $display; ?>">Go Back</button>
                        	<button class="blue-btn" id="<?php echo $changeBtnId; ?>">Continue</button>
                        	<br class="clear" />

                        </div>

                    </div>                             
                </div>
            
            </div>






