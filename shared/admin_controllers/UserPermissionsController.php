<?php
App::import("Controller","LocalApp");
class UserPermissionsController extends LocalAppController {

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
			$this->Session->setFlash(__('Invalid user permission'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('userPermission', $this->UserPermission->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->UserPermission->create();
			if ($this->UserPermission->save($this->request->data)) {
				$this->Session->setFlash(__('The user permission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user permission could not be saved. Please, try again.'));
			}
		}
		$userGroups = $this->UserPermission->UserGroup->find('list');
		//$users = $this->UserPermission->User->userSelectList();
		$this->set(compact('userGroups'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user permission'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->UserPermission->save($this->request->data)) {
				$this->Session->setFlash(__('The user permission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user permission could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->UserPermission->read(null, $id);
		}
		$userGroups = $this->UserPermission->UserGroup->find('list');
		$users = $this->UserPermission->User->userSelectList();
		$this->set(compact('userGroups', 'users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user permission'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->UserPermission->delete($id)) {
			$this->Session->setFlash(__('User permission deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User permission was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>