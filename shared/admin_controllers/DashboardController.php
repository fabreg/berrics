<?php

App::uses("LocalAppController","Controller");

class DashboardController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		
		
	}
	
	public function canteen() {
		
		
		
	}
	
	public function traffic() {
		
		$this->loadModel("PageView");
		$this->loadModel("MediaFileView");

		$uniques = $this->PageView->getUniques();
		
		$pages = $this->PageView->getPageViews();

		$videos = $this->MediaFileView->getTotalViews();
		
		$this->set(compact("uniques","pages","videos"));
		
		
	}
	
	public function top_pages($limit = 15) {
		
		$this->loadModel("PageView");
		
		$pages = $this->PageView->getTopPages($limit);
		
		$this->set(compact("pages"));
		
	}
	
	public function top_videos($limit = 15) {
		
		$this->loadModel("MediaFileView");
		
		$videos = $this->MediaFileView->getTopViews($limit);
		
		$this->set(compact("videos"));
		
	}
	
	public function dailyops($start_date = false) {
		
		if(!$start_date) $start_date = date("Y-m-d");
		
		if(!isset($this->request->params['named']['count'])) {
			
			$this->request->params['named']['count'] = 7;
			
		}
		
		$this->request->data['Dailyop']['start_date'] = $start_date;
		$this->request->data['Dailyop']['count'] = $this->request->params['named']['count'];
		
		$end_date = date("Y-m-d",strtotime("+{$this->request->data['Dailyop']['count']} Days",strtotime($start_date)));
		
		$this->loadModel("Dailyop");
		$this->loadModel("SplashDate");
		
		$dops = array();
		
		$post_ids = $this->Dailyop->find("all",array(
					"fields"=>array(
						"Dailyop.id",
						"DATE(Dailyop.publish_date) AS `date`"		
					),
					"conditions"=>array(
						"DATE(publish_date) BETWEEN '{$start_date}' AND '{$end_date}'"		
					),
					"contain"=>array(),
					"order"=>array(
						"Dailyop.publish_date"=>"ASC",
						"Dailyop.display_weight"=>"ASC"		
					)
				));
		
		foreach($post_ids as $v) $dops[$v[0]['date']]['posts'][] = $this->Dailyop->validatePostStatus($this->Dailyop->returnPost(array("Dailyop.id"=>$v['Dailyop']['id']),true,true));
		
		$splash_ids = $this->SplashDate->find("all",array(
					"fields"=>array(
							"SplashDate.id",
							"DATE(SplashDate.publish_date) AS `date`"
					),
					"conditions"=>array(
						"DATE(publish_date) BETWEEN '{$start_date}' AND '{$end_date}'"
					),
					"contain"=>array(),
					"order"=>array(
						"SplashDate.publish_date"=>"ASC"		
					)
				));
		
		foreach($splash_ids as $v) $dops[$v[0]['date']]['splash'][] = $this->SplashDate->findById($v['SplashDate']['id']);
		
		$this->set(compact("dops","start_date","end_date"));
		
		
	}
	
	public function canteen_order_stats() {
		
		$this->loadModel("CanteenOrder");
		
		//get today's order stats
		$date_today = date("Y-m-d");
		
		$orders_today = $this->CanteenOrder->find("all",array(
				"fields"=>array(
						'COUNT(*) AS `total`',"CanteenOrder.order_status"
				),
				"conditions"=>array(
						"DATE(created) = '{$date_today}'"
						),
						"contain"=>array(),
						"group"=>array(
								"CanteenOrder.order_status"
						),
						"order"=>array("total"=>"DESC")
						));
		
		$this->set(compact("orders_today"));
		
		//get some ordering stats
		$yesterday = date("Y-m-d",strtotime("-1 Day"));
		$month_ago = date("Y-m-d",strtotime("-30 Days"));
		
		$this_month = date("m");
		$this_year = date("Y");

		$orders_month = $this->CanteenOrder->find("all",array(
				"fields"=>array(
						'COUNT(*) AS `total`',"CanteenOrder.order_status"
				),
				"conditions"=>array(
					"MONTH(CanteenOrder.created) = '{$this_month}'",
					"YEAR(CanteenOrder.created) = '{$this_year}'"
				),
				"contain"=>array(),
				"group"=>array(
						"CanteenOrder.order_status"
				),
				"order"=>array("total"=>"DESC")
		));
		
		$this->set(compact("orders_month"));
		
	}
	
}