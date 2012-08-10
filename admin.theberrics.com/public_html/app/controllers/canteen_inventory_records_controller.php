<?php

App::import("Controller","LocalApp");

class CanteenInventoryRecordsController extends LocalAppController {

	var $name = 'CanteenInventoryRecords';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function search() {
		
		if(count($this->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"search"=>true
				);
				
				
				foreach($this->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		

		
		
	}
	
	function index() {
		
		if(isset($this->params['named']['search'])) {
			
			if(isset($this->params['named']['CanteenInventoryRecord.name'])) {
				
				$this->paginate['conditions']['CanteenInventoryRecord.name LIKE'] = "%".str_replace(" ","%",$this->params['named']['CanteenInventoryRecord.name'])."%";
				
				$this->data['CanteenInventoryRecord']['name'] = $this->params['named']['CanteenInventoryRecord.name'];
				
			}
			
			if(isset($this->params['named']['CanteenInventoryRecord.foreign_key'])) {
			
				$this->paginate['conditions']['CanteenInventoryRecord.foreign_key LIKE'] = "%".str_replace(" ","%",$this->params['named']['CanteenInventoryRecord.foreign_key'])."%";
			
				$this->data['CanteenInventoryRecord']['foreign_key'] = $this->params['named']['CanteenInventoryRecord.foreign_key'];
			
			}
			
			
		}
		
		$this->CanteenInventoryRecord->recursive = 0;
		$this->set('canteenInventoryRecords', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid canteen inventory record', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('canteenInventoryRecord', $this->CanteenInventoryRecord->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CanteenInventoryRecord->create();
			$this->data['CanteenInventoryRecord']['allocated'] = 0;
			if ($this->CanteenInventoryRecord->save($this->data)) {
				$this->Session->setFlash(__('The canteen inventory record has been saved', true));
				
				if(isset($this->data['CanteenInventoryRecord']['canteen_product_id'])) {
					
					$this->CanteenInventoryRecord->CanteenProductInventory->create();
					$this->CanteenInventoryRecord->CanteenProductInventory->save(array(
						"canteen_inventory_record_id"=>$this->CanteenInventoryRecord->id,
						"canteen_product_id"=>$this->data['CanteenInventoryRecord']['canteen_product_id']
					));
					
					return $this->redirect(base64_decode($this->params['named']['callback']));
					
				}
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen inventory record could not be saved. Please, try again.', true));
			}
		}
		
		if(isset($this->params['named']['canteen_product_id'])) {
			
			$this->loadModel('CanteenProduct');
			
			$prod = $this->CanteenProduct->find("first",array(
				"conditions"=>array(
					"CanteenProduct.id"=>$this->params['named']['canteen_product_id']
				),
				"contain"=>array(
					"ParentCanteenProduct"=>array(
						"Brand"
					)
				)
			));
			
			$this->data['CanteenInventoryRecord']['name'] = $prod['ParentCanteenProduct']['Brand']['name']." ".$prod['ParentCanteenProduct']['name']." ".$prod['ParentCanteenProduct']['sub_title']." ".$prod['CanteenProduct']['opt_label']." ".$prod['CanteenProduct']['opt_value'];
			
		}
		
		$warehouses = $this->CanteenInventoryRecord->Warehouse->find('list');
		
		$this->set(compact('warehouses'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid canteen inventory record', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->CanteenInventoryRecord->save($this->data)) {
				$this->Session->setFlash(__('The canteen inventory record has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen inventory record could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CanteenInventoryRecord->read(null, $id);
		}
		$warehouses = $this->CanteenInventoryRecord->Warehouse->find('list');
		$this->set(compact('warehouses'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for canteen inventory record', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CanteenInventoryRecord->delete($id)) {
			$this->Session->setFlash(__('Canteen inventory record deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Canteen inventory record was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
	public function inventory_modal_search() {
		
		
		
	}
	
	public function inventory_modal_search_results() {
		
		if(count($this->data)) {
			
			$str = "%".str_replace(" ","%",$this->data['CanteenInventoryRecord']['name'])."%";
			
			$this->paginate['CanteenInventoryRecord']['conditions']['CanteenInventoryRecord.name LIKE'] = $str;
			$this->paginate['CanteenInventoryRecord']['contain'][] = "Warehouse";
			$records = $this->paginate("CanteenInventoryRecord");
			
			$this->set(compact("records"));
			
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}
