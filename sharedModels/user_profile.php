<?php

class UserProfile extends AppModel {
	
	
	public $belongsTo = array(
	
		"User"
	
	);
	
	public function ensureProfile($user_id) {
		
		$check = $this->find("count",array(
		
			"conditions"=>array(
				"UserProfile.user_id"=>$user_id
			),
			"contain"=>array()
		));
		
		if($check<=0) {
			
			$this->create();
			
			$this->save(array(
				"user_id"=>$user_id
			));
			
		}
		
		
	}
	
}

