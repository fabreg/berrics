<?php


App::import("Controller","BerricsApp");


class BerricsRecordsController extends BerricsAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		
	}
	
	
	public function section() {

		$records = $this->BerricsRecord->getRecords();
		
		$this->set(compact("records"));
		
	}
	
}