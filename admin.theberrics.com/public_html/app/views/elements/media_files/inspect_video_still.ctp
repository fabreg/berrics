<script>

function handleStillUpload() {

	$('form').submit();
	
}


</script>
<fieldset>
	<legend>Video Still</legend>
	<?php if(!empty($this->data['MediaFile']['file_video_still'])): ?>
		
	<?php else: ?>
		<div style='color:Red; font-weight:bold;'>*VIDEO STILL NOT UPLOADED*</div>
	<?php endif; ?>
	<div>
		<span class='span-button'>
			<a href='javascript:VideoStillUpload.openUpload("<?php echo $this->data['MediaFile']['id']; ?>","handleStillUpload");'>Upload New Still Image</a>
		</span>
	</div>
</fieldset>