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
			<div class='input-pairs'>
				<?php 
					echo $this->Form->input("User.first_name");
					echo $this->Form->input("User.last_name");
				?>
				<div style='clear:both;'></div>
			</div>
			<?php 
				echo $this->Form->input("User.email");
			?>
			<div class='input-pairs'>
					
				<?php 
					echo $this->Form->input("passwd",array("label"=>"Password"));
					echo $this->Form->input("passwd_confirm",array("label"=>"Confirm Password","type"=>"password"));
				?>
				<div style='clear:both;'></div>
			</div>
		</fieldset>
	</div>
	<div>
		<fieldset>
			<legend>Optional Information</legend>
			<?php 
				
				echo $this->Form->input("UserProfile.stance");
				echo $this->Form->input("UserProfile.year_skating");
				echo $this->Form->input("UserProfile.shirt_size");
				echo $this->Form->input("UserProfile.shoe_size")			
			
			?>
		</fieldset>
	</div>
<?php echo $this->Form->end("Register Account"); ?>
</div>