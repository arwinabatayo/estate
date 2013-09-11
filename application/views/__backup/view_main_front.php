<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

	<head>
	
		<title>Sitemee</title>
		
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name='description' content='Sitemee' />
		<meta name="author" content="Jeri Ilao">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/util.js?"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/validate_form.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/_helpers.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/fonts.css?<?php echo time(); ?>" type="text/css" />
		
		<?php 
		$IE6 = (ereg('MSIE 6',$_SERVER['HTTP_USER_AGENT'])) ? true : false;
		$IE7 = (ereg('MSIE 7',$_SERVER['HTTP_USER_AGENT'])) ? true : false;
		$IE8 = (ereg('MSIE 8',$_SERVER['HTTP_USER_AGENT'])) ? true : false;
		?>
		
		<?php if ($IE6 || $IE7 || $IE8) { ?>
			<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/ie8/<?php echo $page; ?>.css?<?php echo time(); ?>" />
			<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/ie8/_global.css?<?php echo time(); ?>" />
		<?php } else { ?>
			<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/<?php echo $page; ?>.css?<?php echo time(); ?>" />
			<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/_global.css?<?php echo time(); ?>" />		
		<?php } ?>
		
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>_assets/images/favicon.png">
		
	</head>
	
	<body>
		
		<div class="g_top">
		
			<div class="g_banner">
			<div class="g_inner">
				<div class="g_logo">
					<a href="<?php echo base_url(); ?>">
					<img src="<?php echo base_url(); ?>_assets/images/logo.png" />
					</a>
				</div>
				<div class="g_menu">
					<ul>
						<li class="<?php echo ($page == "home") ? "active" : ""; ?> <?php echo ($sess_user['logged_in']) ? "h_paddingtop50" : ""; ?>"><a href="<?php echo base_url(); ?>">Home</a><span></span></li>
						<li class="<?php echo ($page == "about") ? "active" : ""; ?> <?php echo ($sess_user['logged_in']) ? "h_paddingtop50" : ""; ?>"><a href="<?php echo base_url(); ?>about-us">About Us</a><span></span></li>
						<li class="<?php echo ($page == "features") ? "active" : ""; ?> <?php echo ($sess_user['logged_in']) ? "h_paddingtop50" : ""; ?>"><a href="<?php echo base_url(); ?>why-sitemee">Why Sitemee</a><span></span></li>
						<?php /* <li class="<?php echo ($page == "templates") ? "active" : ""; ?> <?php echo ($sess_user['logged_in']) ? "h_paddingtop50" : ""; ?>"><a href="<?php echo base_url(); ?>templates">Templates</a><span></span></li> */ ?>
						<li class="<?php echo ($page == "contact") ? "active" : ""; ?> <?php echo ($sess_user['logged_in']) ? "h_paddingtop50" : ""; ?>"><a href="<?php echo base_url(); ?>contact-us">Contact Us</a><span></span></li>
						<?php if (!($sess_user['logged_in'])) { ?>
							<li class="<?php echo ($sess_user['logged_in']) ? "h_paddingtop50" : ""; ?> <?php echo ($page == "login") ? "active" : ""; ?> <?php echo ($sess_user['logged_in']) ? "h_paddingtop50" : ""; ?>"><a href="<?php echo base_url(); ?>login">Login</a><span></span></li>
						<?php } ?>
					</ul>
					
					<div class="h_clearboth"></div>
					
					<?php if ($sess_user['logged_in']) { ?>
						<div class="g_welcome">
							Welcome back <?php echo $sess_user['first_name'] . " " . $sess_user['last_name']; ?>! &nbsp;
							<span id="g_welcome_actions">
								<a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a> &nbsp;
								<a href="<?php echo base_url(); ?>logout">Logout</a>
							</span>
						</div>
					<?php } ?>
				</div>
				
				<div class="h_clearboth"></div>
			</div>
			</div>
			
			<div class="g_dropmenu">
				<select id="dropmenu">
					<option <?php echo ($page == "home") ? "selected='selected'" : ""; ?> value="<?php echo base_url(); ?>">Home</option>
					<option <?php echo ($page == "about") ? "selected='selected'" : ""; ?> value="<?php echo base_url(); ?>about-us">About Us</option>
					<option <?php echo ($page == "features") ? "selected='selected'" : ""; ?> value="<?php echo base_url(); ?>why-sitemee">Why Sitemee</option>
					<?php /* <option <?php echo ($page == "templates") ? "selected='selected'" : ""; ?> value="<?php echo base_url(); ?>templates">Templates</option> */ ?>
					<option <?php echo ($page == "contact") ? "selected='selected'" : ""; ?> value="<?php echo base_url(); ?>contact-us">Contact Us</option>
					<?php if ($sess_user['logged_in']) { ?>
						<option value="<?php echo base_url(); ?>admin/dashboard">Dashboard</option>
						<option value="<?php echo base_url(); ?>logout">Logout</option>
					<?php } else { ?>
						<option <?php echo ($page == "login") ? "selected='selected'" : ""; ?> value="<?php echo base_url(); ?>login">Login</option>
					<?php } ?>
				</select>
			</div>
			
		</div>
		<div class="h_clearboth;"></div>
		
		<?php echo $content; ?>
		
		<div class="g_bottom">
		<div class="g_inner">
		<div class="sections">
		
			<div class="market">
			<div class="inner">
				<div class="section">About Us</div>
				<div class="label">We imagine the future.</div>
				<div class="label">We create possibilities.</div>
				<div class="label">We deliver breakthroughs.</div>
				<div class="content1">The desktop, the tablet, the smartphone, the phablet, the mobile app, and social media: business essentials that push your business presence beyond the limits of consumer awareness.</div>
				<div class="content2">We help create connection channels for you and your customers. We develop websites, we create apps, and we design a social media page for you. Through these channels, your business potential becomes infinite. Because at SiteMee…</div>
				<div class="content3">…we make you soar.</div>
			</div>
			</div>
			
			<div class="services">
			<div class="inner">
				<div class="section">Why Sitemee</div>
				<div class="item">
					<img src="<?php echo base_url(); ?>_assets/images/services/service_1.png" />
					<div class="text">
						<div class="label">Accessibility and Ease of Use</div>
						<div class="content">Easy to use; only one username and password to access all SiteMee solutions.</div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<img src="<?php echo base_url(); ?>_assets/images/services/service_2.png" />
					<div class="text">
						<div class="label">Assistance and Back-up Feature</div>
						<div class="content">Cloud-based access; superb customer and technical support services offered round-the-clock.</div>
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<div class="item">
					<img src="<?php echo base_url(); ?>_assets/images/services/service_3.png" />
					<div class="text">
						<div class="label">Website Management and Reports and Analytics</div>
						<div class="content">Generate reports, analyse figures, and create or customize websites and preview changes before publishing.</div>
					</div>
					<div class="h_clearboth"></div>
				</div>
			</div>
			</div>
			
			<div class="spacer"></div>
			
			<div class="whyus">
			<div class="inner">
				<div class="section">The Sitemee Advantage</div>
				<img src="<?php echo base_url(); ?>_assets/images/whyus/whyus.png" />
				<div class="label">Enjoy our partnership;</div>
				<div class="label_sub">See your business fly</div>
				<div class="content1">At SiteMee, we do not treat you as our clients; we treat you as our partners. We share your business goals, we help you plan them, we help you execute them, and we set you off as a champion. That is a guarantee.</div>
			</div>
			</div>
			
			<div class="tweets">
			<div class="inner">
				<div class="section">Get Connected</div>
				
				<?php /*
				<a class="twitter-timeline" href="https://twitter.com/jgilao" data-tweet-limit="5" data-show-replies="false" data-widget-id="352585445923770368" data-chrome="nofooter noheader transparent">Tweets by @jgilao</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				*/ ?>
			</div>
			</div>
			
			<div class="h_clearboth"></div>
			
		</div>
		</div>
		</div>
		
		<div class="g_copyright">
		<div class="g_inner">
			<div class="copy"><span>Sitemee</span> &copy; 2013 &nbsp; Privacy Policy</div>
			<div class="social">
				
				<div class="g_preload">
					<img src="<?php echo base_url(); ?>_assets/images/social/facebook_hover.png" />
					<img src="<?php echo base_url(); ?>_assets/images/social/twitter_hover.png" />
					<img src="<?php echo base_url(); ?>_assets/images/social/googleplus_hover.png" />
					<img src="<?php echo base_url(); ?>_assets/images/social/rss_hover.png" />
				</div>
			
				<div class="item"><a href="http://www.facebook.com" target="_blank"><img data-val="facebook" src="<?php echo base_url(); ?>_assets/images/social/facebook.png" /></a></div>
				<div class="item"><a href="http://www.twitter.com" target="_blank"><img data-val="twitter" src="<?php echo base_url(); ?>_assets/images/social/twitter.png" /></a></div>
				<div class="item"><a href="http://www.plus.google.com" target="_blank"><img data-val="googleplus" src="<?php echo base_url(); ?>_assets/images/social/googleplus.png" /></a></div>
				<div class="item"><a href="http://www.rss.com" target="_blank"><img data-val="rss" src="<?php echo base_url(); ?>_assets/images/social/rss.png" /></a></div>
				<div class="h_clearboth"></div>
			</div>
			<div class="h_clearboth"></div>
		</div>
		</div>
		
		<script type="text/javascript" language="javascript">
		// menu active indicator
		$(".g_menu ul li").hover(
			function(){ $(this).children('span').animate({top: '0px'}, 100); },
			function(){ 
				if (!$(this).hasClass('active')) { $(this).children('span').animate({top: '-7px'}, 100); }
			}
		);
		
		// change page in dropdown
		$("#dropmenu").change(function(){
			window.location = $(this).val();
		});
		
		// hover for social icons in footer
		var val = "";
		$(".g_copyright .social .item").hover(
			function() { 
				val = $(this).children('a').children('img').attr('data-val');
				$(this).children('a').children('img').attr('src', '<?php echo base_url(); ?>_assets/images/social/'+val+'_hover.png'); 
			},
			function() { 
				val = $(this).children('a').children('img').attr('data-val');
				$(this).children('a').children('img').attr('src', '<?php echo base_url(); ?>_assets/images/social/'+val+'.png'); 
			}
		);
		</script>

	</body>

</html>