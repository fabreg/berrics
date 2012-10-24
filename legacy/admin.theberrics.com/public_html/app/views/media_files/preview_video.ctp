<?php


$this->Html->script("jquery.swfobject",array("inline"=>false));


?>

<script>
$(document).ready(function() { 


	$("#vid-container").flash({
		swf:"http://dev.theberrics.com/swf/BerricsPlayer.swf?time="+Math.random(),
		flashVars:{
			'media_file_id':'<?php echo $m['id']; ?>',
			'pre_roll':0,
			'post_roll':0,
			videoAspectRatio:1
		},
		height:400,
		width:700,
		wmode:"opaque",
		bgcolor:"#000000",
		allowfullscreen:"true"
	
	});

	
});
</script>

<div id="vid-container">Loading the player ...</div>
