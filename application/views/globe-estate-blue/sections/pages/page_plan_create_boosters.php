									<div class="accordion-inner retain-current-plan">												
									
												<div class="accordion-title fleft" >
													<div class="dispalyTable ">
														<i class="icon icon-create"></i>
														<div class="center padding5">
															Boosters
														</div>
													</div>
												</div>
												<div class="accordion-link-holder fright" >
													<div class="ot-toplinks fright accordion-link-holder textright" style="">
														<a href="<?php echo base_url() ?>plan?setOrderConfig=true&plantype=retain">Retain Current Plan</a>&nbsp;
														<a href="<?php echo base_url() ?>plan?setOrderConfig=true&plantype=package">Package Plan</a>
													</div>
												</div>
												<div class="clear"></div><br />
												<label>Create your own plan by selecting your own Combos.</label>
						
												<div class="main" style="width:100%;">
													<ul id="og-grid" class="og-grid">
													<?php if($boosters_datas){ ?>
														<?php foreach($boosters_datas as $boosters) { ?>
			                                            <li>
			                                                <a class="create_add_this_boosters" href="#" data-name="<?php echo $boosters->name; ?>" 
			                                                	data-pv="<?php echo $boosters->peso_value ?>"
			                                                	data-amount="<?php echo $boosters->amount ?>" 
			                                                	data-id="<?php echo $boosters->id ?>" 
			                                                	data-largesrc="" 
			                                                	data-title="<i class='icon icon-big-coins'></i>P <?php echo $boosters->amount ?> /Month" data-description="CASHOUT P<?php echo number_format($boosters->amount,2) ?>">
			                                                    <div class="plan-tile-option-green">
			                                                        <div class="arrow-point-up"></div>
			                                                        <div class="ribbon-new hide"></div>
			                                                        <div class="center">
			                                                            <i class="icon icon-peso"></i>
			                                                            <div class="plan-name"><?php echo $boosters->name ?></div>
			                                                            <div class="plan-description"><?php echo $boosters->description ?></div>
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
									

										
