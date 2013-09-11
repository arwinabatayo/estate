<style type="text/css">

@font-face {
	font-family: "Verdana";
    src: url("./_css/fonts/verdana/verdana.eot");
	src: local('O'),
	src: url("./_css/fonts/verdana/verdana.eot?#iefix") format("embedded-opentype"),
	url("./_css/fonts/verdana/verdana.woff") format("woff"),
	url("./_css/fonts/verdana/verdana.ttf") format('truetype'),
	url("./_css/fonts/verdana/verdana.svg#svgFontName") format("svg");
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'verizon_apexmedium';
    src: url('_css/fonts/verizonapexmedium/verizonapex-medium-webfont.eot');
    src: url('_css/fonts/verizonapexmedium/verizonapex-medium-webfont.eot?#iefix') format('embedded-opentype'),
         url('_css/fonts/verizonapexmedium/verizonapex-medium-webfont.woff') format('woff'),
         url('_css/fonts/verizonapexmedium/verizonapex-medium-webfont.ttf') format('truetype'),
         url('_css/fonts/verizonapexmedium/verizonapex-medium-webfont.svg#verizon_apexmedium') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'verizon_apexbold';
    src: url('_css/fonts/verizonapexbold/verizonapex-bold-webfont.eot');
    src: url('_css/fonts/verizonapexbold/verizonapex-bold-webfont.eot?#iefix') format('embedded-opentype'),
         url('_css/fonts/verizonapexbold/verizonapex-bold-webfont.woff') format('woff'),
         url('_css/fonts/verizonapexbold/verizonapex-bold-webfont.ttf') format('truetype'),
         url('_css/fonts/verizonapexbold/verizonapex-bold-webfont.svg#verizon_apexbold') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'verizon_apexextrabold';
    src: url('_css/fonts/verizonapexextrabold/verizonapex-extrabold-webfont.eot');
    src: url('_css/fonts/verizonapexextrabold/verizonapex-extrabold-webfont.eot?#iefix') format('embedded-opentype'),
         url('_css/fonts/verizonapexextrabold/verizonapex-extrabold-webfont.woff') format('woff'),
         url('_css/fonts/verizonapexextrabold/verizonapex-extrabold-webfont.ttf') format('truetype'),
         url('_css/fonts/verizonapexextrabold/verizonapex-extrabold-webfont.svg#verizon_apexbold') format('svg');
    font-weight: normal;
    font-style: normal;
}

*{
	font-family: "Verdana", Verdana,Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	padding: 0px;
	margin: 0px;
	outline: none;
	border: none;
	vertical-align: top;
	letter-spacing: 0px;
	resize: none;
	text-decoration: none;
	color: #333333;
}

html, body{
	padding: 0px;
	margin: 0px;
	width: 100%;
	height: 100%;
}

body #body-inner-wrapper{
	visibility: hidden;
}

body #body-inner-wrapper.show{
	visibility: visible;
}

#global-textual-loader-wrapper{
    font-family: 'verizon_apexmedium';
	position: absolute;
	font-size: 20px;
	top: 40px;
	left: 0px;
	right: 0px;
	text-align: center;
}

.preload-item{
	display: none;
}

#body-inner-wrapper{
	padding: 0px;
	margin: 0 auto;
	width: 810px;
}

.fullscreen-background-transparent{
	background: #303030;
	/* IE 8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
	/* IE 5-7 */
	filter: alpha(opacity=50);
	/* Netscape */
	-moz-opacity: 0.5;
	/* Safari 1.x */
	-khtml-opacity: 0.5;
	/* Good browsers */
	opacity: 0.5;
	position: fixed;
	top: 0px;
	left: 0px;
	right: 0px;
	bottom: 0px;
	display: none;
	z-index: 999;
}

#product-email-form-holder{
	display: none;
	z-index: 1000;
	position: fixed;
	top: 50%;
	left: 50%;
	width: 500px;
	margin-top: -187px;
	margin-left: -250px;
	background: #FFFFFF;
}

#product-email-form-inner-wrapper{
	margin: 10px;
}

#captcha1,
#captcha2,
#captcha3,
#captcha4{
    font-family: 'verizon_apexbold';
	float: right;
	font-size: 16px;
	line-height: 220%;
	letter-spacing: 5px;
}

.td-emailto-labels label{
    font-family: 'verizon_apexbold';
	float: right;
	font-size: 15px;
}

