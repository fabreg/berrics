<?php 


$l = Lang::returnSection("CommonFields",$user_locale);

?>
<script>
var ship_to_states={};
$(document).ready(function() {

	//get all the opt groups in an object
	$("#CanteenOrderState optgroup").each(function() { 

		ship_to_states[$(this).attr("label")]=$(this).html();
		
	});

	for(var a in ship_to_states) {

			//alert(ship_to_states[a]);
	}
	
	$("#CanteenOrderCountry").change(function() { 

		shipChangeState();

	});
	$("#CanteenOrderCountry").change();
	
	
});

function shipChangeState() {

	var country = $("#CanteenOrderCountry").val();

	//check to see if we have an already selected state or value
	var sel = $("#CanteenOrderState").val();
	
	if(ship_to_states[country]) {

		//alert(ship_to_states[country]);
		$("#CanteenOrderState").html(ship_to_states[country]);
		$("#shipping-form-state-text-div").hide();
		$("#shipping-form-state-select-div").show();

		//try and set the selected val
		if(sel.length>0) {

			$("CanteenOrderState[value="+sel+"]").attr({"selected":"selected"});
			
		}
		
	} else {

		$("#shipping-form-state-select-div").hide();
		$("#shipping-form-state-text-div").show();
	}
	
}

</script>
<div id='shipping-form'>
<?php echo $this->Form->input("CanteenOrder.first_name",array("label"=>$l['fname'])); ?>
<?php echo $this->Form->input("CanteenOrder.last_name",array("label"=>$l['lname'])); ?>
<?php echo $this->Form->input("CanteenOrder.email",array("label"=>$l['email'])); ?>
<?php echo $this->Form->input("CanteenOrder.street_address",array("label"=>$l['streetaddress'])); ?>
<?php echo $this->Form->input("CanteenOrder.apt",array("label"=>$l['apt'])); ?>
<?php echo $this->Form->input("CanteenOrder.country",array("options"=>Arr::countries(),"label"=>$l['country'])); ?>
<?php echo $this->Form->input("CanteenOrder.state",array("options"=>Arr::states(),"label"=>$l['state'],"div"=>array("id"=>"shipping-form-state-select-div"))); ?>
<?php echo $this->Form->input("CanteenOrder.state-text",array("label"=>$l['state'],"div"=>array("id"=>"shipping-form-state-text-div"))); ?>
<?php echo $this->Form->input("CanteenOrder.city",array("label"=>$l['city'])); ?>
<?php echo $this->Form->input("CanteenOrder.postal",array("label"=>$l['zip'])); ?>
<?php echo $this->Form->input("CanteenOrder.phone",array("label"=>$l['phonenum'])); ?>


</div>