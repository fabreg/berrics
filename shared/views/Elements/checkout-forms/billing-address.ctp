<?php 

$l = Lang::returnSection("CommonFields",$user_locale);


?>
<div>
<?php 
	echo $this->Form->input("BillingAddress.address_type",array("value"=>"billing","type"=>"hidden"));
	echo $this->Form->input("BillingAddress.first_name",array("label"=>$l['fname']));
	echo $this->Form->input("BillingAddress.last_name",array("label"=>$l['lname']));
	echo $this->Form->input("BillingAddress.country_code",array("label"=>$l['country'],"options"=>Arr::countries()));
	echo $this->Form->input("BillingAddress.street",array());
	echo $this->Form->input("BillingAddress.postal_code",array("label"=>$l['zip']));
?>
</div>