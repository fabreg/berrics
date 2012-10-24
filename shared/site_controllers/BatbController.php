<?php

App::import("Controller","Dailyops");

class BatbController extends DailyopsController {
	
	
	public $uses = array();
	
	private $event_id = 50014;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		//$this->initPermissions();
		
		//$this->Auth->allow("*");
			
		if($this->request->params['action']=="section") {
			
			$this->request->params['action'] = "view";
			$this->view = "view";
			
		}
		
		switch($this->request->params['section']) {
			
			case "battle-at-the-berrics-1":
				$this->event_id = 50012;
			break;
			case "battle-at-the-berrics-2":
				$this->event_id = 50013;
			break;
			case "battle-at-the-berrics-3":
				$this->event_id = 50014;
			break;
			
		}
		
		$this->theme = $this->request->params['section'];
		
	}
	
	public function view() {	
		
		$this->loadModel("BatbEvent");
		$this->loadModel("User");
		$this->loadModel("Dailyop");
		
		$event = $this->BatbEvent->returnEvent($this->event_id,true);
		
		$this->set(compact("event"));
		
		$p1_ids = Set::extract("/BatbMatch/player1_user_id",$event['Brackets']['5']);
		
		$p2_ids = Set::extract("/BatbMatch/player2_user_id",$event['Brackets']['5']);
		
		$ids = array_merge($p2_ids,$p1_ids);
		
		$users = array();
		
		$u = $this->User->find("all",array(
			
			"conditions"=>array(
				"User.id"=>$ids
			),
			"contain"=>array()
		
		));
		
		foreach($u as $v) $users[$v['User']['id']] = $v['User'];
		
		$this->set(compact("users"));
		
		$match_map = $this->buildMatchMap($event,$users);
		
		if(isset($this->request->params['named']['view'])) {
			
			$key = $this->request->params['named']['view'];
			
			$match_id = $match_map[$key];
				
			$match = $this->BatbEvent->BatbMatch->returnMatch($match_id);

			$this->set(compact("match"));
			
		} else if(isset($this->request->params['uri'])) {
			
			$uri = $this->request->params['uri'];
			
			$post = $this->Dailyop->returnPostByUri($this->request->params['uri'],$this->request->params['section']);
			
			$this->set(compact("post"));
			
		} 
		
		return;
		
		
	}
	

	private function buildMatchMap($event = false,$users = false) {
		
		$map = array();
		
		foreach($event['Brackets'] as $bracket) {
			
			foreach($bracket as $match) {
				
				if(!empty($match['BatbMatch']['player1_user_id']) && !empty($match['BatbMatch']['player2_user_id'])) {
					
					$player1 = $users[$match['BatbMatch']['player1_user_id']];
					
					$player2 = $users[$match['BatbMatch']['player2_user_id']];
					
					$match_id = $match['BatbMatch']['id'];
					
					$key = Tools::safeUrl($player1['first_name']." ".$player1['last_name']." vs ".$player2['first_name']." ".$player2['last_name']);
					
					$map[$key] = $match_id;
					
				}
				
			}
			
		}
		
		return $map;
		
	}
	
}



?>