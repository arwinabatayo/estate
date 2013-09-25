			<div class="span6 textcenter">
				<br ><br ><br ><br ><br >
			<form id="addGadget" action="" onsubmit="return false">	
				<h3>iPhone 5</h3>
				<?php
					$query = $this->db->get('estate_product');
					$products = $query->result();
					
					$img ='';
					$lbl ='';
					
					if($products){
						foreach($products as $prod){
							$img .= '<img src="_products/'.$prod->product_image.'" class="p_img c_'.strtolower($prod->product_color).'" alt="'.$prod->product_name.'" />';
							$lbl .= '<input type="radio" id="iph5_'.strtolower($prod->product_color).'" class="opt_color" value="'.strtolower($prod->product_color).'" name="gadget_color" />  <label style="display:inline" for="iph5_'.strtolower($prod->product_color).'">'.$prod->product_color.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						}
					}
				?>
				<div class="textcenter">
					<?php /*
					<!--
					<input type="radio" id="iph5_black" class="opt_color" value="black" name="sku_gadget" checked="checked" />  <label style="display:inline" for="iph5_black">Black</label>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="iph5_white" class="opt_color" value="white" name="sku_gadget">  <label style="display:inline" for="iph5_white">White</label>
					-->*/ ?>
					<?php echo $lbl ?>
				</div>
				
				
				<?php /*
				<div class="radioset">
					<input type="radio" id="iph5_black" class="opt_color" value="black" name="sku_gadget" checked="checked"><label for="iph5_black">Black</label>
					<input type="radio" id="iph5_white" class="opt_color" value="white" name="sku_gadget"><label for="iph5_white">White</label>
				</div>
				<div class="radioset">
					<input type="radio" id="gs4_blk" class="opt_color" value="blk" name="gadget_gs4" checked="checked"><label for="gs4_blk">Black Mist</label>
					<input type="radio" id="gs4_blu" class="opt_color" value="blu" name="gadget_gs4"><label for="gs4_blu">Blue Artic</label>
					<input type="radio" id="gs4_pnk" class="opt_color" value="pnk" name="gadget_gs4"><label for="gs4_pnk">Pink Twilight</label>
				</div>
				<div class="radioset textcenter">
					<input type="radio" id="gs4_16" name="gadget_capacity" checked="checked"><label for="gs4_16">&nbsp;&nbsp;&nbsp;&nbsp;16 GB&nbsp;&nbsp;&nbsp;</label>
					<input type="radio" id="gs4_32" name="gadget_capacity"><label for="gs4_32">&nbsp;&nbsp;&nbsp;32 GB&nbsp;&nbsp;&nbsp;</label>
					<input type="radio" id="gs4_64" name="gadget_capacity"><label for="gs4_64">&nbsp;&nbsp;&nbsp;&nbsp;64 GB&nbsp;&nbsp;&nbsp;</label>
				</div>
				
				**/ 
				?>
				
				<br />
				<div class="textcenter">
					<input type="radio" id="gs4_16" value="16" name="gadget_capacity" checked="checked"><label style="display:inline" for="gs4_16"> 16 GB</label>
					&nbsp;&nbsp;&nbsp;
					<input type="radio" id="gs4_32" value="32" name="gadget_capacity"><label style="display:inline" for="gs4_32"> 32 GB </label>
					&nbsp;&nbsp;&nbsp;
					<input type="radio" id="gs4_64" value="64" name="gadget_capacity"><label style="display:inline" for="gs4_64"> 64 GB </label>
				</div>
				<br />
				<br />
				
	            <!--<p><button  class="btn-large ui-button-success open-dialog" id="open_enter_email" rel="dialog_enter_email">CONTINUE</button></p>-->
	            <p><button  class="btn-large ui-button-success" id="open_enter_email" rel="dialog_enter_email">CONTINUE</button></p>
								
								 <?php /*TODO: make it db driven */ ?>
								 <input type="hidden" name="cart_id" value="1_gadget" />
							     <input type="hidden" name="product_id" value="1" />
							     <input type="hidden" name="product_name" value="iPhone 5" />
							     <input type="hidden" name="product_price" value="12500" />
							     <input type="hidden" name="product_type" value="gadget" />
							     <?php if ($is_reserve) { ?>
							     	<input type="hidden" name="is_reserve" value="<?php echo $is_reserve; ?>" id="is_reserve" />
							     <?php } ?>

	            </form>
	            
	            <p><a href="#">Go to Comparison Page</a></p> 
	            
				<?php /*<p>
					<strong>Din't receive the verification email?</strong> &nbsp;&nbsp;
					<a href="javascript:void(0)" class="open-dialog" rel="dialog_enter_email">Resend Link</a>
				</p> */ ?>
	            
			</div>
			<div class="span6 textcenter">
				<div id="product_preview">
					<?php 
						echo $img;
					/*
					
					<img src="<?php echo $assets_url ?>images/iphone5/iphone5-black.jpg" class="p_img c_black" alt="" />
					<img src="<?php echo $assets_url ?>images/iphone5/iphone5-white.jpg" class="p_img c_white" alt="" />
					*/ ?>
					<?php /* baka ibalik ulet sa samsung :-\
					<img src="<?php echo $assets_url?>images/gs4/gs4_black.jpg" class="p_img c_blk" alt="" />
					<img src="<?php echo $assets_url?>images/gs4/gs4_pink.jpg" class="p_img c_pnk" alt="" />
					<img src="<?php echo $assets_url?>images/gs4/gs4_blue.jpg" class="p_img c_blu" alt="" />
					**/ ?>
				</div>	
			</div>
