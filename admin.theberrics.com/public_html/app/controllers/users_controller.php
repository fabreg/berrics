<?php

App::import("Controller","AdminApp");

class UsersController extends AdminAppController {

	var $name = 'Users';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
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
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			$this->data['Tag'] = $this->User->Tag->parseTags($this->data['User']['tags']);
			
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->find("first",array(
			
				"conditions"=>array("User.id"=>$id),
				"contain"=>array(
			
					"UserGroup",
					"Tag"		
			
				)
			
			));
		}
		$userGroups = $this->User->UserGroup->find('list');
		$this->set(compact('userGroups'));
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

}
?>