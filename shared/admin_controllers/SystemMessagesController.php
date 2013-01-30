<?php

App::import("Controller","LocalApp");

class SystemMessagesController extends LocalAppController {

	var $name = 'SystemMessages';
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function search() {
		
		if(count($this->request->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->request->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		

		
		
	}
	
	function index() {
		
		$this->SystemMessage->recursive = 0;
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['SystemMessage']['order'] = array("SystemMessage.id"=>"DESC");
		
		$this->buildSelects();
		
		
		if(isset($this->request->params['named']['s'])) {
			
			if(isset($this->request->params['named']['SystemMessage.category'])) {
				
				
				$this->Paginator->settings['SystemMessage']['conditions']['SystemMessage.category']=
				$this->request->data['SystemMessage']['category'] =	
															$this->request->params['named']['SystemMessage.category'];
				
			}
			
			
		}
		
		
		$this->set('systemMessages', $this->paginate());
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid system message'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('systemMessage', $this->SystemMessage->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->SystemMessage->create();
			if ($this->SystemMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The system message has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system message could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid system message'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->SystemMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The system message has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system message could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->SystemMessage->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for system message'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SystemMessage->delete($id)) {
			$this->Session->setFlash(__('System message deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('System message was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	private function buildSelects() {
		
		//get categories
		$cats = $this->SystemMessage->find("all",array(
			"fields"=>array(
				'DISTINCT(SystemMessage.category) as `SystemMessage.cat`'
			),
		));
		
		$catSelect = array();
		
		foreach($cats as $v) $catSelect[$v['SystemMessage']['SystemMessage.cat']] = $v['SystemMessage']['SystemMessage.cat'];
		
		$this->set(compact("catSelect"));
		
	}
	
}
