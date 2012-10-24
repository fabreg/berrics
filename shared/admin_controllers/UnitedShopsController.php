<?php
class UnitedShopsController extends AppController {

	var $name = 'UnitedShops';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->UnitedShop->recursive = 0;
		$this->set('unitedShops', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid united shop'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('unitedShop', $this->UnitedShop->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->UnitedShop->create();
			if ($this->UnitedShop->save($this->request->data)) {
				$this->Session->setFlash(__('The united shop has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The united shop could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid united shop'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UnitedShop->save($this->request->data)) {
				$this->Session->setFlash(__('The united shop has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The united shop could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UnitedShop->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for united shop'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UnitedShop->delete($id)) {
			$this->Session->setFlash(__('United shop deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('United shop was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>