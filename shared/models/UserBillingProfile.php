<?php

class UserBillingProfile extends AppModel {
	
	
	public $belongTo = array(
		"User",
		"GatewayTransaction",
		"GatewayAccount"
	);
	
	public function createBillingProfile($Transaction) {
		
		$billing_profile = $GatewayAccount->get("user_billing_profile");
		$card_data = $GatewayAccount->get("card_data");
		$tres = $GatewayAccount->get("transaction_result");
		$acc = $GatewayAccount->get("gateway_account");

	}
	
	
	
	
}