         
              <div class="accordion row-fluid chooseplan clearfix" id="accordion2">  
             
				<?php
				    if($current_controller != 'home' && ($current_step < 5) ){
						include(ESTATE_THEME_BASEPATH.'/sections/sidebar_panel.php');

                        $subscriber_flag = ""; // jason 092913
                        if(isset($_GET['subscriber_flag'])){
                            $subscriber_flag = "&subscriber_flag=" . $_GET['subscriber_flag'];
                        }
					}
				?>
                
                <div class="span9 ">
                    <div id="addonsAccessories" class="account-content">						
                        <ul class="nav nav-tabs addons-acc">
                            <li class="active"><a data-toggle="tab" href="#addons" class="tab-addons"><span>Add Ons</span></a></li>
                            <li><a data-toggle="tab" href="#accessories" class="tab-accessories"><span>Accessories</span></a></li>
                        </ul>                    
                        <div class="tab-content addons-acc-cont">
                          <div id="addons" class="tab-pane fade active in">
							<div class="row-fluid orange" data-toggle="buttons-radio">
							   <?php 
							       if($gadget_care){ 
									   $items = $gadget_care;
									   include('partials/tpl_cart_item.php');
									} 
								?>
								<?php /*
                                <div class="btn span4" type="button">
                                    <div class="box-content">                                    
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Accidental Damage</span>
                                            <strong>P 1,800.00</strong>
                                        </div>
                                    </div>
                                </div>	
                                */ ?> 			
                            </div>                           
							<div class="row-fluid green" data-toggle="buttons-radio">
                            	<div class="addons-acc-txt">Freebies</div>
                            	
							   <?php 
							       if($freebies){ 
									   $items = $freebies;
									   include('partials/tpl_cart_item.php');
									} 
								?>			
                            </div>
							<div class="row-fluid green" data-toggle="buttons-radio">
                            	<div class="addons-acc-txt">Special Offers</div>
							   <?php 
							       if($offers){ 
									   $items = $offers;
									   include('partials/tpl_cart_item.php');
									} 
								?>					
                            </div>                                                                                   
                          </div>
                          <div id="accessories" class="tab-pane fade"  data-toggle="buttons-radio">
							<div class="row-fluid orange">
								
							   <?php 
							       if($accessories){ 
									   $items = $accessories;
									   //print_r($items);
									   include('partials/tpl_cart_item_accessories.php');
									} 
								?>
								<!--	
                                <div class="btn span4" type="button">
                                    <div class="box-content">                                    
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Headset</span>
                                            <strong>P 1,800.00</strong>
                                        </div>
                                    </div>
                                </div>
								-->
                            </div>
							
						  </div>
                        </div>
					</div>  
					<br />	
                    <!-- start bottom links -->
                    <div class="row-fluid link-bottom">
						
                        <a class="pull-left grey" href="<?php echo base_url() ?>subscriber-info">Skip &amp; Go to Subscribers Info</a>
                        
                        <?php if(empty($subscriber_flag)){ ?>
                        <div class="pull-right">
								<button class="blue-btn" id="btnAddonNextPage">Continue</button>&nbsp;&nbsp;
								<button class="blue-btn">Load More</button>                                              
                        </div>
                        <?php }else{ ?>
                            <div class="pull-right">
                                <button class="blue-btn" id="btnAddonNextPage2">Continue</button>&nbsp;&nbsp;
                                <button class="blue-btn">Load More</button>                                              
                            </div>
                        <?php } ?>
 

                    </div>
                    <div class="row-fluid link-bottom">
                            <ul class="pull-right">
                                <li><a>Contact Us</a></li>
                                <li>|</li>
                                <li><a>Live Chat</a></li>
                            </ul> 
                    </div>
                    
                    <!-- end bottom links --> 
                                                
                </div>
            
            </div>






