<div id="g_content">

	<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?>
		<div id="g_tools">		
			<a href="<?php echo base_url(); ?>admin/templates/add"><img src="<?php echo base_url(); ?>_assets/images/tools/add.png" />Add Template</a>
			<div class="h_clearboth"></div>
		</div>
	<?php } else { ?>
		<div class="g_spacer"></div>
	<?php } ?>
	<div class="h_clearboth"></div>
	
	<?php echo $filter; ?>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/templates.png" /></div>
		<div class="g_pagelabel_text">Templates</div>
		<?php echo $pagination; ?>
	</div>
	
	<?php if ($templates) { ?>
	
		<table class="g_table">
		
			<tr><td id="template_item_wrapper">
				
				<?php foreach ($templates as $template => $t) { ?>
					<div class="template_item_wrapper">
					<div class="template_item">
						<div class="template_label">
							<?php if ($t['template_type_id'] == 4) { ?>
								<div class="template_icon"><img src="<?php echo base_url(); ?>_assets/images/template_types/6.png" /></div>
							<?php } ?>
							<div class="template_icon"><img src="<?php echo base_url(); ?>_assets/images/template_types/<?php echo $t['template_type_id']?>.png" /></div>
							<?php if ($t['responsive']) { ?>
								<div class="template_icon"><img src="<?php echo base_url(); ?>_assets/images/template_types/html5.png" /></div>
							<?php } ?>
							<?php echo $t['title']; ?>
							<div class="template_code"><?php echo $t['template_id_code']; ?></div>
						</div>
						<div class="screenshot">
							<img src="<?php echo $t['screenshot_path']; ?>" />
							<div class="template_description"><table><tr><td valign="center"><?php echo $t['description']; ?></td></tr></table></div>
						</div>
						<div class="details">
							<div class="h_clearboth"></div>
							<?php if ($sess_user['user_type'] == ROLE_SUPER_ADMIN) { ?>
							<div class="actions">
								<a 	href="<?php echo base_url(); ?>admin/templates/edit/<?php echo $t['template_id']; ?>">Edit</a> &nbsp;
								<a 	href="javascript: void(0);"
									class="btn_delete_template"
									data-template-id="<?php echo $t['template_id']; ?>" 
									data-template-folder="<?php echo $t['folder']; ?>"
									data-current-page="<?php echo $current_page; ?>" >
									Delete
								</a>
								<div class="h_clearboth"></div>
							</div>
							<?php } ?>
							<div class="template_type"><?php echo $t['template_type_title']; ?></div>
							<div class="create">
								<form action="<?php echo base_url(); ?>admin/properties/add" method="POST">
									<input type="hidden" name="template_id" value="<?php echo $t['template_id']; ?>" />
									<input type="submit" class="g_inputbutton h_margin0 h_floatright" value="Use template" />
								</form>
								<!--
								<?php if ($t['template_type_id'] != 4) { ?>
								<input 	type="button" class="g_inputbutton h_margin0 h_marginright10" 
										onclick="window.open('<?php echo base_url(); ?>preview/t<?php echo $t['template_type_id']; ?>/<?php echo $t['folder']; ?>');" value="Preview" />
								<?php } ?>
								-->
								<div class="h_clearboth"></div>
							</div>
						</div>
					</div>
					</div>
				<?php } ?>
				
			</td></tr>
			
		</table>
		
	<?php } else { ?>
			
		<table class="g_table">
		<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
		</table>
		
	<?php } ?>
	
	<div class="g_pagination_wrapper"><?php echo $pagination; ?></div>
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
	checkSidebarStatus();
});

// hover in description
$(".screenshot").hover(
	function(){ $(this).children('.template_description').fadeIn(250); },
	function(){ $(this).children('.template_description').fadeOut(250); }
);

$(".btn_delete_template").click(function(){
	var template_id = $(this).attr('data-template-id');
	var folder_name = $(this).attr('data-template-folder');
	var current_page = $(this).attr('data-current-page');
	
	if (confirm("Are you sure you want to delete this template? \nRemember that it will delete the files for the template as well.")) {
		displayNotification("message", "Working...")
		$.ajax({
			url: "<?php echo base_url(); ?>admin/templates/process_delete",
			type: "POST",
			data: "template_id="+template_id+"&folder_name="+folder_name+"&current_page="+current_page+"&"+$("#form_pagination").serialize(),
			success: function(response, textStatus, jqXHR){
				setTimeout(function () {
					$("#middle_wrapper").html(response);
					displayNotification("success", "Template successfully deleted.");
				}, 500);
			},
			error: function(jqXHR, textStatus, errorThrown){
				displayNotification("error", "Oops, something went wrong. Your action may or may not have been completed.");
			}
		});
	}
});
</script>