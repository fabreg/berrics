<?php


App::import("Vendor","BCAPI",array("file"=>"bc_api.php"));

class LocalrAppController extends AppController {
	
	
	public $app_name = "AdminPanel";
	
	public $helpers = array("Admin");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->deny("*");
		
	}
	
	
	public function beforeRender() {
		
		
		
	}
	
}