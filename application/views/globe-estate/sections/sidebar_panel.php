			
	<?php
	//hassle to paxencia na, need to separate prod type into basket (accordion)
		
		$cartProdFiltered = array('accessories'=>array(),'addon'=>array(),'plan'=>array(), 'combos'=>array()); //store it on each key(prod type)
	
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
		//print_r($cartProdFiltered);		
	?>		
			
		
			<div id="left-siderbar" class="span3">

				<div class="line-tab">LINE 1</div>	
				<br class="clear"/>
	            <section class="jq-accordion" id="siderbar-panel">

	                    <div>
	                        <h3><a href="#">My Account - 0915-2211334</a></h3>
	                        <div>
								<p><strong>Mobile Number:</strong> 0915-2211334</p>
								<p><strong>Account #:</strong> 0023197538299</p>
								<p><strong>Plan:</strong> 3799</p>
								<p><strong>Category:</strong> Consumer</p>
								<p><strong>Name:</strong> Allan V. Argosino</p>
								<p><strong>Lock-in Duration:</strong> December 25, 2013</p>
								<p><strong>Outstanding Balance:</strong> Php 5,500.00</p>
								<p><strong>Due Date:</strong> October 15, 2013</p>
								<p><strong>Credit Limit:</strong> Php 10,000</p>
								<p><strong>Overdue:</strong> Php 8,000</p>
	                        
	                        </div>
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
								<div id="PlanCartWidget" class="cartWidget">	
									<?php
									if($cart_plan){
										foreach($cart_plan as $item){
									?>
									<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
										<div class="fleft">
											<span class="productName block"><?php echo $item['name'] ?></span>
										</div>
										<span class="icoDelete"> <a href="javascript:void(0)" class="btnDelete" id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>"><i class="icon-remove"></i></a> </span>
										<br class="clear" />
									</div>
									<?php 
											}
										}	 
									?>
									<p>
										<strong>Combos</strong>
										<div id="CombosCartWidget" class="cartWidget">
										<?php
											$cart_combos='';
											$cart_combos = @$cartProdFiltered['combos'];
											
											if($cart_combos){
												foreach($cart_combos as $item){
										?>
										<div id="prod-item-<?php echo $item['rowid'] ?>" class="item">
											<div class="fleft">
												<span class="productName block"><?php echo $item['name'] ?></span>
												<span class="productName block" id="prod-qty-<?php echo $item['rowid'] ?>" style="margin-left: 15px;">
													<b>x<?php echo $item['qty'] ?></b>
												</span>
											</div>
											<span class="icoDelete"> 
												<a href="javascript:void(0)" class="btnDeleteCombos"  data-id="<?php echo $item['product_id'] ?>" data-name="<?php echo $item['name'] ?>" data-pv="<?php echo $item['pv'] ?>" data-cashout="<?php echo $gadget_cash_out ?>" data-planpv="<?php echo $plan_pv ?>"  id="<?php echo $item['rowid'] ?>" rel="<?php echo $item['name'] ?>">
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
										
								
								</p>
									<!-- <p><strong>Packaged Plan</strong> <br /> 
									<em class="normal" style="font-family:Arial,sans-serif">Plan <?php echo number_format($cart_plan['price'],2) ?></em></p>
									<p><strong>Monthly Payment:</strong> <?php echo number_format($cart_plan['price_formatted'],2) ?></p>
									<p><strong>Text:</strong> Unlitext for 30 days</p>
									<p><strong>Call:</strong> 20mins Free Call/month</p>
									<p><strong>Surf:</strong> 10 hourse Free Internet Surfing</p>
									<p><strong>IDD:</strong> Free 2 hours call/month</p> -->
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
					<span class="bold">PV :</span>&nbsp;&nbsp;<span class="pesovalLabel" id="pesovalLabel"><?php echo $plan_pv; ?></span>
	            </div>
	            <div id="cashoutBox" class="contentbox">
					<span class="bold">CASHOUT :</span>&nbsp;&nbsp;<span class="cashoutLabel" id="cashoutLabel"><?php
					/**
					 * Show price if addon and accessories not empty
					 * 
					 */
					$showprice = count($cartProdFiltered['addon']) + count($cartProdFiltered['accessories']);
					if($showprice > 0) {
						echo $this->cart_model->total(true);
					} else {
						echo number_format($gadget_cash_out,2);
					}
					?></span>
	            </div>
	            
	            
			</div>
			
			
		
