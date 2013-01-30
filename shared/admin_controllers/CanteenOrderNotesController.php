<?php

App::import("Controller","LocalApp");

class CanteenOrderNotesController extends LocalAppController {

	var $name = 'CanteenOrderNotes';


	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->CanteenOrderNote->recursive = 0;
		$this->set('canteenOrderNotes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid canteen order note'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('canteenOrderNote', $this->CanteenOrderNote->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->CanteenOrderNote->create();
			if ($this->CanteenOrderNote->save($this->request->data)) {
				$this->Session->setFlash(__('The canteen order note has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen order note could not be saved. Please, try again.'));
			}
		}
		$users = $this->CanteenOrderNote->User->find('list');
		$parentCanteenOrderNotes = $this->CanteenOrderNote->ParentCanteenOrderNote->find('list');
		$canteenOrders = $this->CanteenOrderNote->CanteenOrder->find('list');
		$this->set(compact('users', 'parentCanteenOrderNotes', 'canteenOrders'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid canteen order note'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->CanteenOrderNote->save($this->request->data)) {
				$this->Session->setFlash(__('The canteen order note has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen order note could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CanteenOrderNote->read(null, $id);
		}
		$users = $this->CanteenOrderNote->User->find('list');
		$parentCanteenOrderNotes = $this->CanteenOrderNote->ParentCanteenOrderNote->find('list');
		$canteenOrders = $this->CanteenOrderNote->CanteenOrder->find('list');
		$this->set(compact('users', 'parentCanteenOrderNotes', 'canteenOrders'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for canteen order note'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CanteenOrderNote->delete($id)) {
			$this->Session->setFlash(__('Canteen order note deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Canteen order note was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
