<style>
.nav-button { display: none; } /* hide the navigation button by default */
body { padding-top: 50px; background:<?php echo $site_data['body']['background_color']; ?>;font-family:arial;} 
 @media only screen and (min-width: 0px) and (max-width: 600px) {

/*	Navigation Button
	-------------------------------------------------------- */

	.nav-button {
		display: block;
		position: absolute;
		top: 7px;
		right: 7px;
		width: 50px;
		height: 35px;
		background: url('images/menu-icon-large.png'), -webkit-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('images/menu-icon-large.png'),    -moz-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('images/menu-icon-large.png'),     -ms-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('images/menu-icon-large.png'),      -o-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background-position: center center;
		background-repeat: no-repeat;
		background-size: 21px, 100%;
		cursor: pointer;
		border: 0 none;
		border-bottom: 1px solid rgba(255,255,255,.1);
		box-shadow: 0 0 4px rgba(0,0,0,.7) inset;
		border-radius: 5px;
		z-index: 999;
		text-indent: -9999px;
	}
	.nav-button:hover { 
		background-color: rgba(0,0,0,.1); 
	}
	.nav-button.open {
		background: url('images/close-icon-large.png'), -webkit-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('images/close-icon-large.png'),    -moz-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('images/close-icon-large.png'),     -ms-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background: url('images/close-icon-large.png'),      -o-linear-gradient(top, rgba(0,0,0,0), rgba(0,0,0,.2));
		background-position: center center;
		background-repeat: no-repeat;
		background-size: 21px, 100%;
	}

	/* Navigation Bar
	-------------------------------------------------------- */

	

	.primary-nav {
		width: 100%;
		float: none;
		background-color: #000000; /* change the menu color */
				display: block;
		height: 50px;
		margin: 0;
		padding: 0;
		overflow: hidden;
		box-shadow: 0 1px 2px rgba(0,0,0,.6);
		position: absolute;
		top: 0px;
		left: 0px;
		z-index: 998;
		clear: both;
	}
	.primary-nav li {
		display: none;
		width: 100%;
		font-family: Arial;
	}
	.primary-nav li a {
		display: block;
		width: 90%;
		padding: 10px 5%;
		font-size: 14px;
		font-weight: bold;
		text-shadow: -1px -1px 0 rgba(0,0,0,.15);
		color: white;
		text-decoration: none;
		border-bottom: 1px solid rgba(0,0,0,.2);
		border-top: 1px solid rgba(255,255,255,.1); 
	}
	.primary-nav li a:hover {
		background-color: rgba(0,0,0,.5);
		border-top-color: transparent;
	}
	
	.primary-nav li a.active{
		background-color: rgba(0,0,0,.5);
		border-top-color: transparent;
		background:#cccccc;
	}
	
	.primary-nav > li:first-child {
		border-top: 1px solid rgba(0,0,0,.2);
	}

	/* Toggle the navigation bar open  */

	.primary-nav.open { 
		height: auto; 
		padding-top: 50px;
	}
	.primary-nav.open li { 
		display: block; 
	}

	/* Submenus – optional .parent class indicates dropdowns */

	.primary-nav > li:hover > a {
		background: rgba(0,0,0,.5);
		border-bottom-color: transparent;
	}
	.primary-nav li.parent > a:after {
		content: "▼";
		color: rgba(255,255,255,.5);
		float: right;
	}
	.primary-nav li.parent > a:hover {
		background: rgba(0,0,0,.75);
	}
	.primary-nav li ul {
		display: none;
		background: rgba(0,0,0,.5);
		border-top: 0 none;
		padding: 0;
	}
	.primary-nav li ul a {
		border: 0 none;
		font-size: 12px;
		padding: 10px 5%;
		font-weight: normal;
	}
	.primary-nav li:hover ul {
		display: block;
		border-top: 0 none;
	}
	
	#social_holder{
		float: right;
		height: 18px;
		margin: -49px 55px;
		position: relative;
		width: 35px;
		z-index: 999;
	
	}
	
	
	
	#social_holder img {
		float: left;
	}
	
	#main_slide {
		background: none repeat scroll 0 0 #EFEFEF;
		border: 1px solid #333333;
		border-radius: 2px 2px 2px 2px;
		float: left;
		height: 270px;
		position: relative;
		width: 100%;
	}

	#main_slide img
	{
		position: absolute;
		top: 0;
		left: 0;
		z-index: 8;
		visibility: hidden;
		height: 87%;
		width: 100%;;
	}
	
	

	#slide_holder{
		background: <?php echo $site_data['body']['slider_background_color']; ?>;
		border-radius: 2px 2px 2px 2px;
		height: auto;
		padding: 8px;
		
	}
	
	
	#main_slide_thumbs {
		border-radius: 3px 3px 3px 3px;
		margin: 236px auto auto;
		padding: 0 1px 1px;
		position: absolute;
		text-align: center;
		z-index: 999;
	}
	
	#main_slide_thumbs img
	{
		background: none repeat scroll 0 0 #EFEFEF;
		cursor: pointer;
		display: block;
		float: left;
		height: 35px;
		margin: 0;
		opacity: 0.4;
		width: 60px;
	}
	.nav_holder{
	
	
	}
	
	#main_image_holder{
	
		padding:4px;
		background:<?php echo $site_data['body']['main_image_background_color']; ?>;
		margin:4px 0 4px 0;
		border-radius:2px;
		height: 200px;
	
	}
	
	#main_image_holder img{
		
		height: 100%;
		width: 100%;		
	}
	.sub_label {
		color: #000000;
		font-size: 14px;
		font-weight: bold;
		
	}
	.content{
		
		font-size: 11px;
	
	}
	
	#gallery {
		padding: 10px 0 2px 10px;
	}
	
	
	#gallery .item {
		background: none repeat scroll 0 0 #FFFFFF;
		border: 1px solid #CCCCCC;
		border-radius: 3px 3px 3px 3px;
		box-shadow: 2px 2px 2px #DDDDDD;
		float:left;
		height: 50px;
		margin: 0 20px 20px 0;
		padding: 10px;
		width: 50px;
	}
	
	
	#gallery .item .inner {
		cursor: pointer;
		height: 50px;
		overflow: hidden;
		width: 50px;
	}
	
	#featured .item {
		background: none repeat scroll 0 0 #000000;
		color: #FFFFFF;
		float: left;
		font-size: 10px;
		height: 280px;
		line-height: 1.2;
		margin: 15px;
		padding: 10px;
		width: 220px;
	}
	
	#featured .item {
		color: #FFFFFF;
		font-size: 10px;
		line-height: 1.2;
	}
	
	#featured .item > img {
		width: 100%;
	}

	
}  /*End Mobile Styles */

	.logo{
		background:url('assets/<?php echo $site_data['site_settings']['site_logo']; ?>') no-repeat;
		display:block;
		height:50px;
		width:250px;
		background-size: 80%, 100%;
		z-index: 999;
		top:0;
		position:absolute;
	}
	
	
