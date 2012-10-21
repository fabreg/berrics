<?php

App::import("Controller","LocalApp");


class InstagramServerController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		
		
	}
	
	public function edit() {
		
		
	}
	
	
	
}