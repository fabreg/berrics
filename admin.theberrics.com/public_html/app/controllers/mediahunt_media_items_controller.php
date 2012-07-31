<?php
class MediahuntMediaItemsController extends AppController {

	var $name = 'MediahuntMediaItems';

	function index() {
		$this->MediahuntMediaItem->recursive = 0;
		$this->set('mediahuntMediaItems', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid mediahunt media item', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('mediahuntMediaItem', $this->MediahuntMediaItem->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->MediahuntMediaItem->create();
			if ($this->MediahuntMediaItem->save($this->data)) {
				$this->Session->setFlash(__('The mediahunt media item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mediahunt media item could not be saved. Please, try again.', true));
			}
		}
		$users = $this->MediahuntMediaItem->User->find('list');
		$mediahuntTasks = $this->MediahuntMediaItem->MediahuntTask->find('list');
		$this->set(compact('users', 'mediahuntTasks'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid mediahunt media item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->MediahuntMediaItem->save($this->data)) {
				$this->Session->setFlash(__('The mediahunt media item has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mediahunt media item could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MediahuntMediaItem->read(null, $id);
		}
		$users = $this->MediahuntMediaItem->User->find('list');
		$mediahuntTasks = $this->MediahuntMediaItem->MediahuntTask->find('list');
		$this->set(compact('users', 'mediahuntTasks'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for mediahunt media item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MediahuntMediaItem->delete($id)) {
			$this->Session->setFlash(__('Mediahunt media item deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Mediahunt media item was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
