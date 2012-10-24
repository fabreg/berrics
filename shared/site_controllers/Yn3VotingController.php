<?php

App::import("Controller","Dailyops");

class Yn3VotingController extends DailyopsController { 

	public $uses = array("YounitedNationsEventEntry");
	
	public $components = array("RequestHandler");
	
	private $pt = false;
	
	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->theme = "yn3-finals";
		
		if(in_array($this->request->params['action'],array("index","view")) || empty($this->request->params['action'])) {
			
		
			if($this->RequestHandler->isAjax()) {
				
				$this->request->params['action'] = "open_video";
				
			} else {
				
				$this->request->params['action'] = "section";
				
			}
		}
		
		if(isset($this->request->params['uri']) && !empty($this->request->params['uri'])) {
			
			$this->setPost();
			
		}
		
		if(preg_match('/\/dailyops/',$_SERVER['REQUEST_URI'])) {
			
			$this->get_full_date_nav();
			
			$dateIn = date("Y-m-d");
		
			$older_date = $this->Dailyop->getNextDate($dateIn);
			
			$newer_date = $this->Dailyop->getNextDate($dateIn,false);
			
			$this->set(compact("dateIn","newer_date","older_date"));
		}
		
	}
	
	private function setPost() {
		$this->loadModel("Dailyop");
		
		$post = $this->Dailyop->returnPost(array("Dailyop.uri"=>$this->request->params['uri'],"DailyopSection.id"=>66),$this->isAdmin());
		
		$this->pt = $post['Dailyop']['name']." ".$post['Dailyop']['sub_title'];
		
		$this->set(compact("post"));
		
	}
	
	public function open_video() {
		
		$this->layout = "ajax";
		
		$this->render("/elements/video-post");
		
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
			
			foreach($v as $val) $votes[$val['YounitedNationsVote']['younited_nations_event_entry_id']] = $val; 
		}
		
		if(!$this->pt) $this->pt = "Vans Presents: YOUnited Nations 3";
		
		$this->set("title_for_layout",$this->pt);
		
		$this->set(compact("votes"));
		
	}
	
	public function place_vote($payload = false) {
		
		if(!$this->Session->check("Auth.User.id")) {
			
			$p = base64_encode(serialize($this->request->data));
			
			$uri = base64_encode($this->request->here."/".$p);
			
			return $this->redirect("/identity/login/send_to_facebook/".$uri);
			
		}
		
		if($payload) {
			
			$this->request->data = unserialize(base64_decode($payload));
			
		}
		
		if(count($this->request->data)>0) {
			
			$this->loadModel("YounitedNationsVote");
			
			$chk = $this->YounitedNationsVote->find("count",array("conditions"=>array("YounitedNationsVote.user_id"=>$this->Session->read("Auth.User.id"))));
			
			if($chk<3) {
				
				$this->request->data['YounitedNationsVote']['user_id'] = $this->Session->read("Auth.User.id");
				
				$this->YounitedNationsVote->create();
				
				$this->YounitedNationsVote->save($this->request->data);
				
				sleep(1);
					
			}
			
			
			
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
	
	public function remove_vote() {
		
		if(!$this->Session->check("Auth.User.id") || count($this->request->data)<=0) throw new NotFoundException();
		
		$this->loadModel("YounitedNationsVote");
		$chk = $this->YounitedNationsVote->find("first",array(
			"contain"=>array(),
			"conditions"=>array(
				"YounitedNationsVote.id"=>$this->request->data['YounitedNationsVote']['id'],
				"YounitedNationsVote.user_id"=>$this->Session->read("Auth.User.id")
			)
		));
		
		if(isset($chk['YounitedNationsVote']['id'])) {
			
			
			$this->YounitedNationsVote->delete($chk['YounitedNationsVote']['id']);
			
			sleep(1);
			
		}
		
		return $this->redirect("/younited-nations-3");
		
	}
	
	public function close_votes() {
		
		if(!$this->Session->check("Auth.User.id")) throw new NotFoundException();
		
		
		$this->loadModel("YounitedNationsVote");
		
		$this->YounitedNationsVote->updateAll(
			array(
				"YounitedNationsVote.closed"=>1
			),
			array(
				"YounitedNationsVote.user_id"=>$this->Session->read("Auth.User.id")
			)
		);
		
		sleep(1);
		return $this->redirect("/younited-nations-3");
		
	}
	

}