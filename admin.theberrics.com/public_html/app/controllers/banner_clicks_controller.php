<?php

App::import("Controller","AdminApp");

class BannerClicksController extends AdminAppController {

	var $name = 'BannerClicks';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->BannerClick->recursive = 0;
		$this->set('bannerClicks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banner click', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannerClick', $this->BannerClick->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BannerClick->create();
			if ($this->BannerClick->save($this->data)) {
				$this->Session->setFlash(__('The banner click has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner click could not be saved. Please, try again.', true));
			}
		}
		$banners = $this->BannerClick->Banner->find('list');
		$this->set(compact('banners'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banner click', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BannerClick->save($this->data)) {
				$this->Session->setFlash(__('The banner click has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner click could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BannerClick->read(null, $id);
		}
		$banners = $this->BannerClick->Banner->find('list');
		$this->set(compact('banners'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banner click', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannerClick->delete($id)) {
			$this->Session->setFlash(__('Banner click deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banner click was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>