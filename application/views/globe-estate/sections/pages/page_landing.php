
			<div class="span8 divcenter" id="landing-page">
				<div class="row banner">
					<img src="<?php echo $assets_url ?>images/iphone5/landing/banner-image.jpg">
					<div class="text">
						<div class="lp-label">iPhone 5</div>
						<div class="lp-sub">Loving it is easy. <br> That's why so many people do.</div>

							<!--<form id="addGadget" class="addtoCart" action="" onsubmit="return false">-->
							<?php if(!$show_reserve_button){ ?>
							<button class="lp-button" onclick="window.location.href='<?php echo base_url()?>sku-configuration'">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buy Now&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</button>

							<?php } else { ?>

							<button class="lp-button" onclick="window.location.href='<?php echo base_url()?>sku-configuration?reserve=true'">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reserve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</button>

							<?php } ?>

								 <input type="hidden" name="cart_id" value="1_gadget" />
							     <input type="hidden" name="product_id" value="1" />
							     <input type="hidden" name="product_name" value="iPhone 5" />
							     <input type="hidden" name="product_price" value="12500" />
							     <input type="hidden" name="product_type" value="gadget" />
						<!--</form>-->
					</div>
				</div>

				<div class="textrow" style="border-top:1px solid #ccc">
					<div class="item"><img src="<?php echo $assets_url ?>images/iphone5/landing/row-1.jpg" /></div>
					<div class="item text"><span>All-new design</span>iPhone 5 features a 4-inch Retina display, ultrafast wireless, the powerful A6 chip, an 8-megapixel iSight camera with panorama, iOS 6, and iCloud. Yet it's the thinnest, lightest iPhone ever.</div>
					<div class="clear"></div>
				</div>

				<div class="textrow">
					<div class="item text"><span>4-inch Retina display</span>See more of everything - your inbox, every web page, an extra row of apps - on the larger display. With 326 pixels per inch, it all lokks amazing.</div>
					<div class="item"><img src="<?php echo $assets_url ?>images/iphone5/landing/row-2.jpg" /></div>
					<div class="clear"></div>
				</div>

				<div class="textrow">
					<div class="item"><img src="<?php echo $assets_url ?>images/iphone5/landing/row-3.jpg" /></div>
					<div class="item text"><span>Ultrafast wireless</span>iPhone 5 connects to more networks all over the world. And Wi-Fi is faster too. So you can browse, download, and stream content at remarkable speeds, wherever you happen to be.</div>
					<div class="clear"></div>
				</div>

				<div class="textrow">
					<div class="item text"><span>A6 chip</span>The power-efficient A6 chip deliver up to twice the CPU performance and renders graphics up to twice as fast - with even better battery life.</div>
					<div class="item"><img src="<?php echo $assets_url ?>images/iphone5/landing/row-4.jpg" /></div>
					<div class="clear"></div>
				</div>

				<div class="textrow">
					<div class="item"><img src="<?php echo $assets_url ?>images/iphone5/landing/row-5.jpg" /></div>
					<div class="item text"><span>8MP iSight camera</span>Advanced optics, a custom lens, and an 8-megapixel sensor capture high-quality photos, even in panorama. And you can record 1080p HD video with improved stabilization.</div>
					<div class="clear"></div>
				</div>

				<div class="textrow">
					<div class="item text"><span>iOS 6</span>The world's most advanced mobile operating system now has all-new Maps, Facebook intefration, Passbook and more.</div>
					<div class="item"><img width="100%" src="<?php echo $assets_url ?>images/iphone5/landing/row-6.jpg" /></div>
					<div class="clear"></div>
				</div>

			</div>


			<?php if( isset($_GET['showtymsg']) ){ ?>
	            <div class="globe-dialog" id="dialog_thankyou_reserve" title="Thank You!">
					<p>We will send you an email update once the device become available.</p>
	            </div>
			<?php } ?>
