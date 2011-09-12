<div id='form'>
<?php

	echo $this->element("profile");


?>
<script>
var sid = '<?php echo $this->Session->id(); ?>';
</script>
<?php 

	if(!$check):

?>
<div id='video-upload' style='text-align:center;'>
	<span id='video-upload-button'>
	
	</span>
</div>
<div id='video-upload-progress'></div>
<?php 
	
	else:

?>
<div id='video-upload-progress'>Your video has been entered successfully. <br />Check back often for updates.</div>	
<?php 

	endif;

?>
</div>