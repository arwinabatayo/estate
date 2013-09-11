<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

	<head>
	
		<title>Sitemee Preview</title>
		
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name='description' content='Filament Super CMS' />
		<meta name="author" content="Jeri Ilao">
		<meta name="viewport" content="width=device-width">
		
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery.js"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/_global.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/preview.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/fonts.css?<?php echo time(); ?>" type="text/css" />
		<?php /*
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/login.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/<?php echo $page; ?>.css?<?php echo time(); ?>" type="text/css" />
		*/ ?>
		
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>_assets/images/favicon.png">
		
	</head>
	
	<body style="<?php if ($type == 1 || $type == "t1") { echo "overflow: hidden;"; } ?>">
	
		<div id="preview_label">
			<div class="label">Preview</div>
			<?php echo str_replace("_", " ", $folder_name); ?>
			<?php if ($type == "t1" || $type == "t2" || $type == "t3") { echo "template"; } ?>
			<div class="type">
				<?php if ($type == 1 || $type == "t1") { ?>
					<img src="<?php echo base_url(); ?>_assets/images/template_types/1.png" />
				<?php } else if ($type == 2 || $type == "t2") { ?>
					<img src="<?php echo base_url(); ?>_assets/images/template_types/2.png" />
				<?php } else if ($type == 3 || $type == "t3") { ?>
					<img src="<?php echo base_url(); ?>_assets/images/template_types/3.png" />
				<?php } ?>
			</div>
		</div>
		
		<div id="preview_wrapper">
		
			<?php if ($type == 1 || $type == "t1" || $type == 5 || $type == "t5") { ?>
				<iframe	width="100%"
						height="100%"
						frameborder="0"
						src="<?php echo base_url(); ?><?php echo ($type == 1 || $type == 5) ? "_properties" : "_templates"; ?>/<?php echo $folder_name; ?>/index.php?<?php echo time(); ?>">
				</iframe>
			<?php } ?>
			
			<?php if ($type == 2 || $type == "t2") { ?>
				<div id="mobile">
				<div id="container">
					<iframe width="100%" 
							height="100%" 
							frameborder="0"
							src="<?php echo base_url(); ?><?php echo ($type == 2) ? "_properties" : "_templates"; ?>/<?php echo $folder_name; ?>/index.php?<?php echo time(); ?>">
					</iframe>
				</div>
				</div>
			<?php } ?>
			
			<?php if ($type == 3 || $type == "t3") { ?>
				<div id="platform">
					<div id="top"></div>
					<div id="middle">
					<div id="preview">
						<iframe width="810" 
								height="100%" 
								frameborder="0"
								scrolling="no"
								id="container"
								src="<?php echo base_url(); ?><?php echo ($type == 3) ? "_properties" : "_templates"; ?>/<?php echo $folder_name; ?>/index.php?<?php echo time(); ?>">
						</iframe>
					</div>
					</div>
					<div id="bottom"></div>
				</div>
				
				<script type="text/javascript" language="javascript"> 
				$("#preview iframe").load(function(){
					$("#middle").css('height', document.getElementById('container').contentWindow.document.body.scrollHeight+"px");
					$("#middle #preview").css('height', document.getElementById('container').contentWindow.document.body.scrollHeight+"px");
				});
				</script>
			<?php } ?>
			
			<?php if ($type == 4 || $type == "t4") { ?>
				<div id="mobile">
				<div id="container">
					<iframe width="100%" 
							height="100%" 
							frameborder="0"
							src="<?php echo base_url(); ?><?php echo ($type == 2) ? "_properties" : "_templates"; ?>/<?php echo $folder_name; ?>/preview.swf?<?php echo time(); ?>">
					</iframe>
				</div>
				</div>
			<?php } ?>
			
		</div>
		
	</body>

</html>