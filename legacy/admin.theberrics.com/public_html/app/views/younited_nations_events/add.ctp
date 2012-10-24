<div class='form'>
	<fieldset>
		<legend>Add New Younited Nations Events</legend>
		<div>
			<?php 
				
				echo $this->Form->create("YounitedNationsEvent");
				echo $this->Form->input("active");
				echo $this->Form->input("name");
				echo $this->Form->input("description");
				echo $this->Form->end("Create Event");
			?>
		</div>
	</fieldset>
</div>