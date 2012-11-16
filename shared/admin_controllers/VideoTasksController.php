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



	public function search() {
		
		if(count($this->request->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"search"=>true
				);
				
				
				foreach($this->request->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						if(empty($vv)) continue;

						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}

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
				"order"=>array("VideoTask.id"=>"DESC"),
				"limit"=>50
			),

		);

		if(isset($this->request->params['named']['search'])) {

			if(isset($this->request->params['named']['VideoTask.task_status'])) {

				$this->request->data['VideoTask']['task_status'] = 
				$this->Paginator->settings['VideoTask']['conditions']['VideoTask.task_status'] = 
				$this->request->params['named']['VideoTask.task_status'];


			}

			if(isset($this->request->params['named']['VideoTask.task'])) {

				$this->request->data['VideoTask']['task'] = 
				$this->Paginator->settings['VideoTask']['conditions']['VideoTask.task'] = 
				$this->request->params['named']['VideoTask.task'];


			}

			if(isset($this->request->params['named']['VideoTask.server'])) {

				$this->request->data['VideoTask']['server'] = 
				$this->Paginator->settings['VideoTask']['conditions']['VideoTask.server'] = 
				$this->request->params['named']['VideoTask.server'];


			}


		}

		$this->setSelects();
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


	public function setSelects() {
			
		$taskStatus = array();

		$status  = $this->VideoTask->find("all",array(
			"fields"=>array(
				"DISTINCT(VideoTask.task_status) AS `status`"
			),
			"contain"=>array(),
			"order"=>array(
				"VideoTask.task_status"=>"DESC"
			)
		));
		foreach($status as $v) {

			$taskStatus[$v['VideoTask']['status']] = strtoupper($v['VideoTask']['status']);

		}

		$tasks = array();

		$task  = $this->VideoTask->find("all",array(
			"fields"=>array(
				"DISTINCT(VideoTask.task) AS `task`"
			),
			"contain"=>array(),
			"order"=>array(
				"VideoTask.task"=>"DESC"
			)
		));
		foreach($task as $v) {

			$tasks[$v['VideoTask']['task']] = strtoupper($v['VideoTask']['task']);

		}

		$servers = array();

		$server  = $this->VideoTask->find("all",array(
			"fields"=>array(
				"DISTINCT(VideoTask.server) AS `server`"
			),
			"contain"=>array(),
			"order"=>array(
				"VideoTask.server"=>"DESC"
			)
		));
		foreach($server as $v) {

			$servers[$v['VideoTask']['server']] = strtoupper($v['VideoTask']['server']);

		}

		$this->set("statusSelect",$taskStatus);
		$this->set("taskSelect",$tasks);
		$this->set("serverSelect",$servers);

	}

}
