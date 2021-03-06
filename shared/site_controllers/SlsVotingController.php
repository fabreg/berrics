<?php

App::import("Controller","Dailyops");

class SlsVotingController extends DailyopsController {
	
	
	public $uses = array("SlsEntry","SlsVote");
	
	public $components = array("RequestHandler");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "sls-voting";
		
		if($this->request->params['action'] == "view") {
			
			if($this->RequestHandler->isAjax()) {
				
				$this->request->params['action'] = "open_video";
				
			} else {
				
				$this->request->params['action'] = "section";
				
			}
			
			
		}
		
		if(isset($this->request->params['uri']) && !empty($this->request->params['uri'])) {
			
			$p = $this->setPost();
			
			$this->setFacebookMetaImg($p['DailyopMediaItem'][0]['MediaFile']);
			
		}
		
		if(preg_match('/\/dailyops/',$_SERVER['REQUEST_URI'])) {
			
			$this->get_full_date_nav();
			
		}
			
		
	}
	
	public function section() {
		
		//get all the entires
		$entries = $this->SlsEntry->returnEntries();
		
		$votes = array();
		
		//check for votes
		if($this->Session->check("Auth.User.id")) {
			
			$v = $this->SlsVote->find("all",array(
				"conditions"=>array(
					"SlsVote.user_id"=>$this->Session->read("Auth.User.id")
				),
				"contain"=>array()
			));
			
			foreach($v as $val) $votes[] = $val['SlsVote']['sls_entry_id'];
			
		}
		
		$meta_d = "You've heard of the 'sponsor me' tape, right? Well guess what? The Selection is that on steroids. Street League has 5 open slots and these 10 guys each put together an edit of new and unseen footage in hopes to be selected as one of 2012's newest Street League pros. Watch their videos, and pick your top 5. Their fate is in your hands and our panel of Street League Pro's";
		
		$this->set(compact("entries","votes","meta_d"));
		
		
		$dateIn = date("Y-m-d");
		
		$older_date = $this->Dailyop->getNextDate($dateIn);
		
		$newer_date = $this->Dailyop->getNextDate($dateIn,false);
		
		$this->set(compact("dateIn","newer_date","older_date"));
		
		$this->view = "section";
		
		
	}
	
	public function view() {
		
		
		
	}
	
	private function setPost() {
		
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array(
			"Dailyop.uri"=>$this->request->params['uri'],
			"DailyopSection.uri"=>$this->request->params['section']
		),$this->isAdmin());
		
		$this->set(compact("post"));
		
		return $post;
		
	}
	
	public function open_video() {
		
		$this->layout = "ajax";
		
		$this->render("/Elements/video-post");
		
	}
	
	public function place_vote($enc = false) {
		
		
		
		if(!$this->Session->check("Auth.User.id")) {
			
			//encode the vote
			$enc = base64_encode(serialize($this->request->data));
			
			$uri = "/".$this->request->params['section']."/".$this->request->params['action']."/".$enc;
			
			$uri = base64_encode($uri);
			
			return $this->redirect("/identity/login/send_to_facebook/{$uri}");
			
		} elseif($this->Session->check("Auth.User.id")) {
			
			if($enc) $this->request->data = unserialize(base64_decode($enc));

			//place the vote if the users doesn't have five already
			$check = $this->SlsVote->find("count",array(
				"conditions"=>array(
					"SlsVote.user_id"=>$this->Session->read("Auth.User.id")
				)
			));
			
			if($check>=5) {
				
				//can't vote
				
			} else {
				
				//place vote
				
				$this->SlsVote->place_vote($this->Session->read("Auth.User.id"),$this->request->data['SlsVote']['sls_entry_id']);
				
				
				
			}
			
			return $this->redirect("/".$this->request->params['section']."?".time());
			
		}
		
		throw new NotFoundException();
		
		
		
	}
	
	public function delete_vote() {
		
		$id = base64_decode($this->request->data['SlsVote']['id']);
		
		$chk = $this->SlsVote->find("first",array(
			"conditions"=>array(
				"SlsVote.user_id"=>$this->Session->read("Auth.User.id"),
				"SlsVote.sls_entry_id"=>$id
			),
			"contain"=>array()
		));
		
		if(isset($chk['SlsVote']['id'])) {
			
			$this->SlsVote->delete($chk['SlsVote']['id']);
			
		}
		
		return $this->redirect("/".$this->request->params['section']);
		
	}
	
	
}