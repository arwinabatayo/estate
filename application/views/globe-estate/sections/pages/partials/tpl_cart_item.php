



								   <?php 
								       if($items){ 
										   //print_r($gadget_care);
											foreach($items as $row){
												$row = (object)$row;
									   ?>
									   
												<div class="span2 product-item">
													<form id="addtoCart<?php echo $row->f_add_on_id ?>" class="addtoCart" action="" onsubmit="return false">
														 <img src="<?php echo base_url() . $assets_path ?>images/plans/temp/<?php echo $row->f_add_on_image ?>.png" alt="" />
														 <p class="bold"><?php echo $row->f_add_on_title ?></p>
														 <span class="block">Php <?php echo number_format($row->f_add_on_amount,2) ?></span>
														 <input type="hidden" name="cart_id" value="<?php echo $row->f_add_on_id ?>_addon" />
													     <input type="hidden" name="product_id" value="<?php echo $row->f_add_on_id ?>" />
													     <input type="hidden" name="product_name" value="<?php echo $row->f_add_on_title ?>" />
													     <input type="hidden" name="product_price" value="<?php echo $row->f_add_on_amount ?>" />
													     <input type="hidden" name="product_type" value="addon" />
													</form> 
												</div>
  
								   <?php 
											}
										} 
									?>
