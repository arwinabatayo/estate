<div id="delivery_pickup" style="display:block">
								   <div class="textleft">
										<h4 style="font-size:24px;font-weight:normal">Pickup at Globe Stores</h4>
                                                                                
										<p id="w_store_result" style="font-size:110%;">Here's a list of Globe Stores we found near your area.</p>
								   </div>
								   
									   <div class="container-fluid">
                                                                               
                                                                               
                                                                               
                                                                               <?php if(!empty($stores_on_top)) { ?>
                                                                                 <div class="accordion" id="accordion1">
                                                                                 <?php unset($stores_on_top['total_count']);
                                                                                    foreach( $stores_on_top as $val_top ) { ?>
                                                                                 <div class="accordion-group">
									              <div class="accordion-heading">
									                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#<?php echo $val_top['id']; ?>">
									                 <?php echo $val_top['name']; ?>
									                </a>
									              </div>
                                                                                                        <?php 
                                                                                                        $properties = $store_properties[$val_top['id']];
                                                                                                            if(!empty($properties)) { ?>
                                                                                                                    <div id="<?php echo $val_top['id']; ?>" class="accordion-body collapse" style="height: 0px; ">
                                                                                                                            <?php foreach($properties as $prop) { ?>
                                                                                                                            <div class="accordion-inner">
                                                                                                                                <div class="contentbox">
                                                                                                                                        <span class="fleft"><?php echo date("F d, Y", strtotime($prop['date_of_operation'])); ?><br />
                                                                                                                                        <?php echo date("h:i:s A", strtotime($prop['time_of_operation_from'])); ?> to <?php echo date("h:i:s A", strtotime($prop['time_of_operation_to'])); ?>
                                                                                                                                        </span>
                                                                                                                                        <span class="fright">
                                                                                                                                                <input type="radio" name="<?php echo $prop['store_id']; ?>" value="1" />
                                                                                                                                        </span>
                                                                                                                                        <br class="clear" />
                                                                                                                                </div>	

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
                                                                                                       <?php echo $val['name']; ?>
                                                                                                      </a>
                                                                                                    </div>
                                                                                                    <?php 
                                                                                                        $properties = $store_properties[$val['id']];
                                                                                                            if(!empty($properties)) { ?>
                                                                                                                    <div id="<?php echo $val['id']; ?>" class="accordion-body collapse" style="height: 0px; ">
                                                                                                                            <?php foreach($properties as $prop) { ?>
                                                                                                                            <div class="accordion-inner">
                                                                                                                                <div class="contentbox">
                                                                                                                                        <span class="fleft"><?php echo date("F d, Y", strtotime($prop['date_of_operation'])); ?><br />
                                                                                                                                        <?php echo date("h:i:s A", strtotime($prop['time_of_operation_from'])); ?> to <?php echo date("h:i:s A", strtotime($prop['time_of_operation_to'])); ?>
                                                                                                                                        </span>
                                                                                                                                        <span class="fright">
                                                                                                                                                <input type="radio" name="<?php echo $prop['store_id']; ?>" value="1" />
                                                                                                                                        </span>
                                                                                                                                        <br class="clear" />
                                                                                                                                </div>	

                                                                                                                            </div>
                                                                                                                         <?php  } ?>
                                                                                                                    </div>
                                                                                                         <?php } ?>
                                                                                                </div>
                                                                                    <?php } ?>
									            
									            	
									          </div>
									    </div>
								   
							            <div class="headerbox" style="font-size:12px">
											<div class="fleft">
												<label>Choose your prefered location</label>
												<select id="prefered_loc_val">
                                                                                                    <?php foreach( $stores_all as $val ) { ?>
													<option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
                                                                                                    <?php } ?>
												</select>
												&nbsp;
												<i class="icon-search icon-2x prefered_loc_store" id="prefered_loc_search" style="cursor:pointer; cursor:hand;"></i>
											</div>
											
											<div class="fright">
												<label>Search for nearest store</label>
												<input type="text" id="store_keyword"/>&nbsp;<i class="icon-search icon-2x" id="store_search" style="cursor:pointer; cursor:hand;"></i>
											</div>
											<br class="clear" />
							            </div>
								   
								   
								   
							   </div>