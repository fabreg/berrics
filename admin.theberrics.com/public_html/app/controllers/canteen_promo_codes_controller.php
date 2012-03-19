<?php

App::import("Controller","LocalApp");

class CanteenPromoCodesController extends LocalAppController {

	var $name = 'CanteenPromoCodes';
	
	public function beforeFilter() {
		
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	
	function index() {
		$this->CanteenPromoCode->recursive = 0;
		$this->set('canteenPromoCodes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid canteen promo code', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('canteenPromoCode', $this->CanteenPromoCode->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CanteenPromoCode->create();
			if ($this->CanteenPromoCode->save($this->data)) {
				$this->Session->setFlash(__('The canteen promo code has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen promo code could not be saved. Please, try again.', true));
			}
		}
		$users = $this->CanteenPromoCode->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid canteen promo code', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->CanteenPromoCode->save($this->data)) {
				$this->Session->setFlash(__('The canteen promo code has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen promo code could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CanteenPromoCode->read(null, $id);
		}
		$users = $this->CanteenPromoCode->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for canteen promo code', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CanteenPromoCode->delete($id)) {
			$this->Session->setFlash(__('Canteen promo code deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Canteen promo code was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>