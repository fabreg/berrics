<script>
$(document).ready(function() { 

	
	
});
</script>
<style>
#BerricsLogin .wrapper {

	width:750px;
	

}
</style>
<div id='identity-register' class='identity-container'>
<div class='heading'>
	THE BERRICS REGISTRATION FORM
</div>
<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create("User",array("url"=>$this->here,"id"=>"identity-register-form")); ?>
	<div class='required-fields'>
		<div class='form-heading'>Required Information</div>
		<?php 
					echo $this->Form->input("User.first_name");
					echo $this->Form->input("User.last_name");
					echo $this->Form->input("User.email");
					echo $this->Form->input("new_passwd",array("label"=>"Password"));
					echo $this->Form->input("new_passwd_confirm",array("label"=>"Confirm Password","type"=>"password"));
		?>
	</div>
	<div class='optional-fields'>
		<div class='form-heading'>Optional Information</div>
		<?php 
				
				echo $this->Form->input("UserProfile.stance");
				echo $this->Form->input("UserProfile.year_skating");
				echo $this->Form->input("UserProfile.shirt_size");
				echo $this->Form->input("UserProfile.shoe_size")			
			
			?>
	</div>
	<div style='clear:both;'></div>
<?php echo $this->Form->end("Register Account"); ?>
</div>