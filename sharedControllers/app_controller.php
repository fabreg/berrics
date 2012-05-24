<?php


App::import("Vendor","FacebookApi",array("file"=>"facebook_api.php"));
App::import("Vendor","Tools",array("file"=>"Tools.php"));
App::import("Vendor","Arr",array("file"=>"arr.php"));
App::import("Vendor","Lang",array("file"=>"Lang.php"));
App::import("Vendor","SysMsg",array("file"=>"SysMsg.php"));

class AppController extends Controller {

	####################################
	# ACL STUFF
	####################################
	/**
	 * Configure the App name that ACL permissions will search for
	 * @var String
	 */
	public $app_name = '';
	public $user_id_scope;
	public $user_group_id;
	private $is_admin = false;
	private $auth_user_id = false;
	private $auth_user_group_id = false;
	public $skip_page_view = false;
	//public $cacheAction = "1 Minute";
	###################################
	
	public $helpers = array("Html","Form","Session","Time","Thumb","Media","Text","Number");
	
	public $components = array("RequestHandler","Session","Auth");
	
	/**
	 * Setup the Auth component and deny all access to controller actions
	 * @see public_html/cake/libs/controller/Controller#beforeFilter()
	 */
	public function beforeFilter(/*POLYMORPHIC*/) {
		
        $this->Auth->authorize = 'controller';
        $this->Auth->loginAction = array('controller' => 'login', 'action' => 'index','plugin'=>'identity');
        $this->Auth->logoutRedirect = "/";
        $this->Auth->loginRedirect = "/";
		$this->Auth->fields=array(
			
			"username"=>"email",
			"password"=>"passwd"
			
		);
		
		//put the current URL in the session
		if(!in_array(strtolower($this->params['controller']),array("login","img","media"))) {
			
			$this->Session->write("here",$_SERVER['REQUEST_URI']);
			
		}
		
		$this->Auth->deny("*");
		
		if($this->Session->id()=='undefined') $this->Session->destroy();
		
		if(
			(!preg_match('/^(https)/',$_SERVER['SCRIPT_URI']) && !preg_match('/(dev)/',$_SERVER['SERVER_NAME'])) || 
			(preg_match('/(127\.0\.0\.1)/',$_SERVER['HTTP_X_FORWARDED_FOR']))
			) 
		{
			
			$_SERVER['HTTPS'] = false;
			
		} else {
			
			$_SERVER['HTTPS'] = true;
			
		}
		
	}

	/**
	 * Initialize the Authentication variables
	 * @return void
	 */
	private function initAuthVariables() {
		
		if($this->Auth->user("user_group_id")) {
			
			$this->auth_user_group_id = $this->Auth->user("user_group_id");
			
		}
		
		if($this->Auth->user("id")) {
			
			$this->auth_user_id = $this->Auth->user("id");
			$this->user_id_scope = $this->Auth->user("id");
			$this->Session->write("user_id_scope",$this->Auth->User("id"));
			
		}
		
		if($this->Auth->user("parent_id")) {
			
			$this->user_id_scope = $this->Auth->user("parent_id");
			$this->Session->write("user_id_scope",$this->Auth->User("parent_id"));
		}
		
		if($this->Auth->user("user_group_id")==10) {
			
			$this->setAdmin(true);
			
		} else {
			
			$this->setAdmin(false);
			
		}
		
	}
	
	
	/**
	 * Accessor to set if the users scope is "admin"
	 * @param Bool $is_admin
	 * @return void
	 */
	public function setAdmin($is_admin = false) {
		
		if($is_admin) {
			
			$this->is_admin=true;
			$this->Session->write("is_admin",true);
			
		} else {
			
			$this->is_admin=false;
			if($this->Session->check("is_admin") && $this->Session->read("is_admin")==1) {
				
				$this->Session->write("is_admin",false);
				
			}
			
			
		}
		
		
	}
	
	/**
	 * Check if user is in admin mode
	 * @return bool
	 */
	public function isAdmin() {
		
		return $this->is_admin;
		
	}
	
