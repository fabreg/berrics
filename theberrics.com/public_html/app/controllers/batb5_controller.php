<?php

App::import("Controller","Dailyops");


class Batb5Controller extends DailyopsController {
	
	
	public $uses = array();
	
	private $event_id = 50018;
	//private $event_id = 50016;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		//set the theme
		
		$this->theme = "battle-at-the-berrics-5";
		
		if($this->params['action'] == "view")  {
			
			$this->params['action'] = "section";
			
		}
		
	}
	
	
	public function section() {
		
		//clear out the right columnd
		$this->set("right_column","");
		
		//load the events model
		$this->loadModel("BatbEvent");
		
		//get and set the event
		$event = $this->BatbEvent->returnEvent($this->event_id);
		$this->set(compact("event"));
		
	}
	
	public function view() {
		
		
		
	}
	
	private function setFeaturedMatch() {
		
		
		
	}
	
	
	private function setPosts() {
		
		
		
	}
	
	
}