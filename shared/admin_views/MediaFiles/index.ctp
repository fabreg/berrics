<?php 

$mediaTypes = MediaFile::mediaFileTypes();

$report_queue = $this->Session->read("MediaFileReportQueue");

if(!is_array($report_queue)) {
	
	$report_queue = array();
	
}

?>

<script>

$(document).ready(function() { 


	$("a[href=#opensearch]").click(function() { 

		$('.search-form').toggle();
		
	});
	$('.search-form').hide();

	$('.img-preview-link').hover(

		function() { 	

			var media_file_id = $(this).attr("media_file_id");
			var img = "<div class='img'><img src='http://img.theberrics.com/i.php?src=/images/"+$(this).attr("media_file")+"&h=450&w=450' /></div>";
			$(".img-preview-wrapper[media_file_id="+media_file_id+"]").html(img);
	
		},
		function() { 

			var media_file_id = $(this).attr("media_file_id");

			$(".img-preview-wrapper[media_file_id="+media_file_id+"]").html('');
		}

	);
	
	
});

function imageHover() {

	
	
}


</script>
<style>
.img-preview-wrapper {

	position:relative;

}

.img-preview-wrapper img {

	position:absolute;
	top:-50px;
	right:-450px;

}
</style>
<div class="mediaFiles index">
	<h2><?php echo __('Media Files');?></h2>
	
	<div>
		<ul class='nav nav-tabs'>
			<li class='dropdown'>
				<a href='#' data-toggle='dropdown'>Actions <b class='caret'></b></a>
				<ul class='dropdown-menu'>
					<li>
						<a href='javascript:uploadVideoFile(); '><i class='icon-plus-sign'></i> Upload Video File</a>
					</li>
				</ul>
			</li>
			<li><a href='#search' data-toggle='tab' rel='no-ajax'>Search Files</a>
		</ul>
		<div class='tab-content'>
			<div class='tab-pane well' id='search'>
				
				<?php 
			
				echo $this->Form->create("MediaFile",array("url"=>array("action"=>"search")));
				echo $this->Form->input("name");
				echo $this->Form->input("media_type",array("options"=>MediaFile::mediaFileTypes(),"empty"=>"* All"));
				echo $this->Form->input("website_id",array("empty"=>"* All"));
				echo $this->Form->input("limelight_not_active",array("type"=>"checkbox"));
				echo $this->Form->end("Search");
				
			?>
			</div>
		</div>
	</div>
	<?php echo $this->Admin->adminPaging(); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th>Thumbnail</th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('media_type');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($mediaFiles as $mediaFile):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>  media_file_id='<?php echo $mediaFile['MediaFile']['id']; ?>'>
		<td style='font-size:9px;'><?php echo $mediaFile['MediaFile']['id']; ?>&nbsp;<a name='<?php echo $mediaFile['MediaFile']['id']; ?>' style='display:hidden;'></a></td>
		<td class='thumb'>
			<?php 
				
				echo $this->Media->adminMediaThumbLink(array(
				
					"MediaFile"=>$mediaFile['MediaFile'],
					"w"=>125,
					
				
				));
				
				switch($mediaFile['MediaFile']['media_type']) {
					
					case "bcove":
						echo "<br />".$this->Admin->link("Preview Video",array("action"=>"preview_video",$mediaFile['MediaFile']['id']),array("target"=>"_blank","rel"=>"no-ajax"));
					break;
					case "img":
						echo "<br /><div class='img-preview-wrapper' media_file_id='".$mediaFile['MediaFile']['id']."'></div><a href='http://img.theberrics.com/images/".$mediaFile['MediaFile']['file']."' target='_blank' rel='no-ajax' media_file_id='".$mediaFile['MediaFile']['id']."' class='img-preview-link' media_file='".$mediaFile['MediaFile']['file']."'>Preview Image</a>";
					break;
					
				}

			?>
		</td>
		<td><?php echo $mediaFile['MediaFile']['modified']; ?>&nbsp;</td>
		<td><?php echo $mediaFile['MediaFile']['name']; ?>&nbsp;</td>
 
		<td><?php echo $mediaTypes[$mediaFile['MediaFile']['media_type']]; ?>&nbsp;
		<?php if($mediaFile['MediaFile']['limelight_mediavault_active']==1): ?>
		<div style='font-weight:bold; color:Red;'>*SECURED</div>
		<?php endif; ?>
		</td>
		<td class="actions">
				<div class='btn-toolbar'>
				<?php if($this->request->is('ajax')): ?>
					<?php echo $this->Admin->link("Attach",array(),array("rel"=>"no-ajax","media_file_id"=>$mediaFile['MediaFile']['id'],"class"=>"attach_media btn btn-success btn-small")); ?>
				<?php else: ?>
						<div class='btn-group'>
							<?php echo $this->Admin->link("<i class='icon-edit icon-white'></i> Edit",array("action"=>"inspect",$mediaFile['MediaFile']['id']),array("class"=>"btn btn-primary btn-small","escape"=>false)); ?>
							<a href='#' class='btn btn-primary btn-small' data-toggle='dropdown'><b class='caret'></b></a>
							<ul class='dropdown-menu pull-right'>
								<li>
									<?php echo $this->Admin->link("<i class='icon-edit'></i> Edit in new window",array("action"=>"inspect",$mediaFile['MediaFile']['id']),array("class"=>"none","escape"=>false,"target"=>"_blank")); ?>
								</li>
								<?php if(in_array($mediaFile['MediaFile']['media_type'],array("bcove","video"))): ?>
								<li>
									<a class='none' href='javascript:uploadVideoFile({"id":"<?php echo $mediaFile['MediaFile']['id']; ?>"});'><l class='icon-edit'></l> Update Video File</a>
								</li>
								<li>
									<a class='none' href='javascript:uploadVideoImage("<?php echo $mediaFile['MediaFile']['id']; ?>");'><l class='icon-edit'></l> Update Video Image</a>
								</li>
								<?php endif; ?>
							</ul>
						</div>	
					
					
					<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $mediaFile['MediaFile']['id']), array("confirm"=>"Are you sure you want to delete this file?")); ?>
				<?php endif; ?>
				</div>
				<?php if ($mediaFile['MediaFile']['media_type'] == "bcove"): ?>
					<a rel='noAjax' href="<?php echo $this->Html->url(array("action"=>"run_report",$mediaFile['MediaFile']['id'])); ?>" class="btn btn-small">Run Report</a>
					<?php 
						if(in_array($mediaFile['MediaFile']['id'],$report_queue)):
					?>
					<a href='/media_files/remove_queue_video_for_report/<?php echo $mediaFile['MediaFile']['id']; ?>/<?php echo base64_encode($this->request->here."#".$mediaFile['MediaFile']['id']); ?>' id='remove-from-queue' media_file_id='<?php echo $mediaFile['MediaFile']['id']; ?>'>Remove From Report Queue</a>
					<?php 
						else:
					?>
					<a href='/media_files/queue_video_for_report/<?php echo $mediaFile['MediaFile']['id']; ?>/<?php echo base64_encode($this->request->here."#".$mediaFile['MediaFile']['id']); ?>' id='add-to-queue' media_file_id='<?php echo $mediaFile['MediaFile']['id']; ?>'>Add To Report Queue</a>
					<?php 
						endif;
					?>
				<?php endif ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
