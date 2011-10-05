<?php

App::import("Controller","BerricsApp");

class AccountController extends BerricsAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}

	public function index() {
		
		
		
	}
	
	public function canteen() {
		
		
		
	}
	
	
}
