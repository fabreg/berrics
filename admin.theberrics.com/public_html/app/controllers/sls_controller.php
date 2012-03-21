<?php

App::import("Controller","LocalApp");

class SlsController extends LocalAppController {
	
	
	public $uses = array("SlsEntry","SlsVote");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	public function index() {
		
		$data = $this->paginate("SlsEntry");
		
		$this->set(compact("data"));
		
	}
	
	public function add_entry() {
		
		if(count($this->data)>0) {
			
			if($this->SlsEntry->save($this->data)) {
				
				$this->Session->setFlash("Street League Entry Added");
				
				return $this->redirect("/sls");
				
			}
			
		} 
		
	}
	
	public function edit_entry($id = false) {
		
		
	}
	
	public function view_votes() {
		
		
		
	}
	
	
}