<?php

App::import("Vendor","Facebook",array("file"=>"facebook.php"));

class FacebookApi {
	
	public static $instance = false;
	public static $fb_app_id = '128870297181216';
	public static $fb_app_secret ='323ecb1c86618ea4145abd75c60f3b4c';
	public  $facebook = false;
	
	/**
	 * Block public access to construct
	 * @return null
	 */
	private function __construct() {
		
		$this->facebook = new Facebook(array(
		
			'appId' => self::$fb_app_id,
			"secret" => self::$fb_app_secret,
			"cookie" => true
		
		));
		
	}
	
	/**
	 * Return Singleton Instance
	 * @return FacebookApi
	 */
	public function instance() {
		
		if(!self::$instance) {
			
			self::$instance = new self();
			
		}
		
		return self::$instance;
		
	}
	
	
	public static function checkSession() {
		
		$fb = self::instance();
	
	}
	
	public function facebookApiCall($method) {
		
		
		
	}
	
	public function link_stats($link = false) {
		
		
		
		
		
		
	}
	
	
	
}