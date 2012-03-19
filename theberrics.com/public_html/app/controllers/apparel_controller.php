<?php

App::import("Controller","LocalApp");

class ApparelController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function index($splash=false) {
		
		$this->layout = "empty";
		
		$this->loadModel("UnifiedShop");
		
		//get the shops
		
		if($splash) {
			
			$shops = array();
			
		} else {
			
			
			$shops = $this->UnifiedShop->find("all",array(
		
			"conditions"=>array(
				"active"=>1
			),
			"contain"=>array(),
			"order"=>array("UnifiedShop.name"=>"ASC")	
			
		));
		
			
			
		}
		
		
		
		
		$this->set(compact("shops","splash"));
		
	}
	
	
}