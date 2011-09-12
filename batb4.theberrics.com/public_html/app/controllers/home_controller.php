<?php

App::import("Controller","BatbApp");

class HomeController extends BatbAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow();
		
	}
	
	public function index($id = false) {
		
		
		$ev_id = $this->batb_event_id;
		
		switch($id) {
			
			case 1:
				$ev_id = 50012;
			break;
			case 2:
				$ev_id = 50013;
			break;
			
			case 3:
				$ev_id = 50014;
			break;
			
		}
		
		$this->loadModel("BatbEvent");
		$this->loadModel("User");
		
		$event = $this->BatbEvent->returnEvent($ev_id);
		
		$p1_ids = Set::extract("/BatbMatch/player1_user_id",$event['Brackets']['5']);
		
		$p2_ids = Set::extract("/BatbMatch/player2_user_id",$event['Brackets']['5']);
		
		$user_ids = array_merge($p1_ids,$p2_ids);
		
		$user_list = $this->User->find("all",array(
		
			"conditions"=>array(
		
				"User.id"=>$user_ids
		
			),
			"contain"=>array()
		
		));
		
		//compact the users
		$users = array();
		
		foreach($user_list as $user) {
			
			$users[$user['User']['id']] = $user['User'];
			
		}
		
		//let's get the featured matches 
		$fids = array();
		if(!empty($event['BatbEvent']['featured_match1_id'])) {
			
			$fids[] = $event['BatbEvent']['featured_match1_id'];
			
		}
		
		if(!empty($event['BatbEvent']['featured_match2_id'])) {
			
			$fids[] = $event['BatbEvent']['featured_match2_id'];
			
		}
		
		$featured_matches = array();
		
		if(count($fids)>0) {
			
			$featured_matches[] = $this->BatbEvent->BatbMatch->find("first",array(
		
				"conditions"=>array(
					"BatbMatch.id"=>$fids[0]
				),
				"contain"=>array()
			
			));
			$featured_matches[] = $this->BatbEvent->BatbMatch->find("first",array(
		
				"conditions"=>array(
					"BatbMatch.id"=>$fids[1]
				),
				"contain"=>array()
			
			));
			
		}
		
		$this->set(compact("event","users","featured_matches"));
		//page title
		$this->set("title_for_layout","U.S VS. THEM");
		
	}
	
	
	public function temp() {
		
		
		
	}
	
	
	
	
}

?>