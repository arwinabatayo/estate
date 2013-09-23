
			<div id="main-page" class="span9">
	            <section class="jq-accordion" id="plan-order-page">
	                    <div>
	                        <h3><a href="#">Order Type</a></h3>
	                        <div class="textcenter">

								<!-- START OF ORDER-TYPE TABLE -->
								<div id="acc-order-type" class="pricing-tables textcenter">

									<?php if(!$new_line_flag){ ?>
									<!-- PRICING TABLE -->
									<div class="option-wrapper">
										<div class="plan over">
											<div class="header">
												<div class="price-wrapper">
													<h4>RENEW CONTRACT</h4>
												</div>
											</div>
											<ul>
												<li>Nullam suscipit ultrices enim.</li>
												<li>Vestibulum tincidunt odio sit amet dolor.</li>
												<li><button class="btn-large ui-button-success ">Select Order Type!</button></li>
											</ul>
										</div>
									</div>
									<!-- END OF PRICING TABLE -->

									<!-- PRICING TABLE -->
									<div class="option-wrapper">
										<div class="plan over best-value">
											<div class="header">
												<div class="price-wrapper">
													<h4>GET ADDITIONAL LINE</h4>
												</div>
											</div>
											<ul>
												<li>Nullam suscipit ultrices enim.</li>
												<li>Vestibulum tincidunt odio sit amet dolor.</li>
												<li><button class="btn-large ui-button-success ">Select Order Type!</button></li>
											</ul>
										</div>
									</div>

									<!-- END OF PRICING TABLE -->

									<!-- PRICING TABLE -->
									<div class="option-wrapper">
										<div class="plan over">
											<div class="header">
												<div class="price-wrapper">
													<h4>RESET</h4>
												</div>
											</div>
											<ul>
												<li>Nullam suscipit ultrices enim.</li>
												<li>Vestibulum tincidunt odio sit amet dolor.</li>
												<li><button class="btn-large ui-button-success ">Select Order Type!</button></li>
											</ul>
										</div>
									</div>
									<!-- END OF PRICING TABLE -->


									<?php } ?>



									<!-- START OF ADDITIONAL LINE PAGE -->
									<?php include('page_get_additional_line.php'); ?>
									<!-- END OF ADDITIONAL LINE PAGE -->

								</div>
								<!--END OF ORDER-TYPE TABLE -->

	                        </div>
	                    </div>
	                    <div>
	                        <h3><a href="#">Choose Your Plan</a></h3>
	                        <div>

								<!-- START OF PLAN-TYPE TABLE -->
								<!-- ======================= -->
								<div id="plantype-table" class="pricing-tables textcenter">

									<?php  if($plans){

										$i=1;
											foreach($plans as $row){
												//var_dump(intval($row->status));
												if(intval($row->status) == 1){
										?>
									<!-- PRICING TABLE -->
									<div class="noLeftMargin">

										<div class="plan over <?php echo ($i==2) ? 'best-value':''?>">
											<div class="header">
												<div class="price-wrapper">
													<h4><?php echo $row->title 	?></h4>
													<div class="price"><span>Vestibulum Varius</span></div>
												</div>
											</div>
											<ul>
												<li><?php echo $row->description ?></li>
												<li><button class="btn-large ui-button-success" rel="<?php echo $row->title ?>" id="<?php echo $row->main_plan_id ?>">Select Plan Type!</button></li>
											</ul>
										</div>
									</div>
									<!-- END OF PRICING TABLE -->
									<?php
											$i++;
											}
										}
									 }
									?>

								</div>
								<!--END OF PLAN-TYPE TABLE -->

								<div id="packageplantype-options" class="textcenter" style="display:none">

									<p><button class="btn-large ui-button-success btn-show-plantype">SHOW PLAN TYPE OPTIONS</button></p>

									<br />

									<div class="textright">
										<h4 style="font-size:24px;font-weight:normal"></h4>
										<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>

									</div>
									<br />
									<?php
										if($package_plan_options){
											foreach($package_plan_options as $package_plan){
												?>
													<div class="fleft" style="margin-right:12px; height:110px;width:200px;
													background:url('<?php echo $assets_path ?>images/plans/plan_temp.jpg') no-repeat 50% 50%">
														<p style="padding:10px 20px 0px 20px;color:#FFF;font-size:22px">
															<a style="color:#FFF" class="btnAddPackagePlan" data-pv="<?php echo $package_plan->total_pv ?>" data-id="<?php echo $package_plan->id ?>" data-name="<?php echo $package_plan->title ?>" href="javascript:void(0)">
																<?php echo $package_plan->title ?>
															</a>
														</p>
														<p style="color:#FFF;font-size:10px; padding:0 20px; min-height: 26px;"><b><?php echo $package_plan->description ?></b></p>
														<p style="color:#FFF;font-size:12px; padding:0 20px;"><b>get <?php echo $package_plan->total_pv ?>PV/mo.</b></p>
														<div class="my-plan-id" style="display:none"><?php echo $package_plan->id; ?></div>
													</div>
												<?php
											}
										}
									?>
								</div>

								<div id="plantype-options" class="textcenter" style="display:none">

									<p><button class="btn-large ui-button-success btn-show-plantype">SHOW PLAN TYPE OPTIONS</button></p>

									<br />

									<div class="textright">
										<h4 style="font-size:24px;font-weight:normal"></h4>
										<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>

									</div>
									<br />
									<?php if($plans_options){

											 foreach($plans_options as $plan) {
										?>
											<div class="fleft" style="margin-right:12px; height:110px;width:200px;
											background:url('<?php echo $assets_path ?>images/plans/plan_temp.jpg') no-repeat 50% 50%">
												<p style="padding:10px 20px 0px 20px;color:#FFF;font-size:22px">
													<a style="color:#FFF" class="btnAddPlan" data-pv="<?php echo $plan->total_pv ?>" data-id="<?php echo $plan->id ?>" data-name="<?php echo $plan->title ?>" href="javascript:void(0)">
														<?php echo $plan->title ?>
													</a>
												</p>
												<p style="color:#FFF;font-size:10px; padding:0 20px; min-height: 26px;"><b><?php echo $plan->description ?></b></p>
												<p style="color:#FFF;font-size:12px; padding:0 20px;"><b>get <?php echo $plan->total_pv ?>PV/mo.</b></p>
												<div class="my-plan-id" style="display:none"><?php echo $plan->id; ?></div>
											</div>



									<?php
											}
									}






									?>
									<div>
									<p class="textright">
										<button  class="btn-large ui-button-success" id="goCombos">CONTINUE</button>
									</p>

									<p class="textright" style="display:none;">
										<button  class="btn-large ui-button-success" id="goPackagePlanCombos">CONTINUE</button>
									</p>
									</div>
									<!-- class="row-fluid product-row"-->

									<div id="combo-type" style="display:none; clear:both;">

										<div id="combo-type-text" class="span2 product-item" style="display:none;">
											<img src="http://n-cubator.com/staging-estate/demo/_assets/estate/images/plans/temp/gadget-care-a.png" alt="">
											<p class="bold">Text</p>
											<span id="combo-type-text-desc" class="block"></span>
										</div>

										<div id="combo-type-call" class="span2 product-item" style="display:none;">
											<img src="http://n-cubator.com/staging-estate/demo/_assets/estate/images/plans/temp/gadget-care-a.png" alt="">
											<p class="bold">Call</p>
											<span id="combo-type-call-desc" class="block"></span>
										</div>

										<div id="combo-type-surf" class="span2 product-item" style="display:none;">
											<img src="http://n-cubator.com/staging-estate/demo/_assets/estate/images/plans/temp/gadget-care-a.png" alt="">
											<p class="bold">Surf</p>
											<span id="combo-type-surf-desc" class="block"></span>
										</div>

										<div id="combo-type-idd" class="span2 product-item" style="display:none;">
											<img src="http://n-cubator.com/staging-estate/demo/_assets/estate/images/plans/temp/gadget-care-a.png" alt="">
											<p class="bold">IDD</p>
											<span id="combo-type-idd-desc" class="block"></span>
										</div>
							   		</div>

							   		<div id="cashoutBox" class="contentbox" style="display:none; clear: both; text-align: left; background-color: #515151; color: #FFF;">
										<span class="bold">CASHOUT :</span>&nbsp;&nbsp;<span class="cashoutLabel" id="cashoutLabel">0.00</span>
						            </div>

								</div>

								<!--END OF PLAN-TYPE BUTTONS -->

								<!--robert-->
								<div id="plantype-combos" class="textcenter" style="display:none">
									<p><button class="btn-large ui-button-success btn-show-plans">SHOW PLANS</button></p>
									<div class="textright">
										<h4 style="font-size:24px;font-weight:normal">Combos</h4>
										<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>

									</div>
									<br />
									<?php if($combos_datas){
											 foreach($combos_datas as $combo) {
									?>
										<div class="fleft" style="margin-right:12px; height:100px;width:200px; background:url('<?php echo $assets_path ?>images/plans/plan_temp.jpg') no-repeat 50% 50%">
											<p style="padding:10px 20px 0px 20px;color:#FFF;font-size:22px"><a style="color:#FFF" class="btnAddCombo" data-id="<?php echo $combo->id ?>" data-name="<?php echo $combo->name ?>" data-pv="<?php echo $combo->peso_value ?>" data-cashout="<?php echo $gadget_cash_out ?>" data-planpv="<?php echo $plan_pv ?>" href="javascript:void(0)"><?php echo $combo->name ?></a></p>
											<p style="color:#FFF;font-size:12px; padding:0 20px;"><b><?php echo $combo->description ?></b></p>
										</div>
									<?php
											}
									}




									 ?>

									<p class="textright">
										<button  class="btn-large ui-button-success" id="goBoosters">CONTINUE</button>
									</p>
								</div>
								<!--END OF PLAN-TYPE COMBOS-->

								<!--robert-->
								<div id="plantype-boosters" class="textcenter" style="display:none">
									<p><button class="btn-large ui-button-success btn-show-plancombos">SHOW COMBOS</button></p>
									<div class="textright">
										<h4 style="font-size:24px;font-weight:normal">Boosters</h4>
										<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>

									</div>
									<br />
									<?php if($boosters_datas){
											 foreach($boosters_datas as $booster) {
									?>
										<div class="fleft" style="margin-right:12px; height:100px;width:200px; background:url('<?php echo $assets_path ?>images/plans/plan_temp.jpg') no-repeat 50% 50%">
											<p style="padding:10px 20px 0px 20px;color:#FFF;font-size:22px"><a style="color:#FFF" class="btnAddBooster" data-id="<?php echo $booster->id ?>" data-name="<?php echo $booster->name ?>" data-amount="<?php echo $booster->amount ?>" data-cashout="<?php echo $gadget_cash_out ?>" data-planpv="<?php echo $plan_pv ?>" href="javascript:void(0)"><?php echo $booster->name ?></a></p>
											<p style="color:#FFF;font-size:12px; padding:0 20px;"><b><?php echo $booster->description ?></b></p>
										</div>
									<?php
											}
									} ?>

									<p class="textright">
										<button  class="btn-large ui-button-success" onclick="window.location.href='<?php echo base_url() ?>addons'">CONTINUE</button>
									</p>
								</div>
								<!--END OF PLAN-TYPE BOOSTERS-->


								<div id="retain-plan" style="display:none">
									  <p class="textcenter"><button class="btn-large ui-button-success btn-show-plantype">SHOW PLAN TYPE OPTIONS</button></p>

									   <div class="well textright">
											<h4 style="font-size:24px;font-weight:normal">Retain Current Plan</h4>
											<p style="font-size:110%">Nullam suscipit ultrices enim. Ut nec sem. Quisque laoreet vulputate dui. Aenean rutrum diam vitae magna rhoncus lobortis. Nunc bibendum, dui in posuere blandit, ante nibh varius felis, a commodo purus leo non risus.</p>
									   </div>
									   <br />
									   <table class="table table-striped table-bordered table-hover table-condensed">
											<tr>
											  <td>Current Plan:</td>
											  <td><strong>Best Ever MySuper Plan 3799:</strong></td>
											</tr>
											<tr>
											  <td>Consumable Amount:</td>
											  <td><strong>Php 1,000</strong></td>
											</tr>
											<tr>
											  <td>Current Freebies:</td>
											  <td><strong>Freebie B = 2 </strong></td>
											</tr>
											<tr>
											  <td>Current Tack-on:</td>
											  <td><strong>Super Surf 999</strong></td>
											</tr>
										</table>
										<br />

										<p class="textright">
											<button  class="btn-large ui-button-success" onclick="window.location.href='<?php echo base_url() ?>addons'">CONTINUE</button>
										</p>

								</div>

	                        </div>
	                    </div>

	            </section>
			</div>

			<a href="javascript: void(0);" id="get-prepaid-kit" style="float: right; margin-top: 10px">Get a Prepaid Kit</a>
			<?php // TODO : change to tooltip and show correct present gadget added to cart ?>
			<div class="globe-dialog" id="tooltip-prepaid-kit">
			    <div style="width: 400px; text-align: center;">
			    	<h4><?php echo $gadget_data['gadget_name'] . " / " . $gadget_data['gadget_specs']['capacity'] . " GB"; ?></h4>
			    	Lorem ipsum dolor sit amet, usu at utinam interpretaris. Ne sed legendos volutpat. Ius facer delenit ex. Te quo oratio elaboraret, usu omnesque similique et, eos et mutat erant dicam. Utroque consulatu his id, pericula conceptam mei no.
					Error perpetua cum at, te pro graeco animal meliore. Ex autem dignissim pri. Voluptua singulis repudiandae no mei. Ipsum nonumes at per, eu vis vide animal.
					<h4>Price: <?php echo $gadget_data['gadget_price']; ?></h4>
					<a href="javascript: void(0);" id="add-prepaid-to-cart">Add to Cart</a>
			    </div>
			</div>

			<?php // popup to show when credit limit exceeds ?>
			<div class="globe-dialog" id="dialog-exceed-limit" title="Exceed Limit">
			    <div style="width: 400px; text-align: center;">
			    	The plan selected is not within your credit limit. <br/>
			    	Lorem ipsum dolor sit amet, usu at utinam interpretaris. Ne sed legendos volutpat. Ius facer delenit ex. Te quo oratio elaboraret, usu omnesque similique et, eos et mutat erant dicam. Utroque consulatu his id, pericula conceptam mei no. <br/>
					<a href="javascript: void(0);" id="retain-current-plan">Retain your Current Plan</a> or
					<a href="javascript: void(0);" id="other-plan">Choose Other Plan</a>
			    </div>
			</div>
