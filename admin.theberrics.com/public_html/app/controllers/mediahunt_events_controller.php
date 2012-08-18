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
		$this->list_pending_uploads($id);
		
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
	
	public function list_pending_uploads($event_id = false) {
		
		$this->loadModel("MediahuntMediaItem");
		
		$uploads = $this->MediahuntMediaItem->find("all",array(
					"conditions"=>array(
						"MediahuntMediaItem.approved"=>0		
					),
					"order"=>array(
						"MediahuntMediaItem.created"=>"DESC"		
					),
					"contain"=>array(
						"MediahuntTask",
						"User"		
					),
					"limit"=>50
				));
		
		$this->set(compact("uploads"));
		
	}
	
	public function reject_file($id) {
		
		$file = $this->MediahuntMediaItem->find("first",array("conditions"=>array("MediahuntMediaItem.id"=>$id),"contain"=>array("MediahuntTask")));
		
		$this->MediahuntMediaItem->delete($id);
		
		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
		$i = ImgServer::instance();
		
		$i->delete_file("mediahunt-media/".$file['MediahuntMediaItem']['file_name']);
		
		$cb = "/mediahunt_events/view/".$file['MediahuntTask']['mediahunt_event_id'];
		
		if(isset($this->params['callback'])) {
			
			$cb = base64_decode($this->params['callback']);
			
		}
		
		$this->redirect($cb);
		
	}
	
	public function list_tasks($event_id = false) {
		
		$this->loadModel("MediahuntTask");
		$this->loadModel("MediahuntMediaItem");
		
		
		$tasks = $this->MediahuntTask->find("all",array(
					"conditions"=>array(
								"MediahuntTask.mediahunt_event_id"=>$event_id
							),
					"contain"=>array(),
					"order"=>array(
								"MediahuntTask.sort_order"=>"ASC"
							)
				));
		
		foreach($tasks as $k=>$v) {
			
			$c = $this->MediahuntMediaItem->find("count",array(
					
						"conditions"=>array(
							"MediahuntMediaItem.mediahunt_task_id"=>$v['MediahuntTask']['id']		
						)
					));
			$tasks[$k]['MediahuntEvent']['UploadCount'] = $c;
			
			//get the approved
			
			$ap = $this->MediahuntMediaItem->find("count",array(
					
						"conditions"=>array(
							"MediahuntMediaItem.mediahunt_task_id"=>$v['MediahuntTask']['id'],
							"MediahuntMediaItem.approved"=>1		
						)
					));
			$tasks[$k]['MediahuntEvent']['UploadApproved'] = $ap;
		}
		
		$this->set(compact("tasks"));
		
	}
	
}
