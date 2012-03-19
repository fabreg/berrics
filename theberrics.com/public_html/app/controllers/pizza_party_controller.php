<?php

App::import("Controller","LocalApp");


class PizzaPartyController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();

		$this->Auth->allow("*");
		
	}
	
	public function index() {
		
		if($this->confirm_user()) {
			
			$this->loadModel("User");
			
			$user = $this->User->find("first",array(
			
				"conditions"=>array(
					"User.id"=>$this->Auth->user("id")
				),
				"contain"=>array(
					"UserProfile"
				)
			
			));
			
			$this->confirm_entry($user['User']['id']);
			
		} else {
			
			$user = false;
			
		}
		
		$this->set(compact("user"));
		
	}
	
	
	private function confirm_user() {
	
		$this->loadModel("User");
		
		//get the persons profile
		
		$user = $this->User->find("first",array(
		
			"conditions"=>array(
				"User.id"=>$this->Auth->User("id")
			)
		
		));
		
		$profile = $this->User->ensure_user_profile($user['User']['id']);
		
		$sql = "SELECT current_location FROM user where uid=me()";

		//$sql = "SELECT hometown_location FROM user WHERE uid='1383222383'";
		
		$location = FacebookApi::instance()->facebook->api(array(
			
			"method"=>"fql.query",
			"query"=>$sql,
			"format"=>"json"
		
		));
		
		
		$loc = $location[0]['current_location'];
		
		if(count($loc)<=0) {
			
			return false;
			
		}
		
		//die(print_r($location));
		
		//update the users profile location
		
		$this->User->UserProfile->create();
		$this->User->UserProfile->id = $profile['UserProfile']['id'];
		
		$update = array();
		
		if(isset($loc['country'])) $update['geo_country_name'] = $loc['country'];
		if(isset($loc['city'])) $update['geo_city_name'] = $loc['city'];
		if(isset($loc['state'])) $update['geo_region_name'] = $loc['state'];
		
		return $this->User->UserProfile->save($update);
		
	}
	
	public function signup() {
		
		
		//return $this->redirect("/identity/login/send_to_facebook/".base64_encode("/pizza_party"));
		
		
	}
	
	
	public function confirm_entry($user_id = false) {
		
		if(!$user_id) return $this->cakeError("error404");
		
		$this->loadModel("UserContest");
		
		//id for the pizza party
		
		$id = 5;
		
		///check to see if the person has already entered and if they didn't let's insert a new contest entry row
		
		$check = $this->UserContest->UserContestEntry->find("count",array(
		
			"conditions"=>array(
		
				"UserContestEntry.user_contest_id"=>$id,
				"UserContestEntry.user_id"=>$user_id		
		
			)
		
		));
		
		if($check<=0) {
			
			//not found; let's insert a new contest entry
			$this->UserContest->UserContestEntry->create();
			$this->UserContest->UserContestEntry->save(array(
			
				"user_contest_id"=>$id,
				"user_id"=>$user_id
			
			));
			
		}
		
	}
	
	
	
	
	
	
}