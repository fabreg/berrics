<div id='identity-reset-password'>
	
	<div>
		<?php echo $this->Session->flash(); ?>
		<p>Enter your email address below to reset your password</p>
	</div>
	<div>
		<?php 
			
			echo $this->Form->create("User",array("url"=>$this->here));
			echo $this->Form->input("email");
			echo $this->Form->end("Reset Password");
		?>
	</div>
</div>