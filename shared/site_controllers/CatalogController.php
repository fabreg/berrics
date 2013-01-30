<?php 

App::import("Controller","LocalApp");

class CatalogController extends LocalAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow("*");
		
		$this->theme = "catalog";
		
	}
	
	public function index() {
		
		$this->loadModel("Dailyop");
		
		//get the post
		$post = $this->Dailyop->returnPost(array(
		
			"Dailyop.id"=>4533
		
		));
		
		$this->set(compact("post"));
		
	}
	
	private function getNextImage() {
		
		
		
	}
	
	private function buildThumbGrid() {
		
		
		
	}
	
	
}
