<?php

App::import("Controller","LocalApp");

class Yn3VotingController extends LocalAppController { 

	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->theme = "yn3-voting";
		
	}
	
	public function view() {
		
		
		
	}
	
	
	public function section() {
		
		
		
	}
	
	

}