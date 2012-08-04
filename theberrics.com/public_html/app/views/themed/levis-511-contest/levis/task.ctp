<script type='text/javascript'>
$(document).ready(function() { 



	
});
</script>
<style>

#LevisOverlay .wrapper {
	
	width:650px;
	margin:auto;

}

#levis-task {

	background-color:#333;
	padding:5px;

}
.instagram-thumb {

	float:left;
	margin:5px;

}

</style>
<div id='levis-task'>
<div class='task-heading'>
	<strong> TASK: </strong> <?php echo $task['MediahuntTask']['name']; ?>
</div>
<div>
	STANDARD UPLOADING STUFF GOES HERE
</div>
<div>
	<?php if(isset($instagram_images)): ?>
	<div class='instagram-heading'>Instagram: <strong>@<?php echo $this->Session->read("Auth.User.instagram_handle"); ?></strong></div>
	<div class='instagram-thumbs'>
		<?php foreach($instagram_images->data as $img): ?>
		<div style='float:left' class='instagram-thumb'>
			<img src='<?php echo $img->images->thumbnail->url; ?>' border='0' height='75' width='75' />
		</div>
		<?php endforeach; ?>
		<div style='clear:both;'></div>
		<?php //print_r($instagram_images); ?>
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