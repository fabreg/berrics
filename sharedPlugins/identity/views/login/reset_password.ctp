<div id='identity-reset-password'>
	
	<div>
		<?php echo $this->Session->flash(); ?>
		<p>Enter your email address below to reset your password. You will receive an email within a few minutes with further instructions</p>
	</div>
	<div>
		<?php 
			
			echo $this->Form->create("User",array("url"=>$this->here));
			echo $this->Form->input("email");
			echo $this->Form->end("Reset Password");
		?>
	</div>
</div>