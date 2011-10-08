<?php

App::import("Controller","BerricsApp");

class AccountController extends BerricsAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}

	public function index() {
		
		
		
	}
	
	public function canteen() {
		
		$this->theme = "canteen";
		
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
