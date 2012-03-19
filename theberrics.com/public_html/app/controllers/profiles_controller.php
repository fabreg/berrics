<?php


App::import("Controller","LocalApp");

class ProfilesController extends LocalAppController {
	
	public $uses = array("User");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "profiles";
		
	}
	
	
	public function index() {
		
		
		
	}
	
	public function view() {
		
		$profile = $this->User->returnProfile(array(
		
			"User.profile_uri"=>$this->params['uri']
		
		));
		
		$this->set(compact("profile"));
		
	}
	
}