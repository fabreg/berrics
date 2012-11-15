<script>

function handleUpload() {

	VideoFileUpload.closeUpload();

	//submit the form
	$("form").submit();
	
}

</script>
<fieldset>
	<legend>Video File(s)</legend>
	<div class='well'>
		<h4>MP4 ( PRIMARY VIDEO )</h4>
		<?php 
		
			echo $this->Form->input("MediaFile.limelight_file",array("disabled"=>true));
			
		?>
		<div>
			<label>Direct URL</label>
			<?php 
				$ll_url = "http://berrics.vo.llnwd.net/o45/".$this->data['MediaFile']['limelight_file'];
			?>
			<a href='<?php echo $ll_url; ?>' target='_blank'><?php echo $ll_url; ?></a>
		</div>
		<div>
			
			<a class='btn btn-warning' href='javascript:uploadVideoFile({id:"<?php echo $this->request->data['MediaFile']['id']; ?>"});'>Update Video File</a>
		</div>
	</div>
	<div class="well">
		<h4>OGV (FireFox HTML5)</h4>
	</div>
	<div class="well">
		<h4>MP4 MOBILE</h4>
	</div>
	<div class="well">
		<h4>MP4 MOBILE W/ADVERTISING</h4>
	</div>
</fieldset>


<?php
	//print_r($this->data);
?>