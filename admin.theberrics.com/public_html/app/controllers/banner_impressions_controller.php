<?php
class BannerImpressionsController extends AppController {

	var $name = 'BannerImpressions';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->BannerImpression->recursive = 0;
		$this->set('bannerImpressions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner impression', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannerImpression', $this->BannerImpression->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BannerImpression->create();
			if ($this->BannerImpression->save($this->data)) {
				$this->Session->setFlash(__('The banner impression has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner impression could not be saved. Please, try again.', true));
			}
		}
		$banners = $this->BannerImpression->Banner->find('list');
		$bannerTypes = $this->BannerImpression->BannerType->find('list');
		$bannerPlacements = $this->BannerImpression->BannerPlacement->find('list');
		$this->set(compact('banners', 'bannerTypes', 'bannerPlacements'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banner impression', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BannerImpression->save($this->data)) {
				$this->Session->setFlash(__('The banner impression has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner impression could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BannerImpression->read(null, $id);
		}
		$banners = $this->BannerImpression->Banner->find('list');
		$bannerTypes = $this->BannerImpression->BannerType->find('list');
		$bannerPlacements = $this->BannerImpression->BannerPlacement->find('list');
		$this->set(compact('banners', 'bannerTypes', 'bannerPlacements'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner impression', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannerImpression->delete($id)) {
			$this->Session->setFlash(__('Banner impression deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner impression was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>