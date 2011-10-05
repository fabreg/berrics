<?php

abstract class GatewayBase {
	
	protected $card_data			 = array();
	protected $transaction			 = array();
	protected $transaction_result	 = array();
	protected $response_data		 = array();
	protected $customer				 = array();
	protected $gateway_account		 = array();
	protected $currency				 = array();
	protected $user_billing_profile	 = array();
	

	
	#ABSTRACT METHODS
	public 	  abstract function init();
	protected abstract function runCharge();
	protected abstract function runAuth();
	protected abstract function runRefund();
	protected abstract function runCapture();
	protected abstract function runVoid();
	protected abstract function runCreateUserProfile();
	protected abstract function runChargeUserBillingProfile();
	protected abstract function formatTransactionResponse();
	
	#CALLBACK METHODS
	protected function beforeCharge() 							{ return true; }
	protected function afterCharge($trans)  					{ if($trans) $this->runCreateUserProfile(); }
	protected function beforeAuth() 							{ return true; }
	protected function afterAuth($trans)  						{ if($trans) $this->runCreateUserProfile(); }
	protected function beforeCapture()  						{ return true; }
	protected function afterCapture($trans)  					{ return true; }
	protected function beforeRefund() 							{ return true; }
	protected function afterRefund($trans)  					{ return true; }
	protected function beforeVoid() 							{ return true; }
	protected function afterVoid($trans)  						{ return true; }
	protected function beforeCreateUserProfile()  				{ return true; }
	protected function afterCreateUserProfile($trans)  			{ return true; }
	protected function afterChargeUserBillingProfile($trans)  	{ return true; }
	protected function beforeChargeUserBillingProfile() 		{ return true; }
	
	public function __construct($o) {
		
		$this->set($o);
		
	}
	
	public function reset() {
		
		$this->card_data = 
		$this->transaction = 
		$this->transaction_result = 
		$this->response_date = 
		$this->user_billing_profile = 
		$this->customer = array();
		
	}
	
	public function set($a = array()) {
		
		if(isset($a['Customer'])) 			$this->customer = $a['Customer'];
		
		if(isset($a['Transaction'])) 		$this->transaction = $a['Transaction'];
		
		if(isset($a['GatewayAccount'])) 	$this->gateway_account = $a['GatewayAccount'];
		
		if(isset($a['Currency'])) 			$this->currency = $a['Currency'];
		//CC STUFF
		if(isset($a['CardData'])) {
			
			$this->card_data = $a['CardData'];
			
			if(isset($this->card_data['number'])) {
				
				$this->card_data['number'] = str_replace(" ","",$this->card_data['number']);
				
				$this->card_data['cc_hash'] = substr($this->card_data['number'],0,4)."-".substr($this->card_data['number'],-(4-strlen($this->card_data['number'])),4);
				
				
			}
			
			if(isset($this->card_data['exp_month']) && !empty($this->card_data['exp_month']) && strlen($this->card_data['exp_month'])<2) {
				
				$this->card_data['exp_month'] = "0".$this->card_data['exp_month'];
				
			}
			
		}
		//BILLING PROFILE
		if(isset($a['UserBillingProfile'])) $this->user_billing_profile = $a['UserBillingProfile'];
		
		
		if(isset($this->user_billing_profile['id'])) {
		
			if(isset($this->user_billing_profile['first_name'])) 	$this->customer['first_name'] = $this->user_billing_profile['first_name'];
			if(isset($this->user_billing_profile['last_name'])) 	$this->customer['last_name'] = 	$this->user_billing_profile['last_name'];
			if(isset($this->user_billing_profile['address'])) 		$this->customer['address'] = 	$this->user_billing_profile['address'];
			if(isset($this->user_billing_profile['city'])) 			$this->customer['city'] = 		$this->user_billing_profile['city'];
			if(isset($this->user_billing_profile['state'])) 		$this->customer['state'] = 		$this->user_billing_profile['state'];
			if(isset($this->user_billing_profile['country'])) 		$this->customer['country'] = 	$this->user_billing_profile['country'];
			if(isset($this->user_billing_profile['postal'])) 		$this->customer['postal'] = 	$this->user_billing_profile['postal'];
			if(isset($this->user_billing_profile['email'])) 		$this->customer['email'] = 		$this->user_billing_profile['email'];
			if(isset($this->user_billing_profile['phone'])) 		$this->customer['phone'] = 		$this->user_billing_profile['phone'];
			if(isset($this->user_billing_profile['cc_hash'])) $this->card_data['cc_hash'] = $this->user_billing_profile['cc_hash'];
			
			
		}
		
		
	}
	
	public function get($key) {
		
		if(preg_match('/(\.)/',$key)) {
			
			$keys = explode(".",$key);
		
			return $this->{$keys[0]}[$keys[1]];
			
		} else {
			
			return $this->{$key};
			
		}
		
		
		
	}
	
	
	
	public function charge(/*POLYMORPHIC*/) {
		
		$args = func_get_args();
		
		if(isset($args[0]) && is_array($args[0])) {
			
			$this->set($args[0]);
			
		}
		
		$trans = false;
		
		if($this->beforeCharge()) $trans = $this->runCharge();
		
		$this->afterCharge($trans);
		
		return $trans;
		
	}
	
	public function auth(/*POLYMORPHIC*/) {
		
		$args = func_get_args();
		
		if(is_array($args[0])) {
			
			$this->set($args[0]);
			
		}
		
		$trans = false;
		
		if($this->beforeAuth()) $trans = $this->runAuth();
		
		$this->afterAuth($trans);
		
		return $trans;
		
	}
	
	public function refund(/*POLYMORPHIC*/) {
		
		$args = func_get_args();
		
		if(is_array($args[0])) {
			
			$this->set($args[0]);
			
		}
		
		$trans = false;
		
		if($this->beforeRefund()) $trans = $this->runRefund();
		
		$this->afterRefund($trans);
		
		return $trans;
		
	}
	
	public function capture(/*POLYMORPHIC*/) {
		
		$args = func_get_args();
		
		if(is_array($args[0])) {
			
			$this->set($args[0]);
			
		}
		
		$trans = false;
		
		if($this->beforeCapture()) $trans = $this->runCapture();
		
		$this->afterCapture($trans);
		
		return $trans;
		
	}
	
	public function void() {
		
		$args = func_get_args();
		
		if(is_array($args[0])) {
			
			$this->set($args[0]);
			
		}
		
		$trans = false;
		
		if($this->beforeVoid()) $trans = $this->runVoid();
		
		$this->afterVoid($trans);
		
		return $trans;
		
	}
	
	public function addUserProfile(/*POLYMORPHIC*/) {
		
		$args = func_get_args();
		
		if(is_array($args[0])) {
			
			$this->set($args[0]);
			
		}
		
		$trans = false;
		
		if($this->beforeCreateUserProfile()) $trans = $this->runAddCustomerAccount();
		
		$this->afterCreateUserProfile();($trans);
		
		return $trans;
		
	}
	
	public function chargeUserBillingProfile() {
		
		$args = func_get_args();
		
		if(is_array($args[0])) {
			
			$this->set($args[0]);
			
		}
		
		$trans = false;
		
		if($this->beforeChargeUserBillingProfile()) $trans = $this->runChargeUserBillingProfile();
		
		$this->afterChargeUserBillingProfile($trans);
		
		return $trans;
		
		
	}

}