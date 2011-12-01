<script type='text/javascript'>

$(document).ready(function() { 


	$( "#UserContestStartDate,#UserContestEndDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	
});

</script>
<div class='form'>
	<fieldset>
		<legend>Add New Contest</legend>
		<div>
			<?php 
			
				echo $this->Form->create("UserContest");
				echo $this->Form->input("active");
				echo $this->Form->input("name");
				echo $this->Form->input("start_date",array("type"=>"text"));
				echo $this->Form->input("end_date",array("type"=>"text"));
				echo $this->Form->end("Add Contest");
				
			?>	
		</div>	
	</fieldset>
</div>