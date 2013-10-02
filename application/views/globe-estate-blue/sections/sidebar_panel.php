			
	<?php
		//Need to separate prod type into basket (accordion)
		//TODO - add to table
		$cartProdFiltered = array('gadget'=>array(),'accessories'=>array(),'addon'=>array(),'plan'=>array(), 'combos'=>array(), 'boosters'=>array(), 'packageplan'=>array()); //store it on each key(prod type)
	
		$cartItems = $this->cart->contents();
		
		

		if($cartItems){
			foreach($cartItems as $item){
					if(array_key_exists($item['product_type'],$cartProdFiltered)){
						$cartProdFiltered[ $item['product_type'] ][] = $item;
					}
			}		
		}
		$cart_plan='';
		$cart_plan = @$cartProdFiltered['plan'];
		if($cart_plan) {
			foreach($cart_plan as $item) {
				$plan_name =  $item['name'];
				$plan_pv =  $item['plan_pv'];
				$gadget_cash_out =  $item['gadget_cash_out'];
			}
		}
		
		
		$user = isset($account_info) ? $account_info : (object) $this->session->userdata('subscriber_info');
		
	?>		
                <div class="span3 left">
                	<div class="chooseline">
						<?php if($user){ ?>
                        <div class="line">
                            <span>CHOOSE A LINE</span>
                            <label>
                                <select>
                                    <option>LINE 1</option>
                                    <option>LINE 2</option>                                
                                </select>
                            </label>
                        </div>
                        <?php  } ?>
                        
                        <div class="accordion" id="accordion2">
                            <div class="accordion-group account-group account">
								
							  <?php if($user){ ?>	
                              <div class="row-fluid accordion-heading">
                                <a class="accordion-toggle account-name" data-toggle="collapse" data-target="#collapseOne">
                                  MY ACCOUNT <i class="expand icon-pn"></i>
                                </a>
                              </div>
                              <div id="collapseOne" class="accordion-body in collapse" style="height: auto; ">
                                <div class="accordion-inner">
                                    <ul>
										<?php if($user){ ?>
											<?php if($user->mobile_number){ ?>
											<li><span>Mobile Number:</span> <?php echo $user->mobile_number ?></li>
											<?php } ?>
											
											<?php if($user->account_id ){ ?>
											<li><span>Account #:</span> <?php echo $user->account_id ?></li>
											<?php } ?>
											
											<?php if($user->account_id ){ //TODO: get from account_plan ?>
											<li><span>Plan:</span> 3799</li>
											<?php } ?>
											
											<?php if($user->account_type_name ){ ?>
											<li><span>Category:</span> <?php echo $user->account_type_name?></li>
											<?php } ?>
											
											<?php if($user->name && $user->surname){ ?>
											<li><span>Name:</span> <?php echo $user->name.' '.$user->surname ?></li>
											<?php } ?>
											
											<?php if($user->lockin_duration ){ ?>
											<li><span>Lock-in Duration:</span> <?php echo $user->lockin_duration ?></li>
											<?php } ?>
											
											<?php if($user->outstanding_balance ){ ?>
											<li><span>Outstanding Balance:</span> Php <?php echo number_format($user->outstanding_balance,2) ?></li>
											<?php } ?>
											
											<?php if($user->due_date  ){ ?>
											<li><span>Due Date:</span> <?php echo date('M d, Y',strtotime($user->due_date) ) ?></li>
											<?php } ?>
											
											<?php if($user->credit_limit ){ ?>
											<li><span>Credit Limit:</span> Php <?php echo number_format($user->credit_limit,2) ?></li>
											<?php } ?>
											
											<?php if($user->account_id ){ //TODO not in DB ?>
											<li><span>Overdue:</span> Php <?php echo number_format($user->outstanding_balance,2) ?></li>
											<?php } ?>
											
										<?php } ?>	

                                    </ul>
                                </div>
                              </div>
                            </div>
                            <?php } ?>	
                            
                            <div class="accordion-group account-group addevice">
                              <div class="row-fluid accordion-heading">
                                <a class="accordion-toggle account-name in collapse" data-toggle="collapse" data-target="#collapseTwo">
                                  ADD A DEVICE<i class="expand icon-pn"></i>
                                </a>
                              </div>
                              <div id="collapseTwo" class="accordion-body collapse" style="height: auto; ">
                                <div class="accordion-inner">
                                <?php 
                                $cartItemsGadget='';
                                $cartItemsGadget = $cartProdFiltered['gadget'][0];
                                
                                $selectedColor 		= $cartItemsGadget['options']['color'];
                                $selectedCapacity 	= $cartItemsGadget['options']['capacity'];
                                
                                $availableColor = $this->home_model->getAvailableColors($cartItemsGadget['product_id']);
                                $availableCapacity = $this->home_model->getCapacity($cartItemsGadget['product_id'], $selectedColor);
                                
                                unset($availableColor['count']);
                                unset($availableCapacity['count']);
                                ?>
                                    <ul id="addDeviceSidePanel">
                                        <li>
                                            <span>Color</span>
                                            <?php foreach($availableColor as $key => $value) { ?>
                                            <?php 	if($selectedColor = $value['clid']) {?>
                                            <input data-device="type_<?php echo $cartItemsGadget['product_id']; ?>" id="<?php echo strtolower(trim($value['clname'])); ?>" type="radio" name="color" value="<?php echo $value['clid']; ?>" checked><label for="<?php echo strtolower(trim($value['clname'])); ?>"><?php echo  $value['clname']; ?></label>
                                            <?php 	} else {?>
                                            <input data-device="type_<?php echo $cartItemsGadget['product_id']; ?>" id="<?php echo strtolower(trim($value['clname'])); ?>" type="radio" name="color" value="<?php echo $value['clid']; ?>"><label for="<?php echo strtolower(trim($value['clname'])); ?>"><?php echo  $value['clname']; ?></label>
                                            <?php 	} ?>
                                            <?php } ?>
                                        </li>
                                        <li id="dataCapacitySidebarPanel">
                                            <span>Data Capacity</span>
                                            <?php foreach($availableCapacity as $key => $value) { ?>
                                            <?php 	if($selectedCapacity = $value['dcid']) {?>
                                            <input data-device="type_<?php echo $cartItemsGadget['product_id']; ?>" id="<?php echo strtolower(trim($value['dcname'])); ?>" type="radio" name="capacity" value="<?php echo $value['dcid']; ?>" checked><label for="<?php echo strtolower(trim($value['dcname'])); ?>"><?php echo $value['dcname']; ?></label>
                                            <?php 	} else {?>
                                            <input data-device="type_<?php echo $cartItemsGadget['product_id']; ?>" id="<?php echo strtolower(trim($value['dcname'])); ?>" type="radio" name="capacity" value="<?php echo $value['dcid']; ?>"><label for="32gb">32GB</label>
                                            <?php 	} ?>
                                            <?php } ?>
                                        </li>
                                    </ul>				
                                </div>
                              </div>
                            </div>
                            
                            <div id="accChooseYourPlan" class="accordion-group account-group chooseyourplan">
                              <div class="row-fluid accordion-heading">
                                <a class="accordion-toggle account-name collapsed" data-toggle="collapse" data-target="#collapseThree">
                                    CHOOSE YOUR PLAN <i class="expand icon-pn"></i>
                                </a>
                              </div>
                              <div id="collapseThree" class="accordion-body collapse" style="height: 0px; ">
                                <div class="accordion-inner">
                                	<ul>
                                		<li>
                                			<span>Plan</span>
                                			<?php
												$cartItemsPlan='';
												$cartItemsPlan = $cartProdFiltered['plan'];
											?>
                                			<div id="PlanCartWidget" class="cartWidget">
                                				<?php if($cartItemsPlan){ ?>
												<?php foreach($cartItemsPlan as $item) {?>
													<div data-prod-type="plan" id="prod-item-<?php echo $item['rowid'] ?>" class="item" data-cashout="<?php echo $item['price']; ?>" data-pv="<?php echo $item['this_pv_value']; ?>">
														<div class="fleft">
															<span class="productName block"><?php echo $item['name'] ?></span>
														</div>
														<span class="icoDelete"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove">&nbsp;X&nbsp;</i></a> </span>
														<br class="clear" />
													</div>	
											
												<?php } ?>
												<?php } ?>	 
                                			</div>
                                		</li>
                                		<li>
                                			<span>Combos</span>
                                			<?php
												$cartItemsCombos='';
												$cartItemsCombos = $cartProdFiltered['combos'];
											?>
                                			<div id="CombosCartWidget" class="cartWidget">
                                				<?php if($cartItemsCombos){ ?>
												<?php foreach($cartItemsCombos as $item) {?>
													<div data-prod-type="combos" id="prod-item-<?php echo $item['rowid'] ?>" class="item">
														<div class="fleft">
															<span class="productName block"><?php echo $item['name'] ?></span>
															<span class="price block arial italic">x<?php echo $item['combos_qty'] ?></span>
														</div>
														<span class="icoDelete"> 
														<a data-amount="<?php echo $item['price']; ?>" data-pv="<?php echo $item['this_pv_value']; ?>" data-id="<?php echo $item['product_id']; ?>" href="javascript:void(0)" class="btnDeleteCombos" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>">
														<i class="icon-remove">&nbsp;X&nbsp;</i></a> </span>
														<br class="clear" />
													</div>	
											
												<?php } ?>
												<?php } ?>	
                                			</div>
                                		</li>
                                		<li>
                                			<span>Boosters</span>
                                			<?php
												$cartItemsBoosters ='';
												$cartItemsBoosters = $cartProdFiltered['boosters'];
											?>
                                			<div id="BoostersCartWidget" class="cartWidget">
                                				<?php if($cartItemsBoosters){ ?>
												<?php foreach($cartItemsBoosters as $item) {?>
													<div data-prod-type="boosters" id="prod-item-<?php echo $item['rowid'] ?>" class="item">
														<div class="fleft">
															<span class="productName block"><?php echo $item['name'] ?></span>
															<span class="price block arial italic"><?php echo $item['price_formatted'] ?></span>
														</div>
														<span class="icoDelete"> 
														<a data-amount="<?php echo $item['price']; ?>" data-pv="<?php echo $item['this_pv_value']; ?>" data-id="<?php echo $item['product_id']; ?>" href="javascript:void(0)" class="btnDeleteBoosters" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>">
														<i class="icon-remove">&nbsp;X&nbsp;</i></a> </span>
														<br class="clear" />
													</div>	
											
												<?php } ?>
												<?php } ?>	
                                			</div>      
                                		</li>
                                	</ul>
                                          
                                </div>
                              </div>
                            </div>
                            
							<?php
								$cartItems='';
								$cartItems = $cartProdFiltered['addon'];
								//print_r($cartItems);
							?>
                            <div id="accAddonTab" class="accordion-group account-group addons">
                              <div class="row-fluid accordion-heading">
                                <a class="accordion-toggle account-name collapsed" data-toggle="collapse" data-target="#collapseFour">
                                    ADD-ONS <i class="expand icon-pn"></i>
                                </a>
                              </div>
                              <div id="collapseFour" class="accordion-body collapse" style="height: <?php echo count($cartItems) > 0  ? 'auto': '0px' ?>; ">
                                <div class="accordion-inner">
								<div id="AddonCartWidget" class="cartWidget">	
									<?php

										if($cartItems){
											foreach($cartItems as $item) {
									?>
									
												<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
													<div class="fleft">
														<span class="productName block"><?php echo $item['name'] ?></span>
														<span class="price block arial italic"><?php echo $item['price_formatted'] ?></span>
													</div>
													<span class="icoDelete"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove">&nbsp;X&nbsp;</i></a> </span>
													<br class="clear" />
												</div>	
									
									<?php 
											}
										}	 
									?>
								</div>                      
                                </div>
                              </div>
                            </div>
                            
                            
							<?php
								$cartItems='';
								$cartItems = $cartProdFiltered['accessories'];
								//print_r($cartItems);
							?>
                            <div id="accAccesoriesTab" class="accordion-group account-group accessories">
                              <div class="row-fluid accordion-heading">
                                <a class="accordion-toggle account-name collapsed" data-toggle="collapse" data-target="#collapseFive">
                                    ACCESSORIES <i class="expand icon-pn"></i>
                                </a>
                              </div>
                              <div id="collapseFive" class="accordion-body collapse" style="height: 0px; ">
                                <div class="accordion-inner">
                                    <div id="AccessoryCartWidget" class="cartWidget">                       
										<?php
	
											if($cartItems){
												foreach($cartItems as $item) {
										?>
										
													<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
														<div class="fleft">
															<span class="productName block"><?php echo $item['name'] ?></span>
															<span class="price block arial italic"><?php echo $item['price_formatted'] ?></span>
														</div>
														<span class="icoDelete"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove">&nbsp;X&nbsp;</i></a> </span>
														<br class="clear" />
													</div>	
										
										<?php 
												}
											}	 
										?>
									
									</div>
                                </div>
                              </div>
                            </div>                                                
                        </div>                          
                    </div>
                    <div id="pesovalueBox" class="cash-out">
                    	<span class="blue">PESO VALUE</span>
                        <span class="black" id="pesovalueLabel">
							<?php echo $this->cart_model->remaining_pv(false); ?>
						</span>
                    </div>   
                    <div id="cashoutBox" class="cash-out">
                    	<span class="blue">YOUR CASHOUT</span>
                        <span class="black" id="cashoutLabel">
							P <?php echo number_format($this->cart_model->total(false),2); ?>
						</span>
                    </div>                   
                </div>
                
                	
		<?php /*
			<div id="left-siderbar" class="span3">

				<div class="line-tab">LINE 1</div>	
				<br class="clear"/>
	            <section class="jq-accordion" id="siderbar-panel">

						<?php
							//TODO - move this object to session after authentication - mark
						    $user = $this->accounts_model->get_account_info_by_id('9151178863',false);	
						    //print_r($user);
						?>
	                    <div>
	                        <h3><a href="#">My Account - 0915-2211334</a></h3>
	                        <div>

	                    </div>
	                    
	                    <div>
	                        <h3><a href="#">Add a Device - iPhone 5</a></h3>
	                        <div>
								<div style="display:none">
									<input type="radio" id="gs4_blk" class="opt_color" value="blk" name="gadget_gs4" checked="checked"><label for="gs4_blk">Black Mist</label>
									<input type="radio" id="gs4_blu" class="opt_color" value="blu" name="gadget_gs4"><label for="gs4_blu">Blue Artic</label>
									<input type="radio" id="gs4_pnk" class="opt_color" value="pnk" name="gadget_gs4"><label for="gs4_pnk">Pink Twilight</label>
								</div>
								<br />
								<div style="display:none">
									<input type="radio" id="gs4_16" name="gadget_capacity" checked="checked"><label for="gs4_16">&nbsp;&nbsp;16 GB&nbsp;&nbsp;</label>
									<input type="radio" id="gs4_32" name="gadget_capacity"><label for="gs4_32">&nbsp;&nbsp;32 GB&nbsp;&nbsp;</label>
									<input type="radio" id="gs4_64" name="gadget_capacity"><label for="gs4_64">&nbsp;&nbsp;64 GB&nbsp;&nbsp;</label>
								</div>
	                        </div>
	                    </div>
	                    <?php
	                    	$cart_plan='';
							$cart_plan = @$cartProdFiltered['plan'];
							
	                    ?>
	                    
	                    <div>
	                        <h3><a href="#">Choose your Plan</a></h3>
	                        <div>
	                        	<em>Plan</em>
								<div id="PlanCartWidget" class="cartWidget">	
									<?php
									if($cart_plan){
										foreach($cart_plan as $item){
									?>
									<div id="prod-item-<?php echo $item['rowid'] ?>" class="itemPlan">
										<div class="fleft">
											<span class="productName block"><b><?php echo $item['name'] ?></b></span>
										</div>
										<span class="icoDelete"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove"></i></a> </span>
										<br class="clear" />
									</div>
									<?php 
											}
										}	 
									?>
									<hr>
									<em>Combos</em>
									<div id="CombosCartWidget" class="cartWidget">
									<?php
										$cart_combos='';
										$cart_combos = @$cartProdFiltered['combos'];
										
										if($cart_combos){
											foreach($cart_combos as $item){
									?>
									<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
										<div class="fleft" style="width:95%;">
											<span class="productName block fleft"><?php echo $item['name'] ?></span>
											<span class="productName block fleft" id="prod-qty-<?php echo $item['rowid'] ?>" style="margin-left: 15px;">
												<b>x<?php echo $item['combos_qty'] ?></b>
											</span>
										</div>
										<span class="icoDelete"> 
											<a href="javascript:void(0)" class="btnDeleteCombos"  data-id="<?php echo $item['product_id'] ?>" data-product-type="<?php echo $item['product_type'] ?>" data-name="<?php echo $item['name'] ?>" data-pv="<?php echo $item['this_pv_value'] ?>" data-cashout="<?php echo $gadget_cash_out ?>" data-planpv="<?php echo $plan_pv ?>"  id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>">
												<i class="icon-remove"></i>
											</a>
										</span>
										<br class="clear" />
									</div>
									<?php 
											}
										}	 
									?>
									</div>
									<hr>
									<em>Boosters</em>
									<div id="BoostersCartWidget" class="cartWidget">
									<?php
										$cart_boosters='';
										$cart_boosters = @$cartProdFiltered['boosters'];
										
										if($cart_boosters){
											foreach($cart_boosters as $item){
									?>
									<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
										<div class="fleft">
											<span class="productName block" style="max-width:199px;"><?php echo $item['name'] ?></span>
										</div>
										<span class="icoDelete"> 
											<a href="javascript:void(0)" class="btnDeleteBoosters"  data-id="<?php echo $item['product_id'] ?>" data-product-type="<?php echo $item['product_type'] ?>" data-name="<?php echo $item['name'] ?>" data-amount="<?php echo $item['price'] ?>" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>">
												<i class="icon-remove"></i>
											</a>
										</span>
										<br class="clear" />
									</div>
									<?php 
											}
										}	 
									?>
									</div>

								</p>
									<!-- <p><strong>Packaged Plan</strong> <br /> 
									<em class="normal" style="font-family:Arial,sans-serif">Plan <?php echo number_format($cart_plan['price'],2) ?></em></p>
									<p><strong>Monthly Payment:</strong> <?php echo number_format($cart_plan['price_formatted'],2) ?></p>
									<p><strong>Text:</strong> Unlitext for 30 days</p>
									<p><strong>Call:</strong> 20mins Free Call/month</p>
									<p><strong>Surf:</strong> 10 hourse Free Internet Surfing</p>
									<p><strong>IDD:</strong> Free 2 hours call/month</p> -->
		                        </div>


		                        <!-- Package Plan -->

		                        <div id="package-plan-items">
		                        	<em>Package Plan</em>
		                        	<div id="PackagePlanCartWidget" class="cartWidget" style="display:none;">

	                        		</div>
	                        	</div>	

	                        </div>


	                        

	                    </div>
	                    <div>
	                        <h3><a href="#">Add-ons</a></h3>
	                        <div>
								<div id="AddonCartWidget" class="cartWidget">	
									<?php
										$cartItems='';
										$cartItems = $cartProdFiltered['addon'];
										//print_r($cartItems);
										if($cartItems){
											foreach($cartItems as $item) {
									?>
									
												<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
													<div class="fleft">
														<span class="productName block"><?php echo $item['name'] ?></span>
														<span class="price block arial italic"><?php echo $item['price_formatted'] ?></span>
													</div>
													<span class="icoDelete"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove"></i></a> </span>
													<br class="clear" />
												</div>	
									
									<?php 
											}
										}	 
									?>
									
								</div>
	                        </div>
	                    </div>
	                    <div>
	                        <h3><a href="#">Accessories</a></h3>
	                        <div>
								<div id="AccessoryCartWidget" class="cartWidget">
									<?php
										$cartItems='';
										$cartItems = $cartProdFiltered['accessories'];
										//print_r($cartItems);
										if($cartItems){
											foreach($cartItems as $item){
									?>
									
												<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
													<div class="fleft">
														<span class="productName block"><?php echo $item['name'] ?></span>
														<span class="price block arial italic"><?php echo $item['price_formatted'] ?></span>
													</div>
													<span class="icoDelete"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove"></i></a> </span>
													<br class="clear" />
												</div>	
									
									<?php 
											}
										}	 
									?>
								</div>
	                        </div>
	                    </div>
	            </section>   
	            <div id="pesovalBox" class="contentbox">
					<span class="bold">PV :</span>&nbsp;&nbsp;<span class="pesovalLabel" id="pesovalLabel">
					<?php echo $this->cart_model->remaining_pv(); ?></span>
	            </div>
	            <div id="cashoutBox" class="contentbox">
					<span class="bold">CASHOUT :</span>&nbsp;&nbsp;<span class="cashoutLabel" id="cashoutLabel"><?php
					/**
					 * Show price if addon and accessories not empty
					 * robert 
					 */
// 					$showprice = count($cartProdFiltered['addon']) + count($cartProdFiltered['accessories']);
// 					if($showprice > 0) {
						//echo $this->cart_model->total(true);
// 					} else {
// 						echo number_format($gadget_cash_out,2);
// 					}
					?>
					<?php /*
					</span>
	            </div>
	            
	            
			</div>
			
			
		*/ ?>
