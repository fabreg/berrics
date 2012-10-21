<script>
var media_file_id = '<?php echo $view_id; ?>';
var view_file = '<?php echo $view_item['MediaFile']['file']; ?>';
</script>
<?php 
$this->Html->script(array('image_gallery/view'),array('inline'=>false));
//css

$uri = env('REQUEST_URI');

?>

<div id='gallery-view'>
<?php 

	echo $this->element("image_gallery/header");

?>
<?php 
	$img_count = 1;
	foreach($items as $index=>$row):
			if($index == $view_row) {
				
				echo "<a name='viewing'></a>";
				echo $this->element("image_gallery/image_view",array("m"=>$view_item));
				
			}
?>
	<div class='item-row'>
		
		<?php 
			
			foreach($row as $item):
			
		?>
			<div class='item img-<?php echo $item['MediaFile']['id']; ?>' index='<?php echo $img_count; ?>'>
				<?php 
					$img_count++;
					$thumb =  $this->Media->mediaThumb(array(
					
						"MediaFile"=>$item['MediaFile'],
						"w"=>150,
						"h"=>100,
						"zc"=>1
					
					));
					
					$link = $this->Html->url(array("controller"=>$this->theme,"action"=>$gallery['Dailyop']['uri'],"view"=>$item['MediaFile']['id']));
					
					echo $this->Html->link($thumb,$link,array("escape"=>false));
					
				?>
			</div>
		<?php 
		
			endforeach;
		
		?>
		<div style='clear:both;'></div>
	</div>
<?php 

	endforeach;

?>
<?php 

echo $this->element("image_gallery/footer");

?>

</div>
<?php

pr($this->request->params);

?>
