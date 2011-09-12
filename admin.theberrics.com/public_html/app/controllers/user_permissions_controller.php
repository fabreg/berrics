<?php
App::import("Controller","AdminApp");
class UserPermissionsController extends AdminAppController {

	var $name = 'UserPermissions';

	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	function index() {
		$this->UserPermission->recursive = 0;
		$this->set('userPermissions', $this->paginate());

	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user permission', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('userPermission', $this->UserPermission->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UserPermission->create();
			if ($this->UserPermission->save($this->data)) {
				$this->Session->setFlash(__('The user permission has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user permission could not be saved. Please, try again.', true));
			}
		}
		$userGroups = $this->UserPermission->UserGroup->find('list');
		//$users = $this->UserPermission->User->userSelectList();
		$this->set(compact('userGroups'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user permission', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UserPermission->save($this->data)) {
				$this->Session->setFlash(__('The user permission has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user permission could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UserPermission->read(null, $id);
		}
		$userGroups = $this->UserPermission->UserGroup->find('list');
		$users = $this->UserPermission->User->userSelectList();
		$this->set(compact('userGroups', 'users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user permission', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserPermission->delete($id)) {
			$this->Session->setFlash(__('User permission deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User permission was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>