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
		
		$this->paginate['BqReport'] = array(

			"limit"=>20,
			"order"=>array("BqReport.created"=>"DESC"),
			"contain"=>array("User")
				
		);
		
		$data = $this->paginate("BqReport");
		
		$this->set(compact("data"));
		
	}
	
	public function generate($screen) {
		
		$this->render("/elements/".$screen);
		
	}
	
	public function process() {
		
		$this->data['BqReport']['user_id'] = $this->Auth->user("id");
		
		$this->BqReport->processReportRequest($this->data['BqReport']);
		
	}
	
	
	
}