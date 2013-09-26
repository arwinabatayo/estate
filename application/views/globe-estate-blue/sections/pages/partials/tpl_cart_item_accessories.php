



								   <?php 
								       if($items){ 
										   
										   
   
											$i=1;
											foreach($items as $row){
												$row = (object)$row;
												
									   ?>

											<form id="addtoCartAccessory<?php echo $row->id ?>" class="addtoCart" action="" onsubmit="return false">				
				                                <div class="btn span4" type="button">
				                                    <div class="box-content">                                    
				                                        <div class="boxes"></div>
				                                        <div class="txts">
				                                            <span><?php echo $row->title ?></span>
				                                            <strong>Php <?php echo number_format($row->amount,2) ?></strong>
				                                        </div>
				                                    </div>
				                                </div>
											     <input type="hidden" name="cart_id" value="<?php echo $row->id ?>_accessories" />
											     <input type="hidden" name="product_id" value="<?php echo $row->id ?>" />
											     <input type="hidden" name="product_name" value="<?php echo $row->title ?>" />
											     <input type="hidden" name="product_price" value="<?php echo $row->amount ?>" />
											     <input type="hidden" name="product_discount" value="0" />
											     <input type="hidden" name="product_type" value="accessories" />
											</form> 
											
								   <?php 
											
												if($i % 3 == 0){
													echo '</div>'."\n";
													echo '<div class="row-fluid orange">'."\n";
												}
												
												$i++;
											
											
											
											}

											
										} 
									?>
