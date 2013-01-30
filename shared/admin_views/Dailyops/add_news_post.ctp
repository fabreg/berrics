<script>

$(document).ready(function() { 


	$( "#DailyopPubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});



	
});

</script>
<div class='form'>
	<h2>Add News Post</h2>
	<fieldset>
		<legend>New Post</legend>
		<?php 
		
			echo $this->Form->create("Dailyop",array("url"=>$this->here));
			echo $this->Form->input("name");
			echo $this->Form->input("pub_date");
			echo $this->Form->input("misc_category",array("options"=>Arr::dailyopsMiscCategories(),"label"=>"Category"));
			echo $this->Form->end("Insert News");
			
		?>
	</fieldset>
</div>