<?php

App::import("Controller","LocalApp");

class LocalesController extends LocalAppController {

	var $name = 'Locales';
	public function beforeFilter() {

		parent::beforeFilter();

		$this->initPermissions();

	}
	function index() {
		$this->Locale->recursive = 0;
		$this->set('locales', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid locale', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('locale', $this->Locale->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Locale->create();
			if ($this->Locale->save($this->data)) {
				$this->Session->setFlash(__('The locale has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The locale could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid locale', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Locale->save($this->data)) {
				$this->Session->setFlash(__('The locale has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The locale could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Locale->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for locale', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Locale->delete($id)) {
			$this->Session->setFlash(__('Locale deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Locale was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
