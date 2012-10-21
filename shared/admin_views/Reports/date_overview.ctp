<script>

$(document).ready(function() { 


	$("#ReportStartDate,#ReportEndDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});


	$("#report-form").ajaxForm({


		"beforeSubmit":function() { 

			$("#submit-button").attr('disabled','disabled').text("Processing....");
			
			return true;

		},
		"success":function(d) { 

			document.location.href ='<?php echo $this->Admin->url(array("controller"=>"reports","action"=>"index")); ?>';

		}

	});

	
});

</script>
<h2>Date Overview</h2>
<?php 
	echo $this->Form->create("Report",array("id"=>"report-form"));
?>
<div class='row-fluid'>
	<div class='span6'>
		<?php 
			echo $this->Form->input("title");
			echo $this->Form->input("start_date");
			echo $this->Form->input("end_date");
		?>
		<div class='form-actions'>
			<button class='btn btn-primary' id='submit-button'>Generate Report</button>
		</div>
	</div>
</div>
<?php 
	echo $this->Form->end();
?>