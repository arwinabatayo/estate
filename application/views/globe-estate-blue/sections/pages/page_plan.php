         
              <div class="accordion row-fluid chooseplan clearfix" id="accordion2">  
             
				<?php
				    if($current_controller != 'home' && ($current_step < 5) ){
						include(ESTATE_THEME_BASEPATH.'/sections/sidebar_panel.php');
					}
				?>
                
                <div class="span9">
                    <div class="accordion2 account-content" id="accordion3">
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse4">
                              ORDER TYPE <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
                          <div id="collapse4" class="accordion-body collapse" style="height: 0; ">
                            <div class="accordion-inner">
								<div class="row-fluid">
                                	<div class="ac-box-plan">
                                        <div class="span4 ac-boxes g-content">
                                            <img src="images/renew-contract.png" />
                                            <span>Renew Contract</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>
                                            <button class="blue-btn">Click here!</button>
                                        </div>
                                        <div class="span4 ac-boxes o-content">
                                            <img src="images/get-a-new-line.png" />
                                            <span>Get A New Line</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>  
                                            <button class="blue-btn">Click here!</button>
                                        </div>
                                        <div class="span4 ac-boxes r-content">
                                            <img src="images/reset.png" />
                                            <span>Reset</span>
                                            <blockquote>Lorem ipsum dolor sit amet, consectuer adispising  elit. Cras justo nulla, commodo nec mauris ut, interdum adipiscing  nisi</blockquote>                                    
                                            <button class="blue-btn">Click here!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-group account-content-grp">
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse5">
                              SELECT PLAN <i class="tcoll collapse-toggle"></i>
                            </a>
                          </div>
                          <div id="collapse5" class="accordion-body in collapse" style="height: auto; ">
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
                                                    <ul class="thumbnails">
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
                                                    </ul>
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
                        	<button class="blue-btn pull-right">Continue</button>
                        </div>

                    </div>                             
                </div>
            
            </div>

<?php /*
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

											<div class="fleft" style="margin-right:12px; height:110px;width:200px; 
											background:url('<?php echo $assets_path ?>images/plans/plan_temp.jpg') no-repeat 50% 50%">
												<p style="padding:10px 20px 0px 20px;color:#FFF;font-size:22px">
													<a style="color:#FFF" class="btnAddPackagePlan" data-pv="<?php echo $plan->total_pv ?>" data-id="<?php echo $plan->id ?>" data-name="<?php echo $plan->title ?>" href="javascript:void(0)">
														<?php echo $plan->title ?>
													</a>
												</p>
												<p style="color:#FFF;font-size:10px; padding:0 20px; min-height: 26px;"><b><?php echo $plan->description ?></b></p>
												<p style="color:#FFF;font-size:12px; padding:0 20px;"><b>get <?php echo $plan->total_pv ?>PV/mo.</b></p>
												<div class="my-plan-id" style="display:none"><?php echo $plan->id; ?></div>
											</div>
											
									<?php 
											}
									} ?>
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
									} ?>
									
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
			
*/ ?>			

<?php /*
			<a href="javascript: void(0);" id="get-prepaid-kit" style="float: right; margin-top: 10px">Get a Prepaid Kit</a>		
			<?php // TODO : change to tooltip and show correct present gadget added to cart ?>
			<div class="globe-dialog" id="tooltip-prepaid-kit">
			    <div style="width: 400px; text-align: center;">
			    	<h4>iPhone 5 /16GB</h4>
			    	Lorem ipsum dolor sit amet, usu at utinam interpretaris. Ne sed legendos volutpat. Ius facer delenit ex. Te quo oratio elaboraret, usu omnesque similique et, eos et mutat erant dicam. Utroque consulatu his id, pericula conceptam mei no.
					Error perpetua cum at, te pro graeco animal meliore. Ex autem dignissim pri. Voluptua singulis repudiandae no mei. Ipsum nonumes at per, eu vis vide animal.
					<h4>Price: 36, 750.00</h4>
					<a href="javascript: void(0);" id="add-prepaid-kit">Add to Cart</a>
			    </div>
			</div>
*/ ?>
