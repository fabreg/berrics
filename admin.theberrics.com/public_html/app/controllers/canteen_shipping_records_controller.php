<?php

App::import("Controller","LocalApp");

class CanteenShippingRecordsController extends LocalAppController {
	
	
	
	public $uses = array("CanteenShippingRecord","CanteenOrder");
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function search() {
		
		if(count($this->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		

		
		
	}
	
	private function setSelects() {
		
		//warehouses
		
		$whSelect = $this->CanteenShippingRecord->Warehouse->find("list");
		
		$statusSelect = array(
			"processing"=>"processing",
			"pending"=>"pending",
			"shipped"=>"shipped",
			"canceled"=>"canceled"
		);
		
		$this->set(compact("whSelect","statusSelect"));
		
	}
	
	public function index() {
		
		$this->paginate['CanteenShippingRecord'] = array(
			"order"=>array(
				"CanteenShippingRecord.created"=>"DESC"
			),
			"contain"=>array(
				"UserAddress",
				"CanteenOrder",
				"Warehouse"
			),
			"limit"=>50
		);
		
		if(isset($this->params['named']['s'])) {
			
			if(isset($this->params['named']['CanteenShippingRecord.shipping_status'])) {
				
				$this->paginate['CanteenShippingRecord']['conditions']['CanteenShippingRecord.shipping_status'] = $this->params['named']['CanteenShippingRecord.shipping_status'];
				
			}
			
			if(isset($this->params['named']['CanteenShippingRecord.warehouse_id']) && !empty($this->params['named']['CanteenShippingRecord.warehouse_id'])) {
				
				$this->paginate['CanteenShippingRecord']['conditions']['CanteenShippingRecord.warehouse_id'] = 
				$this->data['CanteenShippingRecord']['warehouse_id'] = 
																		$this->params['named']['CanteenShippingRecord.warehouse_id'];
				
				
			}
			
			if(isset($this->params['named']['CanteenShippingRecord.shipping_status']) && !empty($this->params['named']['CanteenShippingRecord.shipping_status'])) {
				
				$this->paginate['CanteenShippingRecord']['conditions']['CanteenShippingRecord.shipping_status'] = 
				$this->data['CanteenShippingRecord']['shipping_status'] = 
																		$this->params['named']['CanteenShippingRecord.shipping_status'];
				
				
			}
			
		}
		
		$records = $this->paginate("CanteenShippingRecord");
		
		$this->set(compact("records"));
		
		$this->setSelects();
		
	}
	
	public function edit($id = false) {
		
		if(count($this->data)>0) {
			
			
			
			
		} else {
			
			$this->data = $this->CanteenShippingRecord->returnAdminRecord($id);
			
		}
		
	}
	
	public function print_record($id) {
		
		$this->set("record",$this->CanteenShippingRecord->returnAdminRecord($id));
		
		$this->render("/elements/canteen_printing/shipping-record");
		
	}
	
	public function process_usps_single($id) {
		
		$record = $this->CanteenShippingRecord->process_usps_shipment($id);
		
	}
	
	
	public function process_usps_shipment($id) {
		
		$record = $this->CanteenShippingRecord->process_usps_shipment($id);

	}
	
	public function usps_combo_label($id) {
		
		$record = $this->CanteenShippingRecord->returnAdminRecord($id);
		
		$this->set(compact("record"));
		
		$this->render("/elements/canteen_printing/usps-combo-label");
		
	}
	
	public function checkout_shipments() {
		
		
		
	}
	
	public function ajax_checkout_shipments() {
		
		
		$record = $this->CanteenShippingRecord->find("first",array(
			"conditions"=>array(
				"OR"=>array(
					"CanteenShippingRecord.tracking_number"=>$this->data['CanteenShippingRecord']['ref_number'],
					"CanteenShippingRecord.shipment_number"=>$this->data['CanteenShippingRecord']['ref_number']
				)
			),
			"contain"=>array(
				"CanteenOrderItem"
			)
		));
		
		//move record to shipped
		$this->CanteenShippingRecord->create();
		$this->CanteenShippingRecord->id = $record['CanteenShippingRecord']['id'];
		$this->CanteenShippingRecord->save(array(
			"shipping_status"=>"shipped"
		));
		
		
		$process_inventory = false;
		$send_email = false;
		
		//should we checkout inventory?
		if($this->data['CanteenShippingRecord']['process_inventory']==1) {
			
			$this->loadModel("CanteenOrderItem");
			
			foreach($record['CanteenOrderItem'] as $i) {
				
				$this->CanteenOrderItem->processLineItemInventory($i['id']);
				
			}
			
			$process_inventory = true;
			
		}
		
		//send customer email
		if($this->data['CanteenShippingRecord']['send_customer_email']==1) {
			
			$this->loadModel("EmailMessage");
			
			$this->EmailMessage->sendCanteenShippingConfirmation($record['CanteenShippingRecord']['id']);
			
			$send_email = true;
			
		}
		
		$this->set(compact("record","process_inventory","send_email"));
		
	}
	
	public function ajax_lookup() {
		
		die(print_r($this->data));
		
	}
	
	
	
	
	
	
}
