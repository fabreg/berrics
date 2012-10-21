<?php


class Instagram {
	
	public static $client_id = '6043dfac97d04a55a4f7b400994c302d';
	public static $client_secret = '928a9fc2a9af4e579eb00a33a1370b2c';
	public static $instance = false;
	
	
	private function __construct() {
		
		
		
	}
	
	
	public static function instance() {
		
		if(!self::$instance) {
			
			self::$instance = new self();
			
		}
		
		return self::$instance;
		
	}
	
	
	public function getPopular() {
		
		
		
		
		
	}
	
	
	public function api(/*POLYMORPHIC*/) {
		
		
		$args = func_get_args();
		
		if(!is_array($args[0])) {
			
			throw new Exception("Berrics Instagram API needs some arguments dude");
			
		} else {
			
			$opt = $args[0];
			
		}
		
		//let's extract the method and do a curl request
		
		$method = $opt['method'];
		
		$api_call = $opt['api_call'];
		
		$callback = $opt['callback'];
		
		$url = "https://api.instagram.com/v1/";
		
		
		switch($api_call) {
			
			case "popular":
			
				$url.="media/popular/";
				
			break;
			
		}
		
		
		$opt['client_id'] = self::$client_id;
		
		die($url);
		return $this->curlRequest($url,$opt,$method);
		
		
	}
	
	public function curlRequest($url,$data = array(),$method = 'GET') {
			
			$curl = curl_init();
			
			switch(strtolower($method)) {
				
				case "post":
					curl_setopt($curl,CURLOPT_POST,1);
				break;
				
				default:
					curl_setopt($curl,CURLOPT_GET,1);
				break;
				
				
			}
			
			curl_setopt($curl,CURLOPT_URL,$url);
			
			curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($data));
			
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			
			$ret = curl_exec($curl);
			
			curl_close($curl);
			
			return $ret;
		
	}
	
	
	
}











?>