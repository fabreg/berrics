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
		/*
		$this->loadModel("CanteenOrder");
		
		$today = date("Y-m-d");
		
		//get the todays order status and shipping status
		$today_order_status = $this->CanteenOrder->groupedStatusCount("order_status",$today,$today);
		$today_shipping_status = $this->CanteenOrder->groupedStatusCount("shipping_status",$today,$today);
		
		//get the past 3 day's order status and shipping status
		
		$three_day_start = date("Y-m-d",strtotime("-1 Day"));
		$three_day_end = date("Y-m-d",strtotime("-3 Days",strtotime($three_day_start)));
		
		$three_day_order_status = $this->CanteenOrder->groupedStatusCount("order_status",$three_day_start,$three_day_end);
		$three_day_shipping_status = $this->CanteenOrder->groupedStatusCount("shipping_status",$three_day_start,$three_day_end);
		
		//get todays transactions
		
		//get the past 3 days transactions
		
		//get the unanswered questions
		
		//get the latest answers
		
		
		$this->set(compact("today_order_status","today_shipping_status","three_day_order_status","three_day_shipping_status","three_day_start","three_day_end"));
		*/
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
	
	
	
	
}



?>