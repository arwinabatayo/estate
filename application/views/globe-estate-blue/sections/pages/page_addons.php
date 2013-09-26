         
              <div class="accordion row-fluid chooseplan clearfix" id="accordion2">  
             
				<?php
				    if($current_controller != 'home' && ($current_step < 5) ){
						include(ESTATE_THEME_BASEPATH.'/sections/sidebar_panel.php');
					}
				?>
                
                <div class="span9">
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
                                <div class="btn span4" type="button">
                                    <div class="box-content">                                    
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Headset</span>
                                            <strong>P 1,800.00</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn span4 active" type="button">  
                                    <div type="button" class="box-content">
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>iPhone stylus pen</span>
                                            <strong>P 3, 500.00</strong>
                                        </div>
                                    </div>                                            
                                </div>
                                <div class="btn span4" type="button">  
                                    <div class="box-content">
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Earphone</span>
                                            <strong>P 1, 800.00</strong>
                                        </div>
                                    </div>
                                </div>	
                            </div>
							<div class="row-fluid orange">
                                <div class="btn span4" type="button">
                                    <div class="box-content">                                    
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Headphones</span>
                                            <strong>P 1,800.00</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn span4" type="button">  
                                    <div type="button" class="box-content">
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Mini Keyboard</span>
                                            <strong>P 1, 800.00</strong>
                                        </div>
                                    </div>                                            
                                </div>
                                <div class="btn span4" type="button">  
                                    <div class="box-content">
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Freebies C</span>
                                            <strong>P 1, 800.00</strong>
                                        </div>
                                    </div>
                                </div>	
                            </div>
							<div class="row-fluid orange">
                                <div class="btn span4" type="button">
                                    <div class="box-content">                                    
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Special Offers A</span>
                                            <strong>P 1,800.00</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn span4" type="button">  
                                    <div type="button" class="box-content">
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Special Offers B</span>
                                            <strong>P 1,800.00</strong>
                                        </div>
                                    </div>                                            
                                </div>
                                <div class="btn span4" type="button">  
                                    <div class="box-content">
                                        <div class="boxes"></div>
                                        <div class="txts">
                                            <span>Special Offers C</span>
                                            <strong>P 1,800.00</strong>
                                        </div>
                                    </div>
                                </div>	
                            </div>                                                                           
                          </div>
                        </div>
					</div>  
                    <div class="row-fluid link-bottom">
                        <a class="pull-left">Skip and Continue</a>

                    </div>                             
                </div>
            
            </div>






