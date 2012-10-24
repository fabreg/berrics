<?php

App::import("Controller","LocalApp");

class CanteenShippingRecordsController extends LocalAppController {
	
	
	
	public $uses = array("CanteenShippingRecord","CanteenOrder");
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function search() {
		
		if(count($this->request->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->request->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						if(empty($vv)) continue;

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
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['CanteenShippingRecord'] = array(
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
		
		if(isset($this->request->params['named']['s'])) {
			
			if(isset($this->request->params['named']['CanteenShippingRecord.id'])) {
				
				$this->Paginator->settings['CanteenShippingRecord']['conditions']['CanteenShippingRecord.id LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['CanteenShippingRecord.id'])."%";
				
				$this->request->data['CanteenShippingRecord']['id'] = $this->request->params['named']['CanteenShippingRecord.id'];
				
			}
			
			if(isset($this->request->params['named']['CanteenShippingRecord.warehouse_id']) && !empty($this->request->params['named']['CanteenShippingRecord.warehouse_id'])) {
				
				$this->Paginator->settings['CanteenShippingRecord']['conditions']['CanteenShippingRecord.warehouse_id'] = 
				$this->request->data['CanteenShippingRecord']['warehouse_id'] = 
																		$this->request->params['named']['CanteenShippingRecord.warehouse_id'];
				
				
			}
			
			if(isset($this->request->params['named']['CanteenShippingRecord.shipping_status']) && !empty($this->request->params['named']['CanteenShippingRecord.shipping_status'])) {
				
				$this->Paginator->settings['CanteenShippingRecord']['conditions']['CanteenShippingRecord.shipping_status'] = 
				$this->request->data['CanteenShippingRecord']['shipping_status'] = 
																		$this->request->params['named']['CanteenShippingRecord.shipping_status'];
				
				
			}
			
		}
		
		$records = $this->paginate("CanteenShippingRecord");
		
		$this->set(compact("records"));
		
		$this->setSelects();
		
	}
	
	public function edit($id = false) {
		
		if(count($this->request->data)>0) {
			
			
			
			
		} else {
			
			$this->request->data = $this->CanteenShippingRecord->returnAdminRecord($id);
			
		}
		
	}
	
	public function add() {
		
		
		
		if(count($this->request->data)>0) {
			
			$this->CanteenShippingRecord->create();
			
			$this->CanteenShippingRecord->save($this->request->data);
			
			$r = "/canteen_shipping_records";
			
			if(isset($this->request->params['named']['callback'])) {
				
				$r = base64_decode($this->request->params['named']['callback']);
				
			}
			
			return $this->redirect($r);
			
		}
		
		
		if(isset($this->request->params['named']['canteen_order_id'])) {
			
			$this->request->data['CanteenShippingRecord']['canteen_order_id'] = $this->request->params['named']['canteen_order_id'];
			
		}
		
		$this->setSelects();
		
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
					"CanteenShippingRecord.tracking_number"=>$this->request->data['CanteenShippingRecord']['ref_number'],
					"CanteenShippingRecord.shipment_number"=>$this->request->data['CanteenShippingRecord']['ref_number']
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
		if($this->request->data['CanteenShippingRecord']['process_inventory']==1) {
			
			$this->loadModel("CanteenOrderItem");
			
			foreach($record['CanteenOrderItem'] as $i) {
				
				$this->CanteenOrderItem->processLineItemInventory($i['id']);
				
			}
			
			$process_inventory = true;
			
		}
		
		//send customer email
		if($this->request->data['CanteenShippingRecord']['send_customer_email']==1) {
			
			$this->loadModel("EmailMessage");
			
			$this->EmailMessage->sendCanteenShippingConfirmation($record['CanteenShippingRecord']['id']);
			
			$send_email = true;
			
		}
		
		$this->set(compact("record","process_inventory","send_email"));
		
	}
	
	public function ajax_lookup() {
		
		die(print_r($this->request->data));
		
	}
	
	
	
	public function batch_operation() {
		
		switch($this->request->data['Command']) {
			
			case 'process_usps_print':
				$this->process_usps_batch($this->request->data['canteen_shipping_record_id'],true);
				break;
			case "usps_print":
				$ids = base64_encode(serialize($this->request->data['canteen_shipping_record_id']));
				return $this->redirect(array("action"=>"print_usps_combo_batch",$ids));
				break;
		}
		
		
	}

	private function process_usps_batch($ids = array(),$print = true) {
		
		$orders_to_print = array();
		
		foreach($ids as $v) {
			
			$record = $this->CanteenShippingRecord->findById($v);
			
			if(empty($record['CanteenShippingRecord']['shipment_number'])) {
				
				$record = $this->CanteenShippingRecord->process_usps_shipment($v);
				
			}
			
			
			if(isset($record['CanteenShippingRecord']['shipment_number']) && !empty($record['CanteenShippingRecord']['shipment_number'])) {
				
				$orders_to_print[] = $record['CanteenShippingRecord']['id'];
				
			}
			
		}
		
		if($print) {
			
			$ids = base64_encode(serialize($orders_to_print));
			
			return $this->redirect("/canteen_shipping_records/print_usps_combo_batch/{$ids}");
			
		}
		
		
	}
	
	public function print_usps_combo_batch($str = false) {
	
		$ids = unserialize(base64_decode($str));
		
		$records = array();
		
		foreach($ids as $v) {
			
			$r = $this->CanteenShippingRecord->returnAdminRecord($v);
			
			if(!empty($r['CanteenShippingRecord']['shipment_number'])) {
				
				$records[] = $r;
				
			}
			
		}
		
		$this->set(compact("records"));
	
	}
	
	public function usps_rate_calculator() {
		
		
		if(isset($this->request->data)) {
			
			App::import("Vendor","Usps",array("file"=>"UspsApi.php"));
			
			$u = new UspsApi();
			
			switch($this->request->data['CalcRate']['command']) {
				
				case "dom":
						$res = $u->calc_dom_rate($this->request->data['CalcRate']);
			
						$xml = simplexml_load_string($res);
						
						$this->set(compact("xml"));
						
						return $this->render("/elements/canteen_shipping_records/dom-rate-result");
			
					break;
				case "int":
						
						$c = Arr::countries();
						
						$this->request->data['CalcRate']['country'] = $c[$this->request->data['CalcRate']['country']];
						
						$res = $u->calc_int_rate($this->request->data['CalcRate']);
			
						$xml = simplexml_load_string($res);
						
						$this->set(compact("xml"));
						
						return $this->render("/elements/canteen_shipping_records/int-rate-result");
					break;
				
			}
			$res = $u->calc_dom_rate($this->request->data['CalcRate']);
			
			$xml = simplexml_load_string($res);
			
			$this->set(compact("xml"));
			
			return $this->render("/elements/canteen_shipping_records/dom-rate-result");
			
		}
		
		
	}
	
	public function lajolla_tracking_files() {
	
		$this->loadModel("LjgTrackingFile");
		
		$this->paginate['LjgTrackingFile'] = array(
			"conditions"=>array(
			
			),
			"order"=>array(
				"LjgTrackingFile.id"=>"DESC"
			),
			"limit"=>100
		);
		
		$files = $this->paginate("LjgTrackingFile");
		
		$this->set(compact("files"));
				
	
	}
	
	public function view_lajolla_tracking_file($file_id) {
		
		$this->loadModel("LjgTrackingFile");
		
		$file = $this->LjgTrackingFile->findById($file_id);
		
		$str = file_get_contents("/home/sites/lajolla/tracking/".$file['LjgTrackingFile']['file_name']);
		
		die("<pre>{$str}</pre>");
		
	}
	
	public function process_tracking_file($file_id) {
		
		//$this->loadModel("LjgTrackingFile");
		
		//$file = $this->LjgTrackingFile->findById($file_id);
		
		$this->CanteenShippingRecord->ljg_process_tracking_file($file_id);
		
	}
	
	public function checkout_shipment($id = false,$cb) {
		
		$record = $this->CanteenShippingRecord->findById($id);
		
		$this->CanteenShippingRecord->checkout_shipment($record,true,true);
		
		return $this->redirect(base64_decode($cb));
		
	}
	
}
