<?php

App::import("Controller","BerricsApp");


class TheotisController extends BerricsAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		//force "view" request to go to "Section"
		if($this->params['action'] == "view") {
			
			$this->params['action'] = "section";
			
		}
		
		$this->theme = $this->params['section'];
		
		$this->set("title_for_layout","Skull Candy Presents: 31 Days of Theotis");
		
	}
	
	public function section() {
		
		//get all the theostis posts
		
	}
	
	public function view() {
		
		
		
	}
	
	private function getPosts() {
		
		$this->loadModel("Dailyop");
		
		$posts = $this->Dailyop->find("all",array(
		
			"condtions"=>array(),
			"contain"=>array()
		
		));
		
		
	}
	
	//contest methods
	
	
	
	
	
}
