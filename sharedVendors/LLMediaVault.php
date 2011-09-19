<?php


class LLMediaVault {
	
	public static $instance = false;
	
	private function __construct() {
		
		
		
	}
	
	public static function instance() {
		
		if(!self::$instance) {
			
			self::$instance = new self();
			
		}

		return self::$instance;
		
	}
	
	
	
	

	
	
	
}


?>