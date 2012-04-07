<?php
App::import("Vendor","GatewayInit",array("file"=>"gateways/init.php"));

/* 		TRANSACTION SCHEMA
 *		 #TRANSACTION
		$t['Transaction']['currency_id'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.currency_id");
		$t['Transaction']['amount'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.grand_total");
		$t['Transaction']['foreign_key'] = 	Set::classicExtract($CanteenOrder,"CanteenOrder.id");
		$t['Transaction']['model'] = 		"CanteenOrder";
		
		#CUSTOMER
		$t['Customer']['first_name'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_first_name");
		$t['Customer']['last_name'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_last_name");
		$t['Customer']['address'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_address");
		$t['Customer']['postal'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_postal");
		$t['Customer']['country'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.bill_country");
		$t['Customer']['email'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.email");
		$t['Customer']['city'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_city");
		$t['Customer']['state'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.bill_state");
		$t['Customer']['phone'] = 			Set::classicExtract($CanteenOrder,"CanteenOrder.phone");
		$t['Customer']['user_id'] = 		Set::classicExtract($CanteenOrder,"CanteenOrder.user_id");
		
		#CARD DATA
		$t['CardData']['number'] = 			Set::classicExtract($CanteenOrder,"CardData.number");
		$t['CardData']['exp_year'] =		Set::classicExtract($CanteenOrder,"CardData.exp_year");
		$t['CardData']['exp_month'] = 		Set::classicExtract($CanteenOrder,"CardData.exp_month");
		$t['CardData']['code'] = 			Set::classicExtract($CanteenOrder,"CardData.code");
 * 
 */

class GatewayAccount extends AppModel {
	
	public $belongsTo = array(
		
		"Currency"
	
	);
	public $hasMany = array(
		"GatewayTransaction",
		"UserBillingProfile"
	);
	
	public static function providers() {
		
		$a = array(
			
			"Authnet"=>"Authorize dot net",
			"Usaepay"=>"USAEPay",
			"Sagepay"=>"Sage Pay",
			"Firstdata"=>"First Data"
		
		);
		
		return $a;
		
	}
	
	public function loadGateway($id = false,$extra = array()) {
		
		$acc = $this->find("first",array("conditions"=>array("GatewayAccount.id"=>$id),"contain"=>array()));
		
		$acc = array_merge($acc,$extra);
		
		$obj = GatewayFactory::getGateway($acc);
		
		return $obj;
		
	}
	
	public function run($method = false,$gateway_account_id = false,$data = array()) {
		
		return $this->{$method}($gateway_account_id,$data);
		
	}
	
	public function charge($gateway_account_id = false, $data = array()) {
		
		
		$gw = $this->loadGateway($gateway_account_id,$data);
		
		if($gw->get("transaction.currency_id") != $gw->get("gateway_account.currency_id")) {
			
			$trn = $gw->get("transaction");
			$acc = $gw->get("gateway_account");
			if(!isset($trn['currency_id'])) throw new Exception("Transaction does not have `currency_id` attribute set!");
			$trn['amount'] = $this->Currency->convertCurrency($trn['currency_id'],$acc['currency_id'],$trn['amount']);
			
			$gw->set(array("Transaction"=>$trn));
			
		}

		$this->GatewayTransaction->create();
		
		if($this->GatewayTransaction->save(array_merge(
													$gw->get("transaction"),
													$gw->get("customer"),
													$gw->get("card_data"),
													array(
														"gateway_account_id"=>$gw->get("gateway_account.id"),
														"method"=>"charge"			
													)
													)
										)) {
											
											
										
										} else {  }
		
		$tid = $this->GatewayTransaction->id;
		
		$charge = $gw->charge();
		
		$this->GatewayTransaction->create();
		$this->GatewayTransaction->id = $tid;
		$this->GatewayTransaction->save($gw->get("transaction_result"));
		
		$this->createUserBillingProfile($gw);
		
		return $charge;
		
	}

	
	public function auth($gwid = false, $data = array()) {
		
		$gw = $this->loadGateway($gwid,$data);
		
		
		if($gw->get("transaction.currency_id") != $gw->get("gateway_account.currency_id")) {
			
			$trn = $gw->get("transaction");
			$acc = $gw->get("gateway_account");
			if(!isset($trn['currency_id'])) throw new Exception("Transaction does not have `currency_id` attribute set!");
			$trn['amount'] = $this->Currency->convertCurrency($trn['currency_id'],$acc['currency_id'],$trn['amount']);
			
			$gw->set(array("Transaction"=>$trn));
			
		}
		
		$this->GatewayTransaction->save(array_merge(
													$gw->get("transaction"),
													$gw->get("customer"),
													$gw->get("card_data"),
													array(
														"gateway_account_id"=>$gw->get("gateway_account.id"),
														"method"=>"auth"			
													)
													)
										);
		
		$tid = $this->GatewayTransaction->id;
		
		$auth = $gw->auth();
		
		$this->GatewayTransaction->create();
		$this->GatewayTransaction->id = $tid;
		$this->GatewayTransaction->save($gw->get("transaction_result"));
		
		$this->createUserBillingProfile($gw);
		
		return $auth;
		
	}
	

	
	/**
	 * 
	 * @param int $gwid ID of the gateway account
	 * @param uuid $gateway_transaction_id ID of the transaction that we wish to run a refund on
	 * @param decimal $amount the amount that we wish to refund
	 * @return bool
	 */
	public function refund($gwid = false, $gateway_transaction_id = array(),$amount = false) {
		
		//get the original transaction
		$trans = $this->GatewayTransaction->find("first",array("conditions"=>array("GatewayTransaction.id"=>$gateway_transaction_id),"contain"=>array()));
		
		//let's remove some stuff that we don't want
		unset($trans['GatewayTransaction']['id'],$trans['GatewayTransaction']['created'],$trans['GatewayTransaction']['modified']);
		
		//let's create a new credit record using the previous transaction
		$this->GatewayTransaction->create();
		
		$this->GatewayTransaction->save($trans);
		
		$tid = $this->GatewayTransaction->id;
		
		//pull the new transaction into scope
		$transaction = $this->GatewayTransaction->read();
		
		//let's connected to the gateway
		$gw = $this->loadGateway($gwid,array("Transaction"=>$transaction['GatewayTransaction']));
		
		//attempt a refund
		$refund = $gw->refund();
		
		//save the results of the transaction
		$this->GatewayTransaction->create();
		$this->GatewayTransaction->id = $tid;
		$this->GatewayTransaction->save($gw->get("transaction_result"));
			

		return $refund;
	}
	
