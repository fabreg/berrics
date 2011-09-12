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
		
		//get the current vote count for battle of the berrics 4

		App::import("Vendors","CanteenConfig",array("file"=>"CanteenConfig.php"));
		
		$this->loadModel("Dailyop");
		$this->loadModel("AberricanOriginal");
		
		$this->loadModel("MediaFile");
		$this->loadModel("CanteenOrder");
		$this->loadModel("GatewayTransaction");
		
		//get the total amount of videos
		$videoCount = $this->MediaFile->find("count",array("conditions"=>array("MediaFile.media_type"=>"bcove")));
		
		//get the total amount of videos that have been transfered to limelight
		$llnwCount = $this->MediaFile->find("count",array("conditions"=>array("MediaFile.media_type"=>"bcove","limelight_transfer_status"=>1)));
		
		//get the total amount of videos that are active on limelight
		$llnwLive = $this->MediaFile->find("count",array("conditions"=>array("MediaFile.media_type"=>"bcove","limelight_active"=>1)));
		
		$ordersYesterday = $this->CanteenOrder->find("all",array(
			"contain"=>array(),	
			"fields"=>array("COUNT(*) AS `total`","CanteenOrder.order_status"),
			"conditions"=>array(
				"CanteenOrder.created > DATE_SUB(NOW(),INTERVAL 1 Day)" 
			),
			"group"=>array("CanteenOrder.order_status"),
			"order"=>array("CanteenOrder.order_status"=>"ASC")
		));
		
		$ordersToday = $this->CanteenOrder->find("all",array(
			"contain"=>array(),	
			"fields"=>array("COUNT(*) AS `total`","CanteenOrder.order_status"),
			"conditions"=>array(
				"CanteenOrder.created > '".date("Y-m-d 00:00:00")."'" 
			),
			"group"=>array("CanteenOrder.order_status"),
			"order"=>array("CanteenOrder.order_status"=>"ASC")
		));
		
		//let's get the transaction stats coming in from the canteen
		$approvedTransStats = $this->GatewayTransaction->find("all",array(
			"contain"=>array(),		
			"fields"=>array("SUM(GatewayTransaction.amount) AS `total`","GatewayTransaction.method"),
			"conditions"=>array(
				"GatewayTransaction.gateway_account_id"=>1,
				"GatewayTransaction.approved"=>1,
				"GatewayTransaction.created > DATE_SUB(NOW(),INTERVAL 3 Day)"
			),
			"group"=>array("GatewayTransaction.method")
			
		
		));
		
		
		$this->set(compact("videoCount","llnwCount","llnwLive"));

		$aberrican_etries = $this->AberricanOriginal->find('count');
		
		$upcoming_posts = $this->Dailyop->getUpcomingPosts(true);
		$sections = $this->Dailyop->DailyopSection->returnSelectList();
		
		$this->set(compact("upcoming_posts","sections","aberrican_etries","bangyoself","ordersYesterday","approvedTransStats","ordersToday"));	
		
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