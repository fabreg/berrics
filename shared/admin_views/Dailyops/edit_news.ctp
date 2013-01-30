<div class='form'>
	<h2>Edit News</h2>
	<?php 
		echo $this->Form->create("Dailyop",array("url"=>$this->here));
	?>
	<fieldset>
		<legend>General Info</legend>
		<?php 
		
			echo $this->Form->input("active");
			echo $this->Form->input("publish_date");
			echo $this->Form->input("name");
			echo $this->Form->input("text_content",array("label"=>"Summary"));
			
		?>
	</fieldset>
	
	<?php 
	
		echo $this->Form->end();
	
	?>
</div>