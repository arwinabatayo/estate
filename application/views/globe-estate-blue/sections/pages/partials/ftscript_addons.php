
		//accessories & addons addtocart - mark
		$('form.addtoCart .box-content').click(function(){

				var thisID = $(this).parent('form').attr('id');
				var itemname  = $(this).find('input[name=product-name]').val();
				var itemprice = $(this).find('input[name=product-price]').val();
				var itemid    = $(this).find('input[name=product-id]').val();
				var formData  = $('form#'+thisID).serialize();
				var basket    = $('#AddonCartWidget');
				var basketAccessory    = $('#AccessoryCartWidget');


				$.ajax({
					url: base_url+'cart/addtocart',
					data: formData,
					type:'post',
					success: function(response){

						var resp = jQuery.parseJSON( response );

						var cartItem = '<div id="prod-item-'+resp.rowid+'" class="item" style="display:none"><div class="fleft"><span class="productName block">'+resp.name+'</span><span class="price block arial italic">'+resp.price_formatted+'</span></div><span class="icoDelete"> <a class="btnDelete" href="javascript:void(0)" id="'+resp.rowid+'"><i class="icon-remove">&nbsp;X&nbsp;</i></a> </span><br class="clear" /></div>\n';

						if(resp.status == 'success' && resp.rowid){
							
							if( resp.product_type == 'accessories'){
								basketAccessory.append(cartItem);
								$('#accAccesoriesTab .accordion-body').height('auto');
								$('#accAccesoriesTab .accordion-toggle').removeClass('in collapse').addClass('collapsed');
							}else{
								$('#accAddonTab .accordion-body').height('auto');
								$('#accAddonTab .accordion-toggle').removeClass('in collapse').addClass('collapsed');
								
							    basket.append(cartItem);
							}

							$('#prod-item-'+resp.rowid).show('slow');
							$('#cashoutLabel').html(resp.total);
							$('#cashoutBox').animate({backgroundColor: '#fff267'}, 'fast', function(){
								$('#cashoutBox').animate({backgroundColor: '#F4F4F4'}, 'fast');
							});


						}else{
							alert(resp.msg);
						}

					},
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');
					}
				});

		});

		//delete cart item - mark
		$(document).on('click', '.cartWidget a.btnDelete, #cartSummaryTable a.btnDelete', function(){
				var rowid = $(this).attr('id');
				var prodName = $(this).attr('rel');

				if( !confirm('Are you sure you want to delete "'+prodName+'"?')) return;

				$.ajax({
					url: base_url+'cart/delete',
					data: 'keyid='+rowid+'&type',
					type:'post',
					success: function(response){

						var resp = jQuery.parseJSON( response );

						if(resp.status == 'success'){
							$('#prod-item-'+rowid).slideUp('slow', function(){ $(this).remove() });
							$('#cashoutLabel').html(resp.total);
						}else{
							alert(resp.msg);
						}
					},
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');
					}
				});

		});
		
		$('#btnAddonNextPage').click(function(){
				$.ajax({
					url: base_url+'cart/check_credit_limit',
					type:'post',
					success: function(response){

						var resp = jQuery.parseJSON( response );

						if( resp.status == 'true' ){
							alert('Credit limit exceed!');
						}else{
							window.location.href= base_url+'subscriber-info'
						}
					},
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');
					}
				});
			
		});
			
		//
		
		
		