@media only screen and (min-width: 601px) and (max-width: 1500px) {
	
	#wrapper{
		width:920px;
		margin:auto;
	
	}
	.sub_label {
		color: #000000;
		font-size: 14px;
		font-weight: bold;
		
	}
	.content{
		
		font-size: 11px;
	
	}
	#social_holder{
		float: right;
		height: 18px;
		margin: -34px -326px;
		position: relative;
		width: auto;
		z-index: 999;
	
	}
	.primary-nav {
		display: block;
		
		position: relative;
	
	}
	
	.primary-nav li {
		float: left;
		font-family: Arial;
		font-size: 12px;
		font-weight: bold;
		list-style: none outside none;
		margin: -14px 3px 0;
		position: relative;
		top: -4px;
		
	}
	
	.primary-nav a.active{
		border-bottom: 2px solid #808080;
		
	}
	
	.primary-nav a{
		color:<?php echo $site_data['body']['text_color']; ?>;
		text-decoration:none;
		text-transform:uppercase;
	}
	
	#main_side	{
		height: 299px;
		margin: 10px 10px 10px 580px;
		overflow: auto;
		position: absolute;
		text-align: left;
		width: 281px;
	}
	
	
	#slide_holder{
		background: <?php echo $site_data['body']['slider_background_color']; ?>;
		border-radius: 2px 2px 2px 2px;
		height: 370px;
		padding: 25px;
		
	}
	
	#main_slide
	{
		background: #EFEFEF;
		height: 100%;
		width: 100%;
		border: 1px solid #333;
		float: left;
		position: relative;
		border-radius: 2px;
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
	}
	
	#main_slide_thumbs {
		
		margin-right: 29px;
		padding: 0 1px 1px;
		position: relative;
		text-align: center;
		top: -55px;
		
	}
	
	#main_slide_thumbs img
	{
		background: none repeat scroll 0 0 #EFEFEF;
		cursor: pointer;
		display: block;
		float: left;
		height: 52px;
		margin: 0;
		opacity: 0.4;
		width: 80px;
	}
	
	#main_slide img
	{
		position: absolute;
		top: 0;
		left: 0;
		z-index: 8;
		visibility: hidden;
		height: 85%;
		width: 65%;;
	}
	
	#main_image_holder {

		background: <?php echo $site_data['body']['main_image_background_color']; ?>;
		border-radius: 2px 2px 2px 2px;
		height: 420px;
		margin: 10px 0;
		padding: 2px;
		width: 870px;
		padding:25px;
	
	}
	
	.nav_holder{
	
		float: right;
		position: relative;
		right: 91px;
		top: -30px;
	}
	
	
	#main_image_holder > img {
		width: 100%;
		height: 100%;
	}
	
	
	#gallery {
		padding: 23px 0 3px 23px;
	}
	
	
	#gallery .item {
		background: none repeat scroll 0 0 #FFFFFF;
		border: 1px solid #CCCCCC;
		border-radius: 3px 3px 3px 3px;
		box-shadow: 2px 2px 2px #DDDDDD;
		float:left;
		height: 190px;
		margin: 0 20px 20px 0;
		padding: 10px;
		width: 190px;
	}
	
	
	#gallery .item .inner {
		cursor: pointer;
		height: 190px;
		overflow: hidden;
		width: 190px;
	}
	
	
	#featured .item {
		background: none repeat scroll 0 0 #000000;
		color: <?php echo $site_data['body']['text_color']; ?>;
		float: left;
		font-size: 10px;
		height: 263px;
		line-height: 1.2;
		margin: 10px 8px 10px 0;
		padding: 10px;
		width: 207px;
	}
	
	#featured .item {
		color: #FFFFFF;
		font-size: 10px;
		line-height: 1.2;
	}
	
	#featured .item > img {
		width: 100%;
	}
	
}	/* end for wide screen */
	
	
	
	#footer_holder{
		text-align:center;
		border-top:1px solid #333;
		margin: 5px 0 5px 0;
	}
	
	#footer_holder  a {
		text-decoration: none;
		text-transform:uppercase;
		font-size:10px;
		font-weight:bold;
		color:<?php echo $site_data['body']['text_color']; ?>;
		font-family: Arial;
	}
	



	#main_side .label
	{
		text-transform: uppercase;
		font-weight: bold;
		font-size: 30px;
		margin: 0px 0px 5px 0px;
		
	}


	

	/*#main_slide img
	{
		position: absolute;
		top: 0;
		left: 0;
		z-index: 8;
		visibility: hidden;
		height: 300px;
		width: 600px;
	}*/

	#main_slide img.active 
	{
		visibility: visible;
	}

	#image_holder{
	
		padding:4px;
		background:<?php echo $site_data['body']['content_background_color']; ?>;
		margin:4px 0 4px 0;
		border-radius:2px;
		height: auto;
	
	}
	
	#main_side .content{
		font-size:12px;
	
	}

	#main_slide_thumbs img.active
	{
		opacity: 1;
		filter: alpha(opacity=100);
	}
	
	
	.fancybox > img {
		height: 100%;
		width: 200%;
	}
</style>