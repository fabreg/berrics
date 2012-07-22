<?php

class DashboardController extends BqReportsAppController {
	
	public $uses = array("BqReport");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
			
	}
	
	
	
}