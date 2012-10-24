<div class='form'>
	<h2>Edit Gateway Account</h2>
	<?php 
		echo $this->Form->create("GatewayAccount",array("url"=>$this->here));
	?>
	<fieldset>
		<legend>Account Info</legend>
		<?php 
			echo $this->Form->input("id");
			echo $this->Form->input("active");
			echo $this->Form->input("name");
			echo $this->Form->input("provider",array("options"=>GatewayAccount::providers()));
			echo $this->Form->input("currency_id");
		?>
	</fieldset>
	<fieldset>
		<legend>API info</legend>
		<?php 
		
			echo $this->Form->input("api_op1");
			echo $this->Form->input("api_op2");
			echo $this->Form->input("api_op3");
			echo $this->Form->input("api_op4");
		
		?>
	</fieldset>
	<?php 
		echo $this->Form->end("Update Account");
	?>
</div>