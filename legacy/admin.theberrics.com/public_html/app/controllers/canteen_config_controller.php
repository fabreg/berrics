<?php
App::import("Controller","LocalApp");

class CanteenConfigController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		
		
	}
	
	
}