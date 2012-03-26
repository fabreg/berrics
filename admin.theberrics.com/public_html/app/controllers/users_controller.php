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
		
		
		foreach($this->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
		
		return $this->redirect($url);
		
		
	}
	
	
	
	function index() {
		
		$this->User->recursive = 0;
		
		$cond = array();
		
		if(isset($this->params['named']['search'])) {
			
			if(isset($this->params['named']['User.first_name'])) {
				
				$cond['User.first_name LIKE'] = str_replace(" ","%",$this->params['named']['User.first_name'])."%";
				$this->data['User']['first_name'] = $this->params['named']['User.first_name'];
				
			}
			
			if(isset($this->params['named']['User.last_name'])) {
				
				$cond['User.last_name LIKE'] = str_replace(" ","%",$this->params['named']['User.last_name'])."%";
				$this->data['User']['last_name'] = $this->params['named']['User.last_name'];
				
			}
			
			if(isset($this->params['named']['User.email'])) {
				
				$cond['User.email LIKE'] = "%".str_replace(" ","%",$this->params['named']['User.email'])."%";
				$this->data['User']['email'] = $this->params['named']['User.email'];
				
			}
			
			if(isset($this->params['named']['User.UserGroup'])) {
				
				$cond['User.user_group_id'] = $this->params['named']['User.UserGroup'];
				$this->data['User']['UserGroup'] = $this->params['named']['User.UserGroup'];
				
			}
			if(isset($this->params['named']['User.twitter_handle'])) {
				
				$cond['User.twitter_handle LIKE'] = "%".str_replace(" ","%",$this->params['named']['User.twitter_handle'])."%";
				$this->data['User']['twitter_handle'] = $this->params['named']['User.twitter_handle'];
				
			}
			
			if(isset($this->params['named']['User.instagram_handle'])) {
				
				$cond['User.instagram_handle LIKE'] = "%".str_replace(" ","%",$this->params['named']['User.instagram_handle'])."%";
				$this->data['User']['instagram_handle'] = $this->params['named']['User.instagram_handle'];
				
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
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			
						
			if(!empty($this->data['User']['passwd'])) {
					
					$this->data['User']['passwd'] = Security::hash($this->data['User']['passwd'],null,true);
					
			}
			
			//check to see if we have the same first name and last name in the db and ask them to confirm creation
			$name_check = $this->User->find("first",array(
			
				"conditions"=>array(
					"User.first_name"=>$this->data['User']['first_name'],
					"User.last_name"=>$this->data['User']['last_name']
				),
				"contain"=>array()
			
			));
			
			$this->data['Tag'] = $this->User->Tag->parseTags($this->data['User']['tags']);
	
			//die(pr($this->data));
			
			if($name_check) {
				
				$this->Session->write("UserCheck",$this->data);
				
				return $this->redirect(array("controller"=>"users","action"=>"confirm_duplicate"));
				
			}
			
			
			if ($this->User->save($this->data)) {

				
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		$userGroups = $this->User->UserGroup->find('list');
		
		$this->set(compact('userGroups'));
	}

	
	public function confirm_duplicate() {
		
		if(count($this->data)>0) {
			
			if($this->User->save($this->data)) {
				
				$this->Session->setFlash("User has been created successfully");
				
			} else {
				
				$this->Session->setFlash("There was an error while creating the user. Please try again");
				
			}
			
			$this->redirect(array("controller"=>"users","action"=>"index"));
			
		}
		
		$userGroups = $this->User->UserGroup->find('list');
		
		$this->set(compact('userGroups'));
		
		$this->data = $this->Session->read("UserCheck");
		
	}
	
	function edit($id = null,$callback=false) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$this->data['Tag'] = $this->User->Tag->parseTags($this->data['User']['tags']);
			
			if(isset($this->data['UpdateProfileImage'])) {

				$this->handleProfileImageUpload();
				
			}
			
			if(isset($this->data['UpdateInstagramData'])) {
				
				$this->updateInstagram();
				
			}
			
			if(isset($this->data['MakeDefaultImage'])) {
				
				$this->makeDefaultImage();
				
			}
			
			if(isset($this->data['DeleteProfileImage'])) {
				
				$this->deleteProfileImage();
				
			}
			
			if ($this->User->saveAll($this->data)) {
				
				$this->Session->setFlash(__('The user has been saved', true));
				
				//if($callback) return $this->redirect(base64_decode($callback));
				
				$this->redirect($this->here);
				
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			/*$this->data = $this->User->find("first",array(
			
				"conditions"=>array("User.id"=>$id),
				"contain"=>array(
			
					"UserGroup",
					"Tag",
					"UserProfileImage"		
			
				)
			
			));*/
			
			$this->data = $this->User->returnProfile(array("User.id"=>$id));
			
		}
		
		$userProfile = $this->User->ensure_user_profile($this->data['User']['id']);
		
		$userGroups = $this->User->UserGroup->find('list');
		
		$this->set(compact('userGroups','userProfile'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		
		return $this->render();
		
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	public function update_password($id) {
		
		
		if(empty($id)) {
			
			return $this->invalidUrl();
			
		}
		
		//check for an incoming update
		
		if(!empty($this->data) && count($this->data)) {
			
			//set some validation rules for the user model
			$this->User->updatePasswordValidationRules();
			
			//set the record to be updated
			$this->User->id = $this->data['User']['id'];
			
			$this->User->set($this->data);
			
			if($this->User->validates()) {
				
				$this->data['User']['passwd'] = $this->Auth->password($this->data['User']['passwd']);
				
				$this->User->set($this->data);
				
				$this->User->save($this->data);
				
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
		
		$this->data = $user;
		
		
		
	}
	
	public function users_modal_search() {
		
		
		
	}
	
	public function users_modal_search_results() {
		
		$cond = array();
		
		if(isset($this->data['User']['first_name']) && !empty($this->data['User']['first_name'])) {
			
			$cond['User.first_name LIKE'] = "%".str_replace(" ","%",$this->data['User']['first_name'])."%";
			
		}
		
		if(isset($this->data['User']['last_name']) && !empty($this->data['User']['last_name'])) {
			
			$cond['User.last_name LIKE'] = "%".str_replace(" ","%",$this->data['User']['last_name'])."%";
			
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
		
		$this->UserProfileImage->delete(key($this->data['DeleteProfileImage']));
		
	}
	
	private function makeDefaultImage() {
		
		
		if(!isset($this->data['User']['id'])) return false;
		
		$this->loadModel("UserProfileImage");
		
		//update all the images
		$this->UserProfileImage->updateAll(
			array(
				"user_id"=>$this->data['User']['id']
			),
			array(
				"default"=>0
			)
		);
		
		$this->UserProfileImage->create();
		$this->UserProfileImage->id = key($this->data['MakeDefaultImage']);
		
		$this->UserProfileImage->save(array("default"=>1));
		
	}
	
	private function updateInstagram() {
		
		if(empty($this->data['User']['instagram_handle'])) return false;
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
		
		$i = InstagramApi::berricsInstance();
		
		$search = $i->instagram->searchUser($this->data['User']['instagram_handle']);
		
		$insta = json_decode($search,true);
		
		//die(print_r($insta));
		
		$this->data['User']['instagram_account_num'] = $insta['data'][0]['id'];
		$this->data['User']['instagram_profile_image'] = $insta['data'][0]['profile_picture'];
		
		//update the users profile with the instagram info
		
		$instaData = $i->instagram->getUser($this->data['User']['instagram_account_num']);
		
		$instaData = json_decode($instaData,true);
		
		$profile = $this->User->ensure_user_profile($this->data['User']['id']);
		
		$this->User->UserProfile->create();
		
		$this->User->UserProfile->id = $profile['UserProfile']['id'];
		
		$this->User->UserProfile->save(array(
			"instagram_followers"=>$instaData['data']['counts']['followed_by'],
			"instagra_last_updated"=>'NOW()'
		));
		
		
	}
	
	private function handleProfileImageUpload() {
		
		$file = $this->data['User']['profile_image'];
		
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
		
		$name = md5(microtime()).".".$ext;
		
		//move to temp folder
		$tmp_path = TMP.$name;
		
		move_uploaded_file($file['tmp_name'],$tmp_path);
		
		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
		$i = ImgServer::instance();
		
		//upload file to server
		$i->upload_profile_image($name,$tmp_path);
		
		//$this->data['User']['profile_img_file'] = $name;
		//insert a new profile image row
		$this->loadModel("UserProfileImage");
		$this->UserProfileImage->create();
		
		$this->UserProfileImage->save(array(
			"file_name"=>$name,
			"user_id"=>$this->data['User']['id']
		));
		
	}
	

}
?>