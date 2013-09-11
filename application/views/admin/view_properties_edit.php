<div id="g_content">

	<div id="g_tools"> 
		<a href="<?php echo base_url(); ?>admin/properties"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Property List</a>	
		<?php if (($property_details['template_type_id'] != 4) && ($site_data)) { ?>
			<a href="<?php echo base_url(); ?>preview/<?php echo $property_details['template_type_id']; ?>/<?php echo $property_details['folder_name']; ?>" target="_blank"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/preview.png" />Preview</a>
		<?php } else { ?>
			<a href="javascript: void(0);" id="btn_preview_app"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/preview.png" /><span class="preview_text">Preview App</span></a>
		<?php } ?>
		<?php if (($property_details['template_type_id'] == 5) && ($site_data)) { ?>
			<a href="<?php echo base_url(); ?>admin/blogs/summary/<?php echo $property_details['property_id']; ?>""><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/blog.png" />Blog Summary</a>
		<?php } ?>
		<a href="<?php echo base_url(); ?>admin/properties/revert/<?php echo $property_details['property_id']; ?>""><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/revert.png" />Revert Changes</a>
		<a href="<?php echo base_url(); ?>admin/properties/manage_assets/<?php echo $property_details['property_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/assets.png" />Manage Assets</a>
		<a href="<?php echo base_url(); ?>admin/configurations/property/<?php echo $property_details['property_id']; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/settings.png" />Configurations</a>
		<a href="javascript: void(0);" id="btn_edit_property"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/save.png" />Save Changes</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	
	<?php /*
	<div id="temp_tools"> 
		<a href="javascript: void(0);"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/_elearning.png" />E-Learning</a>
		<a href="javascript: void(0);"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/_coaching.png" />Coaching</a>
		<div class="h_clearboth"></div>
	</div>
	<div class="h_clearboth"></div>
	<div class="g_spacer"></div>
	*/ ?>
	
	<?php if ($property_details['template_type_id'] == 4) { ?>
		<div id="temp_tools"> 
			<a href="javascript: void(0);"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/publish.png" />Publish</a>
			<div class="h_clearboth"></div>
		</div>
		<div class="h_clearboth"></div>
		<div class="g_spacer"></div>
	<?php } ?>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/edit.png" /></div>
		<div class="g_pagelabel_text">Edit property - <?php echo $property_details['property_title']; ?></div>
	</div>
	
	<table class="g_table zebra"><tr><td class="g_widget">	
	
		<?php $reference = 2; ?>
		<div class="property_edit_tabs">
			<div class="item <?php if ($current_active_tab == "1") { echo 'active'; } ?>" data-reference="1">
				<img class="g_icon tab" src="<?php echo base_url(); ?>_assets/images/tools/generic.png" />
				<img class="g_icon grp_error h_displaynone" src="<?php echo base_url(); ?>_assets/images/notifications/error.png" />
				<span>General</span>
				<div class="h_clearboth"></div>
			</div>
			<?php if ($site_data) { ?>
			<?php foreach ($site_data as $sdata => $sd) { ?>
				<div class="item <?php if ($current_active_tab == $reference) { echo 'active'; } ?>" data-reference="<?php echo $reference; ?>">
					<img class="g_icon tab" src="<?php echo base_url(); ?>_assets/images/tools/generic.png" />
					<img class="g_icon grp_error h_displaynone" src="<?php echo base_url(); ?>_assets/images/notifications/error.png" />
					<span><?php echo str_replace("_", " ", $sdata); ?></span>
				</div>
				<?php $reference++; ?>
			<?php } ?>
			<?php } ?>
			<div class="h_clearboth"></div>
		</div>
	
		<form id="form_edit_property" class="g_form h_floatleft">
			
			<input type="hidden" name="property_id" id="property_id" value="<?php echo $property_details['property_id']; ?>" />
			<input type="hidden" name="orig_folder_name" value="<?php echo $property_details['folder_name']; ?>" />
			<input type="hidden" name="current_active_tab" value="<?php echo $current_active_tab; ?>" id="current_active_tab" />
			
			<div class="property_edit_content_grp <?php if ($current_active_tab == "1") { echo 'active'; } ?>" data-reference="1">
			
			<div class="xml_grp_header">
				<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
				General
			</div>
			
			<div class="xml_grp">
			
				<!-- owner -->
				<div class="item">
					<div class="label">Owner</div>
					<div class="input"> 	
						<select 	class="g_select" 
									name="owner_id" 
									data-reference="1"
									data-tab="1"
									data-required="1">
							<?php if ($users) { ?>
							<?php foreach ($users as $user => $u) { ?>
								<option data-required="1" value="<?php echo $u['user_id']; ?>" <?php echo ($u['user_id'] == $property_details['user_id']) ? "selected='selected'" : ""; ?>>
									<?php echo $u['last_name'] . ", " . $u['first_name']; ?>
								</option>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="h_clearboth"></div>
				</div>
			
				<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?>
					
					<!-- client -->
					<div class="item">
						<div class="label">Client</div>
						<div class="input"> 	
							<select 	class="g_select" 
										name="client_id" 
										data-reference="2"
										data-tab="1"
										data-required="1">
								<option value="0" selected="selected">Client</option>
								<?php if ($clients) { ?>
								<?php foreach ($clients as $client => $c) { ?>
									<?php if ($c['client_id'] == $property_details['client_id']) { ?>
										<option data-required="1" value="<?php echo $c['client_id']; ?>" selected="selected"><?php echo $c['title']; ?></option>
									<?php } else { ?>
										<option data-required="1" value="<?php echo $c['client_id']; ?>"><?php echo $c['title']; ?></option>
									<?php } ?>
								<?php } ?>
								<?php } ?>
							</select>
						</div>
						<div class="h_clearboth"></div>
					</div>
				
				<?php } else { ?>
				
					<input type="hidden" name="client_id" value="<?php echo $property_details['client_id']; ?>" />
				
				<?php } ?>
				
				<!-- template - cant't be edited -->
				<input 	type="hidden" 
						name="template_id" 
						value="<?php echo $property_details['template_id']; ?>"
						data-reference="3"
						data-tab="1" />
				<div class="item">
					<div class="label">Template</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight" 
								readonly="readonly"
								type="text" 
								value="<?php echo "(" . $property_details['template_id_code'] . ") " . $property_details['template_title']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- title -->
				<div class="item">
					<div class="label">Property Title</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="title" 
								maxlength="512"
								value="<?php echo $property_details['property_title']; ?>"	
								data-reference="4"
								data-tab="1"
								data-orig-val="<?php echo $property_details['property_title']; ?>"
								data-unique="1"
								data-field="title"
								data-table="properties"						
								data-required="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
				
				<!-- description -->
				<div class="item">
					<div class="label">Description</div>
					<div class="input">
						<input 	class="g_inputtext" 
								type="text" 
								name="description" 
								maxlength="512"
								value="<?php echo $property_details['property_description']; ?>"
								data-reference="5" 
								data-tab="1" />
					</div>
					<div class="h_clearboth"></div>
				</div>
						
				<?php if ($property_details['template_type_id'] != 4) { ?>
				
					<!-- property url -->
					<div class="item">
						<div class="label">Property URL</div>
						<div class="input">
							<input 	class="g_inputtext h_backgroundlight" 
									readonly="readonly"
									type="text" 
									value="<?php echo base_url(); ?>_properties/<?php echo $property_details['folder_name']; ?>/index.php" />
						</div>
						<div class="h_clearboth"></div>
					</div>

					<!-- preview url -->
					<div class="item">
						<div class="label">Preview URL</div>
						<div class="input">
							<input 	class="g_inputtext h_backgroundlight" 
									readonly="readonly"
									type="text" 
									value="<?php echo base_url(); ?>preview/<?php echo $property_details['template_type_id']; ?>/<?php echo $property_details['folder_name']; ?>" />
						</div>
						<div class="h_clearboth"></div>
					</div>
				
				<?php } ?>
				
				<!-- property data url -->
				<div class="item">
					<div class="label">Data URL</div>
					<div class="input">
						<input 	class="g_inputtext h_backgroundlight" 
								readonly="readonly"
								type="text" 
								value="<?php echo $property_details['xml_url']; ?>" />
					</div>
					<div class="h_clearboth"></div>
				</div>
			
			</div>
			</div>
			
			<!-- sections loaded from xml -->
			<?php $reference = 2; ?>
			<?php $counter = 6; ?>
			<?php if ($site_data) { ?>
			<?php foreach ($site_data as $sdata => $s) { ?>
				
				<div class="property_edit_content_grp <?php if ($current_active_tab == $reference) { echo 'active'; }?>" data-reference="<?php echo $reference; ?>">
				<div class="property_edit_content_grp_items" data-reference="<?php echo $reference; ?>">
				
					<?php if ($s) { ?>
					<?php foreach ($s as $grp => $grp_item) { ?>
						
						<div class="xml_grp_header">
							<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/generic.png" /></div>
							<?php echo str_replace("_", " ", $grp_item['attr']['sub_group']); ?>
						</div>
						
						<div class="xml_grp">
						
							<?php $current_iteration = 0; ?>
							<?php $item_counter = 0; ?>
							
							<?php if ($grp_item) { ?>
							<?php foreach ($grp_item as $key => $value) { ?>
							<?php if ($key != "label" && $key != "attr") { ?>
						
								<?php if (isset($grp_item['attr']['dynamic'])) { ?>
								<?php if (substr($key, strrpos($key, '_')+1) != $current_iteration) { ?>
									<?php if ($current_iteration > 0) { ?><div class="divider"></div><?php } ?>
									<?php $item_counter++; ?>
								<?php } ?>
								<?php } ?>
						
								<div class="item <?php echo ($value['attr']['hidden']) ? "h_displaynone" : ""; ?>">

									<div class="label">
										<?php if (isset($grp_item['attr']['dynamic'])) { ?>
											<?php
											$label_arr = explode(" ", $value['label']);
											unset($label_arr[count($label_arr)-1]);
											if ($label_arr) {
											foreach ($label_arr as $label => $l) {
												echo $l . " ";
											}
											}												
											?>
										<?php } else { ?>
											<?php echo $value['label']; ?>
										<?php } ?>
										<?php if ($value['attr']['required']) { ?>*<?php } ?>
									</div>
									
									<div class="input">
										
										<?php if (	!$value['attr']['customhtml'] && 
													!$value['attr']['asset'] && 
													!$value['attr']['choice'] && 	
													!$value['attr']['range']) { ?>
										
											<input 	class="	g_inputtext <?php echo ($value['attr']['colorpicker']) ? "h_fontlucida" : "" ;?> <?php echo ($value['attr']['datepicker']) ? "dpicker" : "" ;?> <?php echo ($value['attr']['readonly']) ? "h_backgroundlight" : "" ;?>"
													type="text" 
													name="<?php echo $key; ?>__<?php echo $value['attr']['parent']; ?>" 
													maxlength="<?php echo ($value['attr']['colorpicker'] == 1) ? "7" : "512"; ?>"
													data-reference="<?php echo $counter; ?>"
													data-tab="<?php echo $reference; ?>"
													<?php if ($value['attr']['readonly'] || $value['attr']['datepicker']) { echo "readonly='readonly'"; } ?>
													<?php if ($value['attr']['alphanum']) { echo "data-alphanum='1'"; } ?>
													<?php if ($value['attr']['link']) { echo "data-link='1'"; } ?>
													<?php if ($value['attr']['colorpicker']) { echo "data-colorpicker='1'"; } ?>
													<?php if ($value['attr']['datepicker']) { echo "data-format='".$value['attr']['format']."'"; } ?>
													<?php if ($value['attr']['required']) { echo "data-required='1'"; } ?>
													value="<?php echo $value['value']; ?>" />
													
											<!-- color indicator - for color picker -->
											<?php if ($value['attr']['colorpicker']) { ?>
												<div 	class="color_indicator" 
														data-color='<?php echo $value['value']; ?>' 
														style="background: <?php echo $value['value']; ?>">
												</div>
											<?php } ?>
										
										<?php } else if ($value['attr']['choice']) { ?>
										
											<select data-tab="<?php echo $reference; ?>" name="<?php echo $key; ?>__<?php echo $value['attr']['parent']; ?>" class="g_select">
												<option <?php echo ($value['value'] == 'Yes') ? "selected='selected'" : ""; ?>>Yes</option>
												<option <?php echo ($value['value'] == 'No') ? "selected='selected'" : ""; ?>>No</option>
											</select>
													
										<?php } else if ($value['attr']['asset']) { ?>
								
											<input 	class="g_inputtext h_displaynone" 
													type="text" 
													name="<?php echo $key; ?>__<?php echo $value['attr']['parent']; ?>" 
													maxlength="512"
													data-reference="<?php echo $counter; ?>"
													data-tab="<?php echo $reference; ?>"
													data-asset="1"
													<?php if ($value['attr']['readonly']) { echo "readonly='readonly'"; } ?>
													<?php if ($value['attr']['alphanum']) { echo "data-alphanum='1'"; } ?>
													<?php if ($value['attr']['colorpicker']) { echo "data-colorpicker='1'"; } ?>
													<?php if ($value['attr']['required']) { echo "data-required='1'"; } ?>
													value="<?php echo $value['value']; ?>" />
													
											<!-- img preview -->
											<div 	class="img_preview <?php echo ($value['attr']['icon']) ? "icon" : ""; ?>" 
													<?php echo ($value['attr']['icon']) ? "data-icon='1'" : ""; ?>"
													data-reference="<?php echo $counter; ?>">
													
												<?php if ($value['value']) { ?>
													<div class="img_holder">
														<img 	class="tobe_edited" 
																src="<?php echo $this->config->item('base_property_url') . $property_details['folder_name'] . "/assets/" . $value['value']; ?>"
																onError="$(this).attr('src', '<?php echo $this->config->item('base_asset_url') . "images/no_filefound.png"; ?>')" />
													</div>
												<?php } else { ?>
													<div class="img_holder">
														<img class="tobe_edited" src="<?php echo $this->config->item('base_asset_url') . "images/no_image.png"; ?>" />
													</div>
												<?php } ?>
												
												<div class="img_actions">
													<div 	class="remove_value <?php echo ($value['value']) ? "" : "h_displaynone"; ?>" 
															title="Remove image" 
															data-reference="<?php echo $counter; ?>">
															<img class="g_tableicon h_width100percent" src="<?php echo base_url(); ?>_assets/images/global_icon_close.png" />
													</div>
													<div 	class="upload"
															data-reference="<?php echo $counter; ?>">
														<img 	class="g_tableicon h_width100percent" 
																title="Upload image" 
																src="<?php echo base_url(); ?>_assets/images/global_icon_upload.png" />
													</div>
													<div 	class="edit_value upload_indicator" 
															title="Edit image" 
															data-reference="<?php echo $counter; ?>">
															<img class="g_tableicon h_width100percent" src="<?php echo base_url(); ?>_assets/images/global_icon_edit.png" />
													</div>
													<?php if ($value['attr']['dimensions']) { ?>
														<div class="guide">Dimensions: <?php echo $value['attr']['dimensions']; ?></div>
													<?php } ?>
												</div>
												
												<div class="h_clearboth"></div>
												
											</div>
										
										<?php } else if ($value['attr']['customhtml']) { ?>
										
											<textarea 	class="" style="width: 502px;" 
														name="<?php echo $key; ?>__<?php echo $value['attr']['parent']; ?>" 
														data-reference="<?php echo $counter; ?>"
														data-tab="<?php echo $reference; ?>">
												<?php echo $value['value']; ?>
											</textarea>
											
										<?php } else if ($value['attr']['range']) { ?>
											
											<?php $range_counter = $value['attr']['min']; ?>
											<select data-tab="<?php echo $reference; ?>" name="<?php echo $key; ?>__<?php echo $value['attr']['parent']; ?>" class="g_select">
												<?php while ($range_counter <= $value['attr']['max']) { ?>
													<option <?php echo ($range_counter == $value['value']) ? "selected='selected'" : ""; ?> value="<?php echo $range_counter; ?>"><?php echo $range_counter; ?></option>
													<?php $range_counter++; ?>
												<?php } ?>
											</select>
											
										<?php } ?>
										
									</div>
									
									<div class="h_clearboth"></div>
									
									<!-- show tips for Keywords field -->
									<?php if ($value['label'] == "Keywords") { ?>
										<div class="additional_notes">
											<div class="guide"><div class="icon"></div>Separate keywords by comma</div>
										</div>
									<?php } ?>
									
									<!-- show tips for Facebook App Id field -->
									<?php if ($value['label'] == "Facebook App Id") { ?>
										<div class="additional_notes">
											<div class="guide"><div class="icon"></div>Facebook App ID is required for the page to be displayed properly in Facebook</div>
										</div>
									<?php } ?>
									
									<!-- show tips for URLs -->
									<?php if ($value['attr']['link']) { ?>
									<div class="additional_notes">
										<div class="guide"><div class="icon"></div>URLs must start with "http://" or "https://"</div>
									</div>
									<?php } ?>
										
									<!-- show tips when field is edited from asset library -->
									<div class="additional_notes <?php echo ($value['attr']['dimensions']) ? "" : "h_displaynone" ;?>" data-reference="<?php echo $counter; ?>">
										<div class="info" data-reference="<?php echo $counter; ?>"></div>
									</div>
							
									<?php if (isset($grp_item['attr']['dynamic'])) { ?>
									<?php if (substr($key, strrpos($key, '_')+1) != $current_iteration) { ?>
										<div class="item_bookmark">
											<div class="item_counter"><?php echo $item_counter; ?></div>
											<div class="item_delete">
												<a 	href="javascript:void(0);" 
													class="btn_remove_set g_tableicon"
													data-group="<?php echo $grp_item['attr']['group']; ?>"
													data-subgroup="<?php echo $grp_item['attr']['sub_group']; ?>"
													data-element="<?php echo substr($key, strrpos($key, '_')+1); ?>"
													title="Delete item">
													<img src="<?php echo base_url(); ?>_assets/images/global_icon_delete.png" />
												</a>											
											</div>
										</div>
									<?php } ?>
									<?php $current_iteration = substr($key, strrpos($key, '_')+1); ?>
									<?php } ?>
							
								</div>
								
								<div class="h_clearboth"></div>
								<?php $counter++; ?>
							
							<?php } ?>
							<?php } ?>
							<?php } ?>
							
							<?php if (isset($grp_item['attr']['dynamic'])) { ?>
								<div class="h_clearboth"></div>
								<div class="divider"></div>
								<div class="btn_dynamic_wrapper <?php echo (count($grp_item) > 2) ? "h_margintop10" : "h_margin0"; ?>">
									<input 	type="button" 
											value="Add new item" 
											data-reference="<?php echo $reference; ?>"
											data-group="<?php echo $grp_item['attr']['group']; ?>"
											data-subgroup="<?php echo $grp_item['attr']['sub_group']; ?>"
											class="g_inputbutton btn_dynamic h_margin0" />
									<div class="h_clearboth"></div>
								</div>
							<?php } ?>
							
						</div>
						
					<?php } ?>
					<?php } ?>
					
				</div>
				</div>
				<?php $reference++; ?>
				
			<?php } ?>
			<?php } ?>
			
		</form>
		
	</td></tr></table>
	
	<div class="h_clearboth"></div>
	
</div>

<?php if ($property_details['template_type_id'] == 4) { ?>
<div class="mobile_preview_wrapper">
	
	<?php /*
	<div class="mobile_options">
		<a href="javascript: void(0);"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_ios.png" />iPhone 5</a>
		<a href="javascript: void(0);"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_android.png" />Samsung Galaxy S4</a>
		<a href="javascript: void(0);"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_android.png" />Samsung Galaxy S3</a>
		<a href="ja-ascript: void(0);"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_android.png" />ASUS Nexus 7</a>
		<a href="javascript: void(0);"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_ios.png" />iPhone 3GS</a>
		<a href="javascript: void(0);"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_ios.png" />iPhone 4</a>
		<a href="javascript: void(0);" data-name="iphone4s"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_ios.png" />iPhone 4s</a>
		<a href="javascript: void(0);" data-name="lgnexus4"><img src="<?php echo base_url(); ?>_assets/images/preview/logo_android.png" />LG Nexus 4</a>
	</div>
	*/ ?>

	<form id="mobile_details">
		<input type="hidden" name="preview_url_type" value="<?php echo $property_details['preview_url_type']; ?>" />	
		<input type="hidden" name="preview_url" value="<?php echo $property_details['preview_url']; ?>" />
	</form>
	
	<div class="mobile_preview">

		<div class="mobile">
			<?php if ($property_details['preview_url_type'] == "swf") { ?>
				<?php /*
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="320" height="480" id="expandable" align="middle">
				<param name="allowScriptAccess" value="sameDomain" />
				<param name="allowFullScreen" value="false" />
				<param name="movie" value="preview.swf?<?php echo time(); ?>" />
				<param name="quality" value="high" />
				<param name="wmode" value="direct" />
				<param name="bgcolor" value="#666666" /> 
				<embed src="<?php echo $property_details['preview_url']; ?>?<?php echo time(); ?>" quality="high" wmode="direct" bgcolor="#666666" width="320" height="480" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
				*/ ?>
				<iframe src="<?php echo $property_details['preview_url']; ?>?<?php echo time(); ?>" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" style="height: 480px; width: 320px; z-index: auto;"></iframe>
			<?php } else if ($property_details['preview_url_type'] == "html5") { ?>
				<iframe id="app" src="<?php echo $property_details['preview_url']; ?>?<?php echo time(); ?>" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" style="height: 960px; width: 640px; z-index: auto;"></iframe>
			<?php } ?>
		</div>
		
	</div>
</div>	
<?php } ?>

<div class="g_overlay">
	<div id="asset_wrapper"></div> <!-- asset overlay -->
	<div id="editor_wrapper"></div> <!-- custom text/html editor overlay -->
	
	<!-- upload image in edit item -->
	<div id="upload_wrapper">
		<form 	id="form_upload_asset" 
				action="<?php echo base_url(); ?>ajax/upload_asset" 
				method="POST" 
				enctype="multipart/form-data" 
				target="iframe_location">
			<input 	type="hidden" name="upload_type" 		value="property_asset_edit" />
			<input 	type="hidden" name="property_title" 	value="<?php echo $property_details['property_title']; ?>" />
			<input 	type="hidden" name="folder_path" 		value="<?php echo $folder_path; ?>" />
			<input 	type="hidden" name="upload_reference" 	value="<?php echo $upload_reference; ?>" 	id="upload_reference" />
			<div class="file"><input type="file" name="file_to_upload" id="file_to_upload" /></div>
			<div class="g_info h_marginbottom10"><div class="icon"></div>Only .jpg and .png files are allowed.</div>
			<input type="submit" value="Upload" class="g_inputbutton h_margin0 h_floatright" />
		</form>
	</div>
</div>

<iframe id="iframe_location" name="iframe_location" scrolling="no" src=""></iframe>

<input type="hidden" value="<?php echo $page_sub; ?>" id="_page" />

<script type="text/javascript" language="javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_statusbar_location : "none", 
	theme_advanced_buttons1 : "bold,italic,underline",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	force_br_newlines : true,
	force_p_newlines : false,
	plugins : "paste, autoresize",
	paste_text_sticky : true,
	setup : function(ed) {
		ed.onInit.add(function(ed) {
			ed.pasteAsPlainText = true;
		});
	}
});

