<?php
/**
 * 
 * @author johnhardy
 *
 */
class User extends AppModel {
	var $name = 'User';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'UserGroup' => array(
			'className' => 'UserGroup',
			'foreignKey' => 'user_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
		
	);
	
	public $hasOne = array(
	
		"UserProfile"
	
	);

	var $hasMany = array(
		'Banner' => array(
			'className' => 'Banner',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Dailyop' => array(
			'className' => 'Dailyop',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MediaFile' => array(
			'className' => 'MediaFile',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserPermission' => array(
			'className' => 'UserPermission',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		"BatbScore",
		"UserBillingProfile"
	);


	var $hasAndBelongsToMany = array(
		'MediaFile',
		"Tag"
	);
	
	public function returnUserProfile($id = false) {
		
		
		$token = "user-profile-".$id;
		
		if(($profile = Cache::read($token,"1min")) === false) {
			
			$profile = $this->find("first",array(
				"conditions"=>array(
					"User.id"=>$id
				),
				"contain"=>array(
					"UserProfile",
					"UserGroup"
				)
			));
			
			Cache::write($token,$profile,"1min");
			
		}
		
		return $profile;
		
		
	}
	
	/**
	 * Returns a user account. If one is not found a new one is created and returned
	 * @param Array $data
	 * @return User
	 */
	public function locateLoginAccount($data = array()) {
		
		if(isset($data['facebook_account_num'])) {
			
			return $this->locateLoginAccount_facebook($data);
			
		}
		
		if(isset($data['twitter_account_id'])) {
			
			return $this->locateLoginAccount_twitter($data);
			
		}
		
		
	}
	
	/**
	 * Search the database for a facebook user account
	 * @param Array $data arguments yo!
	 * @return User
	 */
	public function locateLoginAccount_facebook($data = array()) {
		
		$user = $this->find('first',array(
		
			"contain"=>array(),
			"conditions"=>array(
		
				"OR"=>array(
					"User.email"=>$data['email'],
					"User.facebook_account_num"	=> $data['facebook_account_num']
				)
		
			)
		
		));
		
		if(!$user) {
			
			$data['user_group_id'] = '60';
			
			//create the account
			$this->create();
			$this->save($data);
			$user = $this->read();
			
		} else {
			
			//check to see if there is a facebook account number
			if(empty($user['User']['facebook_account_num'])) {

				$this->id = $user['User']['id'];
				$this->save(array(
					"facebook_account_num"=>$data['facebook_account_num'],
					"profile_image_url"=>"http://graph.facebook.com/".$data['facebook_account_num']."/picture"
				));
				$user = $this->read();
				
			}
			
		}
		
		if(!$user['User']['active']) {
			
			die("Your account has been deactivated!!");
			
		}
		
		return $user;
		
	}
	
	public function locateLoginAccount_twitter($data = array()) {
		
		
		
	}
	
	/**
	 * Format an array for a user drop down
	 * @param Array $data Arguments to send in
	 * @return Array
	 */
	
	public function userSelectList($data = array()) {
		
		
		$users = $this->find('all',array(
			
			"fields"=>array("User.id","User.first_name","User.last_name","User.email"),
			"order"=>array("User.last_name"=>"ASC"),
			"contain"=>array(),
			"conditions"=>$data
		));
		
		$select = array();
		
		foreach($users as $v) {
			
			$select[$v['User']['id']] = $v['User']['last_name'].", ".$v['User']['first_name']." ( ".$v['User']['email']." )";
			
		}
		
		return $select;
		
	}
	
	public function premiumSelectList() {
		
		
		$users = $this->find('all',array(
			
			"fields"=>array("User.id","User.first_name","User.last_name","User.email"),
			"order"=>array("User.last_name"=>"ASC"),
			"contain"=>array(),
			"conditions"=>array("User.user_group_id"=>array(10,40,50))
		));
		
		$select = array();
		
		foreach($users as $v) {
			
			$select[$v['User']['id']] = $v['User']['last_name'].", ".$v['User']['first_name']." ( ".$v['User']['email']." )";
			
		}
		
		
		
		return $select;
		
	}
	
	public function returnAssignedUserList() {
		
		$users = $this->find("all",array(
			"conditions"=>array(
				"User.user_group_id"=>10
			),
			"contain"=>array(),
			"order"=>array(
				"User.first_name"=>"ASC",
				"User.last_name"=>"ASC"
			)
		));
		
		$select = array();
		
		foreach($users as $v) {

			$select[$v['User']['id']] = $v['User']['first_name']." ".$v['User']['last_name']." (".$v['User']['title'].") ";
			
		}
			
		return $select;
		
	}
	
	/**
	 * Set validation rules for updating a password
	 * @return void
	 */
	public function updatePasswordValidationRules() {
		
		$this->validate = array(
		
			'passwd'=>array(
			
				"rule"=>array("minLength",4),
				"message"=>"Your password must be at least 4 characters"
		
			)
		
		);
		
	}
	
	
	public function initPhotoshootValidation() {
		
		
		$this->validate = array(
		
			"email"=>array(
		
					"rule"=>"email",
					"message"=>"Please double check that you email address is correct"	
			
				
		
			),
			"first_name"=>array(
			
				"rule"=>"notEmpty",
				"message"=>"Please fill in your first name"
			
			),
			"last_name"=>array(
				
				"rule"=>"notEmpty",
				"message"=>"Please fill in your last name"	
			
			)
		
		);
		
		
	}
	
	public function ensure_user_profile($id) {
		
		$check = $this->UserProfile->find("first",array(
			"conditions"=>array(
				"UserProfile.user_id"=>$id
			),
			"contain"=>array()
		));
		
		if(!isset($check['UserProfile']['id'])) {
			
			$this->UserProfile->create();
			
			$this->UserProfile->save(array(
				"user_id"=>$id
			));
			
			$check = $this->UserProfile->read();
			
		}
		
		return $check;
		
	}
	
	public function returnProfile($cond = array(),$options = array(),$isAdmin = false) {
		
		
		$p = $this->find("first",array(
		
			"conditions"=>$cond,
			"contain"=>array()
		
		));
		
		return $p;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

}
