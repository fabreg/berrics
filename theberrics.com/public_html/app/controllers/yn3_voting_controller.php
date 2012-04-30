<?php

App::import("Controller","Dailyops");

class Yn3VotingController extends DailyopsController { 

	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->theme = "yn3-voting";
		
		if($this->params['action'] == "index" || empty($this->params['action'])) {
			
			
			$this->params['action'] = "section";
			
		}
		
	}
	
	public function view() {
		
		
		
	}
	
	
	public function section() {
		
		
		
	}
	
	

}