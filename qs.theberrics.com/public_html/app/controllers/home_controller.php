<?php

App::import("Controller","QsApp");

class HomeController extends QsAppController {
	
	public $uses = array("User");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		
	}
	
	
	public function index() {
		
		$this->User->initPhotoshootValidation();
		
		if(count($this->data)>0) {
			
			$this->User->set($this->data);
			
			if($this->User->validates($this->data)) {
				
				//get the user id
				
				$u_chk = $this->User->find("first",array(
				
				"conditions"=>array(
					"User.email"=>$this->data['User']['email']
				),
				"contain"=>array()
				
					
				));
				
				$user_id = false;
				
				if(isset($u_chk['User']['id'])) {
					
					$user_id = $u_chk['User']['id'];
					
				} else {
					
					$this->User->save($this->data);
					
					$user_id = $this->User->id;
					
				}
				
				$this->User->UserProfile->ensureProfile($user_id);
				
				$profile = array(
				
					"shoe_size"=>$this->data['UserProfile']['shoe_size'],
					"geo_country"=>$_SERVER['GEOIP_COUNTRY_CODE'],
					"geo_region"=>$_SERVER['GEOIP_REGION'],
					"geo_region_name"=>$_SERVER['GEOIP_REGION_NAME'],
					"geo_city_name"=>$_SERVER['GEOIP_CITY']
				
				);
				
				$this->User->UserProfile->save($profile,array("UserProfile.user_id"=>$user_id));
				
				$this->Session->write("signup",true);
				
				$this->redirect("/");
				
			} else {
				
				
				
			}
			
			
		}
		
	}
	
}