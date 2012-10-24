<?php


?>
<div class='form'>
	<fieldset>
		<legend>Choose Company:</legend>
	<?php 
	
		echo $this->Form->create("DfpReport",array("url"=>$this->request->here));
		echo $this->Form->input("Company",array("options"=>$company_list));
		echo $this->Form->end("Next");
	?>
	</fieldset>
</div>