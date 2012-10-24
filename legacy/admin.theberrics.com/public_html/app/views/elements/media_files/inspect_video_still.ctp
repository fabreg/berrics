<script>

function handleStillUpload() {
	VideoStillUpload.closeUpload();

	//submit the form
	$("form").submit();
}


</script>
<fieldset>
	<legend>Video Still</legend>
	<?php if(!empty($this->data['MediaFile']['file_video_still'])): ?>
		<div>
			<label>Video Still</label>
			<div>
			<?php echo $this->Media->mediaThumb(array(
							"MediaFile"=>$this->data['MediaFile'],
							"w"=>150,
							"h"=>150
						)); ?>
			</div>
		</div>
		<div>
			<label>Direct Link</label>
			<div>
				<?php 
					$img_link = "http://img.theberrics.com/video/stills/".$this->data['MediaFile']['file_video_still'];
				?>
				<a href='<?php echo $img_link; ?>' target='_blank'><?php echo $img_link; ?></a>
			</div>
		</div>
	<?php else: ?>
		<div style='color:Red; font-weight:bold;'>*VIDEO STILL NOT UPLOADED*</div>
	<?php endif; ?>
	<div>
		<span class='span-button'>
			<a href='javascript:VideoStillUpload.openUpload("<?php echo $this->data['MediaFile']['id']; ?>","handleStillUpload");'>Upload New Still Image</a>
		</span>
	</div>
</fieldset>