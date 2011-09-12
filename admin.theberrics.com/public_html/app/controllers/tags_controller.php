<?php

App::import("Controller","AdminApp");

class TagsController extends AdminAppController {

	var $name = 'Tags';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->Tag->recursive = 0;
		$this->set('tags', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid tag', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('tag', $this->Tag->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Tag->create();
			if ($this->Tag->save($this->data)) {
				$this->Session->setFlash(__('The tag has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.', true));
			}
		}
		$banners = $this->Tag->Banner->find('list');
		$dailyopSections = $this->Tag->DailyopSection->find('list');
		$dailyops = $this->Tag->Dailyop->find('list');
		$mediaFiles = $this->Tag->MediaFile->find('list');
		
		$this->set(compact('banners', 'dailyopSections', 'dailyops', 'mediaFiles', 'trikipediaTricks'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid tag', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Tag->save($this->data)) {
				$this->Session->setFlash(__('The tag has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tag could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tag->read(null, $id);
		}
		$banners = $this->Tag->Banner->find('list');
		$dailyopSections = $this->Tag->DailyopSection->find('list');
		$dailyops = $this->Tag->Dailyop->find('list');
		$mediaFiles = $this->Tag->MediaFile->find('list');
		$this->set(compact('banners', 'dailyopSections', 'dailyops', 'mediaFiles', 'trikipediaTricks'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for tag', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tag->delete($id)) {
			$this->Session->setFlash(__('Tag deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Tag was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>