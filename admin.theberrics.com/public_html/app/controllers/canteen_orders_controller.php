<?php

App::import("Controller","LocalApp");

class CanteenOrdersController extends LocalAppController {
	
	public $uses = array('CanteenOrder');
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("barcode");
		
	}
	
	public function ajax_note_reply($id = false) {
		
				
		$this->loadModel("CanteenOrderNote");
		
		
		if(count($this->data)>0) {
			
			
			
			$reply_to = $this->CanteenOrderNote->findById($this->data['CanteenOrderNote']['parent_id']);
			
			$this->CanteenOrderNote->updateNoteStatus($this->data['CanteenOrderNote']['id'],"answered");
			
			if(!empty($reply_to['CanteenOrderNote']['parent_id'])) {
				
				$this->data['CanteenOrderNote']['parent_id'] = $reply_to['CanteenOrderNote']['parent_id'];
				
			}
			
			
			
			
			
		}
		
		
		//get the order note
		$note = $this->CanteenOrderNote->find("first",array(
			"conditions"=>array(
				"CanteenOrderNote.id"=>$id
			),
			"contain"=>array(
				"ChildCanteenOrderNote"=>array("User"),
				"User"
			)
		));
		
		$this->set(compact("note"));
		
	}
	
	public function search() {
		
		
		if(count($this->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=base64_encode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		
		//build some data menus
		
		$orderStatus = CanteenOrder::orderStatusDrop();
		
		$this->set(compact("orderStatus"));
		
		
		/*
		//build some menus
		if(($orderStatusMenu = Cache::read("orderStatus_menu","1min")) === false) {
			
			$orderStatus = $this->CanteenOrder->query("SELECT DISTINCT(order_status) FROM canteen_orders");
			
			$orderStatusMenu = array();
			
			foreach($orderStatus as $s) $orderStatusMenu[$s['canteen_orders']['order_status']] = strtoupper($s['canteen_orders']['order_status']);
			
			Cache::write($orderStatusMenu,"orderStatus_menu","1min");
			
		}
		
		if(($shippingStatusMenu = Cache::read("shippingStatus_menu","1min")) === false) {
			
			
			$shippingStatus = $this->CanteenOrder->query("SELECT DISTINCT(shipping_status) FROM canteen_orders");
			
			$shippingStatusMenu = array();
			
			foreach($shippingStatus as $s) $shippingStatusMenu[$s['canteen_orders']['shipping_status']] = strtoupper($s['canteen_orders']['shipping_status']);
			
			Cache::write($shippingStatusMenu,"shippingStatus_menu","1min");
			
		}
		
		if(($whStatusMenu = Cache::read("whStatus_menu","1min")) === false) {
			
			$whStatus = $this->CanteenOrder->query("SELECT DISTINCT(wh_status) FROM canteen_orders");
			
			$whStatusMenu = array();
			
			foreach($whStatus as $s) $whStatusMenu[$s['canteen_orders']['wh_status']] = strtoupper($s['canteen_orders']['wh_status']);
			
			Cache::write($whStatusMenu,"whStatus_menu","1min");
			
		}
		
		
		
		$this->set(compact("orderStatusMenu","shippingStatusMenu","whStatusMenu"));
		*/
		
	}
	
	public function index() {
		
		$this->paginate['CanteenOrder'] = array(
			"order"=>array("CanteenOrder.created"=>"DESC"),
			"contain"=>array(
				"UserAddress",
				"CanteenShippingRecord",
				"CanteenOrderItem",
				"GatewayTransaction"=>array("GatewayAccount")
			),
			"limit"=>50
		);
		
		$this->setOrderSearchParams();
		
		$orders = $this->Paginate("CanteenOrder");
		
		foreach($orders as $k=>$v) $orders[$k]['balance'] = $this->CanteenOrder->validateOrderBalance($v);
		
		$this->set(compact("orders"));
		
	}
	
	private function setOrderSearchParams() {
		
		if(!isset($this->params['named']['s'])) return false;
		
		if(isset($this->params['named']['CanteenOrder.order_status'])) {
			
			$this->paginate['CanteenOrder']['conditions']['CanteenOrder.order_status'] = base64_decode($this->params['named']['CanteenOrder.order_status']);
			
		}
		
		if(isset($this->params['named']['CanteenOrder.start_date']) && isset($this->params['named']['CanteenOrder.end_date'])) {
			
			
			$startDate = base64_decode($this->params['named']['CanteenOrder.start_date']);
			
			$endDate = base64_decode($this->params['named']['CanteenOrder.end_date']);
			
			$this->paginate['CanteenOrder']['conditions'][] = "DATE(CanteenOrder.created) BETWEEN '{$startDate}' AND '{$endDate}'";
			
		}
		
		//address stuff
		
		$order_ids = array();
		
		if(isset($this->params['named']['UserAddress.email']) || isset($this->params['named']['UserAddress.address_type'])) {
			
			if(isset($this->params['named']['UserAddress.email'])) {
				
				$a = $this->CanteenOrder->UserAddress->find("all",array(
					"contain"=>array(),
					"conditions"=>array(
						"UserAddress.model"=>"CanteenOrder",
						"UserAddress.address_type"=>"shipping",
						"UserAddress.email LIKE"=> "%".base64_decode($this->params['named']['UserAddress.email'])."%"
					),
					"fields"=>array("UserAddress.foreign_key")
				));
			
				$oids = Set::classicExtract($a,"{n}.UserAddress.foreign_key");
				
				if(count($oids)<=0) {
					
					$oids = array(1);
					
				}
				
				$order_ids = array_merge($order_ids,$oids);
				
				//remove any other address params
				foreach($this->params['named'] as $k=>$v) {
					
					if(preg_match('/^UserAddress/',$k) && !preg_match('/(\.email|\.address_type)/',$k)) {
						
						unset($this->params['named'][$k]);
						
					}
					
				}
				
			} else {
				
				
				
			}
			
		}
		
		if(count($order_ids)>0) $this->paginate['CanteenOrder']['conditions']['CanteenOrder.id'] = $order_ids;
		
		
		
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
	
	public function credit_items($order_id) {
		
		
		
	}
	
}