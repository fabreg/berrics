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
			$this->Session->setFlash(__('Invalid user address'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('userAddress', $this->UserAddress->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->UserAddress->create();
			if ($this->UserAddress->save($this->request->data)) {
				$this->Session->setFlash(__('The user address has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user address could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user address'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			$this->UserAddress->id = $this->request->data['UserAddress']['Update']['id'];
			
			if ($this->UserAddress->save($this->request->data['UserAddress']['Update'])) {
				$this->Session->setFlash(__('The user address has been saved'));
				
				if(isset($this->request->params['named']['callback'])) {
					
					return $this->redirect(base64_decode($this->request->params['named']['callback']));
					
				}
				
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user address could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			
			$data = $this->UserAddress->read(null, $id);
			
			$this->request->data['UserAddress']['Update'] = $data['UserAddress'];
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user address'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserAddress->delete($id)) {
			$this->Session->setFlash(__('User address deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User address was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
