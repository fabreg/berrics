<?php

App::import("Controller","LocalApp");

class SlsVotingController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function section() {
		
		
	}
	
	public function view() {
		
		
		
	}
	
	public function place_vote() {
		
		
	}
	
	
}