<?php

App::import("Controller","LocalApp");


class UnifiedShopsController extends LocalAppController {

	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
	
	}
	
	
	function index() {
		$this->UnifiedShop->recursive = 0;
		
		$this->paginate['UnifiedShop'] = array(
		
			"limit"=>100
		
		);
		
		
		$this->set('unifiedShops', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid unified shop'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('unifiedShop', $this->UnifiedShop->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->UnifiedShop->create();
			if ($this->UnifiedShop->save($this->request->data)) {
				$this->Session->setFlash(__('The unified shop has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The unified shop could not be saved. Please, try again.'));
			}
		}
		
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid unified shop'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UnifiedShop->save($this->request->data)) {
				$this->Session->setFlash(__('The unified shop has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The unified shop could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UnifiedShop->read(null, $id);
		}
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for unified shop'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UnifiedShop->delete($id)) {
			$this->Session->setFlash(__('Unified shop deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Unified shop was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>