.td-emailto-labels{
	vertical-align: middle;
	padding: 5px;
}

.td-emailto-input{
	vertical-align: middle;
	padding: 5px;
}

#emailto-from,
#emailto-to,
#emailto-captcha,
#emailto-subject,
#emailto-message{
	float: right;
	border: 1px solid #BFBFBF;
	width: 330px;
	padding: 10px;
	font-size: 12px;
}

#emailto-message{
	height: 100px;
}

#emailto-captcha{
	width: 220px;
	margin-left: 30px;
}

#emailto-button{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_email_to_button_background_color']) && $site_data['site_skin_settings']['product_details_email_to_button_background_color'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['product_details_email_to_button_background_color']; ?>;
<?php }else{ ?>
	background: transparent;
<?php } ?>
    font-family: 'verizon_apexbold';
	font-size: 14px;
	text-align: center;
	color: #FFFFFF;
	float: right;
	padding: 5px 30px;
	cursor: pointer;
}

#emailto-cancel{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_email_to_button_background_color']) && $site_data['site_skin_settings']['product_details_email_to_button_background_color'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['product_details_email_to_button_background_color']; ?>;
<?php }else{ ?>
	background: transparent;
<?php } ?>
    font-family: 'verizon_apexbold';
	font-size: 14px;
	text-align: center;
	color: #FFFFFF;
	float: right;
	padding: 5px 30px;
	cursor: pointer;
	margin-right: 20px;
}

#email-result{
	position: absolute;
	line-height: 220%;
}

.clearboth{
	clear: both;
	height: 0px;
	line-height: 0%;
}

.vhide{
	visibility: hidden;
}

.vshow{
	visibility: visible;
}

.top-slideshow-image{
	width: 810px;
	height: 289px;
}

.top-divider{
	height: 8px;
	margin-top: 20px;
}

#td-category-images-wrapper{
	width: 318px;
}

.alignright{
	text-align: right;
}

#tbl-category-section{
	margin-top: 10px;
}

#td-twitter-feeds-wrapper{
	width: 318px;
}

#td-bottom-lifestyle-wrapper{
	width: 492px;
}

#div-twitter-feeds-wrapper{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['twitter_feed_background_color']) && $site_data['site_skin_settings']['twitter_feed_background_color'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['twitter_feed_background_color']; ?>;
<?php } ?>
	padding-top: 10px;
	padding-left: 10px;
	height: 308px;
	margin-top: 10px;
}

#div-twitter-feeds-wrapper.tablet{
	padding-right: 10px;
}

#div-bottom-lifestyle-wrapper{
	margin-left: 10px;
	margin-top: 10px;
	width: 482px;
	height: 318px;
	background: #E6E6E6;
}

.tr-first .category-image-wrapper{
	margin-left: 10px;
	overflow: hidden;
	height: 154px;
	width: 154px;
}

.tr-second .category-image-wrapper{
	margin-top: 10px;
	margin-left: 10px;
	overflow: hidden;
	height: 154px;
	width: 154px;
}

.social-media-image-wrapper{
	margin-top: 10px;
	margin-left: 10px;
	overflow: hidden;
	height: 154px;
	width: 154px;
}

.category-image{
	height: 154px;
	width: 154px;
}

.category-image-hover{
	height: 154px;
	width: 154px;
}

.category-image-hover-wrapper{
	height: 154px;
	width: 154px;
}

.category-image-hover-wrapper.active{
	margin-top: -154px;
}

#footer-text{
	font-family: "verizon_apexmedium";
	font-size: 9px;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['footer_text_color']) && $site_data['site_skin_settings']['footer_text_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['footer_text_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
	text-align: center;
	padding-top: 15px;
}

#category-main-images-wrapper{
	position: absolute;
	width: 318px;
	height: 318px;
	overflow: hidden;
	z-index: 99;
}

#category-main-images-dummy-wrapper{
	width: 318px;
	height: 318px;
	overflow: hidden;
	z-index: 99;
	background: #E6E6E6;
}

#category-main-images-inner-wrapper{
	width: 318px;
	height: 318px;
	margin-left: 318px;
}

#category-main-images-inner-wrapper .category-main-image{
	width: 318px;
	height: 318px;
	position: absolute;
}

.category-top-layer{
	position: absolute;
	margin-left: 10px;
	margin-top: -154px;
	height: 154px;
	width: 154px;
	z-index: 99;
	background: url('_media/transparent-bg.png');
	background-repeat: repeat;
}

