<?php

App::import("Controller","BerricsApp");

class WidgetsController extends BerricsAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}

	public function video_slate_generator() {
		
		
		
	}
	

}