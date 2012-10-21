<?php

class HomeController extends AppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("index");
		
	}
	
	
	public function index() {
		
		switch($this->Auth->user("user_group_id")) {
			
			case "10":
				return $this->redirect("/dashboard/");
			break;
			
			default:
				$this->Session->setFlash("Your account does not have access to that location. Please login.");
				return $this->redirect(array("plugin"=>"identity","controller"=>"login","action"=>"index"));
			break;
		}
		
	}
	
	
}


?>