.social-media-top-layer{
	position: absolute;
	margin-left: 10px;
	margin-top: -72px;
	height: 72px;
	width: 72px;
	z-index: 99;
	background: url('_media/transparent-bg.png');
	background-repeat: repeat;
	cursor: pointer;
}

.category-main-image.inactive{
	visibility: visible;
}

.category-main-image.active{
	visibility: visible;
}

#tbl-social-media .tr-social-media-first .small-social-media-image-wrapper{
	margin-top: 10px;
	margin-left: 10px;
}

#tbl-social-media .tr-social-media-second .small-social-media-image-wrapper{
	margin-top: 10px;
	margin-left: 10px;
}

.small-social-media-image{
	width: 72px;
	height: 72px;
}

.small-social-media-image-hover{
	width: 72px;
	height: 72px;
}

.small-social-media-image-wrapper{
	overflow: hidden;
	height: 72px;
	width: 72px;
}

.small-social-media-image-hover-wrapper.align13{
	margin-top: -72px;
	margin-left: 72px;
	overflow: hidden;
}

.small-social-media-image-hover-wrapper.align24{
	margin-top: -72px;
	overflow: hidden;
	margin-right: 72px;
}

#product-grid-wrapper .bg-loader{
	position: absolute;
	margin-top: 127px;
	margin-left: 373px;
}

<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['body_color']) && $site_data['site_skin_settings']['body_color'] != '' ){ ?>
body{
	background-color: <?php echo $site_data['site_skin_settings']['body_color']; ?>;
}
<?php } ?>

<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['divider_color']) && $site_data['site_skin_settings']['divider_color'] != '' ){ ?>
.divider-color{
	background-color: <?php echo $site_data['site_skin_settings']['divider_color']; ?>;
}
<?php }else{ ?>
.divider-color{
	display: none;
}
<?php } ?>

#footer-wrapper{
	margin-top: 20px;
	height: 99px;
	<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['company_logo']) && $site_data['site_skin_settings']['company_logo'] != '' ){ ?>
	background: url('assets/<?php echo $site_data['site_skin_settings']['company_logo']; ?>') <?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['footer_background_color']) && $site_data['site_skin_settings']['footer_background_color'] != '' ){ ?><?php echo $site_data['site_skin_settings']['footer_background_color']; ?>;<?php } ?>
	background-repeat: no-repeat;
	<?php }else{ ?>
		<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['footer_background_color']) && $site_data['site_skin_settings']['footer_background_color'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['footer_background_color']; ?>;
		<?php } ?>
	<?php } ?>
}

#bottom-lifestyle-slideshow-cross-wrapper{
	position: absolute;
	height: 318px;
	width: 482px;
	<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['bottom_lifestyle_slideshow_cross_wrapper']) && $site_data['site_skin_settings']['bottom_lifestyle_slideshow_cross_wrapper'] != '' ){ ?>
	background: url('assets/<?php echo $site_data['site_skin_settings']['bottom_lifestyle_slideshow_cross_wrapper']; ?>');
	<?php }else{ ?>
	background: url('_media/bottom-lifestyle-slideshow-cross.png');
	<?php } ?>
	background-repeat: no-repeat;
	z-index: 99;
}

.bx-wrapper .bx-pager.bx-default-pager a {
	text-indent: -9999px;
	display: block;
	outline: 0;
	<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['slideshow_bullet']) && $site_data['site_skin_settings']['slideshow_bullet'] != '' ){ ?>
	background-image: url('assets/<?php echo $site_data['site_skin_settings']['slideshow_bullet']; ?>');
	<?php }else{ ?>
	background-image: url('_media/red-bullet.png');
	<?php } ?>
	background-repeat: no-repeat;
	height: 14px;
	width: 15px;
}

.bx-wrapper .bx-pager.bx-default-pager a:hover{
	<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['slideshow_bullet_hover']) && $site_data['site_skin_settings']['slideshow_bullet_hover'] != '' ){ ?>
	background-image: url('assets/<?php echo $site_data['site_skin_settings']['slideshow_bullet_hover']; ?>');
	<?php }else{ ?>
	background-image: url('_media/gray-bullet.png');
	<?php } ?>
	background-repeat: no-repeat;
}

