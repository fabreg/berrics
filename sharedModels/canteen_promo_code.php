<?php
class CanteenPromoCode extends AppModel {
	var $name = 'CanteenPromoCode';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $hasMany = array(
		"CanteenOrder"
	);
	
	public function applyPromoCode($CanteenOrder) {
		
		//set all the promo codes on the order
		$currency = ClassRegistry::init("Currency");
		
		#User Account Promo Code
		if(
			isset($CanteenOrder['CanteenOrder']['user_account_canteen_promo_code_id']) && 
			!empty($CanteenOrder['CanteenOrder']['user_account_canteen_promo_code_id'])
		) {
			
			$uap = $this->find("first",array(
			
				"conditions"=>array(
					"CanteenPromoCode.id"=>$CanteenOrder['CanteenOrder']['user_account_canteen_promo_code_id']
				),
				"contain"=>array()
			
			));
			
			if(isset($uap['CanteenPromoCode']['id'])) $CanteenOrder['UserAccountCanteenPromoCode'] = $uap['CanteenPromoCode'];
			
		}
		
		#Shipping Promo Code
		if(
			env('GEOIP_COUNTRY_CODE') == "US" && 
			$CanteenOrder['CanteenOrder']['sub_total'] > 85
		) {
			
			$CanteenOrder['CanteenOrder']['shipping_total'] = 0.00;
			$CanteenOrder['CanteenOrder']['shipping_canteen_promo_code_id'] = 2;
			
			//get the promo code
			
			$code = $this->find("first",array(
				"contain"=>array(),
				"conditions"=>array(
					"CanteenPromoCode.id"=>2		
				)		
					
			));
			
			$CanteenOrder['ShippingCanteenPromoCode'] = $code['CanteenPromoCode'];
			
		}
		
		#Promotion Promo Code
		
		#Standard Promo Code
		
		#Calculate all the discounts
		
		$discount = 0;
		
		if(isset($CanteenOrder['CanteenOrder']['UserAccountCanteenPromoCode']['rate'])) {
			
			$discount += ($CanteenOrder['CanteenOrder']['UserAccountCanteenPromoCode']['rate']/100)*$CanteenOrder['CanteenOrder']['sub_total'];
			
		}
		
		if($discount>0) $discount = "-".$discount;
			
		$CanteenOrder['CanteenOrder']['discount_total'] = $discount;
		
		$CanteenOrder['CanteenOrder']['sub_total'] += $discount;
		$CanteenOrder['CanteenOrder']['taxable_total'] += $discount;
		
		return $CanteenOrder;
		
	}
	
	
	public static function promoTypeSelect() {
		
		$a = array(
			"shipping",
			"account",
			"store",
			"standard"
		);
		
		$r = array();
		
		foreach($a as $v) $r[$v] = strtoupper($v);
		
		return $r;
		
	}
	
}
?>