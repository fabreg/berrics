<div id='add-canteen-order-note-form'>
	<?php 
		echo $this->Form->create("CanteenOrderNote",array("url"=>$this->here));
	?>
	<?php 
		echo $this->Form->input("message");
	?>
	<?php 	
		echo $this->Form->end();
	?>
</div>