<?php
class BannerTypesController extends AppController {

	var $name = 'BannerTypes';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->BannerType->recursive = 0;
		$this->set('bannerTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannerType', $this->BannerType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BannerType->create();
			if ($this->BannerType->save($this->data)) {
				$this->Session->setFlash(__('The banner type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner type could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banner type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BannerType->save($this->data)) {
				$this->Session->setFlash(__('The banner type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BannerType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannerType->delete($id)) {
			$this->Session->setFlash(__('Banner type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>