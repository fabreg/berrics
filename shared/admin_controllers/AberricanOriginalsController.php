<?php

App::import("Controller","LocalApp");

class AberricanOriginalsController extends LocalAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	
	public function index() {
		
		$this->paginate = array(
			
			"contain"=>array(
		
				"User"	
		
			)
		
		);
		
		
		$files = $this->paginate("AberricanOriginal");
		
		$this->set(compact("files"));
		
	}
	
	
	
}