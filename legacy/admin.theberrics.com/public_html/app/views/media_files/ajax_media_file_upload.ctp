<script>
var xid = "<?php echo $this->Session->id(); ?>";


</script>
<div class='form index'>
	<div style='text-align:center;'><a style='color:black;' href='javascript:VideoFileUpload.closeUpload();'>CLOSE [X]</a></div>
	<fieldset>
		<legend>Limelight Video Upload</legend>
		<div>
			Media File ID: <?php echo $this->data['MediaFile']['id']; ?>
		</div>
		<div>
			<p>Select a file by clicking the button below. Video files must be in .h264 format with an MP4 extension.</p>
			<p><strong>WARNING:</strong> This will overwrite any previous file associated with this media entry. If you wish to retain the previous file, close this window and download it using the direct link to limelight.</p>
			<p><a href='/media_files/inspect/<?php echo $this->data['MediaFile']['id']; ?>' style='color:black;'>Media Entry</a></p>
		</div>
		<div style='text-align:center; padding:20px;'>
			<span id='video-upload-button' style='border:1px solid #000;'></span>
		</div>
		<div id='progress-div' style='padding:15px; text-align:center;'>
		
		</div>
	</fieldset>
	<div style='text-align:center;'><a style='color:black;' href='javascript:VideoFileUpload.closeUpload();'>CLOSE [X]</a></div>
</div>