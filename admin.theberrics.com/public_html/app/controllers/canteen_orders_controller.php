<?php

App::import("Controller","LocalApp");

class CanteenOrdersController extends LocalAppController {
	
	public $uses = array('CanteenOrder');
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("barcode");
		
	}
	
	public function index() {
		
		$this->paginate['CanteenOrder'] = array(
			"order"=>array("CanteenOrder.created"=>"DESC"),
			"contain"=>array(
				"UserAddress",
				"CanteenShippingRecord"
			),
			"limit"=>50
		);
		
		$orders = $this->Paginate("CanteenOrder");
		
		$this->set(compact("orders"));
		
	}
	
	public function edit($order_id) {
		
		$order = $this->CanteenOrder->returnAdminOrder($order_id);
		
		$this->data = $order;
		
	}
	
	public function print_order($id) {
		
		
		$order = $this->CanteenOrder->returnAdminOrder($id);
		
		$this->set(compact("order"));
		
		$this->render("/elements/canteen_printing/order-receipt");
		
	}
	
	public function barcode() {


		$this->layout = "empty";


	}
	
}