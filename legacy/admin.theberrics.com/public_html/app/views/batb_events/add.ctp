
<div class='form'>
	
	<?php 
	
		echo $this->Form->create("BatbEvent");
	
	?>
	<fieldset>
		<legend>New Battle at the Berrics Event</legend>
		<?php 
		
			
			echo $this->Form->input("official_event",array("label"=>"Is this Battle an official event?"));
			echo $this->Form->input("name");
			echo $this->Form->input("num_players",array("options"=>BatbEvent::numPlayersDrop(),"label"=>"Number of Players / Brackets"));
			echo $this->Form->input("description");
			echo $this->Form->input("active"); 
			
		?>
	</fieldset>
	
	<?php 
	
		echo $this->Form->end("Create New Event");
	
	?>

</div>