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
		"UserBillingProfile",
		"UserProfileImage"
	);


	var $hasAndBelongsToMany = array(
		'MediaFile',
		"Tag"
	);
	
	public function beforeSave() {
		
		parent::beforeSave();

		
		
		if(empty($this->id)) {
			
			$this->data[$this->name]['account_hash'] = md5(time().mt_rand(999,9999));
			
		}
		
		return true;
		
	}
	
	public function returnUserProfile($id = false,$noCache=false) {
		
		
		$token = "user-profile-".$id;
		
		if($noCache || ($profile = Cache::read($token,"1min")) === false) {
			
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

			$select[$v['User']['id']] = $v['User']['first_name']." ".$v['User']['last_name'];
			
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
			"contain"=>array(
				"UserProfile",
				"UserGroup",
				"UserProfileImage"=>array(
					"order"=>array("UserProfileImage.default"=>"DESC")
				),
				"Tag"=>array(
					"Brand",
					"UnifiedStore"
				)
			)
		
		));
		
		if(!isset($p['UserProfile']['id'])) {
			
			$profile = $this->ensure_user_profile($p['User']['id']);
			
			$p['UserProfile'] = $profile['UserProfile'];
			
		}
		
		return $p;
		
	}
	
	public function updateInstagramDetails($User = array(),$crontab = false) {
		
		if(
			(!isset($User['id']) || !isset($User['instagram_handle'])) || 
			(empty($User['id']) || empty($User['instagram_handle']))
		) {
			
			return false;
			
		}
		
		
		
		App::import("Vendor","InstagramApi",array("file"=>"instagram/instagram_api.php"));
		
		$i = InstagramApi::berricsInstance();
		
		$search = $i->instagram->searchUser($User['instagram_handle']);
		
		$insta = json_decode($search,true);
		
		$udata = array();
		
		$udata['instagram_account_num'] = $insta['data'][0]['id'];
		$udata['instagram_profile_image'] = $insta['data'][0]['profile_picture'];
		
		//update the users profile with the instagram info
		$this->create();
		$this->id = $User['id'];

		$this->save($udata);
		
		$instaData = $i->instagram->getUser($udata['instagram_account_num']);
		
		$instaData = json_decode($instaData,true);
		
		$profile = $this->ensure_user_profile($User['id']);
		
		$this->UserProfile->create();
		
		$this->UserProfile->id = $profile['UserProfile']['id'];
		
		$this->UserProfile->save(array(
			"instagram_followers"=>$instaData['data']['counts']['followed_by'],
			"instagra_last_updated"=>'NOW()'
		));
		
		SysMsg::add(array(
			"category"=>"Instagram",
			"from"=>"UserModel",
			"title"=>"Update Instagram: ".$User['instagram_handle'],
			"crontab"=>$crontab
		));
		
	}
	
	
	
	public static function stanceSelect() {
		
		return array(
			"regular"=>"Regular",
			"goofy"=>"Goofy"
		);
		
	}
	
	public function setRegistrationValidation() {
		
		$v['first_name'] = array(
					"rule"=>"notEmpty",
					"message"=>"First name cannot be empty"
				);
		
		$v['last_name'] = array(
				"rule"=>"notEmpty",
				"message"=>"Last name cannot be empty"
		);
		
		$v['email'] = array(
					"email_check"=>array(
						"rule"=>"email",
						"message"=>"Please correct your email address"		
					)
				);
		$v['new_passwd'] = array(
					"must_match"=>array(
							"rule"=>"passwordMatch",
							"message"=>"Your passwords did not match"
					),
					"min_length"=>array(
								"rule"=>array("minLength",6),
								"message"=>"Password must be at least 6 characters"
							)
				);
		$v['city'] = array(
				
					"rule"=>"notEmpty",
					"message"=>'Please enter your city'
				
				);
		$this->validate = $v;
		
	}
	
	public function processUserFormRegistration($data) {

		//does the email already exist?
		$chk = $this->find("first",array(
					"conditions"=>array(
								"User.email"=>$data['User']['email']
							),
					"contain"=>array()
				));
		
		if(isset($chk['User']['email_verified']) && $chk['User']['email_verified']==1) {
			
			return false;
			
		}
		
		$this->create();
		
		if(!empty($chk['User']['id'])) {
			
			$this->id = $chk['User']['id'];
			
		} else {
			
			$data['User']['user_group_id'] = 60;
			
		}
		
		$this->save($data['User']);

		$profile = $this->ensure_user_profile($this->id);
		
		$data['UserProfile']['city'] = $data['User']['city'];
		
		$this->UserProfile->create();
		
		$this->UserProfile->id = $profile['UserProfile']['id'];
		
		$this->UserProfile->save($data['UserProfile']);
		
		$up = $this->returnUserProfile($this->id,true);
		
		//queue up confirmation email
		if($up['User']['email_verified'] != 1) {
			
			$email = ClassRegistry::init("EmailMessage");
			
			$email->userEmailConfirmation($up['User']);
			
		}
		
		return $up;
		
	}


	public function returnTaggedPostIds($User) {
		
		//get all the users tags
		$tags = $this->Tag->find("all",array(
					"conditions"=>array(
						"Tag.user_id"=>$User['User']['id']
					),
					"contain"=>array()
				));

		$tag_ids = Set::extract("/Tag/id",$tags);



		$tposts = $this->Dailyop->DailyopsTag->find('all',array(
					"conditions"=>array(
						"DailyopsTag.tag_id"=>$tag_ids
					),
					"contain"=>array()
				));
		//die(pr($tposts));
		$post_ids = Set::extract("/DailyopsTag/dailyop_id",$tposts);

		return $post_ids;

	}


	//validation methods
	
	public function checkDupeEmail($email) {
		
		$chk = $this->find("first",array(
					"conditions"=>array(
						"User.email"=>$email		
					),
					"contain"=>array()
				));
		
		if(!empty($chk['User']['id'])) {
			
			return $chk;
			
		} else {
			
			return false;
			
		}
		
	}
	
	public function confirmEmail($check) {
		
		$data = $this->data;
		
		if(isset($data['User'])) $data = $data['User'];
		
		if($data['email'] == $data['email_confirm']) {
			
			return false;
			
		} 
		
		return false;
		
	}

	public function passwordMatch() {
	
		$data = $this->data;
		
		if(isset($data['User'])) $data = $data['User'];
	
		if($data['new_passwd'] != $data['new_passwd_confirm']) {
				
			return false;
				
		}
	
		return true;
	
	}



	
	
}
