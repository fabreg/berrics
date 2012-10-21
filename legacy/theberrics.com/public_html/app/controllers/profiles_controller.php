<?php


App::import("Controller","LocalApp");

class ProfilesController extends LocalAppController {
	
	public $uses = array("User");
	
	private $profile = false;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		$this->theme = "profiles";
		
		$this->setProfile();
		
	}
	
	
	public function index() {
		
		
		
	}
	
	public function view() {
		
		
		
	}
	
	public function instagram() {
		
		$this->loadModel("InstagramImageItem");
		
		$instagram = $this->InstagramImageItem->returnInstagramRecent($this->profile['User']);
		
		$this->set(compact("instagram"));
		
	}
	
	private function setProfile() {
		
		if(isset($this->params['uri'])) {
			
			$profile = $this->User->returnProfile(array(
		
				"User.profile_uri"=>$this->params['uri']
			
			));
			$this->profile = $profile;
			$this->set(compact("profile"));
			
		}
		
		
		if(
			!isset($this->params['uri']) || 
			!isset($profile['User']['id'])	
		) return $this->cakeError("error404");
		
		
	}
	
}