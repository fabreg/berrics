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
			$this->Session->setFlash(__('Invalid warehouse'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('warehouse', $this->Warehouse->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Warehouse->create();
			if ($this->Warehouse->save($this->request->data)) {
				$this->Session->setFlash(__('The warehouse has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The warehouse could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid warehouse'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Warehouse->save($this->request->data)) {
				$this->Session->setFlash(__('The warehouse has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The warehouse could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Warehouse->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for warehouse'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Warehouse->delete($id)) {
			$this->Session->setFlash(__('Warehouse deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Warehouse was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
