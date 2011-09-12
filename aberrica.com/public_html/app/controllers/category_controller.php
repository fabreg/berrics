<?php

App::import("Controller","AberricaApp");

class CategoryController extends AberricaAppController {
	
	public $uses = array("AberricaCategory");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	
	public function index() {
		
		$uri = $this->params['uri'];
		
		$category = $this->AberricaCategory->find("all",array(
			"fields"=>array("AberricaCategory.*","SubCategory.*"),
			"conditions"=>array(
				"AberricaCategory.uri"=>$uri
			),
			"contain"=>array(),
			"joins"=>array(
				"INNER JOIN aberrica_categories as `SubCategory` ON (SubCategory.parent_id = AberricaCategory.id)"
			)
		
		));
		
		die(print_r($category));
		
	}
	
	
}


?>