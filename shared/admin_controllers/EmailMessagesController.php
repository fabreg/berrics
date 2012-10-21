<?php

App::import("Controller","LocalApp");

class EmailMessagesController extends LocalAppController {

	public $components = array("Email");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['EmailMessage'] = array(
		
			"order"=>array("EmailMessage.id"=>"DESC"),
			"limit"=>50
		
		);
		
		$this->EmailMessage->recursive = 0;
		$this->set('emailMessages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid email message'));
			$this->redirect(array('action' => 'index'));
		}
		
		$e = $this->EmailMessage->find("first",array(
			"conditions"=>array(
				"EmailMessage.id"=>$id
			)
		
		));
		$msg = $e;
		$e = $e['EmailMessage'];
			
			$this->Email->reset();
			$this->Email->to = $e['to'];
			$this->Email->from = $e['from'];
			$this->Email->subject=$e['subject'];
			$this->Email->cc = explode(",",$e['cc']);
			$this->Email->bcc = $e['bcc'];
			$this->Email->sendAs = $e['send_as'];
			$this->Email->template = $e['template'];
			$this->Email->smtpOptions = array(
												'port'=>'465',
												'timeout'=>'30',
												'host' => 'ssl://smtp.gmail.com',
												'username'=>'do.not.reply@theberrics.com',
												'password'=>'19Berrics82',
			);
			
			$this->set("msg",$msg);
			
			$this->Email->delivery = 'debug';
			
			$this->Email->send();
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->EmailMessage->create();
			if ($this->EmailMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The email message has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email message could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid email message'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->EmailMessage->save($this->request->data)) {
				$this->Session->setFlash(__('The email message has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email message could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->EmailMessage->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for email message'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailMessage->delete($id)) {
			$this->Session->setFlash(__('Email message deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Email message was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>