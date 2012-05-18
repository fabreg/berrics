<?php

App::import("Controller","LocalApp");

class CanteenShippingRecordsController extends LocalAppController {
	
	
	
	public $uses = array("CanteenShippingRecord","CanteenOrder");
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
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
			)
		);
		
		if(isset($this->params['named']['s'])) {
			
			if($this->params['named']['shipping_status']) {
				
				$this->paginate['CanteenShippingRecord']['conditions']['CanteenShippingRecord.shipping_status'] = $this->params['named']['shipping_status'];
				
			}
			
		}
		
		$records = $this->paginate("CanteenShippingRecord");
		
		$this->set(compact("records"));
		
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
	
	
	public function process_usps_shipment($id) {
		
		$record = $this->CanteenShippingRecord->process_usps_shipment($id);
		
		
		
		
	}
	
	
	public function ajax_lookup() {
		
		die(print_r($this->data));
		
	}
	
	
	
	
	
	
}