.bx-wrapper .bx-pager.bx-default-pager a.active {
	<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['slideshow_bullet_active']) && $site_data['site_skin_settings']['slideshow_bullet_active'] != '' ){ ?>
	background-image: url('assets/<?php echo $site_data['site_skin_settings']['slideshow_bullet_active']; ?>');
	<?php }else{ ?>
	background-image: url('_media/white-bullet.png');
	<?php } ?>
	background-repeat: no-repeat;
}

.bottom-lifestyle-image{
	width: 482px;
	height: 318px;
}

.bg-loader{
	<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['loader_image']) && $site_data['site_skin_settings']['loader_image'] != '' ){ ?>
	background-image: url('assets/<?php echo $site_data['site_skin_settings']['loader_image']; ?>');
	<?php }else{ ?>
	background-image: url('_media/loader.gif');
	<?php } ?>
	background-repeat: no-repeat;
	height: 64px;
	width: 64px;
	z-index: 99;
	display: none;
}

#category-text-wrapper{
	font-family: "verizon_apexmedium";
	margin-top: 15px;
	font-size: 21px;
	text-align: center;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['category_name_color']) && $site_data['site_skin_settings']['category_name_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['category_name_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

#products-grid-is-empty{
	
}

#products-wrapper{
	margin-top: 23px;
}

#products-wrapper.no-products{
	min-height: 328px;
}

#products-wrapper.has-products{
	min-height: 900px;
}

.product-image-wrapper, .product-name-wrapper, .product-image{
	cursor: pointer;
}

.product-item-wrapper{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_border_color']) && $site_data['site_skin_settings']['product_border_color'] != '' ){ ?>
	border: 1px solid <?php echo $site_data['site_skin_settings']['product_border_color']; ?>;
<?php }else{ ?>
	border: 1px solid #FFFFFF;
<?php } ?>
	border-top: 0px;
	border-right: 0px;
	width: 201px;
	height: 223px;
	float: left;
	overflow: hidden;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_background_color']) && $site_data['site_skin_settings']['product_background_color'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['product_background_color']; ?>;
<?php }else{ ?>	
	background: transparent;
<?php } ?>
}

.product-focuser{
	position: absolute;
}

.product-item-wrapper.hover{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_background_color_hover']) && $site_data['site_skin_settings']['product_background_color_hover'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['product_background_color_hover']; ?>;
<?php }else{ ?>	
	background: transparent;
<?php } ?>
}

.product-item-wrapper.active{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_background_color_active']) && $site_data['site_skin_settings']['product_background_color_active'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['product_background_color_active']; ?>;
<?php }else{ ?>	
	background: transparent;
<?php } ?>
}

.product-item-wrapper.first-row{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_border_color']) && $site_data['site_skin_settings']['product_border_color'] != '' ){ ?>
	border-top: 1px solid <?php echo $site_data['site_skin_settings']['product_border_color']; ?>;
<?php }else{ ?>
	border-top: 1px solid #FFFFFF;
<?php } ?>
}

.product-item-wrapper.last-col{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_border_color']) && $site_data['site_skin_settings']['product_border_color'] != '' ){ ?>
	border-right: 1px solid <?php echo $site_data['site_skin_settings']['product_border_color']; ?>;
<?php }else{ ?>
	border-right: 1px solid #FFFFFF;
<?php } ?>
}

.product-item-wrapper.last-cell{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_border_color']) && $site_data['site_skin_settings']['product_border_color'] != '' ){ ?>
	border-right: 1px solid <?php echo $site_data['site_skin_settings']['product_border_color']; ?>;
<?php }else{ ?>
	border-right: 1px solid #FFFFFF;
<?php } ?>
}

.product-item-wrapper.has-one-product{
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_border_color']) && $site_data['site_skin_settings']['product_border_color'] != '' ){ ?>
	border-right: 1px solid <?php echo $site_data['site_skin_settings']['product_border_color']; ?>;
<?php }else{ ?>
	border-right: 1px solid #FFFFFF;
<?php } ?>
}

.product-image-wrapper{
	text-align: center;
	height: 165px;
}

.product-image{
	max-width: 195px;
	max-height: 145px;
	min-height: 145px;
	margin: 0 auto;
	margin-top: 10px;
	display: none;
}

.product-name-wrapper{
	text-align: center;
	font-size: 14px;
	height: 55px;
	line-height: 55px;
	display: table;
	width: 100%;
}

