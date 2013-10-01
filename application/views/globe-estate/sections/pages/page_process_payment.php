<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Globe Estate :: <?php echo $page_title ?></title>


<meta name="Keywords" content="Globe Estate">
<meta name="Description" content="Globe Estate">
	<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>_assets/js/jquery.js"></script>
	<!-- Styles -->
	<link href="<?php echo $assets_url?>site/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="<?php echo $assets_url?>css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo $assets_url?>site/css/font-awesome.min.css" rel="stylesheet" />
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo $assets_url?>site/css/font-awesome-ie7.min.css">
	<![endif]-->
	<!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="<?php echo $assets_url?>site/css/custom-theme/jquery.ui.1.10.0.ie.css"/>
	<![endif]-->
	<link href="<?php echo $assets_url?>site/css/docs.css" rel="stylesheet">
	<link href="<?php echo $assets_url?>site/js/google-code-prettify/prettify.css" rel="stylesheet">
	<link href="<?php echo $assets_url?>site/css/table-packages.css" rel="stylesheet">
	<link href="<?php echo $assets_url?>site/css/custom.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo $assets_url?>site/ico/favicon.png">
    
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	
	<script type="text/javascript">
		var base_url = '<?php echo base_url() ?>';
	</script>

</head>

<!-- Preloader -->
<div id="preLoader" class="opacity">
    <div id="status">
		<div class="text">
			We are processing your selection, Please wait...
		</div>
	</div>
</div>


<script type="text/javascript">
	
	var showPreloader = function(){
			$("#status").fadeIn(); $("#preLoader").delay(350).fadeIn("fast");
		}
		
	var closePreloader = function(){
		$("#status").fadeOut(); $("#preLoader").delay(350).fadeOut("fast");
	}
	
	showPreloader();
	
	function saveOrder(){
		$.ajax({
			url: base_url+'order/save_order',
			data: {'email' : "mhaark29@gmail.com" },
			type:'post',
			success: function(response){
				
				closePreloader();
				window.location ="<?php echo base_url() ?>survey"
			},
			error: function(){
				alert('Some error occured or the system is busy. Please try again later');
			}
		});
	}
			$(document).ready(function(){ saveOrder(); })
</script>

