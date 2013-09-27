         
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
                          <div id="collapse4" class="accordion-body collapse" style="height: <?php echo $_GET['val'] == 'renew' ? '0' : 'auto' ?>;">
                            <div class="accordion-inner">
								
								<?php 
								
								if( isset($_GET['val']) && $_GET['val'] == 'newline' ){
								
									//GET NEWLINE
									//IMPLEMENTED: MANAGE - PLATINUM ACCOUNT
									//TODO: BUSINESS - 
									include('page_plan_newline.php'); 
								
								}else if( isset($_GET['val']) && $_GET['val'] == 'reset' ){
								
									include('page_plan_reset.php'); 
								
								}else{	
								
								?>
								
								<div class="row-fluid">
                                	<div class="ac-box-plan">
                                        <div class="span4 ac-boxes g-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/retain-current-plan.png" />
                                            <span>Renew Contract</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>
                                            <button class="blue-btn" onclick="window.location.href='<?php echo base_url() ?>plan?setOrderConfig=true&key=ordertype&val=renew'">Click here!</button>
                                        </div>
                                        <div class="span4 ac-boxes o-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/get-a-new-line.png" />
                                            <span>Get A New Line</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>  
                                            <button class="blue-btn" onclick="window.location.href='<?php echo base_url() ?>plan?setOrderConfig=true&key=ordertype&val=newline'">Click here!</button>
                                        </div>
                                        <div class="span4 ac-boxes r-content">
                                            <img src="<?php echo $assets_url ?>site-blue/images/reset.png" />
                                            <span>Reset</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>                                    
                                            <button class="blue-btn" onclick="window.location.href='<?php echo base_url() ?>plan?setOrderConfig=true&key=ordertype&val=reset'">Click here!</button>
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
                          <div id="collapse5" class="accordion-body in collapse" style="height: <?php echo $_GET['val'] == 'renew' ? 'auto' : '0' ?>; ">
                            <div class="accordion-inner last-border">
								<div class="row-fluid tabbed">
                                    <div class="tabbable package-plan">
                                        <ul class="nav nav-tabs">
                                            <li><a href="#tab1" data-toggle="tab" class="ret-curr"><span><i class="icon-retcurr"><img src="images/icon-retaincurr.png" /></i>Retain Current Plan</span></a></li>
                                            <li class="active"><a href="#tab2" data-toggle="tab" class="pack-plan"><span><i class="icon-packplan"><img src="images/icon-packplan.png" /></i>Package Plan</span></a></li>
                                            <li><a href="#tab3" data-toggle="tab" class="create-own"><span><i class="icon-createown"><img src="images/icon-createown.png" /></i>Create Your Own</span></a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane" id="tab1">
                                                <div class="tab-cont">here goes your content</div>
                                            </div>
                                            <div class="tab-pane active" id="tab2">
                                                <div class="tab-cont">
                                                    <div class="tab-title">Package Plan</div>
                                                    <p class="tab-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                                                    <div class="main" style="width:100%;">
                                        <ul id="og-grid" class="og-grid">
                                            <li>
                                                <a href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "
                                                data-description="CASHOUT P500.00">
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">PLAN 299</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 500 PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "                                               
                                                data-description="CASHOUT P900.00" >
                                                    <div class="plan-tile-option-pink ">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">PLAN 499</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 900 PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a  href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "
                                                data-description="CASHOUT P1,700.00">
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">PLAN 999</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 1700 PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <a  href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "
                                                data-description="CASHOUT P3,200.00">
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">PLAN 1799</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 3200 PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a  href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "
                                                data-description="CASHOUT P12,500.00">
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">PLAN 2499</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 4400 PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </a>
                                            </li>
                                            <li>
                                                <a  href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "                                               
                                                data-description="CASHOUT P6,500.00">

                                                    <div class="plan-tile-option-pink plan-info-height">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">PLAN 3799</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 6500 PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </a>
                                            </li>
                                            <li>
                                                <a  href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "
                                                data-description="CASHOUT P200.00">
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">UNLI PLAN</div>
                                                            <div class="">Pick and mix Boosters<br />of your choice</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 200 PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a  href="#" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span>Unlitext 30days</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span>Free 20mins</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span>100 hrs/month</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span>2hrs free call</span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        " 
                                                    data-description="CASHOUT P200.00">
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name">FAMILY PLAN</div>
                                                            <div class="">Group 3 up to 11<br />Unli Plans</div>
                                                            <div class="">get <i class="icon icon-coins"></i> 200 PV/mo.</div>
                                                            <div class="plan-off"><b>P100 OFF</b> per unli plan</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                                    <!--<ul class="thumbnails">
                                                        <li class="span4"><a class="thumbnail"><img src="images/plan-299.png" alt="Plan 299" /><span>Plan 299</span></a></li>
                                                        <li class="span4">
                                                        	<a id="plan499" class="thumbnail"><img src="images/plan-499.png" alt="Plan 499"/><span>Plan 499</span></a>
                                                            <ul id="plan499-content" style="display:none">
                                                            	<li><span class="plan-cont">TEXT<span>Unlitext 30days</span></span></li>
                                                            	<li><span class="plan-cont">CALL<span>Free 20mins</span></span></li>
                                                            	<li><span class="plan-cont">SURF<span>100 hrs/month</span></span></li>
                                                            	<li><span class="plan-cont">IDD<span>2hrs free call</span></span></li>
                                                            	<li class="c-out">CASHOUT <strong>P 12,000.00</strong></li>                                                                                                                                                                                                                                                                
                                                            </ul>
                                                        </li>
                                                        <li class="span4"><a class="thumbnail"><img src="images/plan-999.png" alt="Plan 999" /><span>Plan 999</span></a></li>           
                                                        <li class="span4"><a class="thumbnail"><img src="images/plan-1799.png" alt="Plan 1799" /><span>Plan 1799</span></a></li>                    
                                                        <li class="span4"><a class="thumbnail"><img src="images/plan-2499.png" alt="Plan 2499" /><span>Plan 2499</span></a></li>                    
                                                        <li class="span4"><a class="thumbnail"><img src="images/plan-3799.png" alt="Plan 3799" /><span>Plan 3799</span></a></li>    
                                                        <li class="span4"><a class="thumbnail"><img src="images/plan-unli.png" alt="Unli Plan" /><span>Unli Plan</span></a></li>
                                                        <li class="span4"><a class="thumbnail"><img src="images/plan-family.png" alt="Family Plan" /><span>Family Plan</span></a></li>                    
                                                    </ul>-->
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab3">
                                                <div class="tab-cont">here goes your content</div>
                                            </div>        
                                        </div>
                                    </div>
                                </div>
                            </div>
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






