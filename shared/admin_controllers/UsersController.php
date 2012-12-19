<?php

App::import("Controller","LocalApp");

class UsersController extends LocalAppController {

	var $name = 'Users';
	
	//public $helpers = array("Berrics");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	
	public function profile_search() {
		
		
		
	}
	
	public function search() {
		
		$url = array(
		
			"action"=>"index",
			"search"=>true
		);
		
		
		foreach($this->request->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				if(empty($vv)) continue;
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
		
	}
	
	
	
	function index() {
		
		$this->User->recursive = 0;
		
		$cond = array();
		
		if(isset($this->request->params['named']['search'])) {
			
			if(isset($this->request->params['named']['User.first_name'])) {
				
				$cond['User.first_name LIKE'] = str_replace(" ","%",$this->request->params['named']['User.first_name'])."%";
				$this->request->data['User']['first_name'] = $this->request->params['named']['User.first_name'];
				
			}
			
			if(isset($this->request->params['named']['User.last_name'])) {
				
				$cond['User.last_name LIKE'] = str_replace(" ","%",$this->request->params['named']['User.last_name'])."%";
				$this->request->data['User']['last_name'] = $this->request->params['named']['User.last_name'];
				
			}
			
			if(isset($this->request->params['named']['User.email'])) {
				
				$cond['User.email LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['User.email'])."%";
				$this->request->data['User']['email'] = $this->request->params['named']['User.email'];
				
			}
			
			if(isset($this->request->params['named']['User.UserGroup'])) {
				
				$cond['User.user_group_id'] = $this->request->params['named']['User.UserGroup'];
				$this->request->data['User']['UserGroup'] = $this->request->params['named']['User.UserGroup'];
				
			}
			if(isset($this->request->params['named']['User.twitter_handle'])) {
				
				$cond['User.twitter_handle LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['User.twitter_handle'])."%";
				$this->request->data['User']['twitter_handle'] = $this->request->params['named']['User.twitter_handle'];
				
			}
			
			if(isset($this->request->params['named']['User.instagram_handle'])) {
				
				$cond['User.instagram_handle LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['User.instagram_handle'])."%";
				$this->request->data['User']['instagram_handle'] = $this->request->params['named']['User.instagram_handle'];
				
			}
			
		}
		
	
		
		$this->paginate = array(
		
			"conditions"=>$cond,
			"limit"=>50
		
		);
		
		$userGroups = $this->User->UserGroup->find("list",array("order"=>array("UserGroup.name"=>"ASC")));
		
		$this->set("userGroups",$userGroups);
		
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->User->create();
			
						
			if(!empty($this->request->data['User']['passwd'])) {
					
					$this->request->data['User']['passwd'] = Security::hash($this->request->data['User']['passwd'],null,true);
					
			}
			
			//check to see if we have the same first name and last name in the db and ask them to confirm creation
			$name_check = $this->User->find("first",array(
			
				"conditions"=>array(
					"User.first_name"=>$this->request->data['User']['first_name'],
					"User.last_name"=>$this->request->data['User']['last_name']
				),
				"contain"=>array()
			
			));
			
			$this->request->data['Tag'] = $this->User->Tag->parseTags($this->request->data['User']['tags']);
	
			//die(pr($this->request->data));
			
			if($name_check) {
				
				$this->Session->write("UserCheck",$this->request->data);
				
				return $this->redirect(array("controller"=>"users","action"=>"confirm_duplicate"));
				
			}
			
			
			if ($this->User->save($this->request->data)) {

				
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'edit',$this->User->id));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$userGroups = $this->User->UserGroup->find('list');
		
		$this->set(compact('userGroups'));
	}

	
	public function confirm_duplicate() {
		
		if(count($this->request->data)>0) {
			
			if($this->User->save($this->request->data)) {
				
				$this->Session->setFlash("User has been created successfully");
				
			} else {
				
				$this->Session->setFlash("There was an error while creating the user. Please try again");
				
			}
			
			$this->redirect(array("controller"=>"users","action"=>"index"));
			
		}
		
		$userGroups = $this->User->UserGroup->find('list');
		
		$this->set(compact('userGroups'));
		
		$this->request->data = $this->Session->read("UserCheck");
		
	}
	
	function edit($id = null,$callback=false) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->request->data['Tag'] = $this->User->Tag->parseTags($this->request->data['User']['tags']);
			
			if(isset($this->request->data['UpdateProfileImage'])) {

				$this->handleProfileImageUpload();
				
			}
			
			if(isset($this->request->data['UpdateInstagramData'])) {
				
				$this->updateInstagram();
				
			}
			
			if(isset($this->request->data['MakeDefaultImage'])) {
				
				$this->makeDefaultImage();
				
			}
			
			if(isset($this->request->data['DeleteProfileImage'])) {
				
				$this->deleteProfileImage();
				
			}
			
			if ($this->User->saveAll($this->request->data)) {
				
				$this->Session->setFlash(__('The user has been saved'));
				
				//if($callback) return $this->redirect(base64_decode($callback));
				
				$this->redirect($this->request->here);
				
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			/*$this->request->data = $this->User->find("first",array(
			
				"conditions"=>array("User.id"=>$id),
				"contain"=>array(
			
					"UserGroup",
					"Tag",
					"UserProfileImage"		
			
				)
			
			));*/
			
			$this->request->data = $this->User->returnProfile(array("User.id"=>$id));
			
		}
		
		$userProfile = $this->User->ensure_user_profile($this->request->data['User']['id']);
		
		$userGroups = $this->User->UserGroup->find('list');
		
		$this->set(compact('userGroups','userProfile'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action'=>'index'));
		}
		
		return $this->render();
		
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function update_password($id) {
		
		
		if(empty($id)) {
			
			return $this->invalidUrl();
			
		}
		
		//check for an incoming update
		
		if(!empty($this->request->data) && count($this->request->data)) {
			
			//set some validation rules for the user model
			$this->User->updatePasswordValidationRules();
			
			//set the record to be updated
			$this->User->id = $this->request->data['User']['id'];
			
			$this->User->set($this->request->data);
			
			if($this->User->validates()) {
				
				$this->request->data['User']['passwd'] = $this->Auth->password($this->request->data['User']['passwd']);
				
				$this->User->set($this->request->data);
				
				$this->User->save($this->request->data);
				
				$this->Session->setFlash("Password updated successfully");
				
				return $this->redirect(array("controller"=>"users","action"=>"index"));
				
			} else {
				
				$this->Session->setFlash("You fucked up!");
				
			}
			
			
			
		}
		
		//grab the user
		$user = $this->User->find("first",array(
		
			"conditions"=>array("User.id"=>$id),
			"contain"=>array()
		
		));
		
		//check to see if we actually found a user
		
		if(count($user)<=0) {
			
			return $this->invalidUrl();
			
		}
		
		$this->request->data = $user;
		
		
		
	}
	
	public function users_modal_search() {
		
		
		
	}
	
	public function users_modal_search_results() {
		
		$cond = array();
		
		if(isset($this->request->data['User']['first_name']) && !empty($this->request->data['User']['first_name'])) {
			
			$cond['User.first_name LIKE'] = "%".str_replace(" ","%",$this->request->data['User']['first_name'])."%";
			
		}
		
		if(isset($this->request->data['User']['last_name']) && !empty($this->request->data['User']['last_name'])) {
			
			$cond['User.last_name LIKE'] = "%".str_replace(" ","%",$this->request->data['User']['last_name'])."%";
			
		}
		
		$results = $this->User->find("all",array(
			
			"conditions"=>$cond,
			"contain"=>array(
				"UserGroup"
			)
		
		));
		
		$this->set("results",$results);
		
	}
	
	private function deleteProfileImage() {
		
		$this->loadModel("UserProfileImage");
		
		$this->UserProfileImage->delete(key($this->request->data['DeleteProfileImage']));
		
	}
	
	private function makeDefaultImage() {
		
		
		if(!isset($this->request->data['User']['id'])) return false;
		
		$this->loadModel("UserProfileImage");
		
		//update all the images
		$this->UserProfileImage->updateAll(
			array(
				"user_id"=>$this->request->data['User']['id']
			),
			array(
				"default"=>0
			)
		);
		
		$this->UserProfileImage->create();
		$this->UserProfileImage->id = key($this->request->data['MakeDefaultImage']);
		
		$this->UserProfileImage->save(array("default"=>1));
		
	}
	
	private function updateInstagram() {
		
		$this->User->updateInstagramDetails($this->request->data['User']);
		
		return $this->render();
		
	}
	
	private function handleProfileImageUpload() {
		
		$file = $this->request->data['User']['profile_image'];
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$name = md5(microtime()).".".$ext;
		
		//move to temp folder
		$tmp_path = TMP.$name;
		
		move_uploaded_file($file['tmp_name'],$tmp_path);
		
		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
		$i = ImgServer::instance();
		
		//upload file to server
		$i->upload_profile_image($name,$tmp_path);
		
		//$this->request->data['User']['profile_img_file'] = $name;
		//insert a new profile image row
		$this->loadModel("UserProfileImage");
		$this->UserProfileImage->create();
		
		$this->UserProfileImage->save(array(
			"file_name"=>$name,
			"user_id"=>$this->request->data['User']['id']
		));
		
	}
	
	public function force_login($id) {
		
		$user = $this->User->find("first",array(
			"conditions"=>array(
				"User.id"=>$id
			),
			"contain"=>array()
		));
		
		$this->Session->write("Auth.User",$user['User']);
		
		return $this->redirect("/users");
		
	}

	public function manage_profiles() {
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['User'] = array(

			"conditions"=>array(
				"User.pro_skater"=>1,
				"User.am_skater"=>1
			),
			"contain"=>array()

		);

		$users = $this->paginate("User");

		$this->set(compact("users"));

	}

	public function edit_profile($id = false) {
		
	}

	public function manage_employees() {
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['User'] = array(

			"conditions"=>array(
				"User.berrics_employee"=>1
			),
			"contain"=>array(),
			"limit"=>50

		);

		$users = $this->paginate("User");

		$this->set(compact("users"));

	}

	public function edit_employee($id = false) {
		


	}



}
?>