<?php

App::import("Controller","LocalApp");

class GatewayTransactionsController extends LocalAppController {

	var $name = 'GatewayTransactions';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->GatewayTransaction->recursive = 0;
		$this->set('gatewayTransactions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid gateway transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('gatewayTransaction', $this->GatewayTransaction->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->GatewayTransaction->create();
			if ($this->GatewayTransaction->save($this->data)) {
				$this->Session->setFlash(__('The gateway transaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gateway transaction could not be saved. Please, try again.', true));
			}
		}
		$gatewayAccounts = $this->GatewayTransaction->GatewayAccount->find('list');
		$this->set(compact('gatewayAccounts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid gateway transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->GatewayTransaction->save($this->data)) {
				$this->Session->setFlash(__('The gateway transaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gateway transaction could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->GatewayTransaction->read(null, $id);
		}
		$gatewayAccounts = $this->GatewayTransaction->GatewayAccount->find('list');
		$this->set(compact('gatewayAccounts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for gateway transaction', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GatewayTransaction->delete($id)) {
			$this->Session->setFlash(__('Gateway transaction deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Gateway transaction was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>