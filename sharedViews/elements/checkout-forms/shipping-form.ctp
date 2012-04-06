<?php 


$l = Lang::returnSection("CommonFields",$user_locale);

$index = ucfirst($index);

?>
<script>
var ship_to_states={};
$(document).ready(function() {

	//get all the opt groups in an object
	$("#UserAddress<?php echo $index; ?>State optgroup").each(function() { 

		ship_to_states[$(this).attr("label")]=$(this).html();
		
	});

	for(var a in ship_to_states) {

			//alert(ship_to_states[a]);
	}
	
	$("#UserAddress<?php echo $index; ?>Country").change(function() { 

		shipChangeState();

	});
	//$("#UserAddress<?php echo $index; ?>Country").change();
	shipChangeState();
	
});

function shipChangeState() {

	var country = $("#UserAddress<?php echo $index; ?>Country").val();

	//check to see if we have an already selected state or value
	var sel = $("#UserAddress<?php echo $index; ?>State").val();
	
	if(ship_to_states[country]) {

		
		$("#UserAddress<?php echo $index; ?>State").html(ship_to_states[country]);
		$("#<?php echo $index; ?>-form-state-text-div").hide();
		$("#<?php echo $index; ?>-form-state-select-div").show();

		//try and set the selected val
		if(sel.length>0) {

			$("UserAddress<?php echo $index; ?>State[value="+sel+"]").attr({"selected":"selected"});
			
		}
		
	} else {

		$("#<?php echo $index; ?>-form-state-select-div").hide();
		$("#<?php echo $index; ?>-form-state-text-div").show();
	}
	
}

</script>
<div id='shipping-form'>
<?php echo $this->Form->input("UserAddress.{$index}.first_name",array("label"=>$l['fname'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.last_name",array("label"=>$l['lname'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.email",array("label"=>$l['email'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.street_address",array("label"=>$l['streetaddress'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.apt",array("label"=>$l['apt'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.country",array("options"=>Arr::countries(),"label"=>$l['country'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.state",array("options"=>Arr::states(),"label"=>$l['state'],"div"=>array("id"=>"{$index}-form-state-select-div"))); ?>
<?php echo $this->Form->input("UserAddress.{$index}.state-text",array("label"=>$l['state'],"div"=>array("id"=>"{$index}-form-state-text-div"))); ?>
<?php echo $this->Form->input("UserAddress.{$index}.city",array("label"=>$l['city'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.postal",array("label"=>$l['zip'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.phone",array("label"=>$l['phonenum'])); ?>


</div>