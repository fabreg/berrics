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

	public function batb_login() {
		
		
		
	}
	
	public function logout($callback = false) {
		
		$this->Auth->logout();
		
		$uri = "/";
		
		if($callback) {
			
			$uri = base64_decode($callback);
			
		}
		
		return $this->redirect($uri);
		
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

		return $this->redirect("/");
		
		
	}
	
	private function authAccount() {
		
		$this->Session->write("Auth.User",$this->userAccount['User']);
		
	}
	
}