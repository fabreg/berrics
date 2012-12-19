<?php

App::import("Controller","LocalApp");


class CanteenAppController extends LocalAppController {

	public function beforeFilter() {
	
		$this->body_element = "layout/v3/canteen-body";

		parent::beforeFilter();
		
		//time to set the currency
		$this->theme = "canteen";

		if(
			(!preg_match('/(admin|web2vm)/i',php_uname('n'))) &&
			!preg_match('/(\/canteen\/working)/',$_SERVER['REQUEST_URI'])

		) {

			$this->redirect("/canteen/working");

		}
		
	}
	
	
	
}