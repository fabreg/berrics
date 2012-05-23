<?php

App::import("Controller","LocalApp");

class AccountController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		//for now, lock it down to the canteen
		if($this->params['action'] != "canteen") {
			
			return $this->redirect("/account/canteen");
			
		}
		
	}

	public function index() {
		
		
		
	}
	
	public function canteen($order_hash = false) {
		
		$this->theme = "account";
		
		//get all the users orders
		
		$this->loadModel("CanteenOrder");
		
		$orders = $this->CanteenOrder->find("all",array(
			"conditions"=>array(
				"CanteenOrder.user_id"=>$this->Auth->user("id")
			),
			"contain"=>array()
		));
		
		$this->set("orders",$orders);
		
	}
	
	
}
