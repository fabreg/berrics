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
	<h2><?php __('Media Files');?></h2>
	
	<div class='form'>
	
		<fieldset>
			<legend><a href='#opensearch' rel='no-ajax'>Search Media</a></legend>
			<div class='search-form'>
			<?php 
			
				echo $this->Form->create("MediaFile",array("url"=>array("action"=>"search")));
				echo $this->Form->input("name");
				echo $this->Form->input("media_type",array("options"=>MediaFile::mediaFileTypes(),"empty"=>"* All"));
				echo $this->Form->input("website_id",array("empty"=>"* All"));
				echo $this->Form->input("limelight_not_active",array("type"=>"checkbox"));
				echo $this->Form->end("Search");
				
			?>
			</div>
		</fieldset>
	
	</div>
	
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th>Thumbnail</th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('media_type');?></th>
			<th class="actions"><?php __('Actions');?></th>
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
						echo "<br />".$this->Html->link("Preview Video",array("action"=>"preview_video",$mediaFile['MediaFile']['id']),array("target"=>"_blank","rel"=>"no-ajax"));
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
			<?php if($this->params['isAjax']): ?>
				<?php echo $this->Html->link("Attach",array(),array("rel"=>"no-ajax","media_file_id"=>$mediaFile['MediaFile']['id'],"class"=>"attach_media")); ?>
			<?php else: ?>
				<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $mediaFile['MediaFile']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $mediaFile['MediaFile']['id'],base64_encode($this->here))); ?>
				<?php
				
					switch($mediaFile['MediaFile']['media_type']) {
						
						case "bcove":
						case "video":
							echo $this->Html->link("Update Video Still",array("controller"=>"media_files","action"=>"update_video_still",$mediaFile['MediaFile']['id'],base64_encode($this->here."#".$mediaFile['MediaFile']['id'])));
							echo $this->Html->link("Update Limelight Video",array("controller"=>"media_files","action"=>"update_limelight_video",$mediaFile['MediaFile']['id'],base64_encode($this->here."#".$mediaFile['MediaFile']['id'])));
						break;	
						
					}
				
				?>
				
				<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $mediaFile['MediaFile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediaFile['MediaFile']['id'])); ?>
			<?php endif; ?>
			<a href='/traffic_reports/media_file_details/media_file_id:<?php echo $mediaFile['MediaFile']['id']; ?>/date_start:2011-06-20/date_end:<?php echo date("Y-m-d"); ?>'>Traffic Report</a> <br />
			<?php 
				if(in_array($mediaFile['MediaFile']['id'],$report_queue)):
			?>
			<a href='/media_files/remove_queue_video_for_report/<?php echo $mediaFile['MediaFile']['id']; ?>/<?php echo base64_encode($this->here."#".$mediaFile['MediaFile']['id']); ?>' id='remove-from-queue' media_file_id='<?php echo $mediaFile['MediaFile']['id']; ?>'>Remove From Report Queue</a>
			<?php 
				else:
			?>
			<a href='/media_files/queue_video_for_report/<?php echo $mediaFile['MediaFile']['id']; ?>/<?php echo base64_encode($this->here."#".$mediaFile['MediaFile']['id']); ?>' id='add-to-queue' media_file_id='<?php echo $mediaFile['MediaFile']['id']; ?>'>Add To Report Queue</a>
			<?php 
				endif;
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
