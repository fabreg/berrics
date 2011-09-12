<?php

App::import("Controller","AberricaApp");

class HomeController extends AberricaAppController {
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		
	}
	
	
	public function index() {
		
		$this->loadModel("Article");
		$this->loadModel("User");
		
		//get the articles
		
		$articles = $this->Article->find("all",array(
		
			"conditions"=>array(),
			"contain"=>array(
				"MediaFile",
				"Tag",
				"User"
			)
		
		));
		
		$featured_bloggers = $this->User->find("all",array(
			"conditions"=>array(
				"User.active"=>1,
				"User.facebook_account_num !="=>'',
				"User.profile_image_url !="=>''
			),
			"contain"=>array(),
			"limit"=>8,
			"order"=>"RAND()"
		));
		
		$this->set(compact("articles","featured_bloggers"));
		
	}
	
}