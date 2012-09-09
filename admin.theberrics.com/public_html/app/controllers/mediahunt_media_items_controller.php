<?php

App::import("Controller","LocalApp");

class MediahuntMediaItemsController extends LocalAppController {

	var $name = 'MediahuntMediaItems';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();	
		
	}
	
	public function search() {
	
		if(count($this->data)>0) {
				
			$url = array(
	
					"action"=>"index",
					"search"=>true
			);
	
	
			foreach($this->data as $k=>$v) {
					
				foreach($v as $kk=>$vv) {
	
					$url[$k.".".$kk]=urlencode($vv);
	
				}
					
			}
	
			return $this->redirect($url);
	
		}
	
	
	
	
	}
	
	
	function index() {
		
		$this->paginate['MediahuntMediaItem'] = array(
				
					"limit"=>50,
					"contain"=>array(

						"User",
						"MediahuntTask"
							
					),
					"order"=>array(
							"MediahuntMediaItem.created"=>"DESC"	
						)
				
				);
		
		if(isset($this->params['named']['search'])) {
			
			if(isset($this->params['named']['MediahuntMediaItem.mediahunt_task_id'])) {
				
				$this->paginate['MediahuntMediaItem']['conditions']['MediahuntMediaItem.mediahunt_task_id'] = 
				$this->data['MediahuntMediaItem']['mediahunt_task_id'] = 
				$this->params['named']['MediahuntMediaItem.mediahunt_task_id'];
				
			}
			if(isset($this->params['named']['MediahuntMediaItem.approved'])) {
			
				$this->paginate['MediahuntMediaItem']['conditions']['MediahuntMediaItem.approved'] =
				$this->data['MediahuntMediaItem']['approved'] =
				$this->params['named']['MediahuntMediaItem.approved'];
			
			}
			
		}
		
		$this->setSelects();
		
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
				
				$redir = array('action' => 'index');
				
				if(isset($this->params['named']['callback'])) $redir = base64_decode($this->params['named']['callback']);
				
				$this->redirect($redir);
				
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
				$redir = array('action' => 'index');
				
				if(isset($this->params['named']['callback'])) $redir = base64_decode($this->params['named']['callback']);
				
				$this->redirect($redir);
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
			
		}
		if ($this->MediahuntMediaItem->delete($id)) {
			$this->Session->setFlash(__('Mediahunt media item deleted', true));
			
		}
		
		$this->redirect(base64_decode($this->params['named']['callback']));
	}
	
	public function update_rank() {
		
		$this->MediahuntMediaItem->create();
		
		$this->MediahuntMediaItem->id = $this->data['MediahuntMediaItem']['id'];
		
		$this->MediahuntMediaItem->save(array("rank"=>$this->data['MediahuntMediaItem']['rank']));
		
		$this->Session->setFlash("Rank Updated");
		
		$this->redirect(base64_decode($this->data['MediahuntMediaItem']['callback']));
		
	}
	
	public function setSelects() {
		
		$mediahuntTaskSelect = array();
		
		$tasks = $this->MediahuntMediaItem->MediahuntTask->find("all",array(
					"contain"=>array(
						"MediahuntEvent"		
					),
					"order"=>array("MediahuntTask.sort_order"=>"ASC")
				));
		
		foreach($tasks as $t) $mediahuntTaskSelect[$t['MediahuntTask']['id']] = $t['MediahuntTask']['name']." (".$t['MediahuntEvent']['name'].")";
		
		$this->set(compact("mediahuntTaskSelect"));
		
	}
	
	public function approve($id) {
		
		$this->MediahuntMediaItem->create();
		
		$this->MediahuntMediaItem->id = $id;
		
		$this->MediahuntMediaItem->save(array("approved"=>1));
		
		$this->redirect(base64_decode($this->params['named']['callback']));
		
	}
	
	public function view_completed() {
		
		//get all the ids of the completed in order
		$count = $this->MediahuntMediaItem->query("select count(*) as `total`,user_id from 
													mediahunt_media_items
													group by user_id
													order by total desc");
		
		
		foreach($count as $k=>$v) {
			
			if($v[0]['total']<20) unset($count[$k]);
			
		}
		
		$uids = Set::extract("/mediahunt_media_items/user_id",$count);

		$this->loadModel("User");
		
		$users = $this->User->find("all",array(
					"conditions"=>array(
						"User.id"=>$uids	
					),
					"contain"=>array(
						"UserProfile"		
					)
				));
		
		foreach($users as $k=>$v) {
			
			if($v['UserProfile']['mediahunt_winner'] != 1) unset($users[$k]);
			
		}
		
		$this->set(compact("users"));
		
	}
	
	public function view_user($id) {
		
		//get the user
		$this->loadModel("User");
		
		$this->User->ensure_user_profile($id);
		
		$user = $this->User->returnUserProfile($id,true);
		
		$items = $this->MediahuntMediaItem->find("all",array(
					"conditions"=>array(
						"MediahuntMediaItem.user_id"=>$id		
					),
					"contain"=>array(

						"MediahuntTask"
							
					)
				));
		
		$this->set(compact("items","user"));
		
	}
	
	public function mark_winner($user_profile_id,$key,$cb) {
		
		$this->loadModel("UserProfile");
		
		$this->UserProfile->create();
		
		$this->UserProfile->id = $user_profile_id;
		
		$this->UserProfile->save(array(
					"mediahunt_winner"=>$key
				));
		
		return $this->redirect("/mediahunt_media_items/view_completed");
		return $this->redirect(base64_decode($cb));
		
	}
	
}
