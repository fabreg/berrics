<?php

App::import("Controller","LocalApp");

class ReportDashboardController extends LocalAppController {
	
	
	public $uses = array("BqReport");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		//handle paginations only for ajax request
		if($this->RequestHandler->isAjax()) return $this->ajax_index();
		
	}
	
	public function ajax_index() {
		
		$data = $this->paginate("BqQuery");
		
		$this->set(compact("data"));
		
	}
	
	
	
}
