<?php

App::import("Controller","LocalApp");

class ArticleTypesController extends LocalAppController {

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
	}
	
	var $name = 'ArticleTypes';

	function index() {
		$this->ArticleType->recursive = 0;
		$this->set('articleTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid article type'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('articleType', $this->ArticleType->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->ArticleType->create();
			if ($this->ArticleType->save($this->request->data)) {
				$this->Session->setFlash(__('The article type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article type could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid article type'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->ArticleType->save($this->request->data)) {
				$this->Session->setFlash(__('The article type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article type could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->ArticleType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for article type'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ArticleType->delete($id)) {
			$this->Session->setFlash(__('Article type deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Article type was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>