	/**
	 * This method will initialize our database managed ACL
	 * First we will check the users group access
	 * the we will check the user_id access rights
	 * @return void
	 */
	public function initPermissions($second = false) {

		$this->initAuthVariables();
		
		$this->loadModel("UserPermission");
		
		$controller = $this->name;
		
		$action = $this->params['action'];

		
		//load in the group permission actions
		$group_token ="group_perms_".$this->app_name."_".$this->auth_user_group_id."_".$controller;
		
		
		if(($group_perms = Cache::read($group_token,"1min")) === false) {
			
			$group_perms = $this->UserPermission->find("all",array(
		
				"conditions"=>array(
			
					"UserPermission.app_name"=>$this->app_name,
					"UserPermission.user_group_id"=>$this->auth_user_group_id,
					"UserPermission.controller"=>array("*",$controller)
			
				),
				"order"=>array("UserPermission.action"=>"ASC"),
				"contain"=>array()
			
			));
			//die($this->render("/elements/sql_dump"));
			
			Cache::write($group_token,$group_perms,"1min");
			
		} 
		
		//die(print_r($this->auth_user_group_id));

			
		foreach($group_perms as $v) {
			
			if($v['UserPermission']['allowed']) {
				
				$this->Auth->allow($v['UserPermission']['action']);
				
			} else {
				
				$this->Auth->deny($v['UserPermission']['action']);
				
			}
			
		}
		
		//load permissions for the user 
		if($this->auth_user_id) {
			
			$user_token = "user_perms_".$this->app_name."_".$this->auth_user_id."_".$controller;
			
			if(($user_perms = Cache::read($user_token,"1min")) === false) {
				
				$user_perms = $this->UserPermission->find("all",array(
			
					"conditions"=>array(
				
						"UserPermission.app_name"=>$this->app_name,
						"UserPermission.user_id"=>$this->auth_user_id,
						"UserPermission.controller"=>array("*",$controller)
				
					),
					"order"=>array("UserPermission.action"=>"ASC"),
					"contain"=>array()
				
				));
				
				Cache::write($user_token,$user_perms,"1min");
				
			}
			
			
			
			foreach($user_perms as $v) {
				
				if($v['UserPermission']['allowed']) {
					
					$this->Auth->allow($v['UserPermission']['action']);
					
				} else {
					
					$this->Auth->deny($v['UserPermission']['action']);
					
				}
				
			}
		}
		
		
		if($this->Auth->user("id")) {
			
			$this->Session->write("Auth.User.allowedActions",$this->Auth->allowedActions);
			
		}
		
		//pr($this->Session->read());
		//pr($this->Auth);
		
		
	}
	/**
	 * Stub Method Needed to extend the Auth components ACL
	 * @see public_html/cake/libs/controller/Controller#isAuthorized()
	 */
	public function isAuthorized() {
		
	}
	
	/**
	 * Redirect User With Invalid URL Message
	 * @param String $url realtive URL to redirect to
	 * @return void
	 */
	public function invalidUrl($url) {
		
		$this->Session->setFlash("Invalid URL");
		
		return $this->redirect($url);
		
	}
	
	public function beforeRender() {
		
		
		if($this->params['controller'] == "media" || $this->skip_page_view == true) {
			
			return;
			
		}
		
		if($this->params['controller'] == "news" && $this->params['isAjax']) {
			
			return;
			
		}
		
		$this->loadModel("PageView");
		
		//check if we are mobile
		
		$mobile = false;
		
		if($this->RequestHandler->isMobile()) {
			
			$mobile = true;
			
		}
		
		$domain_name = $_SERVER['HTTP_HOST'];
		
		$domain_name = str_replace("www.","",$domain_name);
		
		$domains = array(
		
			"dev.theberrics.com",
			"theberrics.com",
			"dev.batb4.thberrics.com",
			"batb4.theberrics.com",
			"aberrica.com",
			"dev.admin.theberrics.com"
		
		);
		
		
		
		if(!in_array($domain_name,$domains)) {

			
		}
		
		if($this->Session->id() == '') {
			
			$this->Session->start();
			
		}
		
		$data = array();
		
		$data["geo_country"]=(isset($_SERVER['GEOIP_COUNTRY_CODE'])) ? $_SERVER['GEOIP_COUNTRY_CODE']:NULL;
		$data["geo_region"]=(isset($_SERVER['GEOIP_REGION'])) ? $_SERVER['GEOIP_REGION']:NULL;
		$data["geo_region_name"]=(isset($_SERVER['GEOIP_REGION_NAME'])) ? $_SERVER['GEOIP_REGION_NAME']:NULL;
		$data["geo_dma_code"]=(isset($_SERVER['GEOIP_DMA_CODE'])) ? $_SERVER['GEOIP_DMA_CODE']:NULL;
		$data["geo_postal_code"]=(isset($_SERVER['GEOIP_POSTAL_CODE'])) ? $_SERVER['GEOIP_POSTAL_CODE']:NULL;
		$data["geo_city"]=(isset($_SERVER['GEOIP_CITY'])) ? $_SERVER['GEOIP_CITY']:NULL;
		$data["session"]=$this->Session->id();
		$data["ip_address"]=$_SERVER['GEOIP_ADDR'];
		$data["domain_name"]=$domain_name;
		$data["script_url"]=$_SERVER['SCRIPT_URL'];
		$data["mobile"] = $mobile;
		
		$this->PageView->save($data);
		
	}
	
	protected function enforceSSL() {
		
		if(
			(!preg_match('/^(https)/',$_SERVER['SCRIPT_URI']) && !preg_match('/(dev)/',$_SERVER['SERVER_NAME'])) || 
			(preg_match('/(127\.0\.0\.1)/',$_SERVER['HTTP_X_FORWARDED_FOR']))
			) 
		{
			
			return $this->redirect("https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			
		} 
	}
	
	public function flex_session_ping($session_id = false) {
		
		if($session_id) $this->Session->start($session_id);
		
		die(json_encode($this->Auth->user()));
		
	}
	
}
