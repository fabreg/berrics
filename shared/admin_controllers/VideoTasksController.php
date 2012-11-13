<?php
App::uses('LocalAppController', 'Controller');
/**
 * VideoTasks Controller
 *
 * @property VideoTask $VideoTask
 */
class VideoTasksController extends LocalAppController {


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
		$this->VideoTask->recursive = 0;

		$this->Paginator->settings = array(
			"VideoTask"=>array(
				"contain"=>array(
					"User"
				),
				"order"=>array("VideoTask.id"=>"DESC")
			),

		);

		$this->set('videoTasks', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->VideoTask->id = $id;
		if (!$this->VideoTask->exists()) {
			throw new NotFoundException(__('Invalid video task'));
		}
		$this->set('videoTask', $this->VideoTask->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->VideoTask->create();
			if ($this->VideoTask->save($this->request->data)) {
				$this->Session->setFlash(__('The video task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video task could not be saved. Please, try again.'));
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
		$this->VideoTask->id = $id;
		if (!$this->VideoTask->exists()) {
			throw new NotFoundException(__('Invalid video task'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->VideoTask->save($this->request->data)) {
				$this->Session->setFlash(__('The video task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The video task could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->VideoTask->read(null, $id);
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
		$this->VideoTask->id = $id;
		if (!$this->VideoTask->exists()) {
			throw new NotFoundException(__('Invalid video task'));
		}
		if ($this->VideoTask->delete()) {
			$this->Session->setFlash(__('Video task deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Video task was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
