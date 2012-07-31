<?php

App::import("Controller","LocalApp");

class MediahuntTasksController extends LocalAppController {

	var $name = 'MediahuntTasks';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->MediahuntTask->recursive = 0;
		$this->set('mediahuntTasks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid mediahunt task', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('mediahuntTask', $this->MediahuntTask->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->MediahuntTask->create();
			if ($this->MediahuntTask->save($this->data)) {
				$this->Session->setFlash(__('The mediahunt task has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mediahunt task could not be saved. Please, try again.', true));
			}
		}
		$mediahuntEvents = $this->MediahuntTask->MediahuntEvent->find('list');
		$this->set(compact('mediahuntEvents'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid mediahunt task', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->MediahuntTask->save($this->data)) {
				$this->Session->setFlash(__('The mediahunt task has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mediahunt task could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MediahuntTask->read(null, $id);
		}
		$mediahuntEvents = $this->MediahuntTask->MediahuntEvent->find('list');
		$this->set(compact('mediahuntEvents'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for mediahunt task', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MediahuntTask->delete($id)) {
			$this->Session->setFlash(__('Mediahunt task deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Mediahunt task was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
