<?php
class BannersTagsController extends AppController {

	var $name = 'BannersTags';
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	function index() {
		$this->BannersTag->recursive = 0;
		$this->set('bannersTags', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid banners tag', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bannersTag', $this->BannersTag->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BannersTag->create();
			if ($this->BannersTag->save($this->data)) {
				$this->Session->setFlash(__('The banners tag has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banners tag could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid banners tag', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BannersTag->save($this->data)) {
				$this->Session->setFlash(__('The banners tag has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banners tag could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BannersTag->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for banners tag', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BannersTag->delete($id)) {
			$this->Session->setFlash(__('Banners tag deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Banners tag was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>