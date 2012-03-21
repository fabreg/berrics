<div class='form'>
	<fieldset>
		<legend>Add New Entry</legend>
		<?php 
		
			echo $this->Form->create("SlsEntry",array("url"=>$this->here));
			echo $this->Form->input("name");
			echo $this->Form->end("Add Entry");
		
		?>
	</fieldset>
</div>