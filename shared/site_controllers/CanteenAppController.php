<?php

App::import("Controller","LocalApp");


class CanteenAppController extends LocalAppController {

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		//time to set the currency
		$this->theme = "canteen";
		

		
		
	}
	
	
	
}