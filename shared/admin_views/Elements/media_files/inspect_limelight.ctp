<script>

function handleUpload() {

	VideoFileUpload.closeUpload();

	//submit the form
	$("form").submit();
	
}

</script>
<fieldset>
	<legend>Video File</legend>
	<div class='well'>
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
</fieldset>


<?php
	//print_r($this->data);
?>