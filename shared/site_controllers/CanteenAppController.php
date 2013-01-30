<?php

App::import("Controller","LocalApp");


class CanteenAppController extends LocalAppController {

	public $left_column_element = "canteen/columns/left-column";

	public function beforeFilter() {
	
		$this->body_element = "layout/v3/canteen-body";

		$this->set("left_column_element",$this->left_column_element);

		parent::beforeFilter();
		
		//time to set the currency
		$this->theme = "canteen";


	}
	
	
	
}