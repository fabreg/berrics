<?php

App::import("Controller","Dailyops");

class SlsVotingController extends DailyopsController {
	
	
	public $uses = array("SlsEntry");
	
	public $components = array("RequestHandler");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "sls-voting";
		
		if($this->params['action'] == "view") {
			
			if($this->RequestHandler->isAjax()) {
				
				$this->params['action'] = "open_video";
				
			} else {
				
				$this->params['action'] = "section";
				
			}
			
			
		}
		
		if(isset($this->params['uri']) && !empty($this->params['uri'])) {
			
			$this->setPost();
			
		}
			
		
	}
	
	public function section() {
		
		//get all the entires
		$entries = $this->SlsEntry->find("all",array(
			
			"contain"=>array(),
			"order"=>array(
				"SlsEntry.name"=>"ASC"
			)
		));
		
		foreach($entries as $k=>$v) {
			
			$post = $this->SlsEntry->Dailyop->returnPost(array("Dailyop.id"=>$v['SlsEntry']['dailyop_id']),1);
			
			$entries[$k] = array_merge($entries[$k],$post);
			
		}
		
		$this->set(compact("entries"));
		
	}
	
	public function view() {
		
		
		
	}
	
	private function setPost() {
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
			"Dailyop.uri"=>$this->params['uri'],
			"DailyopSection.uri"=>$this->params['section']
		),$this->isAdmin());
		
		$this->set(compact("post"));
		
	}
	
	public function open_video() {
		
		$this->layout = "ajax";
		
		$this->render("/elements/video-post");
		
	}
	
	public function place_vote() {
		
		
		
	}
	
	
}