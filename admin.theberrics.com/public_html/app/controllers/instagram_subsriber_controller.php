<?php

App::import("Controller","LocalApp");
App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));

class InstagramSubscriberController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		self::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		if(count($this->data)) {
			
			
			
		} else {
			
			
		}
		
		$this->data['Instagram'] = array(
			"client_id"=>InstagramApi::$config['client_id'],
			"client_secret"=>InstagramApi::$config['client_secret']
		);
		
	}
	
	
	
	
}