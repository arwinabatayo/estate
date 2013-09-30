
			  $('form#personal-info button').click(function() {
					if ( $("input[name='sns_id']:checked").val() == 'facebook' ) {
				      // $( '#confim_onbehalf' ).dialog( "open" );
				    }else{
						
					}
					
					window.location.href=base_url+'payment/plan_summary';
			  });
				

				$('.radio-btn input').iCheck({
					checkboxClass: 'icheckbox_flat-red',
					radioClass: 'iradio_flat-blue'
				});
	

