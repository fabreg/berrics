<div class='image-view'>
<div class='arrow arrow-left'>asdfasdfasdfasdfasdf</div>
<div class='arrow arrow-right'></div>
<?php

//print_r($m['MediaFile']['Tag']);
echo $this->Media->mediaThumb(array(

	"MediaFile"=>$m['MediaFile'],
	"w"=>700

));

?>
</div>
<div class='next-prev'>
	<?php 
	
		if($next_item):
	
	?>
	<div class='next'>
		<div><a href='/<?php echo $this->params['section']; ?>/<?php echo $this->params['uri']; ?>/view:<?php echo $next_item['MediaFile']['id']; ?>'>NEXT</a></div>
	</div>
	<?php 
	
		endif;
	
	?>
	<?php 
	
		if($prev_item):
	
	?>
	<div class='prev'>
		<div><a href='/<?php echo $this->params['section']; ?>/<?php echo $this->params['uri']; ?>/view:<?php echo $prev_item['MediaFile']['id']; ?>'>PREVIOUS</a></div>
	</div>
	<?php 
	
		endif;
	
	?>
</div>