$(function(){
	placeHolder();
	implementColorPicker();
	implementDatePicker();
});

// add new item
$(".btn_dynamic").click(function(){
	tinyMCE.triggerSave();
	var group = $(this).attr('data-group');
	var subgroup = $(this).attr('data-subgroup');
	if (confirm("This will save the changes you made so far. \nAre you sure you want to proceed with adding a new element?")) {
		displayNotification("message", "Working...");
		if (validate_form("form_edit_property")) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/properties/process_edit",
				type: "POST",
				data: "add_item=1&group="+group+"&subgroup="+subgroup+"&"+$("#form_edit_property").serialize(),
				success: function(response, textStatus, jqXHR){
					setTimeout(function () {
						$("#middle_wrapper").html(response);
						displayNotification("success", "Changes to the property saved.");
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
	}
});

// remove element
$(".btn_remove_set").click(function(){
	tinyMCE.triggerSave();
	var group = $(this).attr('data-group');
	var subgroup = $(this).attr('data-subgroup');
	var element = $(this).attr('data-element');
	if (confirm("This will save the changes you made so far. \nAre you sure you want to proceed with removing this set?")) {
		displayNotification("message", "Working...");
		if (validate_form("form_edit_property")) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/properties/process_edit",
				type: "POST",
				data: "remove_item=1&group="+group+"&subgroup="+subgroup+"&element="+element+"&"+$("#form_edit_property").serialize(),
				success: function(response, textStatus, jqXHR){
					setTimeout(function () {
						$("#middle_wrapper").html(response);
						displayNotification("success", "Changes to the property saved.");
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
	}
});

// close overlay
$(".g_overlay").click(function(){
	$(".g_overlay").hide();
	$("#asset_wrapper").hide();
	$("#editor_wrapper").hide();
	$("#upload_wrapper").hide();
	$("body").removeClass('h_overflowhidden');
});

$("#asset_wrapper").click(function(e){ e.stopPropagation(); });
$("#editor_wrapper").click(function(e){ e.stopPropagation(); });
$("#upload_wrapper").click(function(e){ e.stopPropagation(); });

// save edit
$("#btn_edit_property").click(function(e){
	if (confirm("Are you sure you want to save changes?")) {
		$(".mceMenu").hide();
		tinyMCE.triggerSave();
		displayNotification("message", "Working...");
		if (validate_form("form_edit_property")) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/properties/process_edit",
				type: "POST",
				data: $("#form_edit_property").serialize(),
				success: function(response, textStatus, jqXHR){
					setTimeout(function () {
						$("#middle_wrapper").html(response);
						displayNotification("success", "Changes to the property saved.");
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown){
					displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
				}
			});
		}
	}
});

// tabs and tab grp to show
$(".property_edit_tabs .item").click(function(){
	var reference = $(this).attr("data-reference");
	
	// set current active marker (for save - then keep current tab open)
	$("#current_active_tab").val(reference);
	
	$(".property_edit_tabs .item").each(function(){
		$(this).removeClass("active");
	});
	$(this).addClass("active");
	
	$(".property_edit_content_grp").each(function(){
		$(this).removeClass("active");
		if ($(this).attr("data-reference") == reference) { $(this).addClass("active"); }
	});
});

// change image asset
$('.upload_indicator').each(function(){
	$(this).click(function(){
		var reference = $(this).attr("data-reference");
		displayNotification("message", "Working...");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/properties/display_assets",
			type: "POST",
			data: "property_id="+$("#property_id").val()+"&reference="+reference,
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#asset_wrapper").html(response);
					$("body").addClass('h_overflowhidden');
					$("#asset_wrapper").show();
					$(".g_overlay").fadeIn();
					hideAllNotifications();
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	});
});

// delete asset entry
$('.remove_value').click(function(e){
	e.stopPropagation();
	if (confirm("Are you sure you want to remove the value of this field?")) {
		var reference = $(this).attr("data-reference");
		$(".g_inputtext[data-reference='"+reference+"']").val("");
		$(".info[data-reference='"+reference+"']").show();
		$(".info[data-reference='"+reference+"']").html('<div class="icon"></div>Field updated. Please save your changes.');
		$(".img_preview[data-reference='"+reference+"'] img.tobe_edited").attr("src", "<?php echo $this->config->item('base_asset_url') . "images/no_image.png"; ?>");
		$(".img_preview[data-reference='"+reference+"']").removeClass('icon');
		$(this).hide();
	}
});

// upload an asset from the edit entry itself
$('.upload').click(function(){
	var reference = $(this).attr('data-reference'); 
	$("#upload_reference").val(reference);
	$("#file_to_upload").val("");
	displayNotification("message", "Working...");
	setTimeout(function () {
		$("#upload_wrapper").show();
		$("body").addClass('h_overflowhidden');
		$(".g_overlay").fadeIn();
		hideAllNotifications();
	}, 500);
});

// detect if upload is finished (from the property item itself)
$("#iframe_location").on('load', function(){
	if ($(this).contents().find('body').html()) {
		var result = $.parseJSON($(this).contents().find('body').html());
		displayNotification("message", "Working");
		if (result.error == 0) {
			var fieldtoedit = $("#upload_reference").val();
			$("#upload_wrapper").fadeOut(250);
			$(".g_overlay").fadeOut(250);
			$("input[data-reference='"+fieldtoedit+"']").val(result.file);
			$(".additional_notes[data-reference='"+fieldtoedit+"']").removeClass("h_displaynone");
			$(".img_preview .img_actions .remove_value[data-reference='"+fieldtoedit+"']").removeClass("h_displaynone");
			$(".info[data-reference='"+fieldtoedit+"']").html('<div class="icon"></div>Field updated. Please save your changes.').fadeIn(200);
	
			// detect loading
			$(".img_preview[data-reference='"+fieldtoedit+"'] img.tobe_edited").attr("src", "<?php echo base_url() . "/_assets/images/loading.gif"; ?>");
			$("#g_preload_property_edit img").attr("src", "<?php echo $this->config->item('base_property_url') . $property_details['folder_name'] . "/assets/"; ?>"+result.file);
			$("#g_preload_property_edit img").bind("load", function(){
				setTimeout(function () {
					$(".img_preview[data-reference='"+fieldtoedit+"'] img.tobe_edited").attr("src", "<?php echo $this->config->item('base_property_url') . $property_details['folder_name'] . "/assets/"; ?>"+result.file);
				}, 1500);
			});
			
			if ($(".img_preview[data-reference='"+fieldtoedit+"']").attr('data-icon')) {
				$(".img_preview[data-reference='"+fieldtoedit+"']").addClass('icon');
			}
			$(".remove_value[data-reference='"+fieldtoedit+"']").show();
			
			displayNotification("success", "File uploaded successfully!");
		} else {
			$(".g_overlay").fadeOut(250);
			displayNotification("error", result.error);
		}
	}
});

// display actions when hovering on an asset
$(".img_preview").hover(function(){
	$(this).children(".img_actions").fadeIn(200);
},function(){
	$(this).children(".img_actions").fadeOut(200);
});

// toggle preview for mobile
$("#btn_preview_app").click(function(){
	if ($(".mobile_preview_wrapper").css('right') == "-631px") {
		$('.mobile_preview_wrapper').animate({ right: '+=647' }, 150);
		$("#btn_preview_app .preview_text").html('Hide Preview');
	} else {
		$('.mobile_preview_wrapper').animate({ right: '-=647' }, 150);
		$("#btn_preview_app .preview_text").html('Preview App');
	}
});

// change preview background
$(".mobile_options a").click(function(){
	var file_name = $(this).attr('data-name');
	$(".mobile_preview").css('background-image', 'url(<?php echo base_url(); ?>_assets/images/preview/bg_'+file_name+'.png)');
	
	$.ajax({
		url: "<?php echo base_url(); ?>admin/properties/mobile_preview",
		type: "POST",
		data: $("#mobile_details").serialize(),
		success: function(response, textStatus, jqXHR){
			setTimeout(function () {
				$(".mobile_preview").html(response);
			}, 500);
		},
		error: function(jqXHR, textStatus, errorThrown){
			displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
		}
	});
});
</script>