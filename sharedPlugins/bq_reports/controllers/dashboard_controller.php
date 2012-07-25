<?php

class DashboardController extends BqReportsAppController {
	
	public $uses = array("BqReport");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
			
		
		
	}
	
	public function ajax_index() {
		
		$data = $this->paginate("BqReport");
		
		$this->set(compact("data"));
		
	}
	
	public function generate($screen) {
		
		$this->render("/elements/".$screen);
		
	}
	
	public function process() {
		
		$this->BqReport->processReportRequest($this->data['BqReport']);
		
	}
	
	
	
}