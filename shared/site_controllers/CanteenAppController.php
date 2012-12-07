<?php

App::import("Controller","LocalApp");


class CanteenAppController extends LocalAppController {

	public function beforeFilter() {
	
		$this->body_element = "layout/v3/one-column";

		parent::beforeFilter();
		
		//time to set the currency
		$this->theme = "canteen";

		if(preg_match('/()/',$_SERVER['REQUEST_URI']))
		
	}
	
	
	
}