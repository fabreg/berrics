<?php 

App::import("Controller","BerricsApp");

class CatalogController extends BerricsAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		$this->theme = "catalog";
		
	}
	
	public function index() {
		
		
		
	}
	
	
}
