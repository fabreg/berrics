<?php 


$l = Lang::returnSection("CommonFields",$user_locale);

$index = ucfirst($index);

?>
<script>
var ship_to_states_<?php echo $index; ?>={};
$(document).ready(function() {

	//get all the opt groups in an object
	$("#UserAddress<?php echo $index; ?>State optgroup").each(function() { 

		ship_to_states_<?php echo $index; ?>[$(this).attr("label")]=$(this).html();
		
	});


	$("#UserAddress<?php echo $index; ?>CountryCode").change(function() { 

		shipChangeState<?php echo $index; ?>();

	});
	//$("#UserAddress<?php echo $index; ?>Country").change();
	shipChangeState<?php echo $index; ?>();
	
});

function shipChangeState<?php echo $index; ?>() {

	var country = $("#UserAddress<?php echo $index; ?>CountryCode").val();

	//check to see if we have an already selected state or value
	var sel = $("#UserAddress<?php echo $index; ?>State").val();
	
	if(ship_to_states_<?php echo $index; ?>[country]) {

		
		$("#UserAddress<?php echo $index; ?>State").html(ship_to_states_<?php echo $index; ?>[country]);
		$("#<?php echo $index; ?>-form-state-text-div").hide().find('input').attr({"disabled":true});
		$("#<?php echo $index; ?>-form-state-select-div").show().find('select').attr({"disabled":false});

		//try and set the selected val
		if(sel.length>0) {

			$("UserAddress<?php echo $index; ?>State[value="+sel+"]").attr({"selected":"selected"});
			
		}
		
	} else {

		$("#<?php echo $index; ?>-form-state-select-div").hide().find('select').attr({"disabled":true});
		$("#<?php echo $index; ?>-form-state-text-div").show().find('input').attr({"disabled":false});
	}
	
}

</script>
<div id='<?php echo strtolower($index); ?>-form'>
<?php echo $this->Form->input("UserAddress.{$index}.first_name",array("label"=>$l['fname'],"error"=>false)); ?>
<?php echo $this->Form->input("UserAddress.{$index}.last_name",array("label"=>$l['lname'],"error"=>false)); ?>
<?php if($index!="Billing") echo $this->Form->input("UserAddress.{$index}.email",array("label"=>$l['email'],"error"=>false)); ?>
<?php echo $this->Form->input("UserAddress.{$index}.street",array("label"=>$l['streetaddress'],"error"=>false)); ?>
<?php if($index!="Billing") echo $this->Form->input("UserAddress.{$index}.apt",array("label"=>$l['apt'],"error"=>false)); ?>
<?php echo $this->Form->input("UserAddress.{$index}.country_code",array("options"=>Arr::countries(),"label"=>$l['country'],"error"=>false)); ?>
<?php echo $this->Form->input("UserAddress.{$index}.state",array("options"=>Arr::states(),"label"=>$l['state'],"div"=>array("id"=>"{$index}-form-state-select-div"))); ?>
<?php echo $this->Form->input("UserAddress.{$index}.state-text",array("label"=>$l['state'],"div"=>array("id"=>"{$index}-form-state-text-div"))); ?>
<?php echo $this->Form->input("UserAddress.{$index}.city",array("label"=>$l['city'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.postal_code",array("label"=>$l['zip'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.phone",array("label"=>$l['phonenum'])); ?>
</div>