
								
				$('form#addGadget button').click(function(){
						var itemid    = $(this).find('input[name=product-id]').val();
						var formData  = $('form#addGadget').serialize();
						$.ajax({
							url: base_url+'cart/addtocart',
							data: formData,
							type:'post',
							success: function(response){
								
								var resp = jQuery.parseJSON( response );
								
								if(resp.status == 'success' && resp.rowid){
									window.location = '<?php echo base_url() ?>sku-configuration';
								}
								
							}, 
							error: function(){
								alert('Some error occured or the system is busy. Please try again later');	
							}
						});
				});
