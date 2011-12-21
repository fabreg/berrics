<?php

class BerricsFlexController extends AppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		//check for incoming id
		
		if(isset($this->params['pass'][0]) && $this->params['action'] == "flex_session_ping") {
			
			$this->Session->id($this->params['pass'][0]);
			$this->Session->start();
			
		}
		parent::beforeFilter();
		
		$this->Auth->allow("flex_session_ping");
		
	}
	
	public function flex_session_ping() {
		
		die(json_encode($this->Session->read()));
		
	}
	
	public function monthly_report() {
		
		$this->initReports();

		die(json_encode($_POST));
		
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