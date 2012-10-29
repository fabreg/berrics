<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User'); ?></legend>
	<?php
		echo $this->Form->input("first_name");
		echo $this->Form->input("last_name");
		echo $this->Form->input("email");
		echo $this->Form->input("passwd");
				echo $this->Form->input("berrics_employee");
		echo $this->Form->input("pro_skater");
		echo $this->Form->input("am_skater");
		echo $this->Form->input('user_group_id',array("type"=>"hidden","value"=>60));
		//echo $this->Form->input("tags",array("label"=>"Tags: (Multiple tags should be comma seperated)"));
	?>
	</fieldset>
		
	<fieldset>
		<legend>Contact Information</legend>
		<?php 
			echo $this->Form->input("birth_date",array("minYear"=>1970,"maxYear"=>2011));
			echo $this->Form->input("phone_number");
			echo $this->Form->input("street_address");
			echo $this->Form->input("country",array("options"=>Arr::countries()));
		?>
	</fieldset>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
