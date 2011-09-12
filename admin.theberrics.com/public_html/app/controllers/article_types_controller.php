<?php

App::import("Controller","AdminApp");

class ArticleTypesController extends AdminAppController {

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
			$this->Session->setFlash(__('Invalid article type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('articleType', $this->ArticleType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ArticleType->create();
			if ($this->ArticleType->save($this->data)) {
				$this->Session->setFlash(__('The article type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article type could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid article type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ArticleType->save($this->data)) {
				$this->Session->setFlash(__('The article type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ArticleType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for article type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ArticleType->delete($id)) {
			$this->Session->setFlash(__('Article type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Article type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>