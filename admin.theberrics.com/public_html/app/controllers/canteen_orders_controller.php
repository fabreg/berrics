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
				"CanteenShippingRecord",
				"CanteenOrderItem",
				"GatewayTransaction"
			),
			"limit"=>50
		);
		
		$orders = $this->Paginate("CanteenOrder");
		
		foreach($orders as $k=>$v) $orders[$k]['balance'] = $this->CanteenOrder->validateOrderBalance($v);
		
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
	
	public function cancel_order($order_id,$override = false) {
		
		if(!$order_id) return $this->cakeError("error404");
		
		$order = $this->CanteenOrder->returnAdminOrder($order_id);
		
		$valid = array();
		
		
		
	}
	
	public function credit_totals($order_id = false) {
		
		if(!$order_id) return $this->cakeError("error404");
		
		if(count($this->data)>0) {
			
			
		}
		
		
		$order = $this->CanteenOrder->returnAdminOrder($order_id);
		
		$this->set(compact("order"));
		
	}
	
}