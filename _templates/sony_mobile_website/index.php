<?php 
include("includes/controller.php");
$menu = isset($_GET['menu']) ? $_GET['menu'] : '';
 ?>
<!doctype html>
<html>

	<head>
		<meta charset="utf-8"/>
		<title><?php echo $site_data['site_settings']['title']; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!--
		<link rel="stylesheet" type="text/css" media="screen" href="css/style.css"/>
		<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
		-->
		<?php include("css/style.php"); ?>
		
		
		<script src="js/jquery.js"></script>	
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/jquery-ui-1.8.18.custom.min.js"></script>
		<script src="js/lightbox.js"></script>
		

		<script>
		$(document).ready(function(){
			$(".nav-button").click(function () {
			$(".nav-button,.primary-nav").toggleClass("open");
			});    
		});
		</script>
		<script type="text/javascript" language="javascript">
	$(function(){

		// set inpdependent time interval for both slides
		var t = setInterval(function() { changeImg('main_slide', 3); }, 5000);
		var t2 = setInterval(function() { changeImg('main_slide2', 8); }, 5000);

		$(".thumbs img").click(function(){
		
			var reference = $(this).attr('data-reference');
			var thumb_div_id = $(this).parent().attr('id');
			var main_div_id = $(this).parent().attr('data-main');
			
			if (main_div_id == "main_slide") { clearInterval(t); }
			if (main_div_id == "main_slide2") { clearInterval(t2); }
			
			// update marker for thumb
			$("#"+thumb_div_id+" img").each(function(){
				$(this).removeClass('active');
				if (reference == $(this).attr('data-reference')) { $(this).addClass('active'); }
			});
			
			// update image in slider
			$("#"+main_div_id+" img").each(function(){
				$(this).css("visibility", "hidden");
				if (reference == $(this).attr('data-reference')) { 
					$(this).css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}, 1000);
					$("#"+main_div_id+" #current_active").val($(this).attr('data-reference'));
				}
			});
			
			if (main_div_id == "main_slide") { t = setInterval(function() { changeImg(main_div_id, 3); }, 5000); }
			if (main_div_id == "main_slide2") { t2 = setInterval(function() { changeImg(main_div_id, 8); }, 5000); }
			
		});

	});

	function changeImg(div_id, item_total) {
		var current_active = $("#"+div_id+" #current_active").val();
		
		if (current_active < item_total) { 
			// update image in slider
			$("#"+div_id+" img").each(function(){
				$(this).css("visibility", "hidden");
				if (parseInt(current_active)+1 == $(this).attr('data-reference')) { 
					$(this).css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0}, 1000);
					$("#"+div_id+" #current_active").val($(this).attr('data-reference'));
				}
			});
			
			// update marker for thumb
			$("#"+div_id+"_thumbs img").each(function(){
				$(this).removeClass('active');
				if (parseInt(current_active)+1 == $(this).attr('data-reference')) { $(this).addClass('active'); }
			});
		} else if (current_active == item_total) {
			// update image in slider
			$("#"+div_id+" img").each(function(){
				$(this).css("visibility", "hidden");
				if ($(this).attr('data-reference') == 1) { 
					$(this).css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0});
					$("#"+div_id+" #current_active").val("1");
				}
			});
			// update marker for thumb
			$("#"+div_id+"_thumbs img").each(function(){
				$(this).removeClass('active');
				if ($(this).attr('data-reference') == 1) { $(this).addClass('active'); }
			});
		}
		return;
	}
	</script>

	</head>

	<body>
		
	<div id="wrapper">
