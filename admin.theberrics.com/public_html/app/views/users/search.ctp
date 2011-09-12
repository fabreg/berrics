<div class='form'>

	<fieldset>
		<legend>Search Users Database</legend>
		<?php 
		
			echo $this->Form->create("User",array("url"=>$this->here));
			echo $this->Form->input("first_name");
			echo $this->Form->input("last_name");
			echo $this->Form->input("email");
			echo $this->Form->input("user_group_id",array("empty"=>true));
			echo $this->Form->end("Search");
		?>
	</fieldset>

</div>