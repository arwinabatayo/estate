// zebra table effect
function zebraTable() { 
	$(".zebra tr:odd td").addClass("g_zebraodd");
	$(".zebra tr:even td").addClass("g_zebraeven");
	
	$(".zebra tr td").hover(function(){
		$(this).parent("tr").children("td").addClass('h_backgroundhover'); 
	}, function(){
		$(this).parent("tr").children("td").removeClass('h_backgroundhover'); 
	});
}

// select placeholder effect
function placeHolder() {
	$("select").change(function () {
		if($(this).val() == "0") $(this).css("color", "#999999");
		else $(this).css("color", "#000000");
	});
	$("select").change();
}

function displayNotification(type, message)
{
	hideAllNotifications();
	switch(type) 
	{
		case "message":
			$("#message_wrapper").fadeIn(250);
			break;
		case "success":
			$("#success").html(message);
			$("#success_wrapper").fadeIn(250);
			$("._main").css("top", "37px");
			$(".mobile_preview_wrapper").css("top", "37px");
			break;
		case "error":
			$("#error").html(message);
			$("#error_wrapper").fadeIn(250);
			$("._main").css("top", "37px");
			$(".mobile_preview_wrapper").css("top", "37px");
			break;
		case "success_asset":
			$("#success_asset").html(message);
			$("#success_asset_wrapper").fadeIn(250);
			$("._main").css("top", "37px");
			$(".mobile_preview_wrapper").css("top", "37px");
			break;
		case "message_asset":
			$("#message_asset").html(message);
			$("#message_asset_wrapper").fadeIn(250);
			$("._main").css("top", "37px");
			$(".mobile_preview_wrapper").css("top", "37px");
			break;
		default:
			$("#message").html(message);
			$("#message_wrapper").fadeIn(250);
			$("._main").css("top", "37px");
			$(".mobile_preview_wrapper").css("top", "37px");
	}
	return;
}

function hideAllNotifications()
{
	$(".notification").each(function(){
		$(this).hide();
	});
	$("._main").css("top", "0px");
	$(".mobile_preview_wrapper").css("top", "0px");
	return;
}

function implementColorPicker()
{
	$("div.color_indicator").each(function(){
		var _color = $(this).attr('data-color');
		$(this).ColorPicker({
			color: _color,
			onSubmit: function(hsb, hex, rgb, el) {
				hex = hex.toUpperCase();
				$(el).siblings("input").val("#"+hex);
				$(el).ColorPickerHide();
				$(el).css('background', '#'+hex);
			}
		});
	});
	
	return;
}

function implementDatePicker()
{
	$(".dpicker").each(function(){
		$(this).datepicker({ dateFormat: $(this).attr('data-format'), changeMonth: true, changeYear: true });
	});
	return;
}

function showSidebar(animate)
{
	if (animate) {
		$("#g_side").animate({ marginLeft: "0px" }, 100);
		$("#middle_wrapper").animate({ left: "250px" }, 100);
		$(".notification_top").animate({ marginLeft: "280px" }, 100);
	}
	$("#g_side #logo_wrapper a").css("visibility", "visible");
	$("#g_profile").css("visibility", "visible");
	$("#g_profile2").css("visibility", "visible");
	$("#sidetoggle img").attr('src', config['base']+'_assets/images/menu/sidebar_hide.png');
	return;
}

function hideSidebar(animate)
{
	if (animate) {
		$("#g_side").animate({ marginLeft: "-205px" }, 100);
		$("#middle_wrapper").animate({ left: "45px" }, 100);
		$(".notification_top").animate({ marginLeft: "75px" }, 100);
	}
	$("#g_side #logo_wrapper a").css("visibility", "hidden");
	$("#g_profile").css("visibility", "hidden");
	$("#g_profile2").css("visibility", "hidden");
	$("#sidetoggle img").attr('src', config['base']+'_assets/images/menu/sidebar_show.png');
	return;
}

function checkSidebarStatus()
{
	/*
	if (typeof localStorage != 'undefined') {
		var sidebar = localStorage.getItem('sidebar');
		if (sidebar == "hidden") { hideSidebar(0); } 
		else { showSidebar(0); }
	}
	*/
	return;
}