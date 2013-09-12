<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">

	<head>
	
		<title>CMS</title>
		
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<meta name='description' content='' />
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery.jplayer.min.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery-ui/ui/jquery.ui.core.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery-ui/ui/jquery.ui.widget.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery-ui/ui/jquery.ui.effect.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery-ui/ui/jquery.ui.datepicker.js"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/js/jquery-ui/themes/base/jquery.ui.all.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/admin/_global.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/_helpers.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/fonts.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/admin/notifications.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/admin/<?php echo $page; ?>.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/css/admin/jplayer.blue.monday.css?<?php echo time(); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>_assets/js/colorpicker/css/colorpicker.css?<?php echo time(); ?>" type="text/css" />
		
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>_assets/images/favicon.png">
		
		<script type="text/javascript" language="javascript">
		var config = {
			base: "<?php echo base_url(); ?>"
		};
		</script>
		
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/util.js?<?php echo time(); ?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/validate_form.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/colorpicker/js/colorpicker.js"></script>
		<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
		
	</head>
	
	<body>
	
		<?php include("view_preload.php"); ?>
		
		<?php if ($sess_user['logged_in']) { ?>
			<?php include("view_menu.php"); ?>
			<?php include("view_notifications.php"); ?>
			<div id="middle_wrapper" class="_main"><?php echo $content; ?></div>
		<?php } else { ?>
			<div id="login_body_wrapper"><?php echo $content; ?></div>
		<?php } ?>
		<div class="h_clearboth"></div>
		
		<!-- global references -->
		<input type="hidden" value="0" id="ref_mobile_preview" />
		
	</body>

</html>