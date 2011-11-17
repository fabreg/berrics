<?php

App::import("Controller","AdminApp");

class YounitedNationsEventsController extends AdminAppController {
	
	public $uses = array("YounitedNationsEvent");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}	
	
	public function index() {
		
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
		
		$event = $this->YounitedNationEvent->find("first",array(
			"conditions"=>array(
				"YounitedNationsEvent.id"=>$id
			),
			"contain"=>array()
		));
		
		$entries = $this->YounitedNationEvent->YounitedNationsEventEntry->find("all",array(
		
				"conditions"=>array(
					
				),
				"contain"=>array()
		
		));
		
		
		$this->set(compact("event"));
		
		
	}
	
}