<script>
var xid = "<?php echo $this->Session->id(); ?>";

</script>
<div class='form index'>
	<div style='text-align:center;'><a style='color:black;' href='javascript:VideoFileUpload.closeUpload();'>CLOSE [X]</a></div>
	<fieldset>
		<legend>Video Upload</legend>
		<div>
			<label>File ID:</label>
			<div> <?php echo $this->data['MediaFile']['id']; ?></div>
		</div>
		<div style='text-align:center; padding:20px;'>
			<span id='video-upload-button' style='border:1px solid #000;'></span>
		</div>
		<div id='progress-div'>
		
		</div>
	</fieldset>
	<div style='text-align:center;'><a style='color:black;' href='javascript:VideoFileUpload.closeUpload();'>CLOSE [X]</a></div>
</div>