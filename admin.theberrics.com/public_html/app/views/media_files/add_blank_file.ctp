<div class='form'>
	<?php echo $this->Form->create("MediaFile",array()); ?>
	<fieldset>
		<legend>Add Blank Media File</legend>
		<?php 

			echo $this->Form->input("name");
			
			if(isset($this->params['callback'])) {
				
				echo $this->Form->input("callback",array("value"=>$this->params['callback']));
				
			}
			
			echo $this->Form->input("media_type",array("options"=>MediaFile::mediaFileTypes()));
			
			echo $this->Form->submit("Add File");
		
		?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>