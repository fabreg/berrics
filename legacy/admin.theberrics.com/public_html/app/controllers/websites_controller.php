<?php

App::import("Controller","LocalApp");


class WebsitesController extends LocalAppController {

	var $name = 'Websites';
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}

	function index() {
		$this->Website->recursive = 0;
		$this->set('websites', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid website', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('website', $this->Website->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Website->create();
			if ($this->Website->save($this->data)) {
				$this->Session->setFlash(__('The website has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The website could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid website', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Website->save($this->data)) {
				$this->Session->setFlash(__('The website has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The website could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Website->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for website', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Website->delete($id)) {
			$this->Session->setFlash(__('Website deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Website was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>