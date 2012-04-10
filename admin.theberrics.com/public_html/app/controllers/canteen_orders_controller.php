<?php

App::import("Controller","LocalApp");

class CanteenOrdersController extends LocalAppController {
	
	public $uses = array('CanteenOrder');
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		$this->paginate['CanteenOrder'] = array(
			"order"=>array("CanteenOrder.created"=>"DESC"),
			"contain"=>array(
				"UserAddress"
			)
		);
		
		$orders = $this->Paginate("CanteenOrder");
		
		$this->set(compact("orders"));
		
	}
	
	public function edit($order_id) {
		
		$order = $this->CanteenOrder->returnAdminOrder($order_id);
		
		$this->data = $order;
		
	}
	
	
}