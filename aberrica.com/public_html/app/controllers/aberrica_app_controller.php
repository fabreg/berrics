<?php

class AberricaAppController extends AppController {
		
	public $app_name = "Aberrica";

	public $view = "Theme";
	
	public $theme = "website";
	
	public $helpers = array("Aberrica");
	
	public $components = array("DebugKit.Toolbar");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->topNav();
		
	}
	
	public function topNav() {
		
		//get the top level categories
		$this->loadModel("AberricaCategory");
		
		$cats = $this->AberricaCategory->find("all",array(
		
			"conditions"=>array(
				"AberricaCategory.parent_id"=>0,
				"AberricaCategory.browsable"=>1
			),
			"contain"=>array(),
			"order"=>array("AberricaCategory.sort_weight"=>"ASC")
		
		));
		
		$this->set("topNav",$cats);
		
	}
	
}


?>