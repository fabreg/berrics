<?php

class UserPasswdReset extends AppModel {
	
	
	public $belongsTo = array(
				"User"
			);
	
	
	public function process_reset_reqeust($email) {
		
		
		$account = $this->User->find("first",array(
					"contain"=>array(),
					"conditions"=>array(
								"User.email"=>$email,
								"User.active"=>1
							)
				));
		
		if(!empty($account['User']['id'])) {
			
			$this->create();
			
			$this->save(array(
						"user_id"=>$account['User']['id'],
						"hash"=>md5($account['User']['id'].time()),
						"active"=>1
					));
			
			$request = $this->read();
			
			$email = ClassRegistry::init("EmailMessage");
			
			$email->queueUserPasswdReset($request);
			
			return $account;
			 
		}
		
		return false;
		
	}
	
	public function setEmailValidation() {
		
		$this->validate = array(
					"email"=>array(
						"rule"=>"email",
						"message"=>"Please correct your email address"		
					)
				);
		
	}
	
	public function setPasswordValidation() {
		
		$this->validate = array(
				
					"passwd"=>array(
							
								"not_empty"=>array(
											"rule"=>array("minLength",6),
											"message"=>"Your password must be at least 6 characters"
										),
								"must_match"=>array(
											"rule"=>array("passwordMatch"),
											"message"=>"Your passwords do not match"
										)
							
							)
				
				);
		
	}
	
	public function passwordMatch() {
		
		$data = $this->data;
		
		if(isset($data['UserPasswdReset'])) $data = $data['UserPasswdReset'];
		
		if($data['passwd'] != $data['passwd_confirm']) {
			
			return false;
			
		}
		
		return true;
		
	}
	
}