									<div class="accordion-inner retain-current-plan">												
									
												<div class="accordion-title fleft" >
													<div class="dispalyTable ">
														<i class="icon icon-create"></i>
														<div class="center padding5">
															Create Your Own Plan
														</div>
													</div>
												</div>
												<div class="accordion-link-holder fright" >
													<div class="ot-toplinks fright accordion-link-holder textright" style="">
														<?php if($_GET[ordertype]!='newline'){ ?><a href="<?php echo base_url() ?>plan?setOrderConfig=true<?=$_GET[ordertype]?"&ordertype=$_GET[ordertype]":''?>&plantype=retain">Retain Current Plan</a>&nbsp;<?php } //Lawrence 10-02-2013?>
														<a href="<?php echo base_url() ?>plan?setOrderConfig=true<?=$_GET[ordertype]?"&ordertype=$_GET[ordertype]":''?>&plantype=package">Package Plan</a>
													</div>
												</div>
												<div class="clear"></div><br />
												<label>Create your own plan by selecting your own Combos.</label>
						
												<div class="main" style="width:100%;" id="createPlan">
													<ul id="og-grid" class="og-grid">
													<?php if($plan_options){ ?>
														<?php foreach($plan_options as $plan) { ?>
			                                            <li class="<?php echo $isCollapse; ?>">
			                                                <a class="create_add_this_plan" href="#" data-plan-cashout="<?php echo $plan->cashout_val; ?>" data-name="<?php echo $plan->title; ?>" data-pv="<?php echo $plan->total_pv; ?>" data-id="<?php echo $plan->id ?>" data-largesrc="" data-title="<i class='icon icon-big-coins'></i>Get <?php echo $plan->total_pv ?> Peso Value/Month" data-description="CASHOUT P<?php echo number_format($plan->cashout_val,2) ?>">
                                                    <div class="plan-tile-option-pink">
                                                        <div class="arrow-point-up"></div>
                                                        <div class="ribbon-new hide"></div>
                                                        <div class="center">
                                                            <i class="icon icon-peso"></i>
			                                                            <div class="plan-name"><?php echo $plan->title ?></div>
			                                                            <div class="">get <i class="icon icon-coins"></i> <?php echo $plan->total_pv ?> PV/mo.</div>
                                                            <div class="plan-off hide"></div>
                                                        </div>
                                                        
                                                    </div>
                                                </a>
                                            </li>
			                                            <?php } ?>
		                                            <?php } ?>
                                        </ul>
													<div class="clr"></div>
												</div>
											
									</div>					
									

										