.product-name-wrapper p{
	font-family: "verizon_apexmedium";
	font-size: 15px;
	display: inline-block;
	vertical-align: middle;
	line-height: 120%;
	display: table-cell;
	padding: 0px 10px;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_name_color']) && $site_data['site_skin_settings']['product_name_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['product_name_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

.arrow-top{
	position: absolute;
	width: 38px;
	height: 16px;
<?php if( isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['arrow_top']) && $site_data['site_skin_settings']['arrow_top'] != '' ){ ?>
	background: url('assets/<?php echo $site_data['site_skin_settings']['arrow_top']; ?>');
<?php }else{ ?>
	background: url('_media/arrow-top.jpg');
<?php } ?>
	margin-top: -16px;
	margin-left: 82px;
}

.arrow-right{
	position: absolute;
	width: 16px;
	height: 39px;
<?php if( isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['arrow_right']) && $site_data['site_skin_settings']['arrow_right'] != '' ){ ?>
	background: url('assets/<?php echo $site_data['site_skin_settings']['arrow_right']; ?>');
<?php }else{ ?>
	background: url('_media/arrow-right.jpg');
<?php } ?>
	margin-left: 201px;
	margin-top: 93px;
}

.arrow-bottom{
	position: absolute;
	width: 38px;
	height: 16px;
<?php if( isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['arrow_bottom']) && $site_data['site_skin_settings']['arrow_bottom'] != '' ){ ?>
	background: url('assets/<?php echo $site_data['site_skin_settings']['arrow_bottom']; ?>');
<?php }else{ ?>
	background: url('_media/arrow-bottom.jpg');
<?php } ?>
	margin-top: 223px;
	margin-left: 82px;
}

.arrow-left{
	position: absolute;
	width: 16px;
	height: 39px;
<?php if( isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['arrow_left']) && $site_data['site_skin_settings']['arrow_left'] != '' ){ ?>
	background: url('assets/<?php echo $site_data['site_skin_settings']['arrow_left']; ?>');
<?php }else{ ?>
	background: url('_media/arrow-left.jpg');
<?php } ?>
	margin-left: -16px;
	margin-top: 93px;
}

.product-arrow{
	display: none;
	z-index: 3;
}

.product-arrow.active{
	display: block;
}

.product-details-wrapper{
	position: absolute;
	z-index: 2;
	width: 605px;
	height: 447px;
	display: none;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_background_color']) && $site_data['site_skin_settings']['product_details_background_color'] != '' ){ ?>
	background: <?php echo $site_data['site_skin_settings']['product_details_background_color']; ?>;
<?php  }else{ ?>
	background: #FFFFFF;
<?php } ?>
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_border_color']) && $site_data['site_skin_settings']['product_details_border_color'] != '' ){ ?>
	border: 1px solid <?php echo $site_data['site_skin_settings']['product_details_border_color']; ?>;
<?php  }else{ ?>
	border: 1px solid #BFBFBF;
<?php } ?>
	overflow: hidden;
}

.product-details-wrapper.active{
	display: block;
}

.product-details-inner-wrapper{
	margin: 20px;
	height: 407px;
	overflow: hidden;
}

.product-close-btn{
	width: 25px;
	height: 25px;
<?php if( isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_close_button']) && $site_data['site_skin_settings']['product_close_button'] != '' ){ ?>
	background: url('assets/<?php echo $site_data['site_skin_settings']['product_close_button']; ?>');
<?php }else{ ?>
	background: url('_media/product-close-btn.jpg');
<?php } ?>
	background-repeat: no-repeat;
	position: absolute;
	top: 4px;
	right: 3px;
	cursor: pointer;
}

.tbl-product-details-wrapper{
	height: 409px;
	background: #FFFFFF;
}

.td-product-image-wrapper{
	width: 210px;
}

.product-item-image-wrapper{
	margin: 0 auto;
	margin-top: 10px;
	height: 270px;
	line-height: 270px;
	overflow: hidden;
	text-align: center;
	display: table;
	width: 100%;
}

.product-item-image{
	max-width: 210px;
	max-height: 270px;
	display: table-cell;
	display: inline-block;
	vertical-align: middle;
}

.product-social-icons-wrapper{
	text-align: center;
	margin-top: 21px;
}

.product-price-wrapper{
	margin-top: 2px;
}

.tbl-product-price-wrapper{
	margin: 0 auto;
}

