<?php


class LLMediaVault {
	
	public static $instance = false;
	
	public $mv_hash = "yzJiEzNqFAfu6";
	
	public $mv_url = "http://berrics.vo.llnwd.net/o45/s/";
	
	private function __construct() {
		
		
		
	}
	
	public static function instance() {
		
		if(!self::$instance) {
			
			self::$instance = new self();
			
		}

		return self::$instance;
		
	}
	
	
	public function returnSecureUrl($MediaFile = array(),$ttl = 30) {
		
		if(
			!isset($MediaFile['id']) || 
			!isset($MediaFile['limelight_file']) ||
			($MediaFile['limelight_mediavault_active']!=1)
		) {
			
			throw new Exception("[LLMediaVault::returnSecureUrl()]:Invalid Media File");
			
		}
		
		//30 seconds in the future
		$time = strtotime("+{$ttl} Seconds");
		
		$url = $this->mv_url.$MediaFile['limelight_file']."?e=".$time;
		
		$hash = md5($this->mv_hash.$url);
		
		return $url."&h=".$hash;
		
	}
	
	
	

	
	
	
}


?>