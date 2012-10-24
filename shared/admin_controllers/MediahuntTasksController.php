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
			$this->Session->setFlash(__('Invalid mediahunt task'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('mediahuntTask', $this->MediahuntTask->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->MediahuntTask->create();
			if ($this->MediahuntTask->save($this->request->data)) {
				$this->Session->setFlash(__('The mediahunt task has been saved'));
				$redir = array('action' => 'index');
				
				if(isset($this->request->params['named']['callback'])) $redir = base64_decode($this->request->params['named']['callback']);
				
				$this->redirect($redir);
			} else {
				$this->Session->setFlash(__('The mediahunt task could not be saved. Please, try again.'));
			}
		}
		$mediahuntEvents = $this->MediahuntTask->MediahuntEvent->find('list');
		$this->set(compact('mediahuntEvents'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid mediahunt task'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->MediahuntTask->save($this->request->data)) {
				$this->Session->setFlash(__('The mediahunt task has been saved'));
				$redir = array('action' => 'index');
				
				if(isset($this->request->params['named']['callback'])) $redir = base64_decode($this->request->params['named']['callback']);
				
				$this->redirect($redir);
			} else {
				$this->Session->setFlash(__('The mediahunt task could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->MediahuntTask->read(null, $id);
		}
		$mediahuntEvents = $this->MediahuntTask->MediahuntEvent->find('list');
		$this->set(compact('mediahuntEvents'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for mediahunt task'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MediahuntTask->delete($id)) {
			$this->Session->setFlash(__('Mediahunt task deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Mediahunt task was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
