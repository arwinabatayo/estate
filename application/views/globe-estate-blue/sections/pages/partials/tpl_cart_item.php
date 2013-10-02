									<?php 
								       if($items){ 
										   //print_r($gadget_care);
											foreach($items as $row){
												$row = (object)$row;
									   ?>
									   
		                                <div class="btn span4" type="button">
		                                    <form id="addtoCart<?php echo $row->category_id ?>_<?php echo $row->id ?>" class="addtoCart" action="" onsubmit="return false">
			                                    <div class="box-content">     
			                                        <div class="boxes"></div>
			                                         <div class="txts">
			                                            <span><?php echo $row->title ?></span>
			                                            <strong>P <?php echo number_format($row->amount,2) ?></strong>
			                                         </div>
													 <input type="hidden" name="cart_id" value="<?php echo $row->id ?>_addon" />
												     <input type="hidden" name="product_id" value="<?php echo $row->id ?>" />
												     <input type="hidden" name="product_name" value="<?php echo $row->title ?>" />
												     <input type="hidden" name="product_price" value="<?php echo $row->amount ?>" />
												     <input type="hidden" name="product_type" value="addon" />
													
			                                    </div>
		                                    </form> 
		                                </div>
		                                
								   <?php 
											}
										} 
									?>