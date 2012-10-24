<?php

class BerricsFlexController extends AppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		//check for incoming id
		
		if(isset($this->params['pass'][0]) && $this->params['action'] == "flex_session_ping") {
			
			$this->Session->id($this->params['pass'][0]);
			$this->Session->start();
			
		}
		
		//check for json being posts
		if(isset($_POST['json'])) {
			
			$this->data = $_json = json_decode($_POST['json'],true);
			
			//Sanitize::clean($_json);
			
		}
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
	}
	
	public function flex_session_ping() {
		
		die(json_encode($this->Session->read()));
		
	}
	
	public function monthly_report() {
		
		$this->initReports();

		die(json_encode($this->data));
		
	}
	
	public function realtime() {
		
		$this->loadModel("MediaFileView");
		
		$data = $this->MediaFileView->find("all",array(
			
			"fields"=>array(
				"MediaFile.name",
				"MediaFileView.geo_country",
				"MediaFileView.geo_region_name"
			),
			"conditions"=>Array(),
			"contain"=>array(),
			"joins"=>array(
				"LEFT JOIN media_files AS `MediaFile` ON MediaFile.id = MediaFileView.media_file_id"
			),
			"limit"=>1000,
			"order"=>array("MediaFileView.id"=>"DESC")
		
		));
		
		$d = array();
		
		foreach($data as $v) {
			
			$d[] = array(
				"Video"=>$v['MediaFile']['name'],
				"Country"=>$v['MediaFileView']['geo_country'],
				"Region"=>$v['MediaFileView']['geo_region_name']
			);
			
		}
		
		die(json_encode($d));
		
		
	}
	
	
	private function initReports() {

		$this->loadModel("FactPageView");
		$this->loadModel("DimDomain");
		$this->loadModel("DimLocation");
		$this->loadModel("DimDate");
		$this->loadModel("DimRequest");
		$this->loadModel("DimDmaCode");
		$this->loadModel("FactMediaView");
		$this->loadModel("MediaFile");
		$this->loadModel("MediaFileView");
		$this->loadModel("PageViews");
		
	}
	
	
}