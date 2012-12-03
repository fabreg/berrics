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
		
		//$fb->facebook->getSession();
		
		$next_domain = "http://".$_SERVER['SERVER_NAME'];
		
		if(!$callback_after) {
			
			$callback_after = '';
			
		} else {

			CakeSession::write("here",base64_decode($callback_after));

		}

		//die(print_r($fb->facebook->getLoginUrl(array("next"=>$next_domain."/identity/login/handle_facebook_callback/".$callback_after,"req_perms"=>"email,publish_stream,user_about_me"))));
		
		if(isset($_GET['code'])) {

			return $this->handle_facebook_callback();

		}

		return $this->redirect($fb->facebook->getLoginUrl(array("next"=>$next_domain."/identity/login/handle_facebook_callback/".$callback_after,"req_perms"=>"email,publish_stream,user_about_me")));
		
	}
	
	public function handle_facebook_callback($callback = false) {
		
		$fb = FacebookApi::instance();


		//$fb_session = $fb->facebook->getSession();

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
	
	public function send_to_instagram($callback_after = false) {
		
		if(!$this->Session->check("Auth.User.id")) {
			
			return $this->cakeError("error404");
			
		}
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
		
		if($callback_after) {
			
			$this->Session->write("Instagram.login_callback",base64_decode($callback_after));
			
		}
		
		$i = InstagramApi::instance();
		
		$i->instagram->openAuthorizationUrl();
		
		
	}
	
	public function handle_instagram_callback() {
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
	
		$i = InstagramApi::instance();
		
		$currentUser = $i->instagram->getCurrentUser();
		
		$accessToken = $i->instagram->getAccessToken();
		
		$ud = array(
					"instagram_oauth_token"=>$accessToken,
					"instagram_handle"=>$currentUser->username,
					"instagram_account_num"=>$currentUser->id,
					"instagram_profile_image"=>$currentUser->profile_image
				);
		
		$this->User->create();
		
		$this->User->id = $this->Session->read("Auth.User.id");
		
		$this->User->save($ud);
		
		$user = $this->User->returnUserProfile($this->Session->read("Auth.User.id"),true);
		
		$this->Session->write("Auth.User",$user['User']);
		
		$callback = "/";
		
		if($this->Session->check("Instagram.login_callback")) {
				
			$callback = $this->Session->read("Instagram.login_callback");
			$this->Session->delete("Instagram.login_callback");
				
		}
		
		$this->redirect($callback);
		
	}
	
	public function email_login() {
		
		$login = $this->Auth->login();

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
	
	public function form($cb = false) {
		
		if(count($this->data)>0) {
			
			if($this->Auth->login()) {
				
				$user = $this->Session->read("Auth.User");
				
				if($user['email_verified']!=1) {
					
					$this->Session->delete("Auth");
					$callback = "/identity/login/email_not_verified/".$user['id']."/".$user['account_hash'];
					
				} else {
					
					$callback = $this->Session->read("here");
						
					if(empty($callback)) {
					
						$callback = "/";
					
					}
					
				}
				
				$res = array("url"=>$callback);
				
				
			} else {
				
				$res = array("error"=>"Unable to login. Please try again");
				
			}

			die(json_encode($res));
			
		}
		
		if($cb) {
			
			$this->Session->write("here",base64_decode($cb));
			
		}
		
		
		
	}
	
	public function register() {
		
		if(count($this->data)>0) {
			
			$this->User->setRegistrationValidation();
			
			$this->User->set($this->data);
			
			if($this->User->validates()) {
				
				$this->data['User']['passwd'] = $this->Auth->password($this->data['User']['new_passwd']);
				
				$res = $this->User->processUserFormRegistration($this->data);
				
				if(!$res) { //this indicates the email address is registered and verified
					
					$this->Session->setFlash("This email address has already been registered and verified");
					$this->redirect(array(
								
							"plugin"=>"identity",
							"action"=>"form",
							"controller"=>"login",
							$res['User']['id'],
							$res['User']['account_hash']
								
					));
					
				} else { //email has been sent, tell them to confirm
					
					$this->redirect(array(
							
								"plugin"=>"identity",
								"action"=>"registration_success",
								"controller"=>"login",
								$res['User']['id'],
								$res['User']['account_hash']
							
							));
					
				}
				
			}
			
		}
		
	}
	
	public function reset_password() {
		
		if(count($this->data)>0) {
			
			$this->loadModel("UserPasswdReset");
			
			if(
				(!empty($this->data['User']['email'])) && 
				($user = $this->UserPasswdReset->process_reset_reqeust($this->data['User']['email']))
			) {
				
				$this->Session->setFlash("An email has been sent to you with a link to reset your password. It may take a few minutes to reach you. Also check your junk email folder and approve theberrics.com for future emails.");
				
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
			
			if(
					strlen($this->data['User']['new_passwd']) >=6 && 
					($this->data['User']['new_passwd'] == $this->data['User']['passwd_confirm'])
					) {
				
				$this->loadModel("User");
				
				$this->User->create();
				
				$this->User->id = $record['User']['id'];
				
				$this->User->save(array("passwd"=>$this->Auth->password($this->data['User']['new_passwd'])));
				
				$this->UserPasswdReset->create();
				
				$this->UserPasswdReset->id = $record['UserPasswdReset']['id'];
				
				$this->UserPasswdReset->save(array("active"=>0));
				
				$record['UserPasswdReset']['active'] = 0;
				
			} else {
			
				$this->Session->setFlash("Please make sure your passwords match and that your password is at least 6 characters.");
				$this->data['User'] = array();
			}
				
		}
		
		$this->set(compact("record"));
		
	}
	
	public function email_not_verified($user_id = false,$hash = false) {
		
		if(!$user_id || !$hash) return $this->cakeError("error404");
		
		$user = $this->User->find("first",array(
					"conditions"=>array(
								"User.id"=>$user_id,
								"User.account_hash"=>$hash
							),
					"contain"=>array()
				));
		if(empty($user['User']['id'])) {
				
			return $this->cakeError("error404");
				
		}
		$this->set(compact("user"));
		
	}
	
	public function resend_verification($user_id=false,$hash=false) {
		
		if(!$user_id || !$hash) return $this->cakeError("error404");
		
		$this->loadModel("EmailMessage");
		
		$user = $this->User->find("first",array(
				"conditions"=>array(
						"User.id"=>$user_id,
						"User.account_hash"=>$hash
				),
				"contain"=>array()
		));
		
		if(empty($user['User']['id'])) {
			
			return $this->cakeError("error404");
			
		}
		
		$this->EmailMessage->userEmailConfirmation($user['User']);
		
		return $this->redirect("/identity/login/confirmation_resent/".$user['User']['id']."/".$user['User']['account_hash']);
		
	}
	
	
	public function verification_resent($user_id=false,$hash=false) {
		
		if(!$user_id || !$hash) return $this->cakeError("error404");
		
		$user = $this->User->find("first",array(
				"conditions"=>array(
						"User.id"=>$user_id,
						"User.account_hash"=>$hash
				),
				"contain"=>array()
		));
		
		if(empty($user['User']['id'])) {
				
			return $this->cakeError("error404");
				
		}
		
		$this->set(compact("user"));
		
	}
	
	public function verify_account($user_id = false,$hash = false) {
		
		if(!$user_id || !$hash) return $this->cakeError("error404");
		
		$user = $this->User->find("first",array(
				"conditions"=>array(
						"User.id"=>$user_id,
						"User.account_hash"=>$hash
				),
				"contain"=>array()
		));
		
		if(empty($user['User']['id'])) {
			
			return $this->cakeError("error404");
		
		}
		
		$this->User->create();
		
		$this->User->id = $user['User']['id'];
		
		$this->User->Save(array("email_verified"=>1));
		
		$this->Auth->login($user);
		
		return $this->redirect(array(
					"plugin"=>"identity",
					"controller"=>"login",
					"action"=>"verify_success"
				));
		
	}
	
	public function verify_success() {
		
		
		
	}
	
	
	public function registration_success($user_id = false,$hash = false) {
		
		if(!$user_id || !$hash) return $this->cakeError("error404");
		
		$user = $this->User->find("first",array(
				"conditions"=>array(
						"User.id"=>$user_id,
						"User.account_hash"=>$hash
				),
				"contain"=>array()
		));
		
		if(empty($user['User']['id'])) {
			
			return $this->cakeError("error404");
		
		}
		
		$this->set(compact("user"));
		
		
	}
	
	public function confirmation_resent($user_id = false,$hash = false) {
		
		if(!$user_id || !$hash) return $this->cakeError("error404");
		
		$user = $this->User->find("first",array(
				"conditions"=>array(
						"User.id"=>$user_id,
						"User.account_hash"=>$hash
				),
				"contain"=>array()
		));
		
		if(empty($user['User']['id'])) {
				
			return $this->cakeError("error404");
		
		}
		
		$this->set(compact("user"));
		
		
	}
	
	
	
	
	
	
	
}