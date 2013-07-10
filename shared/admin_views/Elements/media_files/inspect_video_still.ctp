<script>

function handleStillUpload() {
	VideoStillUpload.closeUpload();

	//submit the form
	$("form").submit();
}


</script>



<fieldset>
	<legend>Video Image</legend>
	<div class='well'>
		<h4>PRIMARY IMAGE</h4>
		<?php if(!empty($this->data['MediaFile']['file_video_still'])): ?>
			<div style='padding-bottom:5px;'>
				
				<div>
				<?php echo $this->Media->mediaThumb(array(
								"MediaFile"=>$this->data['MediaFile'],
								"w"=>150,
								"h"=>150
							)); ?>
				</div>
			</div>
			<div style='padding-bottom:5px;'>
				<div>
					<?php 
						$img_link = "http://img01.theberrics.com/video/stills/".$this->data['MediaFile']['file_video_still'];
					?>
					<a href='<?php echo $img_link; ?>' target='_blank'><?php echo $img_link; ?></a>
				</div>
			</div>
		<?php else: ?>
			<div style='color:Red; font-weight:bold;'>* IMAGE NOT UPLOADED*</div>
		<?php endif; ?>
		<div>
			<button class='btn btn-warning' type='button' onclick='uploadVideoImage("<?php echo $this->request->data['MediaFile']['id']; ?>");'>Update Video Image</button>
		</div>
	</div>
	<div class="well">
		<h4>SLIM IMAGE</h4>
		<?php if(!empty($this->data['MediaFile']['file_video_still_slim'])): ?>
			<div style='padding-bottom:5px;'>
				
				<div>
				<?php echo $this->Media->mediaThumb(array(
								"MediaFile"=>$this->data['MediaFile'],
								"w"=>150,
								"h"=>150,
								"type"=>"slim"
							)); ?>
				</div>
			</div>
			<div style='padding-bottom:5px;'>
				<div>
					<?php 
						$img_link = "http://img01.theberrics.com/video/stills-slim/".$this->data['MediaFile']['file_video_still_slim'];
					?>
					<a href='<?php echo $img_link; ?>' target='_blank'><?php echo $img_link; ?></a>
				</div>
			</div>
		<?php else: ?>
			<div style='color:Red; font-weight:bold;'>* IMAGE NOT UPLOADED*</div>
		<?php endif; ?>
	</div>
	<div class="well">
		<h4>LARGE IMAGE</h4>
		<?php if(!empty($this->data['MediaFile']['file_video_still_large'])): ?>
			<div style='padding-bottom:5px;'>
				
				<div>
				<?php echo $this->Media->mediaThumb(array(
								"MediaFile"=>$this->data['MediaFile'],
								"w"=>150,
								"h"=>150,
								"type"=>"large"
							)); ?>
				</div>
			</div>
			<div style='padding-bottom:5px;'>
				<div>
					<?php 
						$img_link = "http://img01.theberrics.com/video/stills-large/".$this->data['MediaFile']['file_video_still_large'];
					?>
					<a href='<?php echo $img_link; ?>' target='_blank'><?php echo $img_link; ?></a>
				</div>
			</div>
		<?php else: ?>
			<div style='color:Red; font-weight:bold;'>* IMAGE NOT UPLOADED*</div>
		<?php endif; ?>
	</div>
</fieldset>