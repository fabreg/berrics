<?php

App::import("Controller","LocalApp");

class GatewayAccountsController extends LocalAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		$this->set("accounts",$this->paginate("GatewayAccount"));
		
	//	$g = $this->GatewayAccount->loadGateway(1);
		
		//$g->charge(array("Transaction"=>array("amount"=>"100.00")));
		
	}
	
	public function edit($id = false) {
		
		if(count($this->data)>0) {
			
			$this->GatewayAccount->save($this->data);
			
			return $this->flash("Account Updated","/gateway_accounts/");
			
		} else {
			
			$this->data = $this->GatewayAccount->find("first",array(
				"conditions"=>array("GatewayAccount.id"=>$id)
			));
			
			
		}
		
		$currencies = $this->GatewayAccount->Currency->find("list",array("order"=>array("Currency.name"=>"ASC")));
		
		$this->set(compact("currencies"));
		
		
		
	}
	
	public function add() {
		
		if(count($this->data)>0) {
			
			$this->GatewayAccount->save($this->data);
			
			return $this->flash("Account added successfully","/gateway_accounts/edit/".$this->GatewayAccount->id);
			
		}
		
		
	}
	
	
	
}