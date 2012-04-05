<?php

App::import("Controller","LocalApp");

class CanteenInventoryRecordsController extends LocalAppController {

	var $name = 'CanteenInventoryRecords';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
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
			if ($this->CanteenInventoryRecord->save($this->data)) {
				$this->Session->setFlash(__('The canteen inventory record has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen inventory record could not be saved. Please, try again.', true));
			}
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
