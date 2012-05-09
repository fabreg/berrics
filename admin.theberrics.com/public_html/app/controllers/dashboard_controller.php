<?php

App::import("Controller","LocalApp");

class DashboardController extends LocalAppController {

	public $uses = array();
	
	public $helpers = array("ICal");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("cal");
		
	}
	
	
	public function index() {
		
		$this->loadModel("Dailyop");

		$upcoming_posts = $this->Dailyop->getUpcomingPosts(true);
		
		$sections = $this->Dailyop->DailyopSection->returnSelectList();
		
		$this->set(compact("upcoming_posts","sections"));	
		
	}
	
	public function dailyops() {
		
		$this->loadModel("Dailyop");
		
		$posts = $this->Dailyop->returnDailyopsDashboard();
		
		$this->set(compact("posts"));
		
	}
	
	
	public function canteen() {
		
		App::import("Vendor","CanteenConfig",array("file"=>"CanteenConfig.php"));
		
		$this->loadModel("CanteenOrderNote");
		
		//get all the pending customer notes
		$pending_notes = $this->CanteenOrderNote->find("all",array(
			"conditions"=>array(
				"CanteenOrderNote.feedback_required"=>1
			),
			"contain"=>array(
				"ChildCanteenOrderNote"
			)
		));
		
		$this->set("pending_notes");
		
	}
	
	
	public function reports() {
		
		
		
		
	}
	
	public function cal() {
		
		Configure::write('debug', 0);
		
		//authenticate on the get string
		
		if(trim($_GET['a']) != '') {
			
			$this->loadModel("User");
			$u = $this->User->find('first',array("conditions"=>array("User.ical_hash"=>$_GET['a']),"contain"=>array()));
			
			if(!isset($u['User']['id'])) {
				
				$this->cakeError("error500");
				return;
			}
			
		} else {
			$this->cakeError("error500");
				return;
			
		}
		
		
		$this->loadModel("Dailyop");
		
		$this->layout = "blank";
		
		$posts = $this->Dailyop->getUpcomingPosts(true);
		
		$this->set(compact("posts"));
		
	}
	
	public function younited_nations() {
		
		//get all the younited nations 3 downloads
		$this->loadModel("YounitedNationsEventEntry");
		
		$this->YounitedNationsEventEntry->bindModel(array(
			"hasMany"=>array(
				"MediaFileUpload"=>array(
					"className"=>"MediaFileUpload",
					"conditions"=>array("MediaFileUpload.model"=>"YounitedNationsEventEntry"),
					"foreignKey"=>"foreign_key"
				)
			)
		));
		
		$entries = $this->YounitedNationsEventEntry->find("all");
		
		foreach($entries as $k=>$v) {
			
			if(count($v['MediaFileUpload'])<1) unset($entries[$k]);
			
		}
		
		//die(pr($entries));
		
		$this->set(compact("entries"));
		
	}
	
	public function sls() {
		
		
		$this->loadModel("SlsVote");

		$stats = $this->SlsVote->getVoteStats(array("no_cache"=>true));
		
		$this->set(compact("stats"));
		
		
	}
	
	public function yn3_stats() {
		
		$this->loadModel("YounitedNationsVote");
		$this->loadModel("YounitedNationsEventEntry");
		
		$stats = $this->YounitedNationsVote->return_event_stats();
		
		foreach($stats as $v) {
			
			
			
		}
		
	}
	
	
	
	
}



?>