<?php

App::import("Controller","OndemandApp");

class HomeController extends OndemandAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function index() {
		
		
		
	}
	
	
}