<?php

App::import("Controller","BerricsApp");

class AccountController extends BerricsAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}

}
