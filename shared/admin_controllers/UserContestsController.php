<?php

App::import("Controller","LocalApp");

class UserContestsController extends LocalAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		$data = $this->paginate("UserContest");
		
		$this->set(compact("data"));
		
	}
	
	public function add() {
		
		if(count($this->request->data)>0) {
			
			if($this->UserContest->save($this->request->data)) {
				
				$this->Session->setFlash("Contest has been created");
				return $this->redirect("/user_contests");
				
			} else {
				
				$this->Session->setFlash("There was an error while saving the event. Please try again.");
				
			}
			
		}
		
	}
	
	public function edit($id = false) {
		
		if(!$id) {
			
			$this->Session->setFlash("Invalid URL");
			
			return $this->redirect("/user_contests");
			
		}
		
		//handle the save
		if(count($this->request->data)>0) {
			
			
		} else {
			
			$this->request->data = $this->UserContest->find("first",array(
			
				"conditions"=>array(
					"UserContest.id"=>$id
				),
				"contain"=>array()
			
			));
			
			
		}
		
		
		
		
	}
	
	public function mark_entry() {
		
		switch($this->request->params['named']['type']) {
			
			case "winner":
				$update = array(
					"winner"=>1,
				);
			break;
			case "loser":
				$update = array(
					"winner"=>0
				);
			break;
			
		}
		
		$this->loadModel("UserContestEntry");
		
		$this->UserContestEntry->create();
		$this->UserContestEntry->id = $this->request->params['named']['user_contest_entry_id'];
		$this->UserContestEntry->save($update);
		
		return $this->flash("Update Entry!","/user_contests/view_entries/".$this->request->params['named']['user_contest_id']);
		
	}
	
	public function view_entries($id = false) {
		
		//let's do some binding
		$this->loadModel("UserContestEntry");
		
		$this->UserContestEntry->bindModel(array("belongsTo"=>array(
		
			"Dailyop"=>array(
				"foreignKey"=>"foreign_key",
			),
			"User"
		
		)));
		
		$this->UserContestEntry->recursive = 1;
		
		$this->paginate['UserContestEntry'] = array(
			"fields"=>array(
				"UserContestEntry.*",
				"Dailyop.*",
				"User.*"
			),
			"conditions"=>array(
				"UserContestEntry.user_contest_id"=>$id
			),
			"joins"=>array(
				"LEFT JOIN dailyops AS `Dailyop` ON (UserContestEntry.foreign_key = Dailyop.id)",
				"INNER JOIN users AS `User` ON (UserContestEntry.user_id = User.id)"
			),
			"contain"=>array(
				
			),
			"limit"=>100
		
		);
		
		if(count($this->request->data)>0) {
			
			$this->paginate['UserContestEntry']['conditions']['UserContestEntry.foreign_key'] = $this->request->data['UserContestEntry']['foreign_key'];
			
		}
		
		//get all the post id's
		
	
		
		//make a menu of contest posts to filter thru
		$dist_posts = $this->UserContestEntry->find("all",array(
			
			"fields"=>array(
				"DISTINCT(UserContestEntry.foreign_key)"
			),
			"conditions"=>array(),
			"contain"=>array()
		
		));
		
		$post_ids = Set::extract("/UserContestEntry/foreign_key",$dist_posts);
		
		$this->loadModel("Dailyop");
		$posts = $this->Dailyop->find("all",array(
			
					"conditions"=>array(
						"Dailyop.id"=>$post_ids
					),
					"contain"=>array()
				
		));
		
		$postFilter = array();
		
		foreach($posts as $p) $postFilter[$p['Dailyop']['id']] = $p['Dailyop']['name']." - ".$p['Dailyop']['sub_title'];
		
		$data = $this->paginate("UserContestEntry");
				
		$this->set(compact("postFilter"));
		
		$this->set(compact("data"));
		
	}
	
	public function edit_entry($id = false) {
		
		$this->loadModel("UserContestEntry");
		
		if(count($this->request->data)>0) {
			
			$this->UserContestEntry->id = $this->request->data['UserContestEntry']['id']; 
			
			if($this->UserContestEntry->save($this->request->data)) {
				
				$this->Session->setFlash("Entry Updated!");
				
				$data = $this->UserContestEntry->read();
				
				$url = "/user_contests/view_entries/".$data['UserContestEntry']['user_contest_id'];
				
				return $this->redirect($url);
				
			} else {
				
				$this->Session->setFlash("There was an error while updating the entry");
				
			}
			
		} else {
			
			$entry = $this->UserContestEntry->find("first",array(
				
				"conditions"=>array(
					"UserContestEntry.id"=>$id
				)
			
			));
			
			$this->request->data = $entry;
			
		}
		
	}
	
	public function view_entry($id = false) {
		
		
		
	}
	
	
	
}