.price-dollar-sign{
	font-family: "verizon_apexextrabold";
	font-size: 14px;
	margin-top: 5px;
	letter-spacing: 1px;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_price_dollar_sign_color']) && $site_data['site_skin_settings']['product_details_price_dollar_sign_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['product_details_price_dollar_sign_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

.price-whole-number{
	font-family: "verizon_apexextrabold";
	font-size: 28px;
	letter-spacing: 1px;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_price_whole_number_color']) && $site_data['site_skin_settings']['product_details_price_whole_number_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['product_details_price_whole_number_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

.price-cent{
	font-family: "verizon_apexextrabold";
	font-size: 14px;
	margin-top: 5px;
	letter-spacing: 1px;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_price_cents_color']) && $site_data['site_skin_settings']['product_details_price_cents_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['product_details_price_cents_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

.order-now-btn-wrapper{
	text-align: center;
	margin-top: 4px;
}

.order-now-btn{
	margin: 0 auto;
	cursor: pointer;
	width: 104px;
	height: 32px;
}

.product-email-icon,
.product-google-plus-icon,
.product-pinterest-icon,
.product-twitter-icon,
.product-facebook-icon{
	cursor: pointer;
	width: 16px;
	height: 16px;
}

.div-product-details-wrapper{
	margin-left: 10px;
	height: 323px;
}

.product-details-name{
	font-family: 'verizon_apexbold';
	font-size: 18px;
	margin-top: 13px;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_name_color']) && $site_data['site_skin_settings']['product_details_name_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['product_details_name_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

.product-details-description{
	font-family: 'verizon_apexmedium';
	font-size: 14px;
	text-align: left;
	line-height: 120%;
	margin-top: 22px;
	height: 240px;
	overflow: hidden;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_description_color']) && $site_data['site_skin_settings']['product_details_description_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['product_details_description_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

.tbl-footer-notes-wrapper{
	height: 55px;
}

.tbl-footer-notes-wrapper .td-left-footer-notes{
	vertical-align: bottom;
}

.tbl-footer-notes-wrapper .td-right-footer-notes{
	vertical-align: bottom;
	text-align: right;
	width: 100px;
}

.product-fb-like-wrapper{
	height: 20px;
}

.star-rating-wrapper{
	width: 55px;
	height: 10px;
	margin-left: 10px;
	margin-bottom: 4px;
}

.empty-stars{
	position: absolute;
	z-index: 3;
	width: 55px;
	height: 10px;
<?php if( isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['empty_stars']) && $site_data['site_skin_settings']['empty_stars'] != '' ){ ?>
	background: url('assets/<?php echo $site_data["site_skin_settings"]["empty_stars"]; ?>');
<?php }else{ ?>
	background: url('_media/empty-stars.png');
<?php } ?>
	background-repeat: no-repeat;
}

.full-stars{
	position: absolute;
	z-index: 4;
	width: 55px;
	height: 10px;
<?php if( isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['full_stars']) && $site_data['site_skin_settings']['full_stars'] != '' ){ ?>
	background: url('assets/<?php echo $site_data["site_skin_settings"]["full_stars"]; ?>');
<?php }else{ ?>
	background: url('_media/full-stars.png');
<?php } ?>
	background-repeat: no-repeat;
}

.div-product-notes-wrapper{
	margin-left: 10px;
	font-family: 'verizon_apexmedium';
	font-size: 11px;
}

.div-product-notes-wrapper p{
	font-family: 'verizon_apexmedium';
	font-size: 11px;
	line-height: 130%;
<?php if( isset($site_data) && isset($site_data['site_skin_settings']) && isset($site_data['site_skin_settings']['product_details_footer_notes_color']) && $site_data['site_skin_settings']['product_details_footer_notes_color'] != '' ){ ?>
	color: <?php echo $site_data['site_skin_settings']['product_details_footer_notes_color']; ?>;
<?php }else{ ?>
	color: #333333;
<?php } ?>
}

.pdw-left-top{
	margin-top: -1px;
	margin-left: 201px;
}

.pdw-bottom-left{
	margin-top: 223px;
	margin-left: -1px;
}

.pdw-bottom-right{
	margin-left: -405px;
	margin-top: 223px;
}

.pdw-right-top{
	margin-left: -607px;
	margin-top: -1px;
}

.pdw-left-bottom{
	margin-top: -225px;
	margin-left: 201px;
}

.pdw-right-bottom{
	margin-left: -607px;
	margin-top: -225px;
}

.pdw-top-left{
	margin-top: -449px;
	margin-left: -1px;
}

.pdw-top-right{
	margin-top: -449px;
	margin-left: -405px;
}
</style>