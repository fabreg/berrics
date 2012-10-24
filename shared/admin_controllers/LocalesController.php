<?php

App::import("Controller","LocalApp");

class LocalesController extends LocalAppController {

	var $name = 'Locales';
	public function beforeFilter() {

		parent::beforeFilter();

		$this->initPermissions();

	}
	function index() {
		$this->loadModel("Locale");
		die(print_r($this->Locale));
		$this->Locale->recursive = 0;
		$this->set('locales', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid locale'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('locale', $this->Locale->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Locale->create();
			if ($this->Locale->save($this->request->data)) {
				$this->Session->setFlash(__('The locale has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The locale could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid locale'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Locale->save($this->request->data)) {
				$this->Session->setFlash(__('The locale has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The locale could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Locale->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for locale'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Locale->delete($id)) {
			$this->Session->setFlash(__('Locale deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Locale was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
