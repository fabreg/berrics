<?php

App::import("Vendor","FacebookApi",array("file"=>"facebook_api.php"));

class LoginController extends IdentityAppController {
	
	
	public $uses = array("User");
	
	private $userAccount = false;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function index() {
		
		
		
	}
	
	public function logout($callback = false) {
	
		$this->Auth->logout();
	
		$uri = "/";
	
		if($callback) {
				
			$uri = base64_decode($callback);
				
		}
	
		return $this->redirect($uri);
	
	}
	

	public function batb_login() {
		
		
		
	}
	
	
	
	public function send_to_facebook($callback_after = false) {
		
		$fb = FacebookApi::instance();
		
		$fb->facebook->getSession();
		
		$next_domain = "http://".$_SERVER['SERVER_NAME'];
		
		if(!$callback_after) {
			
			$callback_after = '';
			
		}
		
		return $this->redirect($fb->facebook->getLoginUrl(array("next"=>$next_domain."/identity/login/handle_facebook_callback/".$callback_after,"req_perms"=>"email,publish_stream,user_about_me")));
		
	}
	
	public function handle_facebook_callback($callback = false) {
		
		$fb = FacebookApi::instance();

		$fb_session = $fb->facebook->getSession();

		$fb_user = $fb->facebook->api("/me");

		$fb_data = array(
		
			"facebook_account_num" => $fb_user['id'],
			"first_name"=>$fb_user['first_name'],
			"last_name"=>$fb_user['last_name'],
			"email"=>$fb_user['email'],
			"profile_image_url"=>"http://graph.facebook.com/".$fb_user['id']."/picture"
		
		);
		
		if($callback) {
			
			$callback = base64_decode($callback);
			
		}
		
		if($this->Session->check("here") && !$callback) {
			
			$callback = $this->Session->read("here");
			
		}
		
		if(empty($callback) || !$callback) {
			
			$callback = "/";
			
		}
		
		$this->userAccount = $this->User->locateLoginAccount($fb_data);
		
		$this->authAccount();

		return $this->redirect($callback);

	}
	
	public function send_to_twitter() {
		
		
		
	}
	
	public function handle_twitter_callback() {
		
		
		
	}
	
	public function email_login() {
		
		$login = $this->Auth->login($this->data);

		$goto = "/";
		
		if($this->Session->check("here")) $goto = $this->Session->read("here");
		
		return $this->redirect($goto);
		
		
	}
	
	private function authAccount() {
		
		$this->Session->write("Auth.User",$this->userAccount['User']);
		
	}
	
	/*
	 * LOGIN SCREEN STUFF
	 */
	
	
	public function ajax_login_screen() {
		
		
		
	}
	
	public function ajax_register_screen() {
		
		
		
	}
	
	public function form() {
		
		
		
	}
	
	public function register() {
		
		if(count($this->data)>0) {
			
			$this->User->setRegistrationValidation();
			
			$this->User->set($this->data);
			
			if($this->User->validates()) {
				
				//die(print_r($this->User->invalidFields()));
				
			}
			
		}
		
		
	}
	
	
	public function reset_password() {
		
		if(count($this->data)>0) {
			
			$this->loadModel("UserPasswdReset");
			
			if(
				($user = $this->UserPasswdReset->process_reset_reqeust($this->data['User']['email']))
			) {
				
				$this->Session->setFlash("An email has been sent to you with a link to reset your password. It may take a few minutes to reach your inbox");
				
			} else {
				
				$this->Session->setFlash("Unable to locate an active account");
				
			}
			
		}
		
	}
	
	public function password_reset($user_id=false,$hash=false) {
		
		if(!$user_id || !$hash) return $this->cakeError("error404");
		
		$this->loadModel("UserPasswdReset");
		
		
		
		$record = $this->UserPasswdReset->find("first",array(
					"conditions"=>array(
								"UserPasswdReset.hash"=>$hash,
								"UserPasswdReset.user_id"=>$user_id
							)
				));
		
		if(empty($record['User']['id'])) return $this->cakeError("error404");
		
		if(count($this->data)>0) {
				
			if($this->data['User']['passwd'] == $this->data['User']['passwd_confirm']) {
					
				$this->loadModel("User");
				
				$this->User->create();
				
				$this->User->id = $record['User']['id'];
				
				$this->User->save(array("passwd"=>$this->Auth->password($this->data['User']['passwd'])));
				
				$this->UserPasswdReset->create();
				
				$this->UserPasswdReset->id = $record['UserPasswdReset']['id'];
				
				$this->UserPasswdReset->save(array("active"=>0));
				
				$record['UserPasswdReset']['active'] = 0;
				
			}
				
		}
		
		$this->set(compact("record"));
		
	}
	
	
	
	
	
	
	
	
}