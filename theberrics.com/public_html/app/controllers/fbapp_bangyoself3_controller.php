<?php
 App::import("Controller","BerricsApp");
 
 class FbappBangyoself3Controller extends BerricsAppController {
 	
 	
 	public $uses = array();
 	
 	public function beforeFilter() {
 		
 		parent::beforeFilter();

 		$this->initPermissions();
 		
 		$this->Auth->allow("*");
 		
 	}
 	
 	
 	public function index() {
 		
 		
 		
 	}
 	
 }