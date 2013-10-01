	                    
	                    

           <h3>Pickup</h3>
            
		    <!--content-->
		    <div  style="background:linear-gradient(to bottom, #ffffff 0%,#d7e2f1 100%);">
		      
					<div class="pickup">
						<form action="" method="post">
							<div class="p-search fl">
								<label for="Search for nearest location">Search for nearest location</label>
								<input type="text" id="store_keyword"/>
                                                                
                                                                
							</div>
							
							<div class="p-select fr">
								<label for="Choose your preferred location">Choose your preferred location</label>
								<select name="" id="prefered_loc_search" class="p-location">
									 <?php foreach( $stores_all as $val ) { ?>
                                                                          <option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                                <?php } ?>
								</select>
                                                                
                                                               
                                                                
                                                                
							</div>
							
							<div class="clr"></div>
						</form>
						
						<hr/>
						
						<!--p>5 of 15 GLOBE STORE LOCATION NEAR YOUR BILLING ADDRESS</p-->
						
						<div class="pickup-places-accordion">
                                                    <?php if(!empty($stores_on_top)) { ?>
                                                                                 <div class="accordion" id="accordion1">
                                                                                 <?php unset($stores_on_top['total_count']);
                                                                                    foreach( $stores_on_top as $val_top ) { ?>
                                                                                 <div class="accordion-group">
									              <div class="accordion-heading">
									                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#<?php echo $val_top['id']; ?>">
                                                                                            <?php echo $val_top['name']; ?> <i class="icon-arrow-down pull-right"></i>
									                </a>
									              </div>
                                                                                                        <?php 
                                                                                                        $properties = $store_properties[$val_top['id']];
                                                                                                            if(!empty($properties)) { ?>
                                                                                                                    <div id="<?php echo $val_top['id']; ?>" class="accordion-body collapse" style="height: 0px; ">
                                                                                                                            <?php foreach($properties as $prop) { ?>
                                                                                                                            <div class="accordion-inner pick-up-content">
                                                                                                                        <div class="span4 p-u-c-cal">
                                                                                                                                <p><?php echo date("F d, Y", strtotime($prop['date_of_operation'])); ?></p>
                                                                                                                        </div>
                                                                                                                        <div class="span4 p-u-c-time">
                                                                                                                                <p><?php echo date("h:i:s A", strtotime($prop['time_of_operation_from'])); ?> - <?php echo date("h:i:s A", strtotime($prop['time_of_operation_to'])); ?></p>
                                                                                                                        </div>
                                                                                                                        <div class="span4">
                                                                                                                                <span class="radio-btn"><input type="radio" name="pickup_store" id="flat-radio-1"/></span>
                                                                                                                        </div>
                                                                                                                        <div class="clr"></div><br />
                                                                                                                </div>
                                                                                                                         <?php  } ?>
                                                                                                                    </div>
                                                                                                         <?php } ?>
									            </div>
                                                                                    <?php } ?>
                                                                                 
                                                                                 </div>
                                                                                <?php }?>
							<div class="accordion store_placeholder" id="accordion2">
								
								
								<?php unset($stores['total_count']);
                                                                        foreach( $stores as $val ) { ?>
                                                                                <div class="accordion-group">
                                                                                        <div class="accordion-heading">
                                                                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $val['id']; ?>">
                                                                                                        <?php echo $val['name']; ?> <i class="icon-arrow-down pull-right"></i>
                                                                                                </a>
                                                                                        </div>
                                                                                    <?php 
                                                                                         $properties = $store_properties[$val['id']];
                                                                                               if(!empty($properties)) { ?>
                                                                                                         <div id="<?php echo $val['id']; ?>" class="accordion-body collapse" style="height: 0px; ">
                                                                                                                            <?php foreach($properties as $prop) { ?>
                                                                                                                <div class="accordion-inner pick-up-content">
                                                                                                                        <div class="span4 p-u-c-cal">
                                                                                                                                <p><?php echo date("F d, Y", strtotime($prop['date_of_operation'])); ?></p>
                                                                                                                        </div>
                                                                                                                        <div class="span4 p-u-c-time">
                                                                                                                                <p><?php echo date("h:i:s A", strtotime($prop['time_of_operation_from'])); ?> - <?php echo date("h:i:s A", strtotime($prop['time_of_operation_to'])); ?></p>
                                                                                                                        </div>
                                                                                                                        <div class="span4">
                                                                                                                                <span class="radio-btn"><input type="radio" name="pickup_store" id="flat-radio-1"/></span>
                                                                                                                        </div>
                                                                                                                        <div class="clr"></div><br />
                                                                                                                </div>
                                                                                                            <?php  } ?>
                                                                                                        </div>
                                                                                               <?php } ?>
                                                                                </div>
                                                            <?php } ?>
							</div>					
						</div>
					</div>
		
		    </div>
		    <div class="row-fluid link-bottom">
					<div class="pull-right">
							<button class="blue-btn" onclick="window.location='<?php echo base_url() ?>confirm-order'">Continue</button>   
					</div>
		    </div>
		    
			<div class="row-fluid link-bottom">
					<ul class="pull-right">
						<li><a>Contact Us</a></li>
						<li>|</li>
						<li><a>Live Chat</a></li>
					</ul> 
			</div>
                    
		
