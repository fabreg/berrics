<?php

App::import("Controller","AdminApp");


class UnifiedShopsController extends AdminAppController {

	
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
			$this->Session->setFlash(__('Invalid unified shop', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('unifiedShop', $this->UnifiedShop->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UnifiedShop->create();
			if ($this->UnifiedShop->save($this->data)) {
				$this->Session->setFlash(__('The unified shop has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The unified shop could not be saved. Please, try again.', true));
			}
		}
		
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid unified shop', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UnifiedShop->save($this->data)) {
				$this->Session->setFlash(__('The unified shop has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The unified shop could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UnifiedShop->read(null, $id);
		}
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for unified shop', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UnifiedShop->delete($id)) {
			$this->Session->setFlash(__('Unified shop deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Unified shop was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>