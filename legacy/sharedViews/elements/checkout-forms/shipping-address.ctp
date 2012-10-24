<?php 

$l = Lang::returnSection("CommonFields",$user_locale);


?>
<script>
var ship_to_states = {};
$(document).ready(function() { 

	
	//get all the opt groups in an object
	$("#ShippingAddressState optgroup").each(function() { 

		ship_to_states[$(this).attr("label")]=$(this).html();
		
	});


	$("#ShippingAddressCountryCode").change(function() { 

		shipChangeState();

	});
	//$("#ShippingAddressCountry").change();
	shipChangeState();
	
});


function shipChangeState() {

	var country = $("#ShippingAddressCountryCode").val();

	//check to see if we have an already selected state or value
	var sel = $("#ShippingAddressState").val();
	
	if(ship_to_states[country]) {

		
		$("#ShippingAddressState").html(ship_to_states[country]);
		$("#form-shipping-state-text-div").hide().find('input').attr({"disabled":true});
		$("#form-shipping-state-select-div").show().find('select').attr({"disabled":false});

		//try and set the selected val
		if(sel.length>0) {

			$("#ShippingAddressState[value="+sel+"]").attr({"selected":"selected"});
			
		}
		
	} else {

		$("#form-shipping-state-select-div").hide().find('select').attr({"disabled":true});
		$("#form-shipping-state-text-div").show().find('input').attr({"disabled":false});
	}
	
}

</script>
<div>
	<?php 
		
		echo $this->Form->input("ShippingAddress.address_type",array("type"=>"hidden","value"=>"shipping","error"=>false));
		echo $this->Form->input("ShippingAddress.email",array("label"=>$l['email'],"error"=>false));
		echo $this->Form->input("ShippingAddress.first_name",array("label"=>$l['fname'],"error"=>false));
		echo $this->Form->input("ShippingAddress.last_name",array("label"=>$l['lname'],"error"=>false));
		echo $this->Form->input("ShippingAddress.street",array("label"=>$l['streetaddress'],"error"=>false));
		echo $this->Form->input("ShippingAddress.apt",array("label"=>$l['apt'],"error"=>false));
		echo $this->Form->input("ShippingAddress.country_code",array("label"=>$l['country'],"options"=>Arr::countries(),"error"=>false));
		echo $this->Form->input("ShippingAddress.state",array("label"=>$l['state'],"options"=>Arr::states(),"error"=>false,"div"=>array("id"=>"form-shipping-state-select-div")));
		echo $this->Form->input("ShippingAddress.state-text",array("label"=>$l['state'],"name"=>"data[ShippingAddress][state]","div"=>array("id"=>"form-shipping-state-text-div")));
		echo $this->Form->input("ShippingAddress.city",array("label"=>$l['city'],"error"=>false));
		echo $this->Form->input("ShippingAddress.postal_code",array("label"=>$l['zip'],"error"=>false));
		echo $this->Form->input("ShippingAddress.phone",array("label"=>$l['phonenum'],"error"=>false))
	?>
</div>