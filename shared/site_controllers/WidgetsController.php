<?php

App::import("Controller","LocalApp");

class WidgetsController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}

	public function video_slate_generator() {
		
		
		
	}
	

}