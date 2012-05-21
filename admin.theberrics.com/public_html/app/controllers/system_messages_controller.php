<?php

App::import("Controller","LocalApp");

class SystemMessagesController extends LocalAppController {

	var $name = 'SystemMessages';
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function search() {
		
		if(count($this->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=urlencode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		

		
		
	}
	
	function index() {
		
		$this->SystemMessage->recursive = 0;
		
		$this->paginate['SystemMessage']['order'] = array("SystemMessage.id"=>"DESC");
		
		$this->buildSelects();
		
		
		if(isset($this->params['named']['s'])) {
			
			if(isset($this->params['named']['SystemMessage.category'])) {
				
				
				$this->paginate['SystemMessage']['conditions']['SystemMessage.category']=
				$this->data['SystemMessage']['category'] =	
															$this->params['named']['SystemMessage.category'];
				
			}
			
			
		}
		
		
		$this->set('systemMessages', $this->paginate());
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid system message', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('systemMessage', $this->SystemMessage->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->SystemMessage->create();
			if ($this->SystemMessage->save($this->data)) {
				$this->Session->setFlash(__('The system message has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system message could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid system message', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->SystemMessage->save($this->data)) {
				$this->Session->setFlash(__('The system message has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The system message could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SystemMessage->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for system message', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SystemMessage->delete($id)) {
			$this->Session->setFlash(__('System message deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('System message was not deleted', true));
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
