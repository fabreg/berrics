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
			$this->Session->setFlash(__('Invalid canteen order note', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('canteenOrderNote', $this->CanteenOrderNote->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CanteenOrderNote->create();
			if ($this->CanteenOrderNote->save($this->data)) {
				$this->Session->setFlash(__('The canteen order note has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen order note could not be saved. Please, try again.', true));
			}
		}
		$users = $this->CanteenOrderNote->User->find('list');
		$parentCanteenOrderNotes = $this->CanteenOrderNote->ParentCanteenOrderNote->find('list');
		$canteenOrders = $this->CanteenOrderNote->CanteenOrder->find('list');
		$this->set(compact('users', 'parentCanteenOrderNotes', 'canteenOrders'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid canteen order note', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->CanteenOrderNote->save($this->data)) {
				$this->Session->setFlash(__('The canteen order note has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen order note could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CanteenOrderNote->read(null, $id);
		}
		$users = $this->CanteenOrderNote->User->find('list');
		$parentCanteenOrderNotes = $this->CanteenOrderNote->ParentCanteenOrderNote->find('list');
		$canteenOrders = $this->CanteenOrderNote->CanteenOrder->find('list');
		$this->set(compact('users', 'parentCanteenOrderNotes', 'canteenOrders'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for canteen order note', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CanteenOrderNote->delete($id)) {
			$this->Session->setFlash(__('Canteen order note deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Canteen order note was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
