<style>

#BerricsLogin .wrapper {

	width:650px;

}

</style>
<div id='identity-reset-password' class='identity-container'>
	<h1>RESET YO' PASSWORD</h1>
	<div style=''>
		<?php echo $this->Session->flash(); ?>
		<p style='text-align:center;'>Enter your email address below to reset your password</p>
	</div>
	<div>
		<?php 
			
			echo $this->Form->create("User",array("url"=>$this->here));
			echo $this->Form->input("email",array("label"=>false));
			echo $this->Form->end("RESET PASSWORD");
			
		?>
	</div>
</div>