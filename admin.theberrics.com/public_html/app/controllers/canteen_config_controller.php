<?php
App::import("Controller","AdminApp");

class CanteenConfigController extends AdminAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		
		
	}
	
	
}