



								   <?php 
								       if($items){ 
   
											foreach($items as $row){
												$row = (object)$row;
												
									   ?>
									   
												<div class="span2 product-item">
													<form id="addtoCartAccessory<?php echo $row->id ?>" class="addtoCart" action="" onsubmit="return false">
														 <img src="<?php echo base_url().$assets_path ?>images/plans/temp/<?php echo $row->image ?>.png" alt="" />
														 <p class="bold"><?php echo $row->title ?></p>
														 <span class="block">Php <?php echo number_format($row->amount,2) ?></span>
													     <input type="hidden" name="cart_id" value="<?php echo $row->id ?>_accessories" />
													     <input type="hidden" name="product_id" value="<?php echo $row->id ?>" />
													     <input type="hidden" name="product_name" value="<?php echo $row->title ?>" />
													     <input type="hidden" name="product_price" value="<?php echo $row->amount ?>" />
													     <input type="hidden" name="product_discount" value="0" />
													     <input type="hidden" name="product_type" value="accessories" />
													</form> 
												</div>
  
								   <?php 
											}
										} 
									?>
