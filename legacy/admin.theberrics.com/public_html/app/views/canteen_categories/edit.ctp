<?php

	

?>
<div class='form'>
	<fieldset>
		<legend>Edit Category</legend>
			<?php 
	
		echo $this->Form->create("CanteenCategory",array("url"=>$this->here));
		echo $this->Form->input("id");
		echo $this->Form->input("name");
		echo $this->Form->input("uri");
		echo $this->Form->input("active");
		echo $this->Form->input("browsable");
		echo $this->Form->end("Edit");
	
	?>
	</fieldset>

</div>