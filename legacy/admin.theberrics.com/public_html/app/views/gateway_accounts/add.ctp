<div class='form'>
	<h2>Add New Gateway Account</h2>
	<fieldset>
		<legend>Account Info</legend>
		<?php 
	
			echo $this->Form->create("GatewayAccount",array("url"=>$this->here));
			echo $this->Form->input("name");
			echo $this->Form->input("provider",array("options"=>GatewayAccount::providers()));
			echo $this->Form->end("Add New Account");
		
		?>
	</fieldset>
</div>