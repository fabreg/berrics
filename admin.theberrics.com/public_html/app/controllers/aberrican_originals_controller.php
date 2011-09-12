<?php

App::import("Controller","AdminApp");

class AberricanOriginalsController extends AdminAppController {
	
	
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