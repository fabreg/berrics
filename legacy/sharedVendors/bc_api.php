<?php

/**
 * 
 * @author johnhardy
 *Bright Cove API Singleton Instance
 *
 *
 */
App::import("Vendor","bc-mapi",array("file"=>"bc-mapi.php"));

class BCAPI {
	
	
	public static $instance = false;
	
	public static $bc_read_token = 'llOwb4cmOPlG8tkaBv2v9hsPWQqSphxGbyz1spcwePeoC3QdCOMvJA..';
	
	public static $bc_write_token = 'uikR5D2s7F--oDVV6c9tHkZ8rYGffPqiSv_9Z87hu0K9iR9d4UbsWA..';
	
	public $bc = false;
	
	private function __construct() {
		
		$this->bc = new BCMAPI(self::$bc_read_token,self::$bc_write_token);
		
	}
	
	
	public static function instance() {
		
		if(!self::$instance) {
			
			
			self::$instance = new self();

		}
		
		
		return self::$instance;
		
		
	}
	
	
	
	
	
	
	
	
	
	
}


?>