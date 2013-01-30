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
			$this->Session->setFlash(__('Invalid website'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('website', $this->Website->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Website->create();
			if ($this->Website->save($this->request->data)) {
				$this->Session->setFlash(__('The website has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The website could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid website'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Website->save($this->request->data)) {
				$this->Session->setFlash(__('The website has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The website could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Website->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for website'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Website->delete($id)) {
			$this->Session->setFlash(__('Website deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Website was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>