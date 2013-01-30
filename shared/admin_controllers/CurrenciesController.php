<?php

App::import("Controller","LocalApp");

class CurrenciesController extends LocalAppController {

	var $name = 'Currencies';

	public function beforeFilter() {
		
		parent::beforeFilter();
		$this->initPermissions();
		
	}
	
	function index() {
		$this->Currency->recursive = 0;
		$this->set('currencies', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid currency'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('currency', $this->Currency->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Currency->create();
			if ($this->Currency->save($this->request->data)) {
				$this->Session->setFlash(__('The currency has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The currency could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid currency'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Currency->save($this->request->data)) {
				$this->Session->setFlash(__('The currency has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The currency could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Currency->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for currency'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Currency->delete($id)) {
			$this->Session->setFlash(__('Currency deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Currency was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function ajax_convert($currency_from,$currency_to,$amount) {
		
		$value = $this->Currency->convertCurrency($currency_from,$currency_to,$amount);
		
		die(number_format($value,2));
		
	}
}
?>