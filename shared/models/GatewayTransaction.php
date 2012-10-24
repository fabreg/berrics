<?php
class GatewayTransaction extends AppModel {
	
	public $belongsTo = array(
		"GatewayAccount"
	);
	
	public $hasOne = array(
		"UserBillingProfile"
	);
	
	
	public function captureTransaction($Trans) {
		
		//let's check a few things first
		if($Trans['amount'] <= 0) {
			
			throw new Exception("(GatewayTransaction:captureTransaction):Cannot Capture A Transaction Of 0.00");
			
		}
		
		if(strtoupper($Trans['method']) != "AUTH") {
			
			throw new Exception("(GatewayTransaction:captureTransaction):Cannot Capture A Transaction That Is Not A Method Of 'AUTH'");
			
		}
		
		//make a new transactions
		$nd = $Trans;
		unset($nd['id'],$nd['created'],$nd['modified'],$nd['approved'],$nd['method']);
		
		$nd['method'] = "capture";
		
		$this->create();
		$this->save($nd);
		$new_trans_id = $this->id;
		
		
		//lets try and capture the transaction
		
		$gw = $this->GatewayAccount->loadGateway($Trans['gateway_account_id'],array("Transaction"=>$nd));
		
		$capture = $gw->capture();
		
		if($capture) {
			
			$this->create();
			$this->id = $Trans['id'];
			$this->save(array(
				"amount"=>"0"
			));
			
		}
		
		$this->create();
		$this->id = $new_trans_id;
		$this->save($gw->get("transaction_result"));
		
		return $capture;
		
	}
	
	public function beforeSave() {
		
		return parent::beforeSave();
		
	}
	
	public function refundTransaction($Trans,$amount = false) {
		
		$convert_currency = false;
		
		$nd = $Trans;
		unset($nd['id'],$nd['created'],$nd['modified'],$nd['approved'],$nd['method']);
		
		if($amount) {
			
			$nd['amount'] = $amount;
			
			$convert_currency = true;
			
		}
	
		$gw = $this->GatewayAccount->loadGateway($Trans['gateway_account_id'],array("Transaction"=>$nd));
		
		if($gw->get("transaction.currency_id") != $gw->get("gateway_account.currency_id") && $convert_currency) {
			
			$trn = $gw->get("transaction");
			$acc = $gw->get("gateway_account");

			$trn['amount'] = $this->GatewayAccount->Currency->convertCurrency($trn['currency_id'],$acc['currency_id'],$trn['amount']);
			
			$nd = $trn;
			
			$gw->set(array("Transaction"=>$trn));

		}
		$this->create();
		$this->save($nd); 
		$new_trans_id = $this->id;
		
		
		$res = $gw->refund();
		
		$this->create();
		$this->id = $new_trans_id;
		$this->save($gw->get("transaction_result"));
		
		return $res;
		
	}
	
	public function voidTransaction($Trans) {
		
		$gw = $this->GatewayAccount->loadGateway($Trans['gateway_account_id'],array("Transaction"=>$Trans));
		
		$void = $gw->void();
		
		if($void) {
			
			$this->create();
			$this->id = $Trans['id'];
			$this->save(array(
				"method"=>"void"
			));
			
			return true;
		}
		
		return false;
		
	}
	
	
	
}