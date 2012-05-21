<?php

class GatewayTransactionVO {
	
	/**
	 * Extract all required information from a CanteenOrder to send to the GatewayAccount Processor
	 * @param CanteenOrder $CanteenOrder
	 * @return Array:
	 */
	public static function formatCanteenOrder($CanteenOrder) {
		
		$t = array();
		
		$customer = $CanteenOrder['BillingAddress'];

		#TRANSACTION
		$t['Transaction']['currency_id'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.currency_id");
		$t['Transaction']['amount'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.grand_total");
		$t['Transaction']['foreign_key'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.id");
		$t['Transaction']['model'] = 		"CanteenOrder";
		
		#CUSTOMER
		$t['Customer']['first_name'] = 		Set::classicExtract($customer,"first_name");
		$t['Customer']['last_name'] = 		Set::classicExtract($customer,"last_name");
		$t['Customer']['address'] = 		Set::classicExtract($customer,"street")." ".Set::classicExtract($customer,"apt");
		$t['Customer']['postal'] = 			Set::classicExtract($customer,"postal_code");
		$t['Customer']['country'] = 		Set::classicExtract($customer,"country_code");
		$t['Customer']['email'] = 			Set::classicExtract($customer,"email");
		$t['Customer']['city'] = 			Set::classicExtract($customer,"city");
		$t['Customer']['state'] = 			Set::classicExtract($customer,"state");
		$t['Customer']['phone'] = 			Set::classicExtract($customer,"phone");
		$t['Customer']['user_id'] = 		Set::classicExtract($customer,"user_id");
		
		#CARD DATA
		$t['CardData']['number'] = 			Set::classicExtract($CanteenOrder,"CardData.number");
		$t['CardData']['exp_year'] =		Set::classicExtract($CanteenOrder,"CardData.exp_year");
		$t['CardData']['exp_month'] = 		Set::classicExtract($CanteenOrder,"CardData.exp_month");
		$t['CardData']['code'] = 			Set::classicExtract($CanteenOrder,"CardData.code");

		return $t;
		
	}
	
	
}