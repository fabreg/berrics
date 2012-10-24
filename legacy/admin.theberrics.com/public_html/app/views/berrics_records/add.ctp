<div class='form'>
<fieldset>
	<legend>Add New Berrics Record</legend>
	<?php 
	
		echo $this->Form->create("BerricsRecord");
		echo $this->Form->input("record_name");
		echo $this->Form->end("Add Record")
	
	?>
</fieldset>	

</div>