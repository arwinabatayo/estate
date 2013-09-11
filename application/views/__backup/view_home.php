<div class="img_loader">
	<img src="<?php echo base_url(); ?>_assets/images/home/slide_1.jpg" />
	<img src="<?php echo base_url(); ?>_assets/images/home/slide_2.jpg" />
	<img src="<?php echo base_url(); ?>_assets/images/home/slide_3.jpg" />
	<img src="<?php echo base_url(); ?>_assets/images/home/slide_4.jpg" />
	
	<img src="<?php echo base_url(); ?>_assets/images/carousel_navigation.png" />
</div>

<div class="loader">
	<img src="<?php echo base_url(); ?>_assets/images/loading_2.gif" />
</div>

<div class="hm_slide">

	<img src="<?php echo base_url(); ?>_assets/images/home/slide_1.jpg" data-ref="1" class="slide_item active" />
	<img src="<?php echo base_url(); ?>_assets/images/home/slide_2.jpg" data-ref="2" class="slide_item" />
	<img src="<?php echo base_url(); ?>_assets/images/home/slide_3.jpg" data-ref="3" class="slide_item" />
	<img src="<?php echo base_url(); ?>_assets/images/home/slide_4.jpg" data-ref="4" class="slide_item" />
	
	<div class="caption">
	<div class="caption_inner">
		<table><tr><td valign="center">		
			<div class="label_main">Incite.</div>
			<div class="label_sub">Launch a business revolution online through SiteMee’s services.</div>
		</td></tr></table>
	</div>
	</div>
	
	<div class="navigation_wrapper">
	<div class="navigation">
		<div class="left"></div>
		<div class="right"></div>
	</div>
	</div>
	
</div>

<input type="hidden" id="current_active" value="1" />

<div class="g_inner">
<div class="hm_wrapper">
	
	<div class="hm_header">
		<div class="hm_contact">
			<a href="<?php echo base_url(); ?>contact-us">Contact Us</a>
		</div>
		<div class="hm_text">
			<div class="main">Discover the power of SiteMee</div>
			<div class="sub">Websites, Mobile Sites, Mobile Apps, and Social Media: We help you soar.</div>
		</div>
		<div class="h_clearboth"></div>
		
		<div class="hm_divider"></div>
	</div>
	
	<div class="hm_body">
		<div class="label">Our Services</div>
		<div class="grid">
			<div class="item">
			<div class="inner">
				<img src="<?php echo base_url(); ?>_assets/images/home/item_1.png" />
				<div class="label">The Sitemee Web Solutions</div>
				<div class="label_sub">Your business in a desktop.</div>
				<div class="content">Be empowered. Make a choice. Establish authority. Win customers over through a quality website.</div>
				<div class="readmore" style="display: none;"><a href="">Read More...</a></div>
			</div>
			</div>
			
			<div class="item">
			<div class="inner">
				<img src="<?php echo base_url(); ?>_assets/images/home/item_2.png" />
				<div class="label">The Sitemee Mobile Site Solutions</div>
				<div class="label_sub">Your business on the go.</div>
				<div class="content">Enjoy screen compatibility. Maintain brand consistency. Optimize performance. Get a mobile website today.</div>
				<div class="readmore" style="display: none;"><a href="">Read More...</a></div>
			</div>
			</div>
			
			<div class="spacer"></div>
			
			<div class="item">
			<div class="inner">
				<img src="<?php echo base_url(); ?>_assets/images/home/item_3.png" />
				<div class="label">The SiteMee Mobile and Tablet Apps</div>
				<div class="label_sub">Your business gone smarter.</div>
				<div class="content">Provide brand information. Establish content fluidity. Offer usability to your customers.</div>
				<div class="readmore" style="display: none;"><a href="">Read More...</a></div>
			</div>
			</div>
			
			<div class="item">
			<div class="inner">
				<img src="<?php echo base_url(); ?>_assets/images/home/item_4.png" />
				<div class="label">The SiteMee Facebook Promo Generator</div>
				<div class="label_sub">Your business gone social.</div>
				<div class="content">Get potential exposure to over 1 billion users. Create a professional Facebook Business page. Execute instantaneous changes.</div>
				<div class="readmore" style="display: none;"><a href="">Read More...</a></div>
			</div>
			</div>
			<div class="h_clearboth"></div>
		</div>
	</div>
	
</div>
</div>

<script type="text/javascript" language="javascript">
var t = "";
var slide_items = 0;
var interval = 0;
var labels = new Array();
var captions = new Array();

// detect if all images have been loaded
$(window).load(function(){
	$('.hm_slide').fadeIn();
	$(".loader").hide();
	console.log('Loading of slide items complete!');
	
	interval = 6000;
	t = setInterval("nextSlide()", interval);
	slide_items = $(".hm_slide .slide_item").length;

	labels = new Array();
	labels[1] = "Incite.";
	labels[2] = "Ignite.";
	labels[3] = "Innovate.";
	labels[4] = "SiteMee.";

	captions = new Array();
	captions[1] = "Launch a business revolution online through SiteMee’s services.";
	captions[2] = "Sustain your business passion by using SiteMee’s services as a fuel.";
	captions[3] = "Foster entrepreneurial curiosity through the innovative potentials SiteMee offers.";
	captions[4] = "We make your business soar.";
});

