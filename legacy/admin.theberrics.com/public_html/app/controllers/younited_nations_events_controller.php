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
	
	public function search_entries($id) {
		
		$url = array(
		
			"action"=>"view",
			"s"=>true,
			$id
			
		);
		
		
		foreach($this->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
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
				"YounitedNationsEventEntry.finalist"=>"DESC"
			),
			"limit"=>100,
			"contain"=>array(
				"YounitedNationsPosse"
			)
		
		);
		
		
				
		
		if(isset($this->params['named']['s'])) {
			
			
			if(isset($this->params['named']['YounitedNationsPosse.name'])) {
				
				
				$this->data['YounitedNationsPosse'] = $this->params['named']['YounitedNationsPosse.name'];
				
				$this->paginate['YounitedNationsEventEntry']['conditions']['YounitedNationsPosse.name LIKE'] = "%".str_replace(" ","%",$this->params['named']['YounitedNationsPosse.name'])."%";
				
			}
			
			
		}
		
		
		
		$entries = $this->paginate("YounitedNationsEventEntry");
		
		$this->set(compact("event","entries"));
		
		
	}
	
	
	public function view_entry($id = false) {
		
		
		$this->loadModel("YounitedNationsEventEntry");
		
		if(count($this->data)>0) {
			
			$this->YounitedNationsEventEntry->create();
			
			$this->YounitedNationsEventEntry->id = $this->data['YounitedNationsEvenEntry']['id'];
			
			$this->YounitedNationsEventEntry->save($this->data);
			
			$this->Session->setFlash("Entry Updated");
			
			return $this->redirect(base64_decode($this->params['named']['callback']));
			
		}
		
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
		
		//get all the younited nations three posts
		
		
		$this->loadModel("Dailyop");
		
		
		$p = $this->Dailyop->find("all",array(
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>66
			),
			"contain"=>array()
		));
		
		$posts = array();
		
		foreach($p as $v) $posts[$v['Dailyop']['id']] = $v['Dailyop']['name']." - ".$v['Dailyop']['sub_title'];
		
		$this->set(compact("entry","files","posts"));
		
		$this->data = $entry;
		
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