<?php

App::import("Controller","LocalApp");

class AccountController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		$this->enforceSSL();
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		//for now, lock it down to the canteen
		$lock_down = array("canteen","canteen_order_status");
		if(!in_array($this->params['action'],$lock_down)) {
			
			return $this->redirect("/account/canteen");
			
		}
		
		$this->theme = "account";
		
	}

	public function index() {
		
		
		
	}
	
	public function canteen($order_hash = false) {
		
		
		
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
	
	public function canteen_order_status($hash) {
		
		$this->loadModel("CanteenOrder");
		
		$order_id = $this->CanteenOrder->find("first",array(
			"conditions"=>array(
				"CanteenOrder.hash"=>$hash
			)
		));
		
		if(empty($order_id['CanteenOrder']['id'])) {
			
			return $this->cakeError("error404");
			
		}
		
		$order = $this->CanteenOrder->returnAdminOrder($order_id['CanteenOrder']['id'],array(
			"with_shipping_items"=>true
		));
		
		$this->set(compact("order"));
		
	}
	
	
}
