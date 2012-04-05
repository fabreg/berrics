<?php

App::import("Controller","LocalApp");

class WarehousesController extends LocalAppController {

	var $name = 'Warehouses';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->Warehouse->recursive = 0;
		$this->set('warehouses', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid warehouse', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('warehouse', $this->Warehouse->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Warehouse->create();
			if ($this->Warehouse->save($this->data)) {
				$this->Session->setFlash(__('The warehouse has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The warehouse could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid warehouse', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Warehouse->save($this->data)) {
				$this->Session->setFlash(__('The warehouse has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The warehouse could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Warehouse->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for warehouse', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Warehouse->delete($id)) {
			$this->Session->setFlash(__('Warehouse deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Warehouse was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
