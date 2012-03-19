<?php

App::import("Controller","LocalApp");

class EmailMessagesController extends LocalAppController {

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->EmailMessage->recursive = 0;
		$this->set('emailMessages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid email message', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('emailMessage', $this->EmailMessage->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EmailMessage->create();
			if ($this->EmailMessage->save($this->data)) {
				$this->Session->setFlash(__('The email message has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email message could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid email message', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailMessage->save($this->data)) {
				$this->Session->setFlash(__('The email message has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email message could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailMessage->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for email message', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailMessage->delete($id)) {
			$this->Session->setFlash(__('Email message deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Email message was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>