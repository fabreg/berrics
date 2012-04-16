<?php 
$l = Lang::returnSection("CommonFields",$user_locale);

?>
<script>
$(document).ready(function() {

	var formDiv = $("#user-address-form-<?php echo $index; ?>");
	var states = {};
	$(formDiv).find("#UserAddressStateDrop optgroup").each(function() { 
	
		states[$(this).attr("label")]=$(this).html();
		
	});
	
	$(formDiv).find("#UserAddressCountryDrop").change(function() {
	
		var country = $(formDiv).find("#UserAddressCountryDrop").val();

		//check to see if we have an already selected state or value
		var sel = $(formDiv).find("#UserAddressStateDrop").val();
		
		if(states[country]) {

			
			$(formDiv).find("#UserAddressStateDrop").html(ship_to_states_<?php echo $index; ?>[country]);
			$("#user-address-form-<?php echo $index; ?> #user-address-form-state-text-div").hide().find('input').attr({"disabled":true});
			$("#user-address-form-<?php echo $index; ?> #user-address>-form-state-select-div").show().find('select').attr({"disabled":false});

			//try and set the selected val
			if(sel.length>0) {

				$("#user-address-form-<?phpt echo $index; ?> #UserAddressStateDrop[value="+sel+"]").attr({"selected":"selected"});
				
			}
			
		} else {

			$("#user-address-form-<?php echo $index; ?> #user-address-form-state-select-div").hide().find('select').attr({"disabled":true});
			$("#user-address-form-<?php echo $index; ?> #user-address-form-state-text-div").show().find('input').attr({"disabled":false});
		}
	
	});
	
});
</script>
<div id='user-address-form-<?php echo $index; ?>'>
<?php echo $this->Form->input("UserAddress.{$index}.address_type",array("type"=>"hidden","value"=>$address_type)); ?>
<?php if(isset($this->data['UserAddress'][$index]['id'])) echo $this->Form->input("UserAddress.{$index}.id"); ?>
<?php echo $this->Form->input("UserAddress.{$index}.first_name",array("label"=>$l['fname'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.last_name",array("label"=>$l['lname'])); ?>
<?php if($address_type!="billing") echo $this->Form->input("UserAddress.{$index}.email",array("label"=>$l['email'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.street",array("label"=>$l['streetaddress'])); ?>
<?php if($address_type!="billing") echo $this->Form->input("UserAddress.{$index}.apt",array("label"=>$l['apt'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.country_code",array("options"=>Arr::countries(),"label"=>$l['country'],"id"=>"UserAddressCountryDrop")); ?>
<?php echo $this->Form->input("UserAddress.{$index}.state",array("options"=>Arr::states(),"label"=>$l['state'],"div"=>array("id"=>"user-address-form-state-select-div"),"id"=>"UserAddressStateDrop")); ?>
<?php echo $this->Form->input("UserAddress.{$index}.state-text",array("label"=>$l['state'],"div"=>array("id"=>"user-address-form-state-text-div"))); ?>
<?php echo $this->Form->input("UserAddress.{$index}.city",array("label"=>$l['city'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.postal_code",array("label"=>$l['zip'])); ?>
<?php echo $this->Form->input("UserAddress.{$index}.phone",array("label"=>$l['phonenum'])); ?>

</div>