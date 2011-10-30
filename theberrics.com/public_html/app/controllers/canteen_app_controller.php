<?php

App::import("Controller","BerricsApp");


class CanteenAppController extends BerricsAppController {
	
	public $app_name = "TheCanteen";
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		//time to set the currency
		$this->theme = "canteen";
		

		
		
	}
	
	
	
}