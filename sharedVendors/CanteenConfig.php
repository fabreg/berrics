<?php 

class CanteenConfig {
	
	public static $_config = false;
	
	
	public static function _init() {
		
		if(!self::$_config) {
			
			$a = array(
		
				"store_name"=>"The Canteen",
				"realtime_inventory"=>true,
				"global_discount"=>false,
				"global_discount_rate"=>"0",
				"global_discount_type"=>false, //CAN BE 'flat' or 'percent'
				"free_shipping"=>false,
				"free_shipping_subtotal"=>0, //CALCULATED IN US DOLLARS
				"free_shipping_countries"=>array("US"), //TWO CHAR ISO COUNTY CODES
				"currencies"=>array("USD","GBP","EUR","CAD","AUD","BRL"),
				"user_currency"=>array(
					"GBP"=>array("GB","UK"),
					"EUR"=>array("AD","AT","BE","CY","EE","FI","FR","DE","GR","IE","IT","LU","MT","MC","ME","NL","PT","SM","SK","SI","ES","VA"),
					"CAD"=>array("CA"),
					"AUD"=>array("AU"),
					"BRL"=>array("BR")
				),
				"gateway_account_id"=>3, //3 is live
				"tax_regions"=>array(
					"US-CA"=>9.25
				),
				"shipping_codes"=> array(
										"03"=>"Ground Shipment",
										"02"=>"Second Day Air",
										"01"=>"Next Day Air"
									)
				
			);
			
			self::$_config = $a;
		}
		
	}
	
	public static function get($val) {
		
		self::_init();
		
		return self::$_config[$val];
		
	}
	
	public function returnUserCurrencyId($country_id = "US") {
		
		if($country_id == "US") {
			
			return "USD";
			
		}
		
		
		$c = self::get("user_currency");
		
		foreach($c as $k=>$v) {
			
			if(in_array($country_id,$v)) {
				
				return $k;
				
			}
			
		}
		
		return "USD";
		
	}
	
	
}