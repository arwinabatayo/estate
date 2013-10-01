									<div class="accordion-inner retain-current-plan">												
									
												<div class="accordion-title fleft" >
													<div class="dispalyTable ">
														<i class="icon icon-create"></i>
														<div class="center padding5">
															Retain Current Plan
														</div>
													</div>
												</div>
												<div class="accordion-link-holder fright" >
													<div class="ot-toplinks fright accordion-link-holder textright">
														<a href="<?php echo base_url() ?>plan?setOrderConfig=true&plantype=create<?php echo $subscriber_flag; ?>">Create Your Own Plan</a>&nbsp;
														<a href="<?php echo base_url() ?>plan?setOrderConfig=true&plantype=package<?php echo $subscriber_flag; ?>">Package Plan</a>
													</div>
												</div>
												<div class="clear"></div><br />
												<label>Create your own plan by selecting your own Combos.</label>
						
												<div class="main" style="width:100%;">
													<ul id="og-grid" class="og-grid">
														<li class="fl">
															<a href="#" data-largesrc="" data-title="Get 500 Peso Value/Month" data-description="CASHOUT P500.00">
																<div class="plan-tile-option4">
																	<div class="arrow-point-up"></div>
																	<div class="ribbon-new hide"></div>
																	<div class="center">
																		<i class="icon icon-big-peso"></i>
																		<div class=""><b>Current Plan:</b></div>
																		<div class="plan-name"><?php echo $current_plan->current_plan ?></div>
																		<div class="plan-off hide"></div>
																	</div>
																	
																</div>
															</a>
														</li>
														<li class="fl">
															<a href="#" data-largesrc="" data-title="Get 900 Peso Value/Month" data-description="CASHOUT P900.00" >
																<div class="plan-tile-option4 ">
																	<div class="arrow-point-up"></div>
																	<div class="ribbon-new hide"></div>
																	<div class="center">
																		<i class="icon icon-consumable"></i>
																		<div class=""><b>Consumamable amount:</b></div>
																		<div class="plan-name"><br /><?php echo number_format($current_plan->consumable_amount,2); ?></div>
																		<div class=""></div>
																		<div class="plan-off hide"></div>
																	</div>
																	
																</div>
															</a>
														</li>
													</ul>
													
													<div class="clr"></div>
												</div>
											
									</div>					
