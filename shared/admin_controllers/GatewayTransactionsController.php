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
			$this->Session->setFlash(__('Invalid gateway transaction'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('gatewayTransaction', $this->GatewayTransaction->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->GatewayTransaction->create();
			if ($this->GatewayTransaction->save($this->request->data)) {
				$this->Session->setFlash(__('The gateway transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gateway transaction could not be saved. Please, try again.'));
			}
		}
		$gatewayAccounts = $this->GatewayTransaction->GatewayAccount->find('list');
		$this->set(compact('gatewayAccounts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid gateway transaction'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->GatewayTransaction->save($this->request->data)) {
				$this->Session->setFlash(__('The gateway transaction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gateway transaction could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->GatewayTransaction->read(null, $id);
		}
		$gatewayAccounts = $this->GatewayTransaction->GatewayAccount->find('list');
		$this->set(compact('gatewayAccounts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for gateway transaction'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GatewayTransaction->delete($id)) {
			$this->Session->setFlash(__('Gateway transaction deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Gateway transaction was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>