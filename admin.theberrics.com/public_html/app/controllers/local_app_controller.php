<?php


App::import("Vendor","BCAPI",array("file"=>"bc_api.php"));

class LocalAppController extends AppController {
	
	
	public $app_name = "AdminPanel";
	
	public $helpers = array("Admin","Number");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->deny("*");
		
		$this->set("user_locale","en_us");
		
	}
	
	
	public function beforeRender() {
		
		
		
	}
	
}
