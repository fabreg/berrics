<?php


App::import("Controller","BerricsApp");
class HomeController extends BerricsAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		

	}

	
	public function index() {
		
		
		
	}
	
	
	
}

?>