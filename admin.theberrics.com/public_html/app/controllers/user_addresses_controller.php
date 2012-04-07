<?php

App::import("Controller","LocalApp");

class UserAddressesController extends LocalAppController {

	var $name = 'UserAddresses';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->UserAddress->recursive = 0;
		$this->set('userAddresses', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user address', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('userAddress', $this->UserAddress->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UserAddress->create();
			if ($this->UserAddress->save($this->data)) {
				$this->Session->setFlash(__('The user address has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user address could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user address', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserAddress->save($this->data)) {
				$this->Session->setFlash(__('The user address has been saved', true));
				
				if(isset($this->params['named']['callback'])) {
					
					return $this->redirect(base64_decode($this->params['named']['callback']));
					
				}
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user address could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserAddress->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user address', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserAddress->delete($id)) {
			$this->Session->setFlash(__('User address deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User address was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
