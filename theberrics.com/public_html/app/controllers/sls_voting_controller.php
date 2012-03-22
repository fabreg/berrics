<?php

App::import("Controller","Dailyops");

class SlsVotingController extends DailyopsController {
	
	
	public $uses = array("SlsEntry");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "sls-voting";
		
		if($this->params['action'] == "view") {
			
			$this->params['action'] = "section";
			
		}
		
		if(isset($this->params['uri']) && !empty($this->params['uri'])) {
			
			$this->setPost();
			
		}
			
		
	}
	
	public function section() {
		
		//get all the entires
		$entries = $this->SlsEntry->find("all",array(
			
			"contain"=>array("Dailyop"),
			"order"=>array(
				"SlsEntry.sort_order"=>"ASC"
			)
		));
		
		$this->set(compact("entries"));
		
	}
	
	public function view() {
		
		
		
	}
	
	public function setPost() {
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
			"Dailyop.uri"=>$this->params['uri'],
			"DailyopSection.uri"=>$this->params['section']
		),$this->isAdmin());
		
		$this->set(compact("post"));
		
	}
	
	public function place_vote() {
		
		
		
	}
	
	
}