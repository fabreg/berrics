<?php
App::uses('LocalAppController', 'Controller');
/**
 * DailyopsConfigs Controller
 *
 * @property DailyopsConfig $DailyopsConfig
 */
class DailyopsConfigsController extends LocalAppController {

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
		$this->DailyopsConfig->recursive = 0;
		$this->set('dailyopsConfigs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->DailyopsConfig->id = $id;
		if (!$this->DailyopsConfig->exists()) {
			throw new NotFoundException(__('Invalid dailyops config'));
		}
		$this->set('dailyopsConfig', $this->DailyopsConfig->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DailyopsConfig->create();
			if ($this->DailyopsConfig->save($this->request->data)) {
				$this->Session->setFlash(__('The dailyops config has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dailyops config could not be saved. Please, try again.'));
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
		$this->DailyopsConfig->id = $id;
		if (!$this->DailyopsConfig->exists()) {
			throw new NotFoundException(__('Invalid dailyops config'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DailyopsConfig->save($this->request->data)) {
				$this->Session->setFlash(__('The dailyops config has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dailyops config could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->DailyopsConfig->read(null, $id);
		}
	}



	public function edit_date($date = false) {
		
		if($this->request->is("post") || $this->request->is("put")) {
			
			$this->DailyopsConfig->create();

			$this->DailyopsConfig->id = $this->request->data['DailyopsConfig']['id'];

			$this->DailyopsConfig->save($this->request->data);

			$this->request->data = $this->DailyopsConfig->read();

			$this->Session->setFlash("Updated");
		 
		} else {

			$chk = $this->DailyopsConfig->findByDailyopsDate($date);

			if(!isset($chk['DailyopsConfig']['id'])) {

				$this->DailyopsConfig->create();

				$this->DailyopsConfig->save(array(
							"post_frequency"=>2,
							"dailyops_date"=>$date
						));
				$chk = $this->DailyopsConfig->read();
			}

			$this->request->data = $chk;

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
		$this->DailyopsConfig->id = $id;
		if (!$this->DailyopsConfig->exists()) {
			throw new NotFoundException(__('Invalid dailyops config'));
		}
		if ($this->DailyopsConfig->delete()) {
			$this->Session->setFlash(__('Dailyops config deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Dailyops config was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
