<?php

class HomeController extends AppController {
	
	
	public $uses = array("User");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	
	
	public function index() {
		
		return $this->redirect("/home/confirm_email/");
		
		if($this->Session->read("signup") == 1) {
			
			$this->Session->setFlash("Thanks for signing up. You'll receive an email confirmation in a few days.");
			
		}
		
		$this->User->initPhotoshootValidation();
		
		if(count($this->data)>0) {
			
			$this->data['User']['photoshoot'] = 1;
			$this->data['User']['country'] = $_SERVER['REDIRECT_GEOIP_COUNTRY_CODE'];
			$this->data['User']['province'] = $_SERVER["REDIRECT_GEOIP_REGION_NAME"];
			$this->data['User']['user_group_id'] = 60;
			
			if($this->User->save($this->data)) {
				
				$this->Session->setFlash("Thanks for signing up! We'll send you a confirmation email in a few days");
				return $this->redirect("/confirmation");
				
			} else {
				
				$this->Session->setFlash("Please make sure you filled out the form correctly");
				
				
			}
			
		}
		
	}
	
	
	public function confirmation() {
		
		$this->Session->write("signup",1);
		
	}
	
	
	public function send_to_facebook() {
		
		$fb = FacebookApi::instance();
		
		$fb->facebook->getSession();
		
		return $this->redirect($fb->facebook->getLoginUrl(array("next"=>"http://photoshoot.theberrics.com/handle_facebook_callback","req_perms"=>"email,publish_stream,user_about_me")));
		
	}
	
	public function handle_facebook_callback() {
		
		
		$fb = FacebookApi::instance();
		
		$fb->facebook->getSession();
		
		$data = $fb->facebook->api("/me");
		
		//die(pr($data));
		
		$this->data['User']['photoshoot'] = 1;
		$this->data['User']['country'] = $_SERVER['REDIRECT_GEOIP_COUNTRY_CODE'];
		$this->data['User']['province'] = $_SERVER["REDIRECT_GEOIP_REGION_NAME"];
		$this->data['User']['first_name'] = $data['first_name'];
		$this->data['User']['last_name'] = $data['last_name'];
		$this->data['User']['email'] = $data['email'];
		$this->data['User']['facebook_account_num'] = $data['id'];
		$this->data['User']['user_group_id'] = 60;
		
		$this->User->save($this->data);
		
		$this->redirect("/confirmation");
		
	}
	
	public function signups() {
		
		$this->paginate = array(
		
			"conditions"=>array(
		
				"User.photoshoot"=>1
		
			),
			"order"=>array("User.created"=>"DESC")
		
		);
		
		$users = $this->paginate("User");
		
		$this->set(compact("users"));
		
	}
	
	public function confirm_email() {
		
		$this->loadModel("PhotoshootConfirmation");
		$this->loadModel("User");
		if(count($this->data)>0) {
			
			//check user
			$user = $this->User->find("first",array("conditions"=>array("User.email"=>$this->data['User']['email']),"contain"=>array()));
			
			if(isset($user['User']['id'])) {
				
				$check = $this->PhotoshootConfirmation->findByUserId($user['User']['id']);
				
				if(!isset($check['PhotoshootConfirmation']['id'])) {
					
					
									
				$this->PhotoshootConfirmation->create();
				$this->PhotoshootConfirmation->save(array(
				
					"user_id"=>$user['User']['id']
				
				));
					
				}

				
				$this->Session->setFlash("You've been confirmed!");
				return $this->redirect("/home/email_confirmed");
				
			} else {
				
				$this->Session->setFlash("Sorry, but you do not qualify to go to the photoshoot");
				
			}
			
		}
		
		
		//check to see if we have 500
		
		
		$count = $this->PhotoshootConfirmation->find("count");
		
		if($count>=500) {
			
			return $this->redirect("/home/sorry/");
			
		}
		
	}
	
	public function sorry() {
		
		$this->Session->setFlash("Sorry, we already have enough people for the photoshoot.");
		
	}
	
	public function email_confirmed() {
		
		
		
	}
	
	
	
}


?>