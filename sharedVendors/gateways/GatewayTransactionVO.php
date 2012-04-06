<?php

class GatewayTransactionVO {
	
	/**
	 * Extract all required information from a CanteenOrder to send to the GatewayAccount Processor
	 * @param CanteenOrder $CanteenOrder
	 * @return Array:
	 */
	public static function formatCanteenOrder($CanteenOrder) {
		
		$t = array();
		
		$customer = Set::extract("/UserAddress[address_type=/billing|shipping/]/",$CanteenOrder);
		die(print_r($customer));
		#TRANSACTION
		$t['Transaction']['currency_id'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.currency_id");
		$t['Transaction']['amount'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.grand_total");
		$t['Transaction']['foreign_key'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.id");
		$t['Transaction']['model'] = 		"CanteenOrder";
		
		#CUSTOMER
		$t['Customer']['first_name'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_first_name");
		$t['Customer']['last_name'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_last_name");
		$t['Customer']['address'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_address");
		$t['Customer']['postal'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_postal");
		$t['Customer']['country'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_country");
		$t['Customer']['email'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.email");
		$t['Customer']['city'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_city");
		$t['Customer']['state'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_state");
		$t['Customer']['phone'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.phone");
		$t['Customer']['user_id'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.user_id");
		
		#CARD DATA
		$t['CardData']['number'] = 			Set::classicExtract($CanteenOrder,"CardData.number");
		$t['CardData']['exp_year'] =		Set::classicExtract($CanteenOrder,"CardData.exp_year");
		$t['CardData']['exp_month'] = 		Set::classicExtract($CanteenOrder,"CardData.exp_month");
		$t['CardData']['code'] = 			Set::classicExtract($CanteenOrder,"CardData.code");

		return $t;
		
	}
	
	
}