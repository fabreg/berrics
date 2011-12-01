<?php

App::import("Controller","AdminApp");

class UserContestsController extends AdminAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		$data = $this->paginate("UserContest");
		
		$this->set(compact("data"));
		
	}
	
	public function add() {
		
		if(count($this->data)>0) {
			
			if($this->UserContest->save($this->data)) {
				
				$this->Session->setFlash("Contest has been created");
				return $this->redirect("/user_contests");
				
			} else {
				
				$this->Session->setFlash("There was an error while saving the event. Please try again.");
				
			}
			
		}
		
	}
	
	public function edit($id = false) {
		
		if(!$id) {
			
			$this->Session->setFlash("Invalid URL");
			
			return $this->redirect("/user_contests");
			
		}
		
		//handle the save
		if(count($this->data)>0) {
			
			
		} else {
			
			$this->data = $this->UserContest->find("first",array(
			
				"conditions"=>array(
					"UserContest.id"=>$id
				),
				"contain"=>array()
			
			));
			
			
		}
		
		
		
		
	}
	
	public function view($id = false) {
		
		
		
	}
	
	public function view_entry($id = false) {
		
		
		
	}
	
	
	
}