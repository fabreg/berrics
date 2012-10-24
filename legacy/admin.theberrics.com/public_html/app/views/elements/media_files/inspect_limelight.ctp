<script>

function handleUpload() {

	VideoFileUpload.closeUpload();

	//submit the form
	$("form").submit();
	
}

</script>
<fieldset>
	<legend>Video File</legend>
	<p></p>
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
		<span class='span-button'>
			<a href='javascript:VideoFileUpload.openUpload("<?php echo $this->data['MediaFile']['id']; ?>","handleUpload");'>Upload New Video File</a>
		</span>
	</div>
</fieldset>


<?php
	//print_r($this->data);
?>