<?php 

$m = $item['MediaFile'];
$i = $item['ArticleMediaItem'];
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
				<?php echo $this->Admin->link("Click Here",array("controller"=>"article_manager","action"=>"remove_media_item",$i['id']),array("rel"=>"remove-link")); ?>
			</dt>
			
		</dl>
		<?php echo $this->Form->input("media_item_id",array("type"=>"hidden","value"=>$i['id'])); ?>
	</div>
	<div style='clear:both;'></div>
	
</div>