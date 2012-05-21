<?php

class UserAddress extends AppModel {
	
	

	public function setOrderAddressValidation() {
		
		$this->validate = array(
			"first_name"=>array(
				"rule"=>"notEmpty",
				"message"=>"First Name Cannot Be Empty"
			),
			"last_name"=>array(
				"rule"=>"notEmpty",
				"message"=>"Last Name Cannot Be Empty"
			),
			"street"=>array(
				"rule"=>"notEmpty",
				"message"=>"Street Cannot Be Empty"
			),
			"city"=>"notEmpty",
			"postal_code"=>"notEmpty",
			"phone"=>"notEmpty",
			"email"=>"email"
		);
		
		
	}
	
	
}