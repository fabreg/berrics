<?php


App::import("Controller","LocalApp");

class BangyoselfEventsController extends LocalAppController {	
	
	
	public $uses = array("BangyoselfEvent","BangyoselfEntry");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		
		$this->BangyoselfEvent->recursive = 0;
		
		$this->set('bangyoselfEvents', $this->paginate());
		
	}
	
	function view($id = null) {
		
		//grab the event entries
		$event = $this->BangyoselfEvent->find('first',array(
		
			"conditions"=>array( 
			
				"BangyoselfEvent.id"=>$id	
			
			),
			"contain"=>array()
		
		));
		
		$this->Paginator->settings = array()
		
		$this->Paginator->settings['BangyoselfEntry'] = array(
		
			"conditions"=>array(
				"BangyoselfEntry.bangyoself_event_id"=>$id
			),
			"contain"=>array(
				"User" 
			),
			"order"=>array(
				"BangyoselfEntry.dailyop_id"=>"DESC",
				"BangyoselfEntry.created"=>"DESC"
			)
		
		);
		
		if(isset($_GET['file'])) {
			
			$this->Paginator->settings['BangyoselfEntry']['conditions']['BangyoselfEntry.file_name'] = $_GET['file'];
			
		}

		$entries = $this->paginate('BangyoselfEntry');
		
		$this->set(compact("event","entries"));
		
	}
	
	public function create_post($id) {
		
		$this->loadModel("Dailyop");
		
		$e = $this->BangyoselfEntry->find("first",array(
			
			"conditions"=>array(
				"BangyoselfEntry.id"=>$id
			),
			"contain"=>array(
				'User'
			)
		
		));
		
		
		$d = array(
		
			"hidden"=>1,
			"user_id"=>$this->user_id_scope,
			"publish_date"=>date('Y-m-d 00:00:00',strtotime("+30 days")),
			"sub_title"=>$e['User']['first_name']." ".$e['User']['last_name'],
			"name"=>"Bang Yoself! Finalist",
			"active"=>0,
			"uri"=>Tools::safeUrl($e['User']['first_name']." ".$e['User']['last_name']).".html"
		
		);	
		
		$this->Dailyop->create();
		$this->Dailyop->save($d);
		
		$new_id = $this->Dailyop->id;
		
		$this->BangyoselfEntry->create();
		
		$this->BangyoselfEntry->id = $e['BangyoselfEntry']['id'];
		
		$this->BangyoselfEntry->save(array(
		
			"dailyop_id"=>$new_id
		
		));
		
		return $this->redirect("/dailyops/edit/".$new_id);
	
	}
	
	public function delete_post($id) {
		
		
		$this->BangyoselfEvent->BangyoselfEntry->id = $id;
		
		$this->BangyoselfEvent->BangyoselfEntry->save(array(
			"dailyop_id"=>''
		));
		
		$event = $this->BangyoselfEvent->BangyoselfEntry->read();
		
		return $this->redirect("/bangyoself_events/view/".$event['BangyoselfEntry']['bangyoself_event_id']);
		
	}
	
	

	function add() {
		if (!empty($this->request->data)) {
			$this->BangyoselfEvent->create();
			if ($this->BangyoselfEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The bangyoself event has been saved'));
				$this->redirect(array('action' => 'index'));  
			} else {
				$this->Session->setFlash(__('The bangyoself event could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid bangyoself event'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->BangyoselfEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The bangyoself event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bangyoself event could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->BangyoselfEvent->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bangyoself event'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BangyoselfEvent->delete($id)) {
			$this->Session->setFlash(__('Bangyoself event deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Bangyoself event was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function update_facebook_likes($id) {
		
		$this->BangyoselfEvent->BangyoselfEntry->update_facebook_likes($id);
		
		return $this->redirect(array("action"=>"view",$this->BangyoselfEvent->BangyoselfEntry->field("bangyoself_event_id",array("id"=>$id))));
		
		
	}
	
	
	
	
	
	
}
?>