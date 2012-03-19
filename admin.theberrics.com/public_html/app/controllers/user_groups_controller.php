<?php

App::import("Controller","LocalApp");

class UserGroupsController extends LocalAppController {

	var $name = 'UserGroups';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->UserGroup->recursive = 0;
		$this->set('userGroups', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user group', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('userGroup', $this->UserGroup->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UserGroup->create();
			if ($this->UserGroup->save($this->data)) {
				$this->Session->setFlash(__('The user group has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user group could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user group', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserGroup->save($this->data)) {
				$this->Session->setFlash(__('The user group has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user group could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserGroup->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user group', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserGroup->delete($id)) {
			$this->Session->setFlash(__('User group deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User group was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>