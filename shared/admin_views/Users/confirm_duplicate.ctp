
<div class='form'>
	<?php echo $this->Form->create("User",array("url"=>$this->here)); ?>
	<fieldset>
		<legend>The following user might already exits. Please confirm that wish to create the user.</legend>
		<?php
			echo $this->Form->input("first_name");
			echo $this->Form->input("last_name");
			echo $this->Form->input("email");
			//echo $this->Form->input("passwd");
			echo $this->Form->input('user_group_id');
			echo $this->Form->input("country",array("options"=>Arr::countries()));
		?>
	</fieldset>
	<div style='padding:5px;'>	
		<?php echo $this->Admin->link("No, I don't want to create this user",array("controller"=>"users","action"=>"index")); ?>
	</div>
	<?php echo $this->Form->end("Confirm"); ?>
</div>
