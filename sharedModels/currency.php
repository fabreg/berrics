<?php
class Currency extends AppModel {
	private $currencyCache = array(
		"USD"=>array(
					"Currency"=>array(
								"rate"=>1.0,
								"currency_token"=>"USD",
								"symbol"=>"$",
								"name"=>"United States Dollar",
								"id"=>"USD"
					)
		)
	);
	var $name = 'Currency';
	var $validate = array(
		'currency_token' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	
	
	public function convertCurrency($to = "USD",$from = "USD", $amount = 0.00) {

		if($to == $from) {

			return $amount;
			
		}
		
		$to_c = $this->returnCurrencyRecord($to);
		
		$from_c = $this->returnCurrencyRecord($from);
		
		if($to == "USD") {
			
			$amount = $amount * $from_c['Currency']['rate'];
			
		} else {
			
			//convert the "from" amount back into usd
			$amount = $amount / $to_c['Currency']['rate'];
			
			$amount = $amount * $from_c['Currency']['rate'];
			
		}
		
		return $amount;
		
	}
	
	public function returnCurrencyRecord($token = "USD") {
		
		if(!in_array($token,$this->currencyCache)) {
			
			$this->currencyCache[$token] = $this->findById($token);
			
		}
		
		return $this->currencyCache[$token];
		
	}
}