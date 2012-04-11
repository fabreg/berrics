<?php

App::import("Controller","LocalApp");

class CanteenShippingRecordsController extends LocalAppController {
	
	
	
	public $uses = array("CanteenShippingRecord");
	
	
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
	
	
	
	
	
	
}
