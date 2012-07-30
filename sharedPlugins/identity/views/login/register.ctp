<script>
$(document).ready(function() { 

	<?php if($this->params['isAjax']): ?>

	<?php else: ?>
	
	<?php endif; ?>
	
});
</script>
<div id='identity-register'>
<?php echo $this->Form->create("User",array("url"=>$this->here,"id"=>"identity-register-form")); ?>
	<div>
		<fieldset>
			<legend>Required Information</legend>
			<?php 
				
				echo $this->Form->input("User.first_name");
				echo $this->Form->input("User.last_name");
				echo $this->Form->input("User.email");
				echo $this->Form->input("passwd",array("label"=>"Password"));
				echo $this->Form->input("passwd_confirm",array("label"=>"Confirm Password","type"=>"password"));
			?>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Optional Information</legend>
			<?php 
			
				
			
			?>
		</fieldset>
	</div>
<?php echo $this->Form->end("Register Account"); ?>
</div>