<!--- start of menu -->
		<button class="nav-button">Toggle Navigation</button>
		<div class="nav_holder">
			<ul class="primary-nav">
				
					<?php $counter = 1; 
					$menu_no = 0;
					?>
			 <?php if ($site_data['nav_menu']) { ?>
			 <?php foreach ($site_data['nav_menu'] as $slide_item) { ?>
					<li>
						<a href="?menu=<?php echo $counter; ?>" <?php if(($counter == $menu) ){ echo 'class="active"'; } ?>>
						<?php echo $site_data['nav_menu']['menu_'.$counter]; ?>
						
						</a>
					</li>
			 <?php 
			 
			 $counter++; 
			 $menu_no += 1;
			 ?>
				
			 <?php } ?>
			 <?php } ?>
			
			</ul>
		</div>
		<!--- end of menu -->
		<a href="" class="logo"></a>
		<div id="social_holder" >
			<a href="<?php echo $site_data['social_link']['facebook']; ?>"><img src="images/social_facebook.png" title="facebook" /></a>
			<a href="<?php echo $site_data['social_link']['twitter']; ?>"><img src="images/social_twitter.png" title="twitter" /></a>
			<a href="<?php echo $site_data['social_link']['pinterest']; ?>"><img src="images/social_pinterest.png" title="pinterest" /></a>
			<a href="<?php echo $site_data['social_link']['googleplus']; ?>"><img src="images/social_googleplus.png" title="googleplus" /></a>
		</div> 
		
		<?php 
		
		if(($menu == 1) || ($menu == "") || ($menu > $menu_no) ){
		?>
			<div id="slide_holder">
			<div id="main_slide">
				
			<?php $counter = 1; ?>
			 <?php if ($site_data['slider_images']) { ?>
			 <?php foreach ($site_data['slider_images'] as $slide_item) { ?>	
				<a href="<?php echo $site_data['slider_link']['link_'.$counter]; ?>" target="_blank"><img src="assets/<?php echo $site_data['slider_images']['image_'.$counter]; ?>" data-reference="<?php  echo $counter; ?>" class="active" /></a>
			<?php $counter++; ?>
				
			 <?php } ?>
			 <?php } ?>
			</div>
			<div id="main_slide_thumbs" class="thumbs" data-main="main_slide">
			<?php $counter = 1; ?>
			 <?php if ($site_data['slider_thumb_images']) { ?>
			 <?php foreach ($site_data['slider_thumb_images'] as $slide_item) { ?>
					<img src="assets/<?php echo $site_data['slider_thumb_images']['image_'.$counter]; ?>" data-reference="<?php  echo $counter; ?>" <?php if($counter == 1 ){ echo 'class="active"'; } ?> />
			<?php $counter++; ?>
				
			 <?php } ?>
			 <?php } ?>
			</div>
			<div id="main_side">
				<div class="sub_label"><?php echo $site_data['label']['sub_label']; ?></div>
				<div class="content">
				<?php echo $site_data['label']['content']; ?>
				</div>
				
				
			</div>
						
		</div>
		
		<div id="main_image_holder">
		
			<img src="assets/<?php echo $site_data['main_image']['image']; ?>"  />
	
		</div>
		<?php }elseif($menu == 2){ ?>
		
		<div id="image_holder">
			
			<div id="featured">
			<?php $counter = 1; ?>
			 <?php if ($site_data['featured_images']) { ?>
			 <?php foreach ($site_data['featured_images'] as $slide_item) { ?>
				<a href="<?php echo $site_data['featured_link']['link_'.$counter]; ?>">
				<div class="item">
					<img src="assets/<?php echo $site_data['featured_images']['image_'.$counter]; ?>">
					<div class="content"><?php echo $site_data['featured_details']['details_'.$counter]; ?></div>
				</div>
				</a>
				<?php $counter++; ?>
				
			 <?php } ?>
			 <?php } ?>	
				
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<?php }elseif($menu == 3){ ?>
		
		<div id="main_image_holder">
		
			<img src="assets/<?php echo $site_data['catalog_image']['image']; ?>"  />
	
		</div>
		<?php }elseif($menu == 4){ ?>
		<div id="image_holder">
			<link href="css/photoswipe.css" type="text/css" rel="stylesheet" />
			<script type="text/javascript" src="js/klass.min.js"></script>
			<script type="text/javascript" src="js/code.photoswipe-3.0.5.min.js"></script>
			
			
			<script type="text/javascript">

				(function(window, PhotoSwipe){
				
					document.addEventListener('DOMContentLoaded', function(){
					
						var
							options = {},
							instance = PhotoSwipe.attach( window.document.querySelectorAll('#gallery a'), options );
					
					}, false);
					
					
				}(window, window.Code.PhotoSwipe));
				
			</script>
	
			<div id="gallery">
			<?php $counter = 1; ?>
			 <?php if ($site_data['gallery_images']) { ?>
			 <?php foreach ($site_data['gallery_images'] as $slide_item) { ?>
				<div  class="item">
					
						<div class="inner">
						
							<a class="fancybox" href="assets/<?php echo $site_data['gallery_images']['image_'.$counter]; ?>"  ><img src="assets/<?php echo $site_data['gallery_images']['image_'.$counter]; ?>" alt="" /></a>
						</div>
					
				</div>
			<?php $counter++; ?>
				
			 <?php } ?>
			 <?php } ?>	
			</div>
		
			<div style="clear:both;"></div>
		</div>
		<?php }elseif($menu == 5){ ?>
		
		
		
		<div id="image_holder" style="padding:25px;">
			<span style="font-size: large;"><strong><?php echo $site_data['site_settings']['site_name']; ?></strong></span>
			<div style="font-size:12px;">	
			<?php echo $site_data['site_settings']['site_about']; ?>
			</div>
		</div>
		<?php } ?>
		
		
		<div id="footer_holder">
			
			 <?php $counter = 1; ?>
			 <?php if ($site_data['nav_menu']) { ?>
			 <?php foreach ($site_data['nav_menu'] as $slide_item) { ?>
					<a href="?menu=<?php echo $counter; ?>"><?php echo $site_data['nav_menu']['menu_'.$counter]; ?></a>
			 <?php $counter++; ?>
				
			 <?php } ?>
			 <?php } ?>
				
			</div>
		</div>
	</div>	
	</body>

</html>