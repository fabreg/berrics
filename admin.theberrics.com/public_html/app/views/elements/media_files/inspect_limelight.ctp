<?php

	App::import("Vendor","LLFTP",array("file"=>"LLFTP.php"));

	$ll = new LLFTP();
	
	

	
?>	
<fieldset>
	<legend>Limelight CDN</legend>
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
</fieldset>


<?php
	//print_r($this->data);
	
?>