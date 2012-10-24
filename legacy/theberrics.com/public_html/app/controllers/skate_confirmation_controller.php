<?php

App::import("Controller","LocalApp");

class SkateConfirmationController extends LocalAppController {
	

	public $uses = array("User");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		$this->initPermissions();
		$this->Auth->allow("*");
		
	}
	
	public function index() {
		
		$user = false;
		
		if($this->Session->check("Auth.User.id")) {
			
			$this->User->ensure_user_profile($this->Session->read("Auth.User.id"));
			
			$user = $this->User->find("first",array(
			
				"contain"=>array("UserProfile"),
				"conditions"=>array("User.id"=>$this->Session->read("Auth.User.id"))
			
			));
			
		}
		
		$this->set(compact("user"));
		
		
	}
	
	public function confirmation() {
		
		$this->loadModel("User");
		
		if($this->Session->check("Auth.User.id")) {
			
			$profile = $this->User->ensure_user_profile($this->Session->read("Auth.User.id"));
			
			$this->User->UserProfile->id = $profile['UserProfile']['id'];
			
			$this->User->UserProfile->save(array("westchester_confirmation"=>1));
			
		}
		
		return $this->redirect("/skate_confirmation");
		
		
	}
	
}