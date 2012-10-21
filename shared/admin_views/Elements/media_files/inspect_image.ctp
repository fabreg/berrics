<script>

function handleImageUpload() {

	$('form').submit();
	
}

</script>
<fieldset>
		<legend>Image File</legend>
		<?php if(!empty($this->data['MediaFile']['file'])): ?>
		<div>
			<label>Current File</label>
			<div>
				<?php 
				
					echo $this->Media->mediaThumb(array(
						"MediaFile"=>$this->data['MediaFile'],
						"w"=>150,
						"h"=>150
					));
				
				?>
			</div>
			<div>
				<label>Direct Link</label>
				<div>
					<?php 
						$img_link = "http://img.theberrics.com/images/".$this->data['MediaFile']['file'];
					?>
					<a href='<?php echo $img_link; ?>' target='_blank'><?php echo $img_link; ?></a>
				</div>
			</div>
		</div>
		<?php else: ?>
		<div>
			<p>Image not uploaded</p>
		</div>
		<?php endif; ?>
			<div>
		<span class='span-button'>
			<a href='javascript:ImageFileUpload.openUpload("<?php echo $this->data['MediaFile']['id']; ?>","handleImageUpload");'>Upload New Image File</a>
		</span>
	</div>
</fieldset>
