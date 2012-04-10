<?php


App::import("Controller","LocalApp");


class CanteenPromoController extends LocalAppController {
	
	
	public $uses = array("CanteenPromoCode");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		if(count($this->data)>0) {
			
			
			
		}
		
	}
	
}