// next and previous slide navigation
$(".navigation .left").click(function(){ prevSlide(); });
$(".navigation .right").click(function(){ nextSlide(); });

// trigger resizing when normally loaded
$(window).load(function() {
	if ($(window).width() <= 800) {
		$(".hm_slide img").each(function(){
			$(this).css('margin-left', "-" + ($(this).width()/2) + "px");
			$(".hm_slide").css('height', "200px");
		});
	} else {
		$(".hm_slide img").each(function(){
			$(this).css('margin-left', "0px");
			$(".hm_slide").css('height', $(this).height() + "px");
		});
	}
});

// trigger resizing when window is resized manually
$(window).bind("resize", function(){
	if ($(window).width() <= 800) {
		$(".hm_slide img").each(function(){
			$(this).css('margin-left', "-" + ($(this).width()/2) + "px");
			$(".hm_slide").css('height', "200px");
		});
	} else {
		$(".hm_slide img").each(function(){
			$(this).css('margin-left', "0px");
			$(".hm_slide").css('height', $(this).height() + "px");
		});
	}
});

function nextSlide()
{
	clearInterval(t);
	var current_active = $("#current_active").val();
	$(".hm_slide .slide_item").each(function(){
		if ($(this).hasClass('active')) { 
			$(this).removeClass('active'); 
		}
		
		if ((current_active == slide_items) && ($(this).attr('data-ref') == $("#current_active").val())) {
			$(".hm_slide .slide_item:first").addClass('active'); 
			$(".hm_slide .slide_item:first").css('visibility', 'hidden');
			$(".caption").hide();
			$(".hm_slide .slide_item:first").css({opacity: 0, visibility: "visible"}).animate({opacity: 1},500, function(){ 
				$(".hm_slide .slide_item:not(.active)").each(function(){ $(this).css('visibility', 'hidden'); });
				$(".caption .label_main").html(labels[$(".hm_slide .slide_item:first").attr('data-ref')]);
				$(".caption .label_sub").html(captions[$(".hm_slide .slide_item:first").attr('data-ref')]);
				$(".caption").fadeIn(500);
			});
			$("#current_active").val($(".hm_slide .slide_item:first").attr('data-ref'));
		} else if (parseInt(current_active)+1 == $(this).attr('data-ref')) { 
			$(this).addClass('active'); 
			$(this).css('visibility', 'hidden');
			$(".caption").hide();
			$(this).css({opacity: 0, visibility: "visible"}).animate({opacity: 1},500, function(){ 
				$(".hm_slide .slide_item:not(.active)").each(function(){ $(this).css('visibility', 'hidden'); });
				$(".caption .label_main").html(labels[$(this).attr('data-ref')]);
				$(".caption .label_sub").html(captions[$(this).attr('data-ref')]);
				$(".caption").fadeIn(500);
			});
			$("#current_active").val($(this).attr('data-ref'));
		}
	});
	t = setInterval("nextSlide()", interval);
	return;
}

function prevSlide()
{
	clearInterval(t);
	var current_active = $("#current_active").val();
	$(".hm_slide .slide_item").each(function(){
		if ($(this).hasClass('active')) { 
			$(this).removeClass('active'); 
		}
		
		if ((current_active == 1) && ($(this).attr('data-ref') == $("#current_active").val())) {
			$(".hm_slide .slide_item:last").addClass('active'); 
			$(".hm_slide .slide_item:last").css('visibility', 'hidden');
			$(".caption").hide();
			$(".hm_slide .slide_item:last").css({opacity: 0, visibility: "visible"}).animate({opacity: 1},500, function(){ 
				$(".hm_slide .slide_item:not(.active)").each(function(){ $(this).css('visibility', 'hidden'); });
				$(".caption .label_main").html(labels[$(".hm_slide .slide_item:last").attr('data-ref')]);
				$(".caption .label_sub").html(captions[$(".hm_slide .slide_item:last").attr('data-ref')]);
				$(".caption").fadeIn(500);
			});
			$("#current_active").val($(".hm_slide .slide_item:last").attr('data-ref'));
		} else if (parseInt(current_active)-1 == $(this).attr('data-ref')) { 
			$(this).addClass('active'); 
			$(this).css('visibility', 'hidden');
			$(".caption").hide();
			$(this).css({opacity: 0, visibility: "visible"}).animate({opacity: 1},500, function(){ 
				$(".hm_slide .slide_item:not(.active)").each(function(){ $(this).css('visibility', 'hidden'); });
				$(".caption .label_main").html(labels[$(this).attr('data-ref')]);
				$(".caption .label_sub").html(captions[$(this).attr('data-ref')]);
				$(".caption").fadeIn(500);
			});
			$("#current_active").val($(this).attr('data-ref'));
		}
	});
	t = setInterval("nextSlide()", interval);
	return;
}
</script>