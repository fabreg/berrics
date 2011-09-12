<?php 
	$u = $this->Session->read('Auth.User');
	echo $this->Html->script(array("bangyoself/entry-form","swfupload/swfupload.js","jquery.swfupload.js"),array("inline"=>false));

?>
<script>
var sid='<?php echo $this->Session->id(); ?>';
</script>
<div class='entry-form'>
	<div class='entry-form-info'>
		<ul  class='first-name'>
			<li><?php echo $u['first_name']." ".$u['last_name']; ?></li>
		</ul>
		<ul class='last-name'>
			<li ><?php echo $u['email']; ?></li>
		</ul>
	</div>
	<div id='video-upload' style='text-align:center;'>
		<span id='video-upload-button'>
			
		</span>
	</div>
	<div id='video-upload-progress'></div>
	<div style='clear:both;'></div>
</div>