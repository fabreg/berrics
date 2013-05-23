<?php
App::uses('LocalAppController', 'Controller');
/**
 * PollVotingOptions Controller
 *
 * @property PollVotingOption $PollVotingOption
 */
class PollVotingOptionsController extends LocalAppController {


	public $uses = array("Poll","PollVotingOption");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->initPermissions();

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->PollVotingOption->recursive = 0;
		$this->set('pollVotingOptions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->PollVotingOption->id = $id;
		if (!$this->PollVotingOption->exists()) {
			throw new NotFoundException(__('Invalid poll voting option'));
		}
		$this->set('pollVotingOption', $this->PollVotingOption->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($poll_id) {
		if ($this->request->is('post')) {
			$this->PollVotingOption->create();
			if ($this->PollVotingOption->save($this->request->data)) {
				$this->Session->setFlash(__('The poll voting option has been saved'));
				$this->redirect(array('action' => 'edit','controller'=>'polls',$poll_id));
			} else {
				$this->Session->setFlash(__('The poll voting option could not be saved. Please, try again.'));
			}
		}
		$poll = $this->Poll->returnAdminPoll($poll_id);
		$this->set(compact('poll'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->PollVotingOption->id = $id;
		if (!$this->PollVotingOption->exists()) {
			throw new NotFoundException(__('Invalid poll voting option'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PollVotingOption->save($this->request->data)) {
				$this->Session->setFlash(__('The poll voting option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The poll voting option could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->PollVotingOption->read(null, $id);
		}
		$polls = $this->PollVotingOption->Poll->find('list');
		$this->set(compact('polls'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->PollVotingOption->id = $id;
		if (!$this->PollVotingOption->exists()) {
			throw new NotFoundException(__('Invalid poll voting option'));
		}
		if ($this->PollVotingOption->delete()) {
			$this->Session->setFlash(__('Poll voting option deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Poll voting option was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
