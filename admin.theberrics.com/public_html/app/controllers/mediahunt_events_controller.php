<?php

App::import("Controller","LocalApp");

class MediahuntEventsController extends LocalAppController {

	var $name = 'MediahuntEvents';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->MediahuntEvent->recursive = 0;
		$this->set('mediahuntEvents', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid mediahunt event', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('mediahuntEvent', $this->MediahuntEvent->read(null, $id));
		
		$this->list_tasks($id);
		
	}

	function add() {
		if (!empty($this->data)) {
			$this->MediahuntEvent->create();
			if ($this->MediahuntEvent->save($this->data)) {
				$this->Session->setFlash(__('The mediahunt event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mediahunt event could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid mediahunt event', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->MediahuntEvent->save($this->data)) {
				$this->Session->setFlash(__('The mediahunt event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mediahunt event could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MediahuntEvent->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for mediahunt event', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MediahuntEvent->delete($id)) {
			$this->Session->setFlash(__('Mediahunt event deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Mediahunt event was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
	public function list_tasks($event_id = false) {
		
		$this->loadModel("MediahuntTask");
		
		$tasks = $this->MediahuntTask->find("all",array(
					"conditions"=>array(
								"MediahuntTask.mediahunt_event_id"=>$event_id
							),
					"contain"=>array(),
					"order"=>array(
								"MediahuntTask.sort_order"=>"ASC"
							)
				));
		
		$this->set(compact("tasks"));
		
	}
	
}
