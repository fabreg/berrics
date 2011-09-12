<?php

class StoreHelper extends AppHelper {
	
	
	public $helpers = array("Html");
	
	public function formatMoney($price = 0.00,$currency = 'USD') {
		
		$def = "en_US";
		
		//get the locale from the currency code
		$c = array(
		
			"USD"=>"en_US",
			"EUR"=>"de_DE",
			"AUS"=>"en_AU",
			"GBP"=>"en_GB",
			"BRZ"=>"pt_BR",
			"CAD"=>"en_CA"
		
		);
		
		$cLocale = $c[$currency];
		
		setLocale(LC_MONETARY,$cLocale);
		
		$s = money_format("%#1n",$price);
		
		setLocale(LC_MONETARY,"en_US");
		
		return $s;
		
	}
	
	
	
	
}