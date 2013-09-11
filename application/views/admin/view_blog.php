<?php	
	function date_compare($a, $b) {
		if ($a['published'] == $b['published']) { return 0;  }
		return ($a['published'] > $b['published']) ? -1 : 1;	
	} 		
?>
<div id="g_content" class="blogs-wrapper">

	<div id="g_tools">
		<a href="<?php echo base_url(); ?>admin/blogs/blog_list/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/list.png" />Article List</a>
		<a href="<?php echo base_url(); ?>admin/blogs/categories/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/categories.png" />Category List</a>
		<a href="<?php echo base_url(); ?>admin/blogs/comments/<?php echo $property_id; ?>"><img src="<?php echo base_url(); ?>_assets/images/tools/comments.png" />Comments</a>
		<a href="<?php echo base_url(); ?>preview/<?php echo $property_details['template_type_id']; ?>/<?php echo $property_details['folder_name']; ?>" target="_blank">
			<img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/preview.png" />Preview
		</a>		
		<a href="<?php echo base_url(); ?>admin/properties/edit/<?php echo $property_id; ?>"><img class="g_icon" src="<?php echo base_url(); ?>_assets/images/tools/settings.png" />Blog Settings</a>		
		<div class="h_clearboth"></div>
	</div>
	
	<div class="h_clearboth"></div>
	<div class="h_floatleft h_width40percent">
		<div class="h_paddingright15">
			<div class="g_pagelabel">
				<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" /></div>
				<div class="g_pagelabel_text">Summary - <?php echo $property_details['property_title']; ?></div>
			</div>
			<table class="g_table">
				<tr>
					<td class="h_padding20">
						<div class="blog_count"><?php echo $summary['count_article']['num']; ?></div>
						<div class="blog_count_lable"><?php echo $summary['count_article']['label']; ?></div>
					</td>
					<td class="h_padding20">
						<div class="blog_count"><?php echo $summary['count_categories']['num']; ?></div>
						<div class="blog_count_lable"><?php echo $summary['count_categories']['label']; ?></div>					
					</td>
					<td class="h_padding20">
						<div class="blog_count"><?php echo $summary['count_comments']['num']; ?></div>
						<div class="blog_count_lable"><?php echo $summary['count_comments']['label']; ?></div>					
					</td>
				</tr>			
			</table>
		</div>
	</div>
	
	<div class="h_floatleft h_width60percent">
	<div class="h_paddingleft15">
	
		<div class="g_pagelabel">
			<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" /></div>
			<div class="g_pagelabel_text">Recently Added Articles</div>
		</div>

		<?php if( $count_article ) { ?>
			<table class="g_table zebra">
				<tr>
					<th>Title</th>
					<th width="116">Publish Date</th>
				</tr>
				<?php usort($blog_posts, 'date_compare'); ?>
				<?php $ctr = 1 ; ?>				
				<?php foreach ($blog_posts as $blog => $b) { ?>
					<?php if( $ctr <= 5 ) { ?>
					<tr>
						<td><?php echo $b['title']; ?></td>
						<td width="116"><?php echo $b['published']; ?></td>
					</tr>
				<?php } ?>
				<?php $ctr++; ?>
				<?php } ?>
			</table>
		<?php } else { ?>
			<table class="g_table">
				<tr><td class="h_padding20"><div class="g_nodata"><div class="icon"></div>No data to display</div></td></tr>
			</table>
		<?php } ?>
		
	</div>
	</div>
	
	<div class="h_clearboth"></div>
	
	<div class="g_pagelabel">
		<div class="g_pagelabel_icon"><img src="<?php echo base_url(); ?>_assets/images/tools/reports.png" /></div>
		<div class="g_pagelabel_text">Recent Comments</div>
	</div>

	<table class="g_table zebra">
		<tr>
			<th style="min-width: 120px;">Author</th>
			<th style="min-width: 120px;">Comment</th>
			<th style="min-width: 120px;">In Response To</th>
		</tr>
	
		<?php krsort($blog_comments); ?>
		<?php $ctr = 1 ; ?>		
		<?php foreach ($blog_comments as $comment => $c) { ?>
			
			<?php if( $ctr <= 5 ) { ?>
				<tr>
					<td><strong><?php echo $c['posted_by']; ?></strong>
						<p class="small"><?php echo $c['email']; ?></p>
					</td>
					<td>
						<p class="small">Posted on 
							<em><strong><?php echo date( "Y/m/d \a\\t\ H:i A",  strtotime( $c['date_comment'] ) );?></strong></em>
						</p>
						<?php echo $c['comment_content']; ?>
					</td>
					<td><?php echo $post_title[$c['p_id']];?> </td>
				</tr>	
			<?php } ?>			

		<?php $ctr++; ?>
		<?php } ?>
		
	</table>	
	
</div>

<script type="text/javascript" language="javascript">
$(function(){
	zebraTable();
});
</script>