<script>

$(document).ready(function() { 

	$( "#BqReportStartDate,#BqReportEndDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
	$("#data-form").ajaxForm({

		"success":function(d) {

			$('body').append(d);
			
		}

	});
	
});

</script>
<div class='form'>
	<fieldset>
		<legend>Traffic Overview Report</legend>
		<div>
			<?php 
				
				echo $this->Form->create("BqReport",array("url"=>array("action"=>"process","plugin"=>"bq_reports","controller"=>"dashboard"),"id"=>"data-form"));
				echo $this->Form->input("template",array("type"=>"hidden","value"=>"traffic-overview"));
				echo $this->Form->input("start_date");
				echo $this->Form->input("end_date");
			 
				echo $this->Form->end("Generate Report");
			?>
		
		</div>
	</fieldset>
</div>