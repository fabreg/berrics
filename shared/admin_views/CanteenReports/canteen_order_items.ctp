<?php 

$groups = array(
	"CanteenCategory"=>"Category",
	"Brand"=>"Brands",
);

?>
<script>
$(document).ready(function() { 


	$("#report-form").ajaxForm({

		beforeSubmit:function() {

			$("#report").html("Loading.........");
		
		},
		success:function(d) { 

			$("#report").html(d);
			
		}

	});

	$("#CanteenOrderItemStartDate,#CanteenOrderItemEndDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	
});
</script>
<div class='form'>
	<fieldset>
		<legend>Sales Report</legend>
		<?php 
			echo $this->Form->create("CanteenOrderItem",array("url"=>$this->request->here,"id"=>"report-form"));
			echo $this->Form->input("start_date");
			echo $this->Form->input("end_date");
			echo $this->Form->input("Brand",array("CanteenProduct.brand","empty"=>"* All Brands"));
			echo $this->Form->input("CanteenCategory",array("options"=>$canteenCategories,"empty"=>"* All Categories"));
			echo $this->Form->input("group_by",array("type"=>"select","options"=>$groups));
			echo $this->Form->end("Run Report");
		?>
	</fieldset>
</div>
<div id='report' class='index'>

</div>