<?php 

$m = $file['MediaFile'];
$i = $file['DailyopMediaItem'];
$types = MediaFile::mediaFileTypes();
$sort = array();

for($a = 1; $a<=100; $a++) {
	
	
	$sort[$a]=$a;
	
	
}

?>
<div class='media-item'>
	<div class='left'>
	<?php
	
		echo $this->Media->mediaThumb(array(
		
			"MediaFile"=>$m,
			"w"=>100,
			"h"=>100,
			"zc"=>1
		
		));
	
	?>
	</div>
	<div class='right'>
		<table cellspacing='0'>
			<tr>
				<td>Media Type:</td>
				<td><?php echo $types[$m['media_type']]; ?></td>
			</tr>
			<tr>
				<td>Sort Order:</td>
				<td><?php echo $this->Form->select("sort_order",$sort,$i['display_weight'],array("empty"=>false)); ?></td>
			</tr>
			<tr>
				<td>Remove File:</td>
				<td>
					<?php echo $this->Html->link("Click Here",array("controller"=>"dailyops","action"=>"remove_media_item",$i['id']),array("rel"=>"remove-link")); ?>
				</td>
			</tr>
			<?php if($m['media_type'] == "bcove"): ?>
				<?php if(!empty($m['limelight_file'])): ?>
			<tr>
				<td>Preview Video</td>
				<td>
					<?php echo $this->Html->link("Click Here",array("controller"=>"media_files","action"=>"preview_video",$m['id']),array("target"=>"_blank")); ?>
				</td>
			</tr>
				<?php  endif; ?>
			<tr>
				<td>
					Update Still Image
				</td>
				<td>
					<?php echo $this->Html->link("Click Here",array("controller"=>"media_files","action"=>"update_video_still",$m['id']),array("target"=>"_blank")); ?>
				</td>
			</tr>
			<tr>
				<td>Update Video File</td>
				<td>
					<a href='javascript:VideoFileUpload.openUpload("<?php echo $m['id']; ?>","handleVideoUpload");'>Click Here</a>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		
		<?php echo $this->Form->input("media_item_id",array("type"=>"hidden","value"=>$i['id'])); ?>
	</div>
	<div style='clear:both;'></div>
	
</div>