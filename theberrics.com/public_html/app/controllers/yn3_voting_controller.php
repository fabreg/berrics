<?php

App::import("Controller","Dailyops");

class Yn3VotingController extends DailyopsController { 

	public $uses = array("YounitedNationsEventEntry");
	
	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->theme = "yn3-finals";
		
		if($this->params['action'] == "index" || empty($this->params['action'])) {
			
			$this->params['action'] = "section";
			
		}
		
	}

	
	
	public function section() {
		
		//get the yn3 posts
		$this->setEntries();
		
		//get the votes
		$votes = array();
		
		if($this->Session->check("Auth.User.id")) {
			
			$this->loadModel("YounitedNationsVote");

			$v = $this->YounitedNationsVote->find("all",array(
				"conditions"=>array(
					"YounitedNationsVote.younited_nations_event_id"=>4,
					"YounitedNationsVote.user_id"=>$this->Session->read("Auth.User.id")
				),
				"contain"=>array()
			));
			
			foreach($v as $val) $votes[$v['YounitedNationsVote']['younited_nations_event_entry_id']] = $v; 
		}
		
		
		$this->set(compact("votes"));
		
	}
	
	public function place_vote($payload = false) {
		
		if(!$this->Session->check("Auth.User.id")) {
			
			$p = base64_encode(serialize($this->data));
			
			$uri = base64_encode($this->here."/".$p);
			
			return $this->redirect("/identity/login/send_to_facebook/".$uri);
			
		}
		
		if($payload) {
			
			$this->data = unserialize(base64_decode($payload));
			
		}
		
		if(count($this->data)>0) {
			
			$this->YounitedNationsVote->create();
			
			$this->YounitedNationsVote->save($this->data);
			
			return $this->redirect("/younited-nations-3");
			
		}
		
		
	}
	
	private function setEntries() {
		
		
		$token = "younited-nations-event-entries";
		
		if(($entries = Cache::read($token,"1min")) === false) {
			
			
					
			$entries = $this->YounitedNationsEventEntry->find("all",array(
				"conditions"=>array(
					"YounitedNationsEventEntry.younited_nations_event_id"=>4,
					"YounitedNationsEventEntry.finalist"=>1
				),
				"contain"=>array(
					"YounitedNationsPosse"=>array(
						"YounitedNationsPosseMember"
					)
				)
			));
			
			foreach($entries as $k=>$v) $entries[$k]['Post'] = $this->Dailyop->returnPost(array("Dailyop.id"=>$v['YounitedNationsEventEntry']['entry_dailyop_id']));
			
			Cache::write($token,$entries,"1min");
			
		}	

		$this->set(compact("entries"));
		
		return $entries;
		
	}
	
	

}