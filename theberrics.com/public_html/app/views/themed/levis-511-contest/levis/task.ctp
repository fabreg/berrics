<style>

#LevisOverlay .wrapper {
	
	width:650px;
	margin:auto;

}

</style>
<div id='levis-task'>
<div>
	UPLOAD TEST STUFF
</div>
<div>
	<?php if(isset($instagram_images)): ?>
	<div>
		<?php foreach($instagram_images->data as $img): ?>
		<div style='float:left' class='instagram-thumb'>
			<img src='<?php echo $img->images->thumbnail->url; ?>' border='0' />
		</div>
		<?php endforeach; ?>
		<div style='clear:both;'></div>
	</div>
	<?php else: ?>
	<?php 
		echo $this->Html->link("Instagram Connect",array(
					"plugin"=>"identity",
					"controller"=>"login",
					"action"=>"send_to_instagram",
					base64_encode($this->here)
				),array("rel"=>"no-ajax"));
	?>
	<?php endif; ?>
</div>
</div>