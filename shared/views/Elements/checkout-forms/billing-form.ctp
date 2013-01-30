<?php 

$l = Lang::returnSection("CommonFields",$user_locale);

?>
<script>
var bill_to_states={};
$(document).ready(function() {

	//get all the opt groups in an object
	$("#CanteenOrderBillState optgroup").each(function() { 

		bill_to_states[$(this).attr("label")]=$(this).html();
		
	});

	for(var a in bill_to_states) {

			//alert(ship_to_states[a]);
	}
	
	$("#CanteenOrderBillCountry").change(function() { 
		
		billChangeState();

	});
	$("#CanteenOrderBillCountry").change();
	
	
});

function billChangeState() {

	var country = $("#CanteenOrderBillCountry").val();
	
	//check to see if we have an already selected state or value
	var sel = $("#OrderBillState").val();
	
	if(bill_to_states[country]) {

		//alert(ship_to_states[country]);
		$("#CanteenOrderBillState").html(ship_to_states[country]);
		$("#billing-form-state-text-div").hide();
		$("#billing-form-state-select-div").show();

		//try and set the selected val
		if(sel.length>0) {

			$("CanteenOrderBillState[value="+sel+"]").attr({"selected":"selected"});
			
		}
		
	} else {

		$("#billing-form-state-select-div").hide();
		$("#billing-form-state-text-div").show();
	}
	
}

</script>
<div id='billing-form'>

	<?php echo $this->Form->input("CanteenOrder.bill_first_name",array("label"=>$l['fname'])); ?>
	<?php echo $this->Form->input("CanteenOrder.bill_last_name",array("label"=>$l['lname'])); ?>
	<?php echo $this->Form->input("CanteenOrder.bill_address",array("label"=>$l['streetaddress'])); ?>
	<?php echo $this->Form->input("CanteenOrder.bill_country",array("options"=>Arr::countries(),"label"=>$l['country'])); ?>
	<?php echo $this->Form->input("CanteenOrder.bill_state",array("options"=>Arr::states(),"label"=>$l['state'],"div"=>array("id"=>"billing-form-state-select-div"))); ?>
	<?php echo $this->Form->input("CanteenOrder.bill_state-text",array("label"=>$l['state'],"div"=>array("id"=>"billing-form-state-text-div"))); ?>
	<?php echo $this->Form->input("CanteenOrder.bill_city",array("label"=>$l['city'])); ?>
	<?php echo $this->Form->input("CanteenOrder.bill_postal",array("label"=>$l['zip'])); ?>

</div>