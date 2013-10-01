		
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
		
		
		$('button#btnAddonNextPage').click(function(){
			
				$.ajax({
					url: base_url+'cart/check_credit_limit',
					type:'post',
					success: function(response){

						var resp = jQuery.parseJSON( response );
						if( resp.status == 'true' ){
							//TODO - proceed to next steps
							$('#exceed-limit').modal('show');
						}else{
							window.location.href= base_url+'subscriber-info'
						}
					},
					error: function(){
						alert('Some error occured or the system is busy. Please try again later');
					}
				});
			
		});
			
		$('#myfile').change(function(){
			$('#path').val($(this).val());
		});	

		$("button#btnAddonNextPage2").click(function(){
			window.location.href= base_url+'subscriber-info?subscriber_flag=false';
		});
		
		$(document).on('click', '#showUploadForm', function(){
			$('#exceed-limit').modal('hide');
			$('#modifyPlan2').modal('show');
		});	
		
		// Robert
		$('#financialUpload').click(function(e) {
			e.preventDefault();
			$.ajaxFileUpload({
				url: base_url+'ajax/upload_file',
		        secureuri : false,
		        fileElementId :'myfile',
		        dataType : 'json',
		        data : {
		           	'title' : $('#myfile').val()
		        },
		        success  : function (data, status) {
		           if(data.status != 'error') {
		              $('#uploading').html('<p>Uploading...</p>');
		              var al = alert("File successfully uploaded");
		              window.location= base_url;
		           }
		        }
		        
		     });
		     return false;
		});
		
		jQuery.extend({
		    handleError: function( s, xhr, status, e ) {
		        // If a local callback was specified, fire it
		        if ( s.error )
		            s.error( xhr, status, e );
		        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
		        else if(xhr.responseText)
		            console.log(xhr.responseText);
		    }
		});

		
		
