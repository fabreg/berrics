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
		<dl>
			<dd>Media Type:</dd>
			<dt><?php echo $types[$m['media_type']]; ?></dt>
			
			<dd>
				Sort Order:
			</dd>
			<dt>
				<?php echo $this->Form->select("sort_order",$sort,$i['display_weight'],array("empty"=>false)); ?>
			</dt>
			<dd>
				Remove File
			</dd>
			<dt>
				<?php echo $this->Html->link("Click Here",array("controller"=>"dailyops","action"=>"remove_media_item",$i['id']),array("rel"=>"remove-link")); ?>
			</dt>
			<?php 
			
				if($m['media_type']=='bcove'):
			
			?>
			<dd>
				Preview Video
			</dd>
			<dt>
				<?php echo $this->Html->link("Click Here",array("controller"=>"media_files","action"=>"preview_video",$m['id']),array("target"=>"_blank")); ?>
			</dt>
			<dd>
				Update Still Image
			</dd>
			<dt>
				<?php echo $this->Html->link("Click Here",array("controller"=>"media_files","action"=>"update_video_still",$m['id']),array("target"=>"_blank")); ?>
			</dt>
			<?php 
			
				endif;
			
			?>
			
			<?php 
			
				if(in_array($m['media_type'],array("pic","piclink"))):
			
			?>
			<dd>
				Preview Image
			</dd>
			<dt>
				<a href='http://img.theberrics.com/images/<?php echo $m['file']; ?>' target='_blank'>Click Here</a>
			</dt>
			<?php 
			
				endif;
			
			?>
		</dl>
		<?php echo $this->Form->input("media_item_id",array("type"=>"hidden","value"=>$i['id'])); ?>
	</div>
	<div style='clear:both;'></div>
	
</div>