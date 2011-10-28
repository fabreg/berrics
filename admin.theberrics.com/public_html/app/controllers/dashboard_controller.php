<?php

App::import("Controller","AdminApp");

class DashboardController extends AdminAppController {

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
		
		$this->set(compact("upcoming_posts","sections","aberrican_etries","bangyoself","ordersYesterday","approvedTransStats","ordersToday"));	
		
	}
	
	
	public function canteen() {
		
		
		
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
	
	
	
	
}



?>