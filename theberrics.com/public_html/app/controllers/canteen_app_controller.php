<?php

App::import("Controller","BerricsApp");


class CanteenAppController extends BerricsAppController {
	
	public $app_name = "TheCanteen";
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		//time to set the currency
		$this->theme = "canteen";
		
		$this->loadModel("CanteenCategory");
		$this->set("main_canteen_categories",$this->CanteenCategory->treeArray());
		
		
	}
	
	
	
}