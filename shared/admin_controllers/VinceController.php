<?php

App::import("Controller","LocalApp");

class VinceController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		
		$this->initPermissions();
		
		
		
	}
	
	
	public function testing() {
		
		
		$this->loadModel("BatbEvent");
		
		$events = $this->BatbEvent->find("all",array(
		
			"contain"=>array()
		
		));
		
		
		$this->set("vince",$events);
		
		
	}
	
	
	
	
}



?>