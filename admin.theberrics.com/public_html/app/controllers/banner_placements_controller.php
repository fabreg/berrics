<?php
class BannerPlacementsController extends AppController {

	var $name = 'BannerPlacements';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->BannerPlacement->recursive = 0;
		$this->set('bannerPlacements', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner placement', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannerPlacement', $this->BannerPlacement->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BannerPlacement->create();
			if ($this->BannerPlacement->save($this->data)) {
				$this->Session->setFlash(__('The banner placement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner placement could not be saved. Please, try again.', true));
			}
		}
		$bannerTypes = $this->BannerPlacement->BannerType->find('list');
		$this->set(compact('bannerTypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banner placement', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BannerPlacement->save($this->data)) {
				$this->Session->setFlash(__('The banner placement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner placement could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BannerPlacement->read(null, $id);
		}
		$bannerTypes = $this->BannerPlacement->BannerType->find('list');
		$this->set(compact('bannerTypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner placement', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannerPlacement->delete($id)) {
			$this->Session->setFlash(__('Banner placement deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner placement was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>