	public function capture($gwid = false, $data = array()) {
		
		$gw = $this->loadGateway($gwid,$data);
		
		$this->GatewayTransaction->save(array_merge(
													$gw->get("transaction"),
													$gw->get("customer"),
													$gw->get("card_data"),
													array(
														"gateway_account_id"=>$gw->get("gateway_account.id"),
														"method"=>"auth"			
													)
													)
										);
		
		$tid = $this->GatewayTransaction->id;
		
		$auth = $gw->auth();
		
		$this->GatewayTransaction->create();
		$this->GatewayTransaction->id = $tid;
		$this->GatewayTransaction->save($gw->get("transaction_result"));
		
		return $auth;
		
	}
	/**
	 * 
	 * @param array $data Can Be Either a Transaction with acc_op's or a UserBillingProfile with acc_op's
	 * @return bool
	 */
	public function chargeUserBillingProfile($data) {
		
		//load the gateway
		
		
		$gw = $this->loadGateway($data['UserBillingProfile']['gateway_account_id'],$data);
		
		if($gw->get("transaction.currency_id") != $gw->get("gateway_account.currency_id")) {
			
			$trn = $gw->get("transaction");
			$acc = $gw->get("gateway_account");
			
			if(!isset($trn['currency_id'])) throw new Exception("Transaction does not have `currency_id` attribute set!");
			
			$trn['amount'] = $this->Currency->convertCurrency($trn['currency_id'],$acc['currency_id'],$trn['amount']);
			
			$gw->set(array("Transaction"=>$trn));
			
		}
		
		$this->GatewayTransaction->save(array_merge(
											$gw->get("transaction"),
											$gw->get("customer"),
											$gw->get("card_data"),
											array(
												"gateway_account_id"=>$gw->get("gateway_account.id"),
												"method"=>"charge"			
											)
											)
								);
		
		$tid = $this->GatewayTransaction->id;
								
		$charge = $gw->chargeUserBillingProfile();
		
		$this->GatewayTransaction->create();
		$this->GatewayTransaction->id = $tid;
		$this->GatewayTransaction->save($gw->get("transaction_result"));
		
		
		return $charge;
	
	}
	
	private function createUserBillingProfile($gw) {
		
		//check the gateway to see if we can create the profile
		$up = $gw->get("user_billing_profile");
		
		$c = $gw->get("customer");
		$cc = $gw->get("card_data");
		$t = $gw->get("transaction");
		$acc = $gw->get("gateway_account");
		
		if(
			isset($up['acc_op1']) || 
			isset($up['acc_op2']) || 
			isset($up['acc_op3']) || 
			isset($up['acc_op4']) || 
			isset($up['acc_op5']) && !empty($c['user_id'])
		) {
			
			
			
			$this->UserBillingProfile->create();
			
			$save_data = array(
			
				"ref_model"=>			$t['model'],
				"ref_foreign_key"=>		$t['foreign_key'],
				"acc_op1"=>				$up['acc_op1'],
				"acc_op2"=>				$up['acc_op2'],
				"acc_op3"=>				$up['acc_op3'],
				"acc_op4"=>				$up['acc_op4'],
				"acc_op5"=>				$up['acc_op5'],
				"name"=>				$c['email']." (".$cc['cc_hash'].")",
				"gateway_account_id"=>	$acc['id'],
				"first_name"=>			$c['first_name'],
				"last_name"=>			$c['last_name'],
				"address"=>				$c['address'],
				"city"=>				$c['city'],
				"state"=>				$c['state'],
				"country"=>				$c['country'],
				"email"=>				$c['email'],
				"postal"=>				$c['postal'],
				"phone"=>				$c['phone'],
				"cc_hash"=>				$cc['cc_hash'],
				"user_id"=>				$c['user_id']
			
			);
			
			$save_data['sec_hash'] = md5(serialize($save_data));
			
			$this->UserBillingProfile->save($save_data);
			
			return $this->UserBillingProfile->id;
			
		}
		
		return false;
		
	}

	
	
	
}