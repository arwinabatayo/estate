									<div class="accordion-inner retain-current-plan">												
									
												<div class="accordion-title fleft" >
													<div class="dispalyTable ">
														<i class="icon icon-create"></i>
														<div class="center padding5">
															Package Plan
														</div>
													</div>
												</div>
												<div class="accordion-link-holder fright" >
													<div class="ot-toplinks fright accordion-link-holder textright">
														<?php if($_GET[ordertype]!='newline'){ ?><a href="<?php echo base_url() ?>plan?setOrderConfig=true<?=$_GET[ordertype]?"&ordertype=$_GET[ordertype]":''?>&plantype=retain<?php echo $subscriber_flag; ?>">Retain Current Plan</a>&nbsp;<?php } //Lawrence 10-02-2013?>
														<a href="<?php echo base_url() ?>plan?setOrderConfig=true<?=$_GET[ordertype]?"&ordertype=$_GET[ordertype]":''?>&plantype=create<?php echo $subscriber_flag; ?>">Create Your Own Plan</a>
													</div>
												</div>
												<div class="clear"></div><br />
												<label>Package Plan</label>
						
												<div class="main" style="width:100%;">
													<ul id="og-grid" class="og-grid">

                                            <?php 
                                                if($package_plan_options){
                                                    foreach($package_plan_options as $package_plan){
                                            ?>
                                            <li>
                                                <a href="#" class="btnAddPackagePlan" data-id="2" data-pv="500" data-largesrc="" 
                                                    data-title="
                                                        <div align='left'>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/text.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    Text<br /><span class='combo-type-text-desc'></span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/call.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    CALL<br /><span class='combo-type-call-desc'></span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/surf.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    SURF<br /><span class='combo-type-surf-desc'></span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                            <div class='plan-text fl'>
                                                                <div class='fl'>
                                                                    <img src='<?php echo $assets_url?>site-blue/images/idd.png'>
                                                                </div>
                                                                <div class='fl'>
                                                                    IDD<br /><span class='combo-type-idd-desc'></span>
                                                                </div>
                                                                <div class='clr'></div>
                                                            </div>
                                                        </div>
                                                        "
                                                data-description="CASHOUT P500.00">
                                                    <div class="my-plan-id" style="display:none"><?php echo $package_plan->id; ?></div>
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
                                                            <div class="plan-name"><?php echo $package_plan->title; ?></div>
                                                            <div class="">get <i class="icon icon-coins"></i> <?php echo $package_plan->total_pv ?> PV/mo.</div>
                                                            <div class="plan-off hide"></div>

                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </li>

                                            <?php
                                                    }
                                                }
                                            ?>


                                            <?php /*<li>
                                                <a href="#" class="btnAddPackagePlan" data-id="3" data-pv="900" data-largesrc="" 
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
                                                <a  href="#" class="btnAddPackagePlan" data-id="4" data-pv="1700" data-largesrc="" 
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
                                                <a  href="#" class="btnAddPackagePlan" data-id="5" data-pv="3200" data-largesrc="" 
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
                                                <a  href="#" class="btnAddPackagePlan" data-id="6" data-pv="4400" data-largesrc="" 
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
                                                <a  href="#" class="btnAddPackagePlan" data-id="6" data-pv="6500" data-largesrc="" 
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
                                            </li>*/ ?>
                                            
                                            
                                        </ul>
													<div class="clr"></div>
												</div>
											
									</div>					
									

										
