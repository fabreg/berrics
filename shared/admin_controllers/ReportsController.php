<?php

App::uses('LocalAppController','Controller');


class ReportsController extends LocalAppController {
	
	
	public $uses = array("Report");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		
		
	}
	
	public function report_index() {
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['Report'] = array(

				"order"=>array("Report.id"=>"DESC"),
				"contain"=>array("User"),
				"fields"=>array(
						"Report.id",
						"Report.title",
						"Report.created",
						"Report.report_status",
						"Report.report_type",
						"User.id",
						"User.first_name",
						"User.last_name",
				)
				
		);
		
		
		$reports = $this->paginate("Report");
		
		$this->set(compact("reports"));
		
	}
	
	public function view($id = false) {
		
		
		if(isset($_GET['print'])) $this->layout = "report_print";
		
		set_time_limit(0);
		
		if(!$id) throw new NotFoundException("Report ID Not Sepcified");
		
		$report = $this->Report->findById($id);
		
		if($report['Report']['report_status'] == "pending") {
			
			$report = $this->Report->refresh_report_status($report['Report']['id']);
			
		}
		
		$this->set(compact("report"));
		
		$this->set("title_for_layout",$report['Report']['title']);
		
		if($report['Report']['report_status'] != "completed") {
			
			return $this->render("/Elements/reports/pending");
			
		}
		
		
	}
	
	public function date_overview() {
		
		if($this->request->is("post")) {
			
			//$this->Report->validate_date_overview($this->request->data);
			
			$r = $this->Report->date_overview($this->request->data['Report']['start_date'],
										$this->request->data['Report']['end_date'],
										$this->request->data['Report']['title']);
			
			
			$this->redirect(array("action"=>"report_index"));
			
			
		}
		
		
	}
	
	public function url_report() {
		
		
		if($this->request->is("post")) {
			
			$this->loadModel("Report");
			
			$title		 = $this->request->data['Report']['title'];
			$start_date	 = $this->request->data['Report']['start_date'];
			$end_date	 = $this->request->data['Report']['end_date'];
			
			switch($this->request->data['Report']['type']) {
				
				case "url-report":
					
					$url = "theberrics.com".$this->request->data['Report']['url'];
					
					$this->Report->url_report($url,$start_date,$end_date,$title);
					
					break;
					
				case "url-search":
						
					$url = "theberrics.com".$this->request->data['Report']['url'];
						
					$this->Report->url_search_report($url,$start_date,$end_date,$title);
						
					break;
				
			}
			
			return $this->redirect(array("action"=>"report_index"));
			
		}
		
		$this->request->data['Report']['start_date'] = date("Y-m-01");
		
		$this->request->data['Report']['end_date'] = date("Y-m-d");
	}
	
	public function media_date_overview() {
		
		if($this->request->is("post")) {
			
			//$this->Report->validate_date_overview($this->request->data);
			
			$r = $this->Report->media_date_overview($this->request->data['Report']['start_date'],
										$this->request->data['Report']['end_date'],
										$this->request->data['Report']['title']);
			
			
			$this->redirect(array("action"=>"report_index"));
			
			
		}
		
		
	}
	
	public function realtime() {
		
		$this->loadModel("PageView");
		$this->loadModel("MediaFileView");

		$pages = $this->PageView->find('all',array(
			"conditions"=>array('PageView.domain_name LIKE'=>'%theberrics.com'),
			"contain"=>array(),
			"order"=>array("PageView.id"=>"DESC"),
			"limit"=>100
		));

		$media = $this->MediaFileView->find('all',array(
			"conditions"=>array(),
			"contain"=>array('MediaFile'),
			'order'=>array("MediaFileView.id"=>"DESC"),
			"limit"=>100
		));

		$this->set(compact("pages","media"));


	}

	public function realtime_videos($limit=100) {
		
		$this->loadModel("MediaFileView");

		$media = $this->MediaFileView->find('all',array(
			"conditions"=>array(),
			"contain"=>array('MediaFile'),
			'order'=>array("MediaFileView.id"=>"DESC"),
			"limit"=>$limit
		));

		$this->set(compact("media"));

	}

	public function realtime_pages($limit=100) {
		
		$this->loadModel("PageView");
		
		$pages = $this->PageView->find('all',array(
			"conditions"=>array('PageView.domain_name LIKE'=>'%theberrics.com'),
			"contain"=>array(),
			"order"=>array("PageView.id"=>"DESC"),
			"limit"=>$limit
		));
	
		$this->set(compact("pages"));

	}
	
	public function top_videos() {
		
		if($this->request->is("post") || $this->request->is("put")) {
		
			$this->Report->top_videos(
				$this->request->data['Report']['start_date'],
				$this->request->data['Report']['end_date'],
				$this->request->data['Report']['limit'],
				$this->request->data['Report']['title']
			);

			$this->Session->setFlash("Top Video Report Queued Successfully");
		
			return $this->redirect(array(
						"controller"=>"reports",
						"action"=>"index"
					));

		}

	}

	public function video_queue_report() {
		
		$this->loadModel("MediaFile");

		$videos = array();

		$ids = CakeSession::read("MediaFileReportQueue");

		if(count($ids)>0) {

			$videos = $this->MediaFile->find('all',array(
				"conditions"=>array('MediaFile.id'=>$ids),
				"contain"=>array()
			));

		}

		$this->set(compact("videos"));


	}

}
