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
	
	public function save_xe_currency_file() {
		
		$url  = 'http://www.xe.com/dfs/datafeed2.cgi?theberricsllc';
	 
	    $ch = curl_init($url);
	    
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	    $file_str = curl_exec($ch);
	 
	    curl_close($ch);

		$handle = fopen("/tmp/currency.xml","w");
		
		fwrite($handle,$file_str);
		
		fclose($handle);
		
		SysMsg::add(array(
			"title"=>"Downloaded XE currency XML file",
			"category"=>"CurrencyUpdate",
			"from"=>"Currency",
			"message"=>$file_str
		));
		
	}
	
	public function parse_xe_file() {
		
		$str = file_get_contents("/tmp/currency.xml");
		
		$xml = simplexml_load_string($str);
		
		foreach($xml->currency as $v) {
			
			$this->create();
			
			$this->id = strtoupper($v->csymbol);
			
			$this->save(array(
				"rate"=>$v->crate,
				"inverse"=>$v->cinverse
			));

		}
	
	}
	
	
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
		
		return number_format($amount,2);
		
	}
	
	public function returnCurrencyRecord($token = "USD") {
		
		if(!in_array($token,$this->currencyCache)) {
			
			$this->currencyCache[$token] = $this->findById($token);
			
		}
		
		return $this->currencyCache[$token];
		
	}
}