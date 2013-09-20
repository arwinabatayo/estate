			  $( "#siderbar-panel" ).accordion( "option", "active", 3 );
			  
			
			  $('form#personal-info button').click(function() {
					if ( $("input[name='sns_id']:checked").val() == 'facebook' ) {
				       $( '#confim_onbehalf' ).dialog( "open" );
				    }else{
						
						$( "#personal-info-page" ).accordion( "option", "active", 1 );
					}
			  });
				
				$('#confim_onbehalf').dialog({
					autoOpen: false,
					dialogClass: "no-close",
					buttons: {
						"Yes" : function() {
							   $( this ).dialog( "close" );
							  $( "#personal-info-page" ).accordion({
								  active: 1
								  });
						},
						"No" : function() {
							   $( this ).dialog( "close" );
							  $( "#personal-info-page" ).accordion({
								  active: 1
							  });
						}
					}
				});
