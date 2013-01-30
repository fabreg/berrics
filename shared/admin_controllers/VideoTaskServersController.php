<?php
App::uses('LocalAppController', 'Controller');
/**
 * VideoTaskServers Controller
 *
 * @property VideoTaskServer $VideoTaskServer
 */
class VideoTaskServersController extends LocalAppController {

	public function beforeFilter() {
			
		parent::beforeFilter();

		$this->initPermissions();


	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->VideoTaskServer->recursive = 0;
		$this->set('videoTaskServers', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->VideoTaskServer->id = $id;
		if (!$this->VideoTaskServer->exists()) {
			throw new NotFoundException(__('Invalid video task server'));
		}
		$this->set('videoTaskServer', $this->VideoTaskServer->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->VideoTaskServer->create();
			if ($this->VideoTaskServer->save($this->request->data)) {
				$this->Session->setFlash(__('The video task server has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video task server could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->VideoTaskServer->id = $id;
		if (!$this->VideoTaskServer->exists()) {
			throw new NotFoundException(__('Invalid video task server'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->VideoTaskServer->save($this->request->data)) {
				$this->Session->setFlash(__('The video task server has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video task server could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->VideoTaskServer->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->VideoTaskServer->id = $id;
		if (!$this->VideoTaskServer->exists()) {
			throw new NotFoundException(__('Invalid video task server'));
		}
		if ($this->VideoTaskServer->delete()) {
			$this->Session->setFlash(__('Video task server deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Video task server was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
