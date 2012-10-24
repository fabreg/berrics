<?php

App::uses("SplashAppController","Controller");

class ManageController extends SplashAppController {
	
	public $uses = array("SplashCreative");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
}