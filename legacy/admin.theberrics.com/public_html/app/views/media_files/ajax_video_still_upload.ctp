<script>
var xid = "<?php echo $this->Session->id(); ?>";


</script>
<div class='form'>
	<div style='text-align:center;'><a style='color:black;' href='javascript:VideoStillUpload.closeUpload();'>CLOSE [X]</a></div>

<fieldset>
	<legend>Video Still Upload</legend>
	<div>
		<p>Following image formats are ok: jpeg,jpg,gif,png</p>
	</div>
	<div style='text-align:center; padding:20px;'>
			<span id='video-upload-button' style='border:1px solid #000;'></span>
		</div>
		<div id='progress-div' style='padding:15px; text-align:center;'>
		
		</div>
</fieldset>
	<div style='text-align:center;'><a style='color:black;' href='javascript:VideoStillUpload.closeUpload();'>CLOSE [X]</a></div>

</div>