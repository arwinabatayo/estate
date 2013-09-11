/**
 * Author: NoveSys - Frontend Team (Mark,Stephen)
 * Created:   08.23.2013
 * Description: all js commons
 *
 **/
 

$(function () {
	
	//* * * initialize plugins

	$('button').button();
	$('.button').button();
	$('.radioset').buttonset();
	$('.tabs').tabs();
	$('.globe-dialog').dialog({
				autoOpen: false,
				width:    'auto',
				modal:    true,
                draggable: true,
                resizable: false
	});
 
	//* * * jquery-ui dialogue/modal plugin wrap
	$.fn.extend({ 
		globeDialog: function(options) {
			var defaults = {
				trigger: ".dialog_open", 
				target:  null,
				autoOpen: false,
				width:    'auto',
				modal:    true,
				beforeOpen : function(){}, //callback before dialog is open
				afterOpen  : function(){}, //callback after dialog is open
				btnOkAction: function(){}, //callback when Ok button is press
				btnOK      : 'Ok', // default button label
				btnCancel  : 'Cancel',
				btnCancelAction  : function(){}, //callback when cancel button is press
				debugConfig  : false
			};
			
			var options =  $.extend(defaults, options);

    		return this.each(function() {
				var o = options;
				o.trigger = '#'+$(this).attr('id'); 
				o.target  = '#'+$(this).attr('rel'); 
				
				if(o.debugConfig){
					console.log( JSON.stringify(o) );
				}
				
				$(o.trigger).click(function () {
					var target = o.target;
					//o.beforeOpen();
					$( target ).dialog('open');
					o.afterOpen();
					return false;
				});
				$(o.target).dialog({
					autoOpen: o.autoOpen,
					width:    o.width,
					modal:    o.modal,
					 buttons: [
					{
					text: o.btnOK,
					click: function() {
						o.btnOkAction();
					}
					}
					]
				});
			
    		});
			
		}
	 
	});

	

	

	    
	//generic close/open dialog function
	$('.open-dialog').click( function(e){
		e.preventDefault();
		var target  = '#'+$(this).attr('rel'); 
		$( target ).dialog( "open" );
		$(this).closest('.ui-dialog-content').dialog('close');
	});
	
	$('.close-dialog').click( function(e){
		e.preventDefault();
		var target  = '#'+$(this).attr('rel'); 
		$( target ).dialog( "close" );
	});
	    
	$('.anchor').click( function(){
		var target  = $(this).attr('rel'); 
		window.location = target;
	});    
	    
	//for debugging purpose
	$(window).bind("resize", function(){
		var doc_width = $(document).width();
		//$('#doc').html(doc_width);
	});
	

	
     //page preloader
    //<![CDATA[
        $(window).load(function() { 
            $("#status").fadeOut(); $("#preLoader").delay(350).fadeOut("fast");
        })
    //]]>	

});	 

var showPreloader = function(){
	$("#status").fadeIn(); $("#preLoader").delay(350).fadeIn("fast");
}

var closePreloader = function(){
	$("#status").fadeOut(); $("#preLoader").delay(350).fadeOut("fast");
}













