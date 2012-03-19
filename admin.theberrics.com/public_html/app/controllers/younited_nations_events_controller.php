<?php

App::import("Controller","LocalApp");

class YounitedNationsEventsController extends LocalAppController {
	
	public $uses = array("YounitedNationsEvent");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}	
	
	public function index() {
		
		$this->paginate['YounitedNationsEvent']['contain'] = array();		
		$events = $this->paginate("YounitedNationsEvent");
		
		$this->set(compact("events"));
		
	}
	
	public function add() {
		
		if(count($this->data)>0) {
			
			if($this->YounitedNationsEvent->save($this->data)) {
				
				return $this->redirect("/younited_nations_events");
				
			}
			
		}
		
	}
	
	public function edit() {
		
		
		
	}
	
	public function view($id = false) {
		
		if(!$id) {
			
			return $this->cakeError("error404");
			
		}
		
		$this->loadModel("YounitedNationsEventEntry");
		
		$event = $this->YounitedNationsEvent->find("first",array(
			"conditions"=>array(
				"YounitedNationsEvent.id"=>$id
			),
			"contain"=>array()
		));
		
		
		$this->paginate['YounitedNationsEventEntry'] = array(
			
			"conditions"=>array(
				"YounitedNationsEventEntry.younited_nations_event_id"=>$id
			),
			"order"=>array(
				"YounitedNationsEventEntry.id"=>"DESC"
			),
			"limit"=>100,
			"contain"=>array(
				"YounitedNationsPosse"
			)
		
		);
		
		$entries = $this->paginate("YounitedNationsEventEntry");
		
		$this->set(compact("event","entries"));
		
		
	}
	
	
	public function view_entry($id = false) {
		
		$this->loadModel("YounitedNationsEventEntry");
		//get the entry and all the other stuff
		$entry = $this->YounitedNationsEventEntry->find("first",array(
			
			"conditions"=>array(
				"YounitedNationsEventEntry.id"=>$id
			),
			"contain"=>array(
				"YounitedNationsPosse"=>array(
					"YounitedNationsPosseMember",
					"User"
				)
			),
			
		
		));
		
		//get the media file uploads
		$this->loadModel("MediaFileUpload");
		
		$files = $this->MediaFileUpload->find("all",array(
		
			"conditions"=>array(
				"MediaFileUpload.model"=>"YounitedNationsEventEntry",
				"MediaFileUpload.foreign_key"=>$entry['YounitedNationsEventEntry']['id']
			),
			"contain"=>array()	
		
		));
		
		
		$this->set(compact("entry","files"));
		
		
	}
	
	public function confirm_delete() {
		
		
		
	}
	
	public function check_dupes() {
		
		//get all the whole shebang
		$this->loadModel("YounitedNationsEventEntry");
		$this->loadModel("YounitedNationsPosse");
		$this->loadModel("YounitedNationsPosseMember");
		
		$data = $this->YounitedNationsEventEntry->find("all",array(
		
			"conditions"=>array(),
			"contain"=>array(
				"YounitedNationsPosse"=>array(
					"YounitedNationsPosseMember"
				)
			)
		
		));
		
		$i = 0;
		
		$ids = array();
		
		foreach($data as $v) {
			
			if(count($v['YounitedNationsPosse']['YounitedNationsPosseMember'])>10) {
				
				$ids[] = $v['YounitedNationsPosse']['id'];
				
			} 
			
		}
		
		//let's query each one of these bastards
		foreach($ids as $id) {
			
			$data = $this->YounitedNationsPosseMember->find("all",array(
			
				"conditions"=>array(
					"YounitedNationsPosseMember.younited_nations_posse_id"=>$id
				),
				"contain"=>array(),
				"order"=>array("YounitedNationsPosseMember.id"=>"DESC"),
				"limit"=>"10"
			
			));
			
			foreach($data as $v) {
				
				$d = "delete from younited_nations_posse_members where id = '{$v['YounitedNationsPosseMember']['id']}'";
				$this->YounitedNationsPosse->query($d);
				pr($d);
			}
			
			//pr($data);
			
		}
		
		die();
	}
	
	public function disable_entry() {
		
		
	}
	
	